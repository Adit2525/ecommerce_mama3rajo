@extends('admin.layouts.app')

@section('title','Edit Produk')

@section('content')
<h3>Edit Produk</h3>

<form method="POST" action="{{ route('admin.products.update', $product) }}" class="mt-4" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-md-8">
            <div class="card p-4">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Produk *</label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $product->nama) }}" required>
                    @error('nama')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="5" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                    @error('deskripsi')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Gambar Saat Ini</label>
                    <div class="d-flex flex-wrap gap-2 mb-2">
                        @if($product->gambar)
                            <div class="position-relative" style="width: 100px; height: 100px;">
                                <img src="{{ asset($product->gambar) }}" class="w-100 h-100 object-fit-cover rounded border">
                            </div>
                        @else
                            <p class="text-muted small">Belum ada gambar.</p>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label for="images" class="form-label">Perbarui Gambar</label>
                    <input type="file" name="images[]" id="images" class="form-control @error('images') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Mengunggah gambar baru akan menggantikan yang lama.</small>
                    @error('images')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                

            </div>
        </div>
        <div class="col-md-4">
             <div class="card p-4">
                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori *</label>
                    <select name="kategori_id" id="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('kategori_id', $product->kategori_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="mb-3">
                    <label for="harga_coret" class="form-label">Harga Asli (Sebelum Diskon)</label>
                    <div class="input-group">
                        <span class="input-group-text">IDR</span>
                        <input type="number" step="1" name="harga_coret" id="harga_coret" class="form-control @error('harga_coret') is-invalid @enderror" value="{{ old('harga_coret', $product->harga_coret) }}" placeholder="Contoh: 100000">
                    </div>
                    @error('harga_coret')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label for="diskon" class="form-label">Diskon (%)</label>
                    <input type="number" id="diskon" class="form-control" placeholder="0" min="0" max="100">
                    <small class="text-muted">Masukkan persentase (misal: 20)</small>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga Jual (Setelah Diskon) *</label>
                    <div class="input-group">
                        <span class="input-group-text">IDR</span>
                        <input type="number" step="1" name="harga" id="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', $product->harga) }}" required>
                    </div>
                    @error('harga')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" name="stok" id="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $product->stok) }}">
                    @error('stok')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="mb-3">
                    <label for="ukuran" class="form-label">Ukuran</label>
                    <select name="ukuran" id="ukuran" class="form-select @error('ukuran') is-invalid @enderror">
                        <option value="">Pilih Ukuran</option>
                        <option value="All Size" {{ old('ukuran', $product->ukuran) == 'All Size' ? 'selected' : '' }}>All Size</option>
                        <option value="S" {{ old('ukuran', $product->ukuran) == 'S' ? 'selected' : '' }}>S</option>
                        <option value="M" {{ old('ukuran', $product->ukuran) == 'M' ? 'selected' : '' }}>M</option>
                        <option value="L" {{ old('ukuran', $product->ukuran) == 'L' ? 'selected' : '' }}>L</option>
                        <option value="XL" {{ old('ukuran', $product->ukuran) == 'XL' ? 'selected' : '' }}>XL</option>
                        <option value="XXL" {{ old('ukuran', $product->ukuran) == 'XXL' ? 'selected' : '' }}>XXL</option>
                    </select>
                    @error('ukuran')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                
                <div class="mb-3">
                    <label for="is_active" class="form-label">Status</label>
                    <select name="is_active" id="is_active" class="form-select @error('is_active') is-invalid @enderror">
                        <option value="1" {{ old('is_active', $product->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active', $product->is_active) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('is_active')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                 <hr>
                <button type="submit" class="btn btn-primary w-100">Update Produk</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary w-100 mt-2">Batal</a>
             </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hargaCoretInput = document.getElementById('harga_coret');
        const diskonInput = document.getElementById('diskon');
        const hargaInput = document.getElementById('harga');

        // Initial calculation if data exists
        if(hargaInput.value) {
             // Jika harga coret kosong tapi ada harga jual, asumsikan ini harga asli
             if(!hargaCoretInput.value || parseFloat(hargaCoretInput.value) === 0) {
                 hargaCoretInput.value = hargaInput.value;
             }
             
             // Hitung diskon yang sedang berjalan (jika ada)
             const hCoret = parseFloat(hargaCoretInput.value);
             const hJual = parseFloat(hargaInput.value);
             
             if(hCoret > hJual) {
                 const diff = hCoret - hJual;
                 const percent = (diff / hCoret) * 100;
                 diskonInput.value = Math.round(percent);
             }
        }

        function calculateDiscount() {
            const hargaAsli = parseFloat(hargaCoretInput.value) || 0;
            const diskon = parseFloat(diskonInput.value) || 0;

            if (hargaAsli > 0) {
                if (diskon > 0) {
                    const discountAmount = hargaAsli * (diskon / 100);
                    const finalPrice = hargaAsli - discountAmount;
                    hargaInput.value = Math.round(finalPrice);
                }
            }
        }

        hargaCoretInput.addEventListener('input', calculateDiscount);
        diskonInput.addEventListener('input', calculateDiscount);
    });
</script>
@endpush


