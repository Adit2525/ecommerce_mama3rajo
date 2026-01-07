@extends('admin.layouts.app')

@section('title','Reports')

@section('content')
<h3 class="mb-4">Reports & Analytics</h3>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center p-3">
            <h6 class="text-muted">Total Revenue</h6>
            <h3 class="text-success">IDR {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center p-3">
            <h6 class="text-muted">Total Orders</h6>
            <h3 class="text-primary">{{ $totalOrders }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center p-3">
            <h6 class="text-muted">Pending Orders</h6>
            <h3 class="text-warning">{{ $pendingOrders }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center p-3">
            <h6 class="text-muted">Total Products</h6>
            <h3 class="text-info">{{ $totalProducts }}</h3>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">Rincian Penjualan</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
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
                            <td>
                                <div>{{ $sale->customer_name }}</div>
                                <small class="text-muted">Order #{{ $sale->kode_pesanan }}</small>
                            </td>
                            <td class="font-weight-bold">IDR {{ number_format($sale->revenue, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($sale->date)->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data penjualan yang selesai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($sales->hasPages())
    <div class="card-footer bg-white">
        {{ $sales->links() }}
    </div>
    @endif
</div>

@push('scripts')
{{-- No charts needed anymore --}}
@endpush

@endsection
