@extends('admin.layouts.app')

@section('title', 'Kelola Ongkos Kirim')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h1 class="h3">Daftar Ongkos Kirim</h1>
        <p class="text-muted">Kelola tarif pengiriman berdasarkan jarak atau destinasi.</p>
    </div>
    <div class="col-auto">
        <a href="{{ route('admin.shipping-rates.create') }}" class="btn btn-primary">
            + Tambah Tarif
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Ekspedisi</th>
                        <th>Destinasi/Zona</th>
                        <th>Jarak (KM)</th>
                        <th>Estimasi</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rates as $rate)
                    <tr>
                        <td class="fw-medium">{{ $rate->courier_name }}</td>
                        <td>{{ $rate->destination ?? 'Semua' }}</td>
                        <td>
                            @if($rate->min_distance || $rate->max_distance)
                                <span class="badge bg-info text-dark">
                                    {{ $rate->min_distance ?? 0 }} - {{ $rate->max_distance ?? '∞' }} KM
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $rate->estimate ?? '-' }}</td>
                        <td class="fw-bold">IDR {{ number_format($rate->price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $rate->is_active ? 'success' : 'secondary' }}">
                                {{ $rate->is_active ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.shipping-rates.edit', $rate->id) }}" class="btn btn-outline-warning">Edit</a>
                                <form action="{{ route('admin.shipping-rates.destroy', $rate->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus tarif ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            Belum ada data tarif ongkos kirim. <a href="{{ route('admin.shipping-rates.create') }}">Tambah sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($rates->hasPages())
        <div class="mt-3">
            {{ $rates->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
