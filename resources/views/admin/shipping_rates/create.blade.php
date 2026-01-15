@extends('admin.layouts.app')

@section('title', 'Tambah Tarif Ongkos Kirim')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h1 class="h3">Tambah Tarif Ongkos Kirim</h1>
        <p class="text-muted">Buat tarif pengiriman baru berdasarkan jarak atau zona.</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.shipping-rates.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="courier_name" class="form-label">Nama Ekspedisi <span class="text-danger">*</span></label>
                            <input type="text" name="courier_name" id="courier_name" class="form-control @error('courier_name') is-invalid @enderror" value="{{ old('courier_name') }}" placeholder="Contoh: JNE, J&T, Kurir Toko" required>
                            @error('courier_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="destination" class="form-label">Destinasi/Zona</label>
                            <input type="text" name="destination" id="destination" class="form-control @error('destination') is-invalid @enderror" value="{{ old('destination') }}" placeholder="Contoh: Dalam Kota, Luar Kota, Jambi">
                            @error('destination')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            <small class="text-muted">Kosongkan jika berlaku untuk semua destinasi.</small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="min_distance" class="form-label">Jarak Minimal (KM)</label>
                            <input type="number" name="min_distance" id="min_distance" class="form-control @error('min_distance') is-invalid @enderror" value="{{ old('min_distance') }}" placeholder="0" min="0">
                            @error('min_distance')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            <small class="text-muted">Contoh: 0 untuk dalam kota</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="max_distance" class="form-label">Jarak Maksimal (KM)</label>
                            <input type="number" name="max_distance" id="max_distance" class="form-control @error('max_distance') is-invalid @enderror" value="{{ old('max_distance') }}" placeholder="10" min="0">
                            @error('max_distance')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            <small class="text-muted">Contoh: 10 untuk radius 10 KM</small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Harga Ongkos Kirim <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">IDR</span>
                                <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="15000" min="0" required>
                            </div>
                            @error('price')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="estimate" class="form-label">Estimasi Pengiriman</label>
                            <input type="text" name="estimate" id="estimate" class="form-control @error('estimate') is-invalid @enderror" value="{{ old('estimate') }}" placeholder="Contoh: 1-2 Hari">
                            @error('estimate')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="is_active" class="form-label">Status</label>
                        <select name="is_active" id="is_active" class="form-select">
                            <option value="1" selected>Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Tarif</button>
                        <a href="{{ route('admin.shipping-rates.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body">
                <h6 class="fw-bold mb-3">💡 Tips Pengaturan</h6>
                <ul class="small text-muted mb-0">
                    <li class="mb-2"><strong>Dalam Kota:</strong> Jarak 0-10 KM, Ongkir IDR 10.000</li>
                    <li class="mb-2"><strong>Pinggiran:</strong> Jarak 10-25 KM, Ongkir IDR 15.000</li>
                    <li class="mb-2"><strong>Luar Kota:</strong> Jarak 25-50 KM, Ongkir IDR 25.000</li>
                    <li><strong>Antar Provinsi:</strong> Gunakan JNE/J&T dengan harga tetap</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
