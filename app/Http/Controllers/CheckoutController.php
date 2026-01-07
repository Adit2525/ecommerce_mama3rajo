<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{


    // Show checkout page
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('shop.checkout', compact('cart', 'total'));
    }

    // Process checkout
    public function store(Request $request)
    {
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:10',
            'catatan' => 'nullable|string|max:500',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Generate order code
        $kode_pesanan = 'ORD-' . strtoupper(Str::random(8));

        // Create order using existing column names
        $order = Order::create([
            'user_id' => Auth::id(),
            'kode_pesanan' => $kode_pesanan,
            'nama_penerima' => $request->nama_penerima,
            'no_telp' => $request->telepon,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
            'kode_pos' => $request->kode_pos,
            'total_harga' => $total,
            'ongkir' => 0,
            'status' => 'pending',
            'status_pembayaran' => 'belum_bayar',
        ]);

        // Create order items using existing column names
        foreach ($cart as $item) {
            OrderItem::create([
                'pesanan_id' => $order->id,
                'produk_id' => $item['product_id'],
                'jumlah' => $item['quantity'],
                'harga_satuan' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('checkout.success', $order->id);
    }

    // Show success page
    public function success(Order $order)
    {
        // Ensure user can only view their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items');
        
        return view('shop.checkout-success', compact('order'));
    }
}

