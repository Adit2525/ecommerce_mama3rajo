@extends('admin.layouts.app')

@section('title','Promosi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Promosi</h3>
    <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary">+ Tambah Promosi</a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-light">
            <tr>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Periode</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($promotions as $promotion)
                <tr>
                    <td style="width: 120px;">
                        @if($promotion->gambar)
                             <img src="{{ asset($promotion->gambar) }}" class="rounded" style="width: 100px; height: 50px; object-fit: cover;">
                        @else
                             <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 100px; height: 50px; font-size: 10px;">Tanpa Banner</div>
                        @endif
                    </td>
                    <td>
                        <div class="fw-bold">{{ $promotion->judul }}</div>
                        <small class="text-muted">{{ Str::limit($promotion->deskripsi, 50) }}</small>
                    </td>
                    <td>
                        @if($promotion->tanggal_mulai && $promotion->tanggal_berakhir)
                            <small class="d-block">Mulai: {{ \Carbon\Carbon::parse($promotion->tanggal_mulai)->format('d M Y') }}</small>
                            <small class="d-block">Selesai: {{ \Carbon\Carbon::parse($promotion->tanggal_berakhir)->format('d M Y') }}</small>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-{{ $promotion->is_active ? 'success' : 'secondary' }}">
                            {{ $promotion->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.promotions.edit', $promotion) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="{{ route('admin.promotions.destroy', $promotion) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus promosi ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Belum ada promosi. <a href="{{ route('admin.promotions.create') }}">Buat baru</a></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $promotions->links() }}
</div>

@endsection
