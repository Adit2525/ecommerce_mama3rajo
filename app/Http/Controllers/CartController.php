<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Display the cart
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('shop.cart', compact('cart', 'total'));
    }

    // Add item to cart
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        // Check if product is in stock
        if ($product->stok <= 0) {
            return redirect()->back()->with('error', 'Stok tidak tersedia');
        }
        
        $cart = session()->get('cart', []);
        
        // Get color and size from request
        $color = $request->color ?? 'Hitam';
        $colorHex = $request->color_hex ?? '#000000';
        $size = $request->size ?? 'All Size';
        $quantity = max(1, (int) ($request->quantity ?? 1));
        $customNote = $request->custom_note ?? null;
        
        // Generate a unique ID for the item based on ID + Options (Color/Size)
        $cartKey = $product->id . '-' . strtolower(str_replace(' ', '-', $color)) . '-' . strtolower($size);

        // Calculate total quantity in cart for this product
        $existingQty = isset($cart[$cartKey]) ? $cart[$cartKey]['quantity'] : 0;
        $totalQty = $existingQty + $quantity;
        
        // Check if requested quantity exceeds available stock
        if ($totalQty > $product->stok) {
            return redirect()->back()->with('error', 'Stok tidak tersedia');
        }

        if(isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
            // Update custom note if provided
            if ($customNote) {
                $cart[$cartKey]['custom_note'] = $customNote;
            }
        } else {
            $cart[$cartKey] = [
                "product_id" => $product->id,
                "name" => $product->nama,
                "quantity" => $quantity,
                "price" => $product->harga,
                "image" => $product->gambar,
                "color" => $color,
                "color_hex" => $colorHex,
                "size" => $size,
                "custom_note" => $customNote,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // Update item quantity
    public function update(Request $request, $key)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$key])) {
            $quantity = max(1, (int) $request->quantity);
            $cart[$key]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Keranjang berhasil diperbarui');
    }

    // Remove item from cart
    public function destroy($key)
    {
        $cart = session()->get('cart');
        if(isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang');
    }

    // Clear all items from cart
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan');
    }
}
