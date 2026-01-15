<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display the invoice for the order.
     */
    public function show(Order $order)
    {
        // Ensure user can only view their own orders
        if ($order->user_id != Auth::id()) {
            abort(403, 'Unauthorized access to this invoice.');
        }

        $order->load('items.produk');

        return view('invoice.show', compact('order'));
    }
}
