@extends('layouts.store')

@section('content')
<div style="min-height: 80vh; background: #f9fafb; padding: 32px 16px;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        <!-- Breadcrumb -->
        <div style="margin-bottom: 24px; font-size: 14px;">
            <a href="{{ route('welcome') }}" style="color: #6b7280;">Beranda</a>
            <span style="margin: 0 8px; color: #9ca3af;">/</span>
            <span style="color: #000; font-weight: 500;">Keranjang Belanja</span>
        </div>

        @if(session('success'))
            <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #047857; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-size: 14px;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('cart') && count(session('cart')) > 0)
            <div style="display: flex; flex-wrap: wrap; gap: 32px;">
                
                <!-- Cart Items -->
                <div style="flex: 1; min-width: 300px;">
                    <div style="background: white; border-radius: 8px; border: 1px solid #e5e7eb; overflow: hidden;">
                        <div style="padding: 16px 24px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h1 style="font-size: 18px; font-weight: 700; margin: 0;">Keranjang Belanja</h1>
                                <p style="font-size: 14px; color: #6b7280; margin: 4px 0 0 0;">{{ count(session('cart')) }} item</p>
                            </div>
                            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Hapus semua item?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="font-size: 14px; color: #ef4444; background: none; border: none; cursor: pointer;">
                                    Kosongkan
                                </button>
                            </form>
                        </div>
                        
                        @foreach(session('cart') as $key => $details)
                        <div style="padding: 20px 24px; border-bottom: 1px solid #f3f4f6; display: flex; gap: 16px;">
                            <!-- Image - FIXED SIZE -->
                            <div style="width: 80px; height: 100px; min-width: 80px; background: #f3f4f6; border-radius: 8px; overflow: hidden; flex-shrink: 0;">
                                @if($details['image'])
                                    <img src="{{ asset($details['image']) }}" alt="{{ $details['name'] }}" style="width: 80px; height: 100px; object-fit: cover; display: block;">
                                @else
                                    <div style="width: 80px; height: 100px; background: #e5e7eb; display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 32px; height: 32px; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Details -->
                            <div style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                                <div>
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                        <div>
                                            <h3 style="font-weight: 700; font-size: 16px; margin: 0;">{{ $details['name'] }}</h3>
                                            <p style="font-size: 13px; color: #6b7280; margin: 4px 0 0 0;">
                                                {{ $details['color'] ?? 'Hitam' }} • {{ $details['size'] ?? 'All Size' }}
                                            </p>
                                        </div>
                                        <p style="font-weight: 700; font-size: 16px; margin: 0;">IDR {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</p>
                                    </div>
                                    <p style="font-size: 12px; color: #9ca3af; margin: 4px 0 0 0;">@ IDR {{ number_format($details['price'], 0, ',', '.') }}</p>
                                </div>
                                
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px;">
                                    <!-- Quantity -->
                                    <form action="{{ route('cart.update', $key) }}" method="POST" style="display: flex; align-items: center;">
                                        @csrf
                                        @method('PATCH')
                                        <div style="display: flex; align-items: center; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
                                            <button type="submit" name="quantity" value="{{ max(1, $details['quantity'] - 1) }}" 
                                                    style="width: 36px; height: 36px; background: white; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;"
                                                    {{ $details['quantity'] <= 1 ? 'disabled' : '' }}>−</button>
                                            <span style="width: 40px; text-align: center; font-weight: 700;">{{ $details['quantity'] }}</span>
                                            <button type="submit" name="quantity" value="{{ $details['quantity'] + 1 }}" 
                                                    style="width: 36px; height: 36px; background: white; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;">+</button>
                                        </div>
                                    </form>
                                    
                                    <!-- Remove -->
                                    <form action="{{ route('cart.destroy', $key) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="font-size: 14px; color: #ef4444; background: none; border: none; cursor: pointer;">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Summary -->
                <div style="width: 350px; flex-shrink: 0;">
                    <div style="background: white; border-radius: 8px; border: 1px solid #e5e7eb; position: sticky; top: 100px;">
                        <div style="padding: 16px 24px; border-bottom: 1px solid #e5e7eb;">
                            <h2 style="font-size: 16px; font-weight: 700; margin: 0;">Ringkasan Pesanan</h2>
                        </div>
                        <div style="padding: 24px;">
                            @php
                                $subtotal = 0;
                                foreach(session('cart') as $item) {
                                    $subtotal += $item['price'] * $item['quantity'];
                                }
                            @endphp
                            
                            <div style="margin-bottom: 16px;">
                                <div style="display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 8px;">
                                    <span style="color: #6b7280;">Subtotal ({{ array_sum(array_column(session('cart'), 'quantity')) }} item)</span>
                                    <span>IDR {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-size: 14px;">
                                    <span style="color: #6b7280;">Ongkos Kirim</span>
                                    <span style="color: #059669;">Gratis</span>
                                </div>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 16px; border-top: 1px solid #e5e7eb;">
                                <span style="font-weight: 700; font-size: 16px;">Total</span>
                                <span style="font-weight: 700; font-size: 20px;">IDR {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>

                            <a href="{{ route('checkout.index') }}" 
                               style="display: block; width: 100%; background: black; color: white; text-align: center; padding: 16px; border-radius: 8px; font-weight: 600; text-decoration: none; margin-top: 20px;">
                                Lanjut ke Pembayaran
                            </a>
                            
                            <a href="{{ route('shop.index') }}" style="display: block; text-align: center; padding: 12px; font-size: 14px; color: #6b7280; text-decoration: none; margin-top: 8px;">
                                Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div style="background: white; border-radius: 8px; border: 1px solid #e5e7eb; padding: 80px 20px; text-align: center;">
                <div style="width: 80px; height: 80px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px auto;">
                    <svg style="width: 40px; height: 40px; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h2 style="font-size: 24px; font-weight: 700; margin: 0 0 8px 0;">Keranjang Kosong</h2>
                <p style="color: #6b7280; margin: 0 0 24px 0; max-width: 400px; margin-left: auto; margin-right: auto;">Sepertinya Anda belum menemukan hijab yang sempurna.</p>
                <a href="{{ route('shop.index') }}" style="display: inline-block; background: black; color: white; padding: 16px 32px; border-radius: 8px; font-weight: 600; text-decoration: none;">
                    Jelajahi Koleksi
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
