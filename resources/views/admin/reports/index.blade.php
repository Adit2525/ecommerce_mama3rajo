@extends('admin.layouts.app')

@section('title','Laporan')

@section('content')
<style>
    @media print {
        .no-print { display: none !important; }
        .card { border: none !important; box-shadow: none !important; }
        .card-header { display: none !important; }
        body { background: white !important; }
        .container, .container-fluid { padding: 0 !important; max-width: 100% !important; }
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <h3 class="mb-0">Laporan & Analitik</h3>
    <button onclick="window.print()" class="btn btn-secondary">
        <i class="bi bi-printer"></i> Cetak Laporan
    </button>
</div>

<div class="card mb-4 no-print">
    <div class="card-body">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Cari (Produk/Pelanggan/Resi)</label>
                <input type="text" name="search" class="form-control" placeholder="Masukan kata kunci..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    @if(request()->has('search') || request()->has('start_date'))
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center p-3 border-0 shadow-sm h-100">
            <h6 class="text-muted">Total Pendapatan</h6>
            <h3 class="text-success mb-0">IDR {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center p-3 border-0 shadow-sm h-100">
            <h6 class="text-muted">Total Pesanan</h6>
            <h3 class="text-primary mb-0">{{ $totalOrders }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center p-3 border-0 shadow-sm h-100">
            <h6 class="text-muted">Pesanan Pending</h6>
            <h3 class="text-warning mb-0">{{ $pendingOrders }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center p-3 border-0 shadow-sm h-100">
            <h6 class="text-muted">Total Produk</h6>
            <h3 class="text-info mb-0">{{ $totalProducts }}</h3>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 no-print">
        <h5 class="mb-0">Rincian Penjualan</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Ukuran</th>
                        <th>Pembeli</th>
                        <th>Pendapatan (Subtotal)</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sales as $sale)
                        <tr>
                            <td>
                                <div><strong>{{ $sale->product_name }}</strong></div>
                                <small class="text-muted">Qty: {{ $sale->qty }}</small>
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $sale->category_name ?? '-' }}</span></td>
                            <td>{{ $sale->ukuran ?? '-' }}</td>
                            <td>
                                <div>{{ $sale->customer_name }}</div>
                                <small class="text-muted">Order #{{ $sale->kode_pesanan }}</small>
                            </td>
                            <td class="fw-bold">IDR {{ number_format($sale->revenue, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($sale->date)->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data penjualan yang sesuai filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($sales->hasPages())
    <div class="card-footer bg-white no-print">
        {{ $sales->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
