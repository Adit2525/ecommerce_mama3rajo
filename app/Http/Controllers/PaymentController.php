<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    // Bank account info
    private $bankAccounts = [
        [
            'bank' => 'BCA',
            'account_number' => '1234567890',
            'account_name' => 'MAMA3RAJO',
            'logo' => 'bca'
        ],
        [
            'bank' => 'Mandiri',
            'account_number' => '1234567890123',
            'account_name' => 'MAMA3RAJO',
            'logo' => 'mandiri'
        ],
        [
            'bank' => 'BNI',
            'account_number' => '1234567890',
            'account_name' => 'MAMA3RAJO',
            'logo' => 'bni'
        ],
        [
            'bank' => 'BRI',
            'account_number' => '123456789012345',
            'account_name' => 'MAMA3RAJO',
            'logo' => 'bri'
        ],
    ];

    // Show payment confirmation page
    public function show(Order $order)
    {
        // Make sure user owns this order
        if ($order->user_id != Auth::id()) {
            abort(403);
        }

        return view('shop.payment', [
            'order' => $order,
            'bankAccounts' => $this->bankAccounts,
            'midtransClientKey' => config('midtrans.client_key'),
            'midtransProduction' => config('midtrans.is_production', false),
        ]);
    }

    // Upload payment proof
    public function confirm(Request $request, Order $order)
    {
        // Make sure user owns this order
        if ($order->user_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'bank_tujuan' => 'required|string',
            'catatan_pembayaran' => 'nullable|string|max:500'
        ]);

        // Upload file
        // Upload file
        $file = $request->file('bukti_pembayaran');
        $filename = 'payment_' . $order->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        
        // Use public path directly (safer for shared hosting)
        $file->move(public_path('images/payments'), $filename);

        // Update order
        $order->update([
            'bukti_pembayaran' => 'images/payments/' . $filename,
            'bank_tujuan' => $request->bank_tujuan,
            'catatan_pembayaran' => $request->catatan_pembayaran,
            'tanggal_pembayaran' => now(),
            'status' => 'menunggu_verifikasi'
        ]);

        return redirect()->route('payment.success', $order)->with('success', 'Bukti pembayaran berhasil dikirim! Kami akan memverifikasi pembayaran Anda.');
    }

    // Payment success page
    public function success(Request $request, Order $order)
    {
        if ($order->user_id != Auth::id()) {
            abort(403);
        }

        // Fallback: if paid=1 parameter is present but order is still pending,
        // update it to menunggu_verifikasi (payment was successful in Midtrans but AJAX failed)
        if ($request->has('paid') && $request->paid == '1' && $order->status === 'pending') {
            $order->update([
                'status' => 'menunggu_verifikasi',
                'status_pembayaran' => 'lunas',
                'metode_pembayaran' => 'midtrans',
                'tanggal_pembayaran' => now(),
            ]);
            $order->refresh();
        }

        return view('shop.payment-success', compact('order'));
    }
}
