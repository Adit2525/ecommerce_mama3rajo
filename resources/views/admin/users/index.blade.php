@extends('admin.layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h1 class="h3">Kelola Pengguna</h1>
        <p class="text-muted">Kelola akun pengguna, verifikasi email, dan reset password.</p>
    </div>
</div>

<!-- Search & Filters -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="role" class="form-select">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="verified" class="form-select">
                    <option value="">Status Verifikasi</option>
                    <option value="yes" {{ request('verified') == 'yes' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="no" {{ request('verified') == 'no' ? 'selected' : '' }}>Belum Verifikasi</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Verifikasi Email</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td class="fw-medium">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-{{ $user->role === 'admin' ? 'dark' : 'secondary' }}">
                                {{ ucfirst($user->role ?? 'user') }}
                            </span>
                        </td>
                        <td>
                            @if($user->email_verified_at)
                                <span class="badge bg-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16" class="me-1">
                                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                                    </svg>
                                    Terverifikasi
                                </span>
                                <small class="d-block text-muted">{{ $user->email_verified_at->format('d M Y') }}</small>
                            @else
                                <span class="badge bg-warning text-dark">Belum Verifikasi</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary" title="Edit">
                                    Edit
                                </a>
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @if(!$user->email_verified_at)
                                    <li>
                                        <form action="{{ route('admin.users.verify', $user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-success">
                                                ✓ Verifikasi Email
                                            </button>
                                        </form>
                                    </li>
                                    @else
                                    <li>
                                        <form action="{{ route('admin.users.unverify', $user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-warning">
                                                ✕ Cabut Verifikasi
                                            </button>
                                        </form>
                                    </li>
                                    @endif
                                    <li>
                                        <form action="{{ route('admin.users.send-reset-link', $user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                📧 Kirim Link Reset Password
                                            </button>
                                        </form>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                🗑️ Hapus User
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Tidak ada data pengguna.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
        <div class="mt-3">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
