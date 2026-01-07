<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Dashboard with report overview
     */
    public function index()
    {
        // Summary Cards
        $totalRevenue = \App\Models\Order::whereIn('status', ['diproses', 'dikirim', 'selesai'])->sum('total_harga');
        $totalOrders = \App\Models\Order::count();
        $pendingOrders = \App\Models\Order::where('status', 'menunggu_verifikasi')->count();
        $totalProducts = \App\Models\Product::count();

        // Detailed Sales Table
        // Barang yang terjual | Pembeli | Revenue (per item transaction)
        $sales = DB::table('pesanan_detail')
            ->join('pesanan', 'pesanan_detail.pesanan_id', '=', 'pesanan.id')
            ->join('produk', 'pesanan_detail.produk_id', '=', 'produk.id')
            ->select(
                'produk.nama as product_name',
                'produk.kategori_id', 
                'pesanan.nama_penerima as customer_name',
                'pesanan_detail.jumlah as qty',
                'pesanan_detail.subtotal as revenue',
                'pesanan.created_at as date',
                'pesanan.kode_pesanan'
            )
            ->whereIn('pesanan.status', ['diproses', 'dikirim', 'selesai']) // Only count valid sales
            ->orderBy('pesanan.created_at', 'desc')
            ->paginate(20);

        // Get category names manually or via join if needed, but for simplicity let's stick to product name as requested.
        // Actually, let's join category too for completeness "Jenis Barang"
        $sales = DB::table('pesanan_detail')
            ->join('pesanan', 'pesanan_detail.pesanan_id', '=', 'pesanan.id')
            ->join('produk', 'pesanan_detail.produk_id', '=', 'produk.id')
            ->leftJoin('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->select(
                'produk.nama as product_name',
                'kategori.nama as category_name',
                'pesanan.nama_penerima as customer_name',
                'pesanan_detail.jumlah as qty',
                'pesanan_detail.subtotal as revenue',
                'pesanan.created_at as date',
                'pesanan.kode_pesanan'
            )
            ->whereIn('pesanan.status', ['diproses', 'dikirim', 'selesai'])
            ->orderBy('pesanan.created_at', 'desc')
            ->paginate(20);

        return view('admin.reports.index', compact('totalRevenue', 'totalOrders', 'pendingOrders', 'totalProducts', 'sales'));
    }
}
