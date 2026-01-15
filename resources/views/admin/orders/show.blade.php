@extends('admin.layouts.app')

@section('title','Detail Pesanan')

@section('content')
<div class="mb-4 d-flex justify-content-between">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">&larr; Kembali</a>
    <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="btn btn-primary btn-sm"><i class="bi bi-printer"></i> Lihat Invoice</a>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Order Info -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">#{{ $order->kode_pesanan ?? str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h5>
                <span class="badge bg-{{ 
                    $order->status === 'selesai' ? 'success' :
                    ($order->status === 'pending' ? 'warning' :
                    ($order->status === 'menunggu_verifikasi' ? 'info' :
                    ($order->status === 'diproses' ? 'primary' :
                    ($order->status === 'dikirim' ? 'info' :
                    ($order->status === 'dibatalkan' ? 'danger' : 'secondary')))))
                }}">
                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Customer</h6>
                        <p class="mb-0">
                            <strong>{{ $order->nama_penerima ?? $order->user->name }}</strong><br>
                            {{ $order->user->email }}<br>
                            {{ $order->no_telp ?? '-' }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Alamat Pengiriman</h6>
                        <p class="mb-3">
                            {{ $order->alamat }}<br>
                            {{ $order->kota }}, {{ $order->kode_pos }}
                        </p>
                        
                        <h6 class="text-muted">Metode Pengiriman</h6>
                        <p class="mb-0 fw-bold">
                            @if($order->ekspedisi == 'toko')
                                Ekspedisi Toko
                            @elseif($order->ekspedisi == 'regular')
                                Regular (JNE/J&T/SiCepat)
                            @elseif($order->ekspedisi == 'lainnya')
                                Lainnya / Other
                            @else
                                {{ ucfirst($order->ekspedisi ?? '-') }}
                            @endif
                        </p>
                    </div>
                </div>

                <hr>

                <h6 class="text-muted mb-3">Item Pesanan</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Variasi</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($item->produk && $item->produk->gambar)
                                                <img src="{{ asset($item->produk->gambar) }}" alt="" style="width: 40px; height: 50px; object-fit: cover; border-radius: 4px;">
                                            @endif
                                            <span>{{ $item->produk->nama ?? 'Produk Dihapus' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $item->warna ?? '-' }} / {{ $item->ukuran ?? '-' }}
                                        </small>
                                    </td>
                                    <td class="text-center">{{ $item->jumlah }}</td>
                                    <td class="text-end">IDR {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-end"><strong>IDR {{ number_format($item->subtotal, 0, ',', '.') }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                <td class="text-end"><strong>IDR {{ number_format($order->total_harga, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($order->catatan)
                <hr>
                <h6 class="text-muted">Catatan</h6>
                <p class="mb-0">{{ $order->catatan }}</p>
                @endif
            </div>
        </div>

        <!-- Payment Proof -->
        @if($order->bukti_pembayaran)
        <div class="card mb-4 border-warning">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="bi bi-receipt me-2"></i>Bukti Pembayaran
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ asset($order->bukti_pembayaran) }}" target="_blank">
                            <img src="{{ asset($order->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="img-fluid rounded" style="max-height: 300px;">
                        </a>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="text-muted">Bank Tujuan:</td>
                                <td><strong>{{ $order->bank_tujuan ?? '-' }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Tanggal Konfirmasi:</td>
                                <td><strong>{{ $order->tanggal_pembayaran ? $order->tanggal_pembayaran->format('d M Y, H:i') : '-' }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Catatan Pembayaran:</td>
                                <td>{{ $order->catatan_pembayaran ?? '-' }}</td>
                            </tr>
                        </table>

                        @if($order->status === 'menunggu_verifikasi')
                        <div class="d-flex gap-2 mt-3">
                            <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                                @csrf
                                <input type="hidden" name="status" value="diproses">
                                <button type="submit" class="btn btn-success" onclick="return confirm('Verifikasi pembayaran dan proses pesanan?')">
                                    <i class="bi bi-check-lg me-1"></i> Verifikasi & Proses
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                                @csrf
                                <input type="hidden" name="status" value="pending">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak pembayaran?')">
                                    <i class="bi bi-x-lg me-1"></i> Tolak
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <!-- Update Status -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Update Status</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                    @csrf

                    <div class="mb-3">
                        <label for="status" class="form-label">Status Baru</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="">-- Pilih Status --</option>
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="menunggu_verifikasi" {{ $order->status === 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="diproses" {{ $order->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="dikirim" {{ $order->status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="note" class="form-label">Catatan</label>
                        <textarea name="note" id="note" class="form-control" rows="2" placeholder="Catatan perubahan status..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Update Status</button>
                </form>
            </div>
        </div>

        <!-- Order Timeline -->
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Timeline</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small><br>
                        <strong class="text-success">Pesanan Dibuat</strong>
                    </div>
                    @if($order->tanggal_pembayaran)
                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted">{{ $order->tanggal_pembayaran->format('d M Y, H:i') }}</small><br>
                        <strong class="text-info">Bukti Pembayaran Diupload</strong>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
