@extends('admin.layouts.app')

@section('title', 'Permintaan Ubah Password')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h1 class="h3">Permintaan Ubah Password</h1>
        <p class="text-muted">Verifikasi permintaan perubahan password dari pelanggan.</p>
    </div>
    @if($pendingCount > 0)
    <div class="col-auto">
        <span class="badge bg-warning text-dark fs-6 px-3 py-2">
            {{ $pendingCount }} Menunggu Verifikasi
        </span>
    </div>
    @endif
</div>

<!-- Filter -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.password-requests.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.password-requests.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Requests Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Pengguna</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Tanggal Request</th>
                        <th>Diproses Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                    <tr class="{{ $req->status === 'pending' ? 'table-warning' : '' }}">
                        <td>{{ $req->id }}</td>
                        <td class="fw-medium">{{ $req->user->name ?? 'User Deleted' }}</td>
                        <td>{{ $req->user->email ?? '-' }}</td>
                        <td>
                            @if($req->status === 'pending')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($req->status === 'approved')
                                <span class="badge bg-success">Disetujui</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>{{ $req->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            @if($req->approver)
                                {{ $req->approver->name }}
                                <small class="d-block text-muted">{{ $req->approved_at?->format('d M Y') }}</small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($req->status === 'pending')
                            <div class="btn-group btn-group-sm">
                                <form action="{{ route('admin.password-requests.approve', $req) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menyetujui perubahan password untuk {{ $req->user->name }}?')">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        ✓ Setujui
                                    </button>
                                </form>
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $req->id }}">
                                    ✕ Tolak
                                </button>
                            </div>
                            
                            <!-- Reject Modal -->
                            <div class="modal fade" id="rejectModal{{ $req->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.password-requests.reject', $req) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tolak Permintaan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Tolak permintaan perubahan password dari <strong>{{ $req->user->name }}</strong>?</p>
                                                <div class="mb-3">
                                                    <label class="form-label">Catatan (Opsional)</label>
                                                    <textarea name="admin_note" class="form-control" rows="3" placeholder="Alasan penolakan..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Tolak</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @else
                                @if($req->admin_note)
                                <small class="text-muted" title="{{ $req->admin_note }}">📝 Ada catatan</small>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            Tidak ada permintaan perubahan password.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($requests->hasPages())
        <div class="mt-3">
            {{ $requests->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
