@extends('admin.layouts.app')

@section('title','Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Orders</h3>
    <span class="badge bg-info">{{ $orders->total() }} Total</span>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td><code>{{ $order->kode_pesanan ?? '#'.str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</code></td>
                    <td>
                        <div>{{ $order->nama_penerima }}</div>
                        <small class="text-muted">{{ $order->no_telp }}</small>
                    </td>
                    <td>{{ $order->items_count ?? $order->items->count() }} items</td>
                    <td>IDR {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td>
                        @php
                            $statusColors = [
                                'pending' => 'warning',
                                'menunggu_verifikasi' => 'primary',
                                'diproses' => 'info',
                                'dikirim' => 'purple',
                                'selesai' => 'success',
                                'dibatalkan' => 'danger',
                            ];
                            $color = $statusColors[$order->status] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $color }}">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </td>
                    <td>
                        {{ $order->created_at->format('d M Y') }}<br>
                        <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">
                                View
                            </a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini? Tindakan ini tidak dapat dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No orders found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $orders->links() }}
</div>

@endsection
