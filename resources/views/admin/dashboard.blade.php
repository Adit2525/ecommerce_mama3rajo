@extends('admin.layouts.app')

@section('title','Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted text-uppercase small fw-bold">Total Produk</h6>
                <h2 class="mb-0">{{ number_format($totalProducts) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
             <div class="card-body">
                <h6 class="text-muted text-uppercase small fw-bold">Total Pesanan</h6>
                <h2 class="mb-0">{{ number_format($totalOrders) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
             <div class="card-body">
                <h6 class="text-muted text-uppercase small fw-bold">Pesanan Menunggu</h6>
                <h2 class="mb-0 text-warning">{{ number_format($pendingOrders) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
             <div class="card-body">
                <h6 class="text-muted text-uppercase small fw-bold">Total Pendapatan</h6>
                <h2 class="mb-0 text-success">IDR {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0">Ringkasan Penjualan</h5>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="120"></canvas>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Pesanan Terbaru</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td>{{ $order->kode_pesanan }}</td>
                            <td>{{ $order->user->name ?? $order->nama_penerima ?? 'Guest' }}</td>
                            <td>IDR {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $badgeClass = match($order->status) {
                                        'selesai' => 'success',
                                        'dikirim' => 'primary',
                                        'diproses' => 'info',
                                        'menunggu_verifikasi' => 'warning',
                                        'pending' => 'warning',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeClass }}">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-3 text-muted">Belum ada pesanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0">Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Tambah Produk Baru</a>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Kelola Pesanan</a>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">Lihat Laporan</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const ctx = document.getElementById('salesChart');
if (ctx) {
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Sales (IDR)',
                data: @json($chartData),
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
}
</script>
@endpush

@endsection
