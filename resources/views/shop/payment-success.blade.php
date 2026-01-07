@extends('layouts.store')

@section('content')
<div style="min-height: 80vh; background: #f9fafb; padding: 32px 16px; display: flex; align-items: center; justify-content: center;">
    <div style="max-width: 600px; width: 100%; text-align: center;">
        
        <!-- Success Icon -->
        <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 32px;">
            <svg style="width: 50px; height: 50px; color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        
        <!-- Title -->
        <h1 style="font-size: 28px; font-family: 'Playfair Display', serif; font-weight: 400; margin: 0 0 16px 0; color: #111;">
            Bukti Pembayaran Terkirim!
        </h1>
        
        <p style="font-size: 16px; color: #6b7280; margin: 0 0 32px 0; line-height: 1.6;">
            Terima kasih! Kami akan memverifikasi pembayaran Anda dalam waktu 1x24 jam.
        </p>
        
        <!-- Order Card -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 24px; margin-bottom: 32px; text-align: left;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <div>
                    <p style="font-size: 13px; color: #6b7280; margin: 0;">Nomor Pesanan</p>
                    <p style="font-size: 18px; font-weight: 600; margin: 4px 0 0 0;">#{{ $order->kode_pesanan ?? str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <span style="background: #fef3c7; color: #d97706; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                    Menunggu Verifikasi
                </span>
            </div>
            
            <div style="border-top: 1px solid #e5e7eb; padding-top: 16px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #6b7280; font-size: 14px;">Total Pembayaran</span>
                    <span style="font-weight: 600;">IDR {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #6b7280; font-size: 14px;">Bank Tujuan</span>
                    <span style="font-weight: 500;">{{ $order->bank_tujuan ?? '-' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #6b7280; font-size: 14px;">Tanggal Konfirmasi</span>
                    <span style="font-weight: 500;">{{ $order->tanggal_pembayaran ? $order->tanggal_pembayaran->format('d M Y, H:i') : '-' }}</span>
                </div>
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
            <ol style="margin: 0; padding: 0 0 0 20px; font-size: 14px; color: #1e40af; line-height: 2;">
                <li>Tim kami akan memverifikasi pembayaran Anda</li>
                <li>Anda akan mendapat notifikasi saat pesanan diproses</li>
                <li>Pesanan akan dikirim setelah verifikasi berhasil</li>
                <li>Pantau status pesanan di halaman profil Anda</li>
            </ol>
        </div>
        
        <!-- Actions -->
        <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('profile.order.show', $order) }}" style="display: inline-flex; align-items: center; gap: 8px; background: black; color: white; padding: 14px 28px; border-radius: 8px; font-weight: 600; text-decoration: none; font-size: 14px;">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Lihat Detail Pesanan
            </a>
            <a href="{{ route('shop.index') }}" style="display: inline-flex; align-items: center; gap: 8px; background: white; color: #374151; padding: 14px 28px; border-radius: 8px; font-weight: 600; text-decoration: none; font-size: 14px; border: 1px solid #e5e7eb;">
                Lanjut Belanja
            </a>
        </div>
    </div>
</div>
@endsection
