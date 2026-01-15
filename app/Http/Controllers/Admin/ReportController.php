<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Dashboard with report overview
     */
    public function index(\Illuminate\Http\Request $request)
    {
        // Summary Cards
        $totalRevenue = \App\Models\Order::whereIn('status', ['diproses', 'dikirim', 'selesai'])->sum('total_harga');
        $totalOrders = \App\Models\Order::count();
        $pendingOrders = \App\Models\Order::where('status', 'menunggu_verifikasi')->count();
        $totalProducts = \App\Models\Product::count();

        // Query Builder
        $query = DB::table('pesanan_detail')
            ->join('pesanan', 'pesanan_detail.pesanan_id', '=', 'pesanan.id')
            ->join('produk', 'pesanan_detail.produk_id', '=', 'produk.id')
            ->leftJoin('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->select(
                'produk.nama as product_name',
                'kategori.nama as category_name',
                'pesanan.nama_penerima as customer_name',
                'pesanan_detail.jumlah as qty',
                'pesanan_detail.subtotal as revenue',
                'pesanan_detail.ukuran', // Added size
                'pesanan.created_at as date',
                'pesanan.kode_pesanan'
            )
            ->whereIn('pesanan.status', ['diproses', 'dikirim', 'selesai']);

        // Apply Date Filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('pesanan.created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        // Apply Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('produk.nama', 'like', "%{$search}%")
                  ->orWhere('pesanan.nama_penerima', 'like', "%{$search}%")
                  ->orWhere('pesanan.kode_pesanan', 'like', "%{$search}%");
            });
        }

        $sales = $query->orderBy('pesanan.created_at', 'desc')->paginate(20);

        return view('admin.reports.index', compact('totalRevenue', 'totalOrders', 'pendingOrders', 'totalProducts', 'sales'));
    }
}
