@extends('layouts.store')

@section('content')
<div style="max-width: 1000px; margin: 0 auto; padding: 32px 24px;">
    
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; padding-bottom: 16px; border-bottom: 2px solid #111;">
        <h1 style="font-size: 28px; font-family: 'Playfair Display', serif; margin: 0;">Pesanan Saya</h1>
        <a href="{{ route('profile.index') }}" style="font-size: 13px; color: #6b7280; text-decoration: none;">
            ← Kembali ke Profil
        </a>
    </div>

    @if($orders->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 16px;">
            @foreach($orders as $order)
            <a href="{{ route('profile.order.show', $order) }}" style="display: block; background: white; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; text-decoration: none; color: inherit;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 200px;">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                            <p style="font-weight: 600; margin: 0; font-size: 16px;">
                                Order #{{ $order->kode_pesanan ?? str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                            </p>
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
                            <span style="background: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; text-transform: uppercase;">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </div>
                        <p style="font-size: 13px; color: #6b7280; margin: 0 0 12px 0;">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        
                        <!-- Items Preview -->
                        <div style="display: flex; gap: 8px;">
                            @foreach($order->items->take(4) as $item)
                            <div style="width: 50px; height: 60px; background: #f3f4f6; border-radius: 6px; overflow: hidden; flex-shrink: 0;">
                                @if($item->produk && $item->produk->gambar)
                                    <img src="{{ asset($item->produk->gambar) }}" style="width: 50px; height: 60px; object-fit: cover; display: block;">
                                @else
                                    <div style="width: 50px; height: 60px; background: #e5e7eb;"></div>
                                @endif
                            </div>
                            @endforeach
                            @if($order->items->count() > 4)
                                <div style="width: 50px; height: 60px; background: #f3f4f6; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; color: #6b7280;">
                                    +{{ $order->items->count() - 4 }}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div style="text-align: right;">
                        <p style="font-size: 18px; font-weight: 700; margin: 0;">IDR {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                        <p style="font-size: 13px; color: #6b7280; margin: 4px 0 0 0;">{{ $order->items->sum('jumlah') }} item</p>
                        <span style="display: inline-block; margin-top: 12px; font-size: 13px; color: #d4a5a5; font-weight: 500;">
                            Lihat Detail →
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div style="margin-top: 24px;">
            {{ $orders->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 60px 20px; background: #f9fafb; border-radius: 12px;">
            <svg style="width: 64px; height: 64px; margin: 0 auto 24px; color: #d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <h2 style="font-size: 24px; font-family: 'Playfair Display', serif; margin: 0 0 12px 0;">Belum Ada Pesanan</h2>
            <p style="color: #6b7280; margin: 0 0 24px 0;">Mulai berbelanja untuk melihat pesanan Anda di sini.</p>
            <a href="{{ route('shop.index') }}" style="display: inline-block; background: black; color: white; padding: 14px 32px; text-decoration: none; font-weight: 600; font-size: 14px; border-radius: 8px;">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection
