@extends('admin.layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
<div class="row mb-4">
    <div class="col">
        <a href="{{ route('admin.users.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
            ← Kembali ke Daftar Pengguna
        </a>
        <h1 class="h3">Edit Pengguna</h1>
        <p class="text-muted">Perbarui informasi pengguna.</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- User Info -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Informasi Akun</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                        @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                        <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>

        <!-- Reset Password -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Reset Password</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold text-secondary">Kirim Link Reset</h6>
                        <p class="small text-muted mb-3">Kirim email berisi link untuk reset password ke pengguna.</p>
                        <form action="{{ route('admin.users.send-reset-link', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary">
                                📧 Kirim Link Reset Password
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold text-secondary">Reset Manual</h6>
                        <p class="small text-muted mb-3">Set password baru secara langsung tanpa email.</p>
                        <form action="{{ route('admin.users.reset-password', $user) }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <input type="password" name="password" class="form-control form-control-sm @error('password') is-invalid @enderror" placeholder="Password baru" required>
                                @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-2">
                                <input type="password" name="password_confirmation" class="form-control form-control-sm" placeholder="Konfirmasi password" required>
                            </div>
                            <button type="submit" class="btn btn-warning btn-sm">
                                🔐 Reset Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- User Status -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Status Verifikasi</h5>
            </div>
            <div class="card-body">
                @if($user->email_verified_at)
                    <div class="alert alert-success mb-3">
                        <strong>✓ Email Terverifikasi</strong>
                        <br>
                        <small>{{ $user->email_verified_at->format('d M Y, H:i') }}</small>
                    </div>
                    <form action="{{ route('admin.users.unverify', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning w-100">
                            ✕ Cabut Verifikasi
                        </button>
                    </form>
                @else
                    <div class="alert alert-warning mb-3">
                        <strong>⚠ Email Belum Diverifikasi</strong>
                    </div>
                    <form action="{{ route('admin.users.verify', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">
                            ✓ Verifikasi Email Sekarang
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- User Info Card -->
        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Info Akun</h6>
                <table class="table table-sm table-borderless small mb-0">
                    <tr>
                        <td class="text-muted">ID</td>
                        <td class="text-end">#{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Terdaftar</td>
                        <td class="text-end">{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Update Terakhir</td>
                        <td class="text-end">{{ $user->updated_at->format('d M Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Danger Zone -->
        @if($user->id !== auth()->id())
        <div class="card border-danger mt-4">
            <div class="card-header bg-danger text-white py-3">
                <h6 class="mb-0 fw-bold">⚠ Zona Berbahaya</h6>
            </div>
            <div class="card-body">
                <p class="small text-muted mb-3">Menghapus pengguna akan menghapus semua data terkait.</p>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        🗑️ Hapus Pengguna
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
