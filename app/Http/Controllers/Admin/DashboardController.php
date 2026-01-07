<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalRevenue = Order::whereIn('status', ['diproses', 'dikirim', 'selesai'])->sum('total_harga');

        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalProducts', 'totalOrders', 'pendingOrders', 'totalRevenue', 'recentOrders'));
    }
}
