@extends('layouts.store')

@section('content')
<div style="min-height: 80vh; background: #f9fafb; padding: 32px 16px; display: flex; align-items: center; justify-content: center;">
    <div style="max-width: 600px; width: 100%; text-align: center;">
        
        @if($order->status_pembayaran == 'lunas' || $order->status == 'diproses')
        <!-- Payment Success - Fully Paid -->
        <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 32px;">
            <svg style="width: 50px; height: 50px; color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        
        <h1 style="font-size: 28px; font-family: 'Playfair Display', serif; font-weight: 400; margin: 0 0 16px 0; color: #111;">
            Pembayaran Berhasil!
        </h1>
        
        <p style="font-size: 16px; color: #6b7280; margin: 0 0 32px 0; line-height: 1.6;">
            Terima kasih! Pembayaran Anda telah dikonfirmasi. Pesanan Anda sedang diproses.
        </p>

        @elseif($order->status == 'menunggu_verifikasi')
        <!-- Payment Success - Waiting Admin Verification -->
        <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 32px;">
            <svg style="width: 50px; height: 50px; color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        
        <h1 style="font-size: 28px; font-family: 'Playfair Display', serif; font-weight: 400; margin: 0 0 16px 0; color: #111;">
            Pembayaran Berhasil!
        </h1>
        
        <p style="font-size: 16px; color: #6b7280; margin: 0 0 32px 0; line-height: 1.6;">
            Terima kasih! Pembayaran Anda sudah diterima dan sedang menunggu verifikasi admin. Kami akan segera memproses pesanan Anda.
        </p>

        @elseif($order->status == 'pending' || $order->status_pembayaran == 'menunggu_pembayaran')
        <!-- Pending Payment -->
        <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 32px;">
            <svg style="width: 50px; height: 50px; color: #d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        
        <h1 style="font-size: 28px; font-family: 'Playfair Display', serif; font-weight: 400; margin: 0 0 16px 0; color: #111;">
            Menunggu Pembayaran
        </h1>
        
        <p style="font-size: 16px; color: #6b7280; margin: 0 0 32px 0; line-height: 1.6;">
            Silakan selesaikan pembayaran Anda untuk memproses pesanan.
        </p>

        @else
        <!-- Generic Success -->
        <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 32px;">
            <svg style="width: 50px; height: 50px; color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        
        <h1 style="font-size: 28px; font-family: 'Playfair Display', serif; font-weight: 400; margin: 0 0 16px 0; color: #111;">
            Pesanan Tercatat!
        </h1>
        
        <p style="font-size: 16px; color: #6b7280; margin: 0 0 32px 0; line-height: 1.6;">
            Terima kasih! Pesanan Anda sedang dalam proses.
        </p>
        @endif
        
        <!-- Order Card -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 24px; margin-bottom: 32px; text-align: left;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <div>
                    <p style="font-size: 13px; color: #6b7280; margin: 0;">Nomor Pesanan</p>
                    <p style="font-size: 18px; font-weight: 600; margin: 4px 0 0 0;">#{{ $order->kode_pesanan ?? str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                @if($order->status_pembayaran == 'lunas' || $order->status == 'diproses')
                <span style="background: #d1fae5; color: #059669; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                    Pembayaran Lunas
                </span>
                @elseif($order->status == 'menunggu_verifikasi')
                <span style="background: #fef3c7; color: #d97706; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                    Menunggu Verifikasi
                </span>
                @elseif($order->status_pembayaran == 'menunggu_pembayaran')
                <span style="background: #dbeafe; color: #1d4ed8; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                    Menunggu Pembayaran
                </span>
                @else
                <span style="background: #f3f4f6; color: #374151; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                </span>
                @endif
            </div>
            
            <div style="border-top: 1px solid #e5e7eb; padding-top: 16px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #6b7280; font-size: 14px;">Total Pembayaran</span>
                    <span style="font-weight: 600;">IDR {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
                @if($order->metode_pembayaran)
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #6b7280; font-size: 14px;">Metode Pembayaran</span>
                    <span style="font-weight: 500;">{{ ucfirst(str_replace('_', ' ', $order->metode_pembayaran)) }}</span>
                </div>
                @elseif($order->bank_tujuan)
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #6b7280; font-size: 14px;">Bank Tujuan</span>
                    <span style="font-weight: 500;">{{ $order->bank_tujuan }}</span>
                </div>
                @endif
                @if($order->tanggal_pembayaran)
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #6b7280; font-size: 14px;">Tanggal Pembayaran</span>
                    <span style="font-weight: 500;">{{ $order->tanggal_pembayaran->format('d M Y, H:i') }}</span>
                </div>
                @endif
            </div>
            
            @if($order->bukti_pembayaran)
            <div style="border-top: 1px solid #e5e7eb; padding-top: 16px; margin-top: 16px;">
                <p style="font-size: 13px; color: #6b7280; margin: 0 0 8px 0;">Bukti Pembayaran</p>
                <img src="{{ asset($order->bukti_pembayaran) }}" alt="Bukti Pembayaran" style="max-width: 200px; border-radius: 8px; border: 1px solid #e5e7eb;">
            </div>
            @endif
        </div>
        
        <!-- What's Next -->
        <div style="background: #eff6ff; border-radius: 12px; padding: 24px; margin-bottom: 32px; text-align: left;">
            <h3 style="margin: 0 0 16px 0; font-size: 16px; font-weight: 600; color: #1e40af;">📋 Langkah Selanjutnya</h3>
            @if($order->status_pembayaran == 'lunas' || $order->status == 'diproses')
            <ol style="margin: 0; padding: 0 0 0 20px; font-size: 14px; color: #1e40af; line-height: 2;">
                <li>Pesanan Anda sedang diproses oleh tim kami</li>
                <li>Anda akan mendapat notifikasi saat pesanan dikirim</li>
                <li>Pantau status pengiriman di halaman profil</li>
                <li>Pesanan akan tiba dalam 2-5 hari kerja</li>
            </ol>
            @else
            <ol style="margin: 0; padding: 0 0 0 20px; font-size: 14px; color: #1e40af; line-height: 2;">
                <li>Tim kami akan memverifikasi pembayaran Anda</li>
                <li>Anda akan mendapat notifikasi saat pesanan diproses</li>
                <li>Pesanan akan dikirim setelah verifikasi berhasil</li>
                <li>Pantau status pesanan di halaman profil Anda</li>
            </ol>
            @endif
        </div>

        <!-- Order Items Preview -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 24px; margin-bottom: 32px; text-align: left;">
            <h3 style="margin: 0 0 16px 0; font-size: 16px; font-weight: 600;">Pesanan Anda</h3>
            @foreach($order->items as $item)
            <div style="display: flex; gap: 12px; margin-bottom: 12px; padding-bottom: 12px; {{ !$loop->last ? 'border-bottom: 1px solid #f3f4f6;' : '' }}">
                @if($item->product && $item->product->gambar)
                    <img src="{{ asset($item->product->gambar) }}" 
                         alt="{{ $item->product->nama ?? 'Product' }}" 
                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; background: #f3f4f6;">
                @else
                    <div style="width: 50px; height: 50px; background: #f3f4f6; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 20px; height: 20px; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
                <div style="flex: 1;">
                    <p style="margin: 0; font-weight: 500; font-size: 14px;">{{ $item->product->nama ?? 'Produk' }}</p>
                    <p style="margin: 4px 0 0 0; font-size: 13px; color: #6b7280;">{{ $item->jumlah }}x @ IDR {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                </div>
                <p style="margin: 0; font-weight: 600; font-size: 14px;">IDR {{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>
        
        <!-- Actions -->
        <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('profile.order.show', $order) }}" style="display: inline-flex; align-items: center; gap: 8px; background: black; color: white; padding: 14px 28px; border-radius: 8px; font-weight: 600; text-decoration: none; font-size: 14px; transition: all 0.2s;">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Lihat Detail Pesanan
            </a>
            <a href="{{ route('shop.index') }}" style="display: inline-flex; align-items: center; gap: 8px; background: white; color: #374151; padding: 14px 28px; border-radius: 8px; font-weight: 600; text-decoration: none; font-size: 14px; border: 1px solid #e5e7eb; transition: all 0.2s;">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Lanjut Belanja
            </a>
        </div>
    </div>
</div>

<style>
a:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}
</style>
@endsection
