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

<!-- Search and Filter Card -->
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small text-muted">Cari Produk</label>
                <input type="text" name="search" class="form-control" placeholder="Nama produk..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Kategori</label>
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('kategori') == $category->id ? 'selected' : '' }}>{{ $category->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Ukuran</label>
                <select name="ukuran" class="form-select">
                    <option value="">Semua Ukuran</option>
                    @foreach($sizes as $size)
                        <option value="{{ $size }}" {{ request('ukuran') == $size ? 'selected' : '' }}>{{ $size }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>
            <div class="col-md-2">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">Filter</button>
                    @if(request()->hasAny(['search', 'kategori', 'ukuran', 'status']))
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="bi bi-x-lg"></i></a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 70px;">Gambar</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Ukuran</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>
                                @if($product->gambar)
                                     <img src="{{ asset($product->gambar) }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                     <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px; font-size: 10px;">No Img</div>
                                @endif
                            </td>
                            <td class="fw-medium">{{ $product->nama }}</td>
                            <td><span class="badge bg-info text-dark">{{ $product->category->nama ?? '-' }}</span></td>
                            <td>
                                @if($product->ukuran)
                                    <span class="badge bg-secondary">{{ $product->ukuran }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>IDR {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $product->stok > 0 ? 'success' : 'danger' }}">
                                    {{ $product->stok }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                    {{ $product->is_active ? 'Aktif' : 'Non-Aktif' }}
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
                            <td colspan="8" class="text-center text-muted py-4">
                                @if(request()->hasAny(['search', 'kategori', 'ukuran', 'status']))
                                    Tidak ada produk yang sesuai dengan filter. <a href="{{ route('admin.products.index') }}">Reset filter</a>
                                @else
                                    Tidak ada produk ditemukan. <a href="{{ route('admin.products.create') }}">Buat baru</a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($products->hasPages())
<div class="mt-4">
    {{ $products->withQueryString()->links() }}
</div>
@endif

@endsection
