<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Create Snap Token for payment
     */
    public function createSnapToken(Request $request)
    {
        $order = Order::with('items.product')->findOrFail($request->order_id);

        // Ensure user owns this order
        if ($order->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Prepare item details
        $itemDetails = [];
        foreach ($order->items as $item) {
            $itemDetails[] = [
                'id' => 'PROD-' . $item->produk_id,
                'price' => (int) $item->harga_satuan,
                'quantity' => (int) $item->jumlah,
                'name' => substr($item->product->nama ?? 'Produk', 0, 50),
            ];
        }

        // Add shipping cost if exists
        if ($order->ongkir > 0) {
            $itemDetails[] = [
                'id' => 'SHIPPING',
                'price' => (int) $order->ongkir,
                'quantity' => 1,
                'name' => 'Ongkos Kirim',
            ];
        }

        // Calculate total from items
        $grossAmount = 0;
        foreach ($itemDetails as $item) {
            $grossAmount += $item['price'] * $item['quantity'];
        }

        // Prepare transaction payload
        $params = [
            'transaction_details' => [
                'order_id' => $order->kode_pesanan . '-' . time(),
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $order->nama_penerima,
                'email' => Auth::user()->email,
                'phone' => $order->no_telp,
                'billing_address' => [
                    'first_name' => $order->nama_penerima,
                    'phone' => $order->no_telp,
                    'address' => $order->alamat,
                    'city' => $order->kota,
                    'postal_code' => $order->kode_pos,
                    'country_code' => 'IDN',
                ],
                'shipping_address' => [
                    'first_name' => $order->nama_penerima,
                    'phone' => $order->no_telp,
                    'address' => $order->alamat,
                    'city' => $order->kota,
                    'postal_code' => $order->kode_pos,
                    'country_code' => 'IDN',
                ],
            ],
            'item_details' => $itemDetails,
            'callbacks' => [
                'finish' => route('payment.finish', $order),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            
            // Save snap token to order
            $order->update([
                'snap_token' => $snapToken,
                'midtrans_order_id' => $params['transaction_details']['order_id'],
            ]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat token pembayaran: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle Midtrans notification callback
     */
    public function notification(Request $request)
    {
        try {
            $notification = new Notification();

            $transactionStatus = $notification->transaction_status;
            $type = $notification->payment_type;
            $orderId = $notification->order_id;
            $fraud = $notification->fraud_status;

            // Get order by midtrans_order_id or extract from order_id
            $orderCode = explode('-', $orderId)[0] . '-' . explode('-', $orderId)[1];
            $order = Order::where('kode_pesanan', 'LIKE', $orderCode . '%')
                         ->orWhere('midtrans_order_id', $orderId)
                         ->first();

            if (!$order) {
                Log::error('Midtrans Notification: Order not found - ' . $orderId);
                return response()->json(['status' => 'Order not found'], 404);
            }

            Log::info('Midtrans Notification', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'payment_type' => $type,
                'fraud_status' => $fraud,
            ]);

            // Handle transaction status
            if ($transactionStatus == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->update([
                            'status' => 'pending',
                            'status_pembayaran' => 'challenge',
                            'metode_pembayaran' => $type,
                        ]);
                    } else {
                        $order->update([
                            'status' => 'diproses',
                            'status_pembayaran' => 'lunas',
                            'metode_pembayaran' => $type,
                            'tanggal_pembayaran' => now(),
                        ]);
                    }
                }
            } elseif ($transactionStatus == 'settlement') {
                $order->update([
                    'status' => 'diproses',
                    'status_pembayaran' => 'lunas',
                    'metode_pembayaran' => $type,
                    'tanggal_pembayaran' => now(),
                ]);
            } elseif ($transactionStatus == 'pending') {
                $order->update([
                    'status' => 'pending',
                    'status_pembayaran' => 'menunggu_pembayaran',
                    'metode_pembayaran' => $type,
                ]);
            } elseif ($transactionStatus == 'deny') {
                $order->update([
                    'status' => 'dibatalkan',
                    'status_pembayaran' => 'gagal',
                    'metode_pembayaran' => $type,
                ]);
            } elseif ($transactionStatus == 'expire') {
                $order->update([
                    'status' => 'dibatalkan',
                    'status_pembayaran' => 'expired',
                    'metode_pembayaran' => $type,
                ]);
            } elseif ($transactionStatus == 'cancel') {
                $order->update([
                    'status' => 'dibatalkan',
                    'status_pembayaran' => 'dibatalkan',
                    'metode_pembayaran' => $type,
                ]);
            }

            return response()->json(['status' => 'OK']);
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Handle payment finish redirect
     */
    public function finish(Request $request, Order $order)
    {
        // Check payment status from Midtrans
        $transactionStatus = $request->transaction_status ?? '';
        $paymentType = $request->payment_type ?? '';

        if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
            return redirect()->route('payment.success', $order)
                           ->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');
        } elseif ($transactionStatus == 'pending') {
            return redirect()->route('payment.show', $order)
                           ->with('info', 'Silakan selesaikan pembayaran Anda.');
        } else {
            return redirect()->route('payment.show', $order)
                           ->with('error', 'Pembayaran tidak berhasil. Silakan coba lagi.');
        }
    }
}
