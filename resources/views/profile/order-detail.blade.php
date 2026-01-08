@extends('layouts.store')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding: 32px 24px;">
    
    <!-- Header -->
    <div style="margin-bottom: 32px;">
        <a href="{{ route('profile.orders') }}" style="font-size: 13px; color: #6b7280; text-decoration: none; display: inline-block; margin-bottom: 12px;">
            ← Kembali ke Pesanan
        </a>
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 16px; border-bottom: 2px solid #111;">
            <h1 style="font-size: 28px; font-family: 'Playfair Display', serif; margin: 0;">
                Order #{{ $order->kode_pesanan ?? str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
            </h1>
            @php
                $statusColors = [
                    'pending' => ['bg' => '#fef3c7', 'text' => '#d97706'],
                    'menunggu_verifikasi' => ['bg' => '#dbeafe', 'text' => '#2563eb'],
                    'diproses' => ['bg' => '#e0e7ff', 'text' => '#4f46e5'],
                    'dikirim' => ['bg' => '#ede9fe', 'text' => '#7c3aed'],
                    'selesai' => ['bg' => '#d1fae5', 'text' => '#059669'],
                    'dibatalkan' => ['bg' => '#fee2e2', 'text' => '#dc2626'],
                ];
                $colors = $statusColors[$order->status] ?? ['bg' => '#f3f4f6', 'text' => '#6b7280'];
            @endphp
            <span style="background: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase;">
                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
            </span>
        </div>
    </div>

    <!-- Order Info Grid -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 32px;">
        <div style="background: #f9fafb; padding: 20px; border-radius: 8px;">
            <h3 style="font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin: 0 0 8px 0;">Tanggal Pesanan</h3>
            <p style="font-weight: 500; margin: 0;">{{ $order->created_at->format('d M Y, H:i') }}</p>

            <h3 style="font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin: 16px 0 8px 0;">Metode Pengiriman</h3>
            <p style="font-weight: 500; margin: 0;">
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
        <div style="background: #f9fafb; padding: 20px; border-radius: 8px;">
            <h3 style="font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin: 0 0 8px 0;">Alamat Pengiriman</h3>
            <p style="font-weight: 500; margin: 0;">{{ $order->nama_penerima }}</p>
            <p style="font-size: 14px; color: #6b7280; margin: 4px 0 0 0;">{{ $order->alamat }}</p>
            <p style="font-size: 14px; color: #6b7280; margin: 2px 0 0 0;">{{ $order->kota }}, {{ $order->kode_pos }}</p>
            <p style="font-size: 14px; color: #6b7280; margin: 2px 0 0 0;">{{ $order->no_telp }}</p>
        </div>
    </div>

    <!-- Payment Status -->
    @if($order->status === 'pending' || $order->status_pembayaran === 'menunggu_pembayaran')
    <div style="background: #fef3c7; border-radius: 8px; padding: 20px; margin-bottom: 24px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; background: #fbbf24; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg style="width: 24px; height: 24px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div style="flex: 1;">
            <h4 style="margin: 0 0 4px 0; font-weight: 600; color: #92400e;">Menunggu Pembayaran</h4>
            <p style="margin: 0; font-size: 14px; color: #a16207;">Silakan lakukan pembayaran untuk memproses pesanan Anda.</p>
        </div>
        <a href="{{ route('payment.show', $order) }}" style="background: #d97706; color: white; padding: 12px 24px; border-radius: 8px; font-weight: 600; text-decoration: none; font-size: 14px;">
            Bayar Sekarang
        </a>
    </div>
    @elseif($order->status_pembayaran === 'lunas' || $order->status === 'diproses')
    <div style="background: #d1fae5; border-radius: 8px; padding: 20px; margin-bottom: 24px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; background: #059669; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg style="width: 24px; height: 24px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <div style="flex: 1;">
            <h4 style="margin: 0 0 4px 0; font-weight: 600; color: #065f46;">Pembayaran Berhasil</h4>
            <p style="margin: 0; font-size: 14px; color: #047857;">Pesanan Anda sedang diproses dan akan segera dikirim.</p>
        </div>
    </div>
    @endif

    <!-- Order Items -->
    <div style="margin-bottom: 32px;">
        <h2 style="font-size: 14px; font-weight: 600; text-transform: uppercase; margin: 0 0 16px 0;">Item Pesanan</h2>
        
        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
            @foreach($order->items as $item)
            <div style="display: flex; gap: 16px; padding: 16px; border-bottom: 1px solid #f3f4f6;">
                <!-- Fixed Image Size -->
                <div style="width: 80px; height: 100px; background: #f3f4f6; border-radius: 6px; overflow: hidden; flex-shrink: 0;">
                    @if($item->produk && $item->produk->gambar)
                        <img src="{{ asset($item->produk->gambar) }}" alt="{{ $item->produk->nama }}" style="width: 80px; height: 100px; object-fit: cover; display: block;">
                    @else
                        <div style="width: 80px; height: 100px; background: #e5e7eb; display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 24px; height: 24px; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                
                <div style="flex: 1;">
                    <h4 style="margin: 0; font-weight: 600; font-size: 15px;">{{ $item->produk->nama ?? 'Produk' }}</h4>
                    <p style="margin: 4px 0 0 0; font-size: 13px; color: #6b7280;">
                        {{ $item->warna ?? '-' }} / {{ $item->ukuran ?? '-' }}
                    </p>
                    <p style="margin: 4px 0 0 0; font-size: 13px; color: #9ca3af;">Qty: {{ $item->jumlah }}</p>
                </div>
                
                <div style="text-align: right;">
                    <p style="margin: 0; font-size: 13px; color: #6b7280;">IDR {{ number_format($item->harga_satuan, 0, ',', '.') }} x {{ $item->jumlah }}</p>
                    <p style="margin: 8px 0 0 0; font-weight: 600; font-size: 15px;">IDR {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Order Summary -->
    <div style="background: #f9fafb; padding: 24px; border-radius: 8px; margin-bottom: 24px;">
        <h2 style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #6b7280; margin: 0 0 16px 0; padding-bottom: 8px; border-bottom: 1px solid #e5e7eb;">Ringkasan Pesanan</h2>
        
        <div style="margin-bottom: 16px;">
            <div style="display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 8px;">
                <span style="color: #6b7280;">Subtotal ({{ $order->items->sum('jumlah') }} item)</span>
                <span>IDR {{ number_format($order->total_harga, 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 14px;">
                <span style="color: #6b7280;">Ongkos Kirim</span>
                <span style="color: #059669;">Gratis</span>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 16px; border-top: 1px solid #e5e7eb;">
            <span style="font-weight: 700; font-size: 16px;">Total</span>
            <span style="font-weight: 700; font-size: 24px;">IDR {{ number_format($order->total_harga, 0, ',', '.') }}</span>
        </div>
    </div>

    @if($order->catatan)
    <div style="background: #fefce8; border: 1px solid #fef08a; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
        <h3 style="font-size: 12px; font-weight: 600; color: #a16207; text-transform: uppercase; margin: 0 0 8px 0;">Catatan Pesanan</h3>
        <p style="margin: 0; font-size: 14px; color: #854d0e;">{{ $order->catatan }}</p>
    </div>
    @endif

    <!-- Actions -->
    <div style="display: flex; gap: 16px; flex-wrap: wrap;">
        <a href="{{ route('shop.index') }}" style="flex: 1; text-align: center; background: black; color: white; padding: 16px; text-decoration: none; font-weight: 600; font-size: 14px; border-radius: 8px;">
            Lanjut Belanja
        </a>
        @if(($order->status === 'pending' || $order->status_pembayaran === 'menunggu_pembayaran') && $order->status_pembayaran !== 'lunas')
        <a href="{{ route('payment.show', $order) }}" style="flex: 1; text-align: center; background: #d4a5a5; color: white; padding: 16px; text-decoration: none; font-weight: 600; font-size: 14px; border-radius: 8px;">
            Bayar Sekarang
        </a>
        @endif
    </div>
</div>
@endsection
