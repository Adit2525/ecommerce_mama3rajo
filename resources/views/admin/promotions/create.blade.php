@extends('admin.layouts.app')

@section('title', 'Buat Promosi Baru')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Buat Promosi Baru</h3>
    <a href="{{ route('admin.promotions.index') }}" class="btn btn-secondary">&larr; Kembali</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.promotions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Judul Promosi <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required placeholder="Contoh: Diskon Kemerdekaan 50%">
                        @error('judul') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai') }}">
                                @error('tanggal_mulai') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Berakhir</label>
                                <input type="date" name="tanggal_berakhir" class="form-control" value="{{ old('tanggal_berakhir') }}">
                                @error('tanggal_berakhir') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Banner Promosi <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        <div class="form-text">Format: JPG, PNG. Max: 2MB. Recommended Size: 1200x400px</div>
                        @error('image') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" checked>
                            <label class="form-check-label" for="isActive">Status Aktif</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Simpan Promosi</button>
            </div>
        </form>
    </div>
</div>
@endsection
