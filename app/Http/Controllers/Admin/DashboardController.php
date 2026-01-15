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

        // Chart Data (Last 7 Days)
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('d M'); // e.g. 12 Jan
            $revenue = Order::whereDate('created_at', $date->format('Y-m-d'))
                            ->whereIn('status', ['diproses', 'dikirim', 'selesai'])
                            ->sum('total_harga');
            $chartData[] = $revenue;
        }

        return view('admin.dashboard', compact('totalProducts', 'totalOrders', 'pendingOrders', 'totalRevenue', 'recentOrders', 'chartLabels', 'chartData'));
    }
}
