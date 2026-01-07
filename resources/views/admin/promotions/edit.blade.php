@extends('admin.layouts.app')

@section('title', 'Edit Promosi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Edit Promosi</h3>
    <a href="{{ route('admin.promotions.index') }}" class="btn btn-secondary">&larr; Kembali</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.promotions.update', $promotion) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Judul Promosi <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" value="{{ old('judul', $promotion->judul) }}" required>
                        @error('judul') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $promotion->deskripsi) }}</textarea>
                        @error('deskripsi') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', $promotion->tanggal_mulai ? \Carbon\Carbon::parse($promotion->tanggal_mulai)->format('Y-m-d') : '') }}">
                                @error('tanggal_mulai') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Berakhir</label>
                                <input type="date" name="tanggal_berakhir" class="form-control" value="{{ old('tanggal_berakhir', $promotion->tanggal_berakhir ? \Carbon\Carbon::parse($promotion->tanggal_berakhir)->format('Y-m-d') : '') }}">
                                @error('tanggal_berakhir') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Banner Promosi</label>
                        @if($promotion->gambar)
                            <div class="mb-2">
                                <img src="{{ asset($promotion->gambar) }}" class="img-fluid rounded border" alt="Current Banner">
                            </div>
                        @else
                            <div class="mb-2 p-3 bg-light text-center border rounded">Tidak ada banner</div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="form-text">Biarkan kosong jika tidak ingin mengubah gambar. Max: 2MB.</div>
                        @error('image') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ $promotion->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="isActive">Status Aktif</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update Promosi</button>
            </div>
        </form>
    </div>
</div>
@endsection
