@extends('admin.layouts.app')

@section('title','Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Produk</h3>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Tambah Produk</a>
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
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td style="width: 80px;">
                        @if($product->gambar)
                             <img src="{{ asset($product->gambar) }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                             <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px; font-size: 10px;">Tanpa Foto</div>
                        @endif
                    </td>
                    <td>{{ $product->nama }}</td>
                    <td><span class="badge bg-info text-dark">{{ $product->category->nama ?? '-' }}</span></td>
                    <td>IDR {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge bg-{{ $product->stok > 0 ? 'success' : 'danger' }}">
                            {{ $product->stok }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                            {{ $product->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Tidak ada produk ditemukan. <a href="{{ route('admin.products.create') }}">Buat baru</a></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $products->links() }}
</div>

@endsection
