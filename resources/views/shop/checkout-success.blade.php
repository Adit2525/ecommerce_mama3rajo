@extends('layouts.store')

@section('content')
<div style="min-height: 80vh; background: #f9fafb; padding: 32px 16px; display: flex; align-items: center; justify-content: center;">
    <div style="max-width: 700px; width: 100%; text-align: center;">
        
        <!-- Success Icon -->
        <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 32px;">
            <svg style="width: 50px; height: 50px; color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        
        <!-- Title -->
        <h1 style="font-size: 32px; font-family: 'Playfair Display', serif; font-weight: 400; margin: 0 0 16px 0; color: #111;">
            Pesanan Berhasil Dibuat!
        </h1>
        
        <p style="font-size: 16px; color: #6b7280; margin: 0 0 32px 0; line-height: 1.6;">
            Terima kasih atas pesanan Anda. Silakan lakukan pembayaran untuk memproses pesanan.
        </p>
        
        <!-- Order Card -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 24px; margin-bottom: 32px; text-align: left;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
                <div>
                    <p style="font-size: 13px; color: #6b7280; margin: 0;">Nomor Pesanan</p>
                    <p style="font-size: 22px; font-weight: 700; margin: 4px 0 0 0;">#{{ $order->kode_pesanan ?? str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <span style="background: #fef3c7; color: #d97706; padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                    Menunggu Pembayaran
                </span>
            </div>
            
            <!-- Order Summary -->
            <div style="border-top: 1px solid #e5e7eb; padding-top: 20px;">
                <h4 style="margin: 0 0 16px 0; font-size: 14px; font-weight: 600; color: #374151;">Ringkasan Pesanan</h4>
                
                @foreach($order->items as $item)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #f3f4f6;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        @if($item->produk && $item->produk->gambar)
                        <img src="{{ asset($item->produk->gambar) }}" alt="" style="width: 50px; height: 60px; object-fit: cover; border-radius: 6px;">
                        @else
                        <div style="width: 50px; height: 60px; background: #f3f4f6; border-radius: 6px;"></div>
                        @endif
                        <div>
                            <p style="margin: 0; font-weight: 500; font-size: 14px;">{{ $item->produk->nama ?? 'Produk' }}</p>
                            <p style="margin: 4px 0 0 0; font-size: 12px; color: #6b7280;">
                                {{ $item->warna ?? 'Hitam' }} • {{ $item->ukuran ?? 'All Size' }} • Qty: {{ $item->jumlah }}
                            </p>
                        </div>
                    </div>
                    <p style="margin: 0; font-weight: 600;">IDR {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                </div>
                @endforeach
                
                <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 16px; margin-top: 8px;">
                    <span style="font-size: 16px; font-weight: 700;">Total Pembayaran</span>
                    <span style="font-size: 22px; font-weight: 700; color: #059669;">IDR {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        
        <!-- Payment Info Box -->
        <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 12px; padding: 24px; margin-bottom: 32px; text-align: left;">
            <div style="display: flex; align-items: flex-start; gap: 16px;">
                <div style="width: 48px; height: 48px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 24px; height: 24px; color: #d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 600; color: #92400e;">Langkah Selanjutnya</h3>
                    <p style="margin: 0; font-size: 14px; color: #92400e; line-height: 1.6;">
                        Lakukan pembayaran ke rekening kami dan upload bukti transfer untuk memproses pesanan Anda.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('payment.show', $order) }}" style="display: inline-flex; align-items: center; gap: 8px; background: #d4a5a5; color: white; padding: 16px 32px; border-radius: 8px; font-weight: 600; text-decoration: none; font-size: 16px;">
                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Bayar Sekarang
            </a>
            <a href="{{ route('profile.order.show', $order) }}" style="display: inline-flex; align-items: center; gap: 8px; background: white; color: #374151; padding: 16px 32px; border-radius: 8px; font-weight: 600; text-decoration: none; font-size: 16px; border: 1px solid #e5e7eb;">
                Lihat Detail Pesanan
            </a>
        </div>
        
        <p style="margin-top: 24px; font-size: 13px; color: #9ca3af;">
            Butuh bantuan? <a href="#" style="color: #d4a5a5; text-decoration: underline;">Hubungi kami</a>
        </p>
    </div>
</div>
@endsection
