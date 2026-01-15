@extends('layouts.store')

@section('content')
<div style="min-height: 80vh; background: #f9fafb; padding: 32px 16px;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        <!-- Breadcrumb -->
        <div style="margin-bottom: 24px; font-size: 14px;">
            <a href="{{ route('welcome') }}" style="color: #6b7280; text-decoration: none;">Home</a>
            <span style="margin: 0 8px; color: #9ca3af;">/</span>
            <span style="color: #000; font-weight: 500;">Akun Saya</span>
        </div>

        @if(session('success'))
            <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #047857; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-size: 14px;">
                {{ session('success') }}
            </div>
        @endif

        <div style="display: flex; gap: 32px; flex-wrap: wrap;">
            
            <!-- Sidebar -->
            <div style="width: 280px; flex-shrink: 0;">
                <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;">
                    <!-- User Header -->
                    <div style="background: linear-gradient(135deg, #1f2937 0%, #374151 100%); color: white; padding: 24px;">
                        <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 700; margin-bottom: 12px;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h3 style="margin: 0; font-size: 18px; font-weight: 700;">{{ $user->name }}</h3>
                        <p style="margin: 4px 0 0 0; font-size: 13px; color: #d1d5db;">{{ $user->email }}</p>
                    </div>
                    
                    <!-- Menu -->
                    <div style="padding: 8px;">
                        <a href="{{ route('profile.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; background: #000; color: white; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 500;">
                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Profil Saya
                        </a>
                        <a href="{{ route('profile.orders') }}" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #374151; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 500; margin-top: 4px;">
                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Pesanan Saya
                        </a>
                        <a href="{{ route('cart.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #374151; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 500; margin-top: 4px;">
                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Keranjang
                        </a>
                        <div style="height: 1px; background: #e5e7eb; margin: 8px 0;"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #dc2626; border-radius: 8px; font-size: 14px; font-weight: 500; background: none; border: none; cursor: pointer; width: 100%; text-align: left;">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div style="flex: 1; min-width: 300px;">
                
                <!-- Profile Card -->
                <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; margin-bottom: 24px;">
                    <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb;">
                        <h2 style="margin: 0; font-size: 18px; font-weight: 700;">Informasi Profil</h2>
                        <p style="margin: 4px 0 0 0; font-size: 14px; color: #6b7280;">Kelola informasi profil Anda</p>
                    </div>
                    <div style="padding: 24px;">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                                <div>
                                    <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                           style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px 16px; font-size: 14px; box-sizing: border-box;">
                                    @error('name')
                                        <p style="color: #dc2626; font-size: 12px; margin: 4px 0 0 0;">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                           style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px 16px; font-size: 14px; box-sizing: border-box;">
                                    @error('email')
                                        <p style="color: #dc2626; font-size: 12px; margin: 4px 0 0 0;">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">No. Telepon</label>
                                    <input type="tel" name="phone" value="{{ old('phone', $user->phone ?? '') }}" 
                                           placeholder="+62 812 xxxx xxxx"
                                           style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px 16px; font-size: 14px; box-sizing: border-box;">
                                </div>
                            </div>

                            <div style="margin-top: 24px;">
                                <button type="submit" style="background: black; color: white; padding: 12px 24px; border-radius: 8px; font-weight: 600; border: none; cursor: pointer; font-size: 14px;">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Password Card -->
                <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; margin-bottom: 24px;">
                    <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb;">
                        <h2 style="margin: 0; font-size: 18px; font-weight: 700;">Ubah Password</h2>
                        <p style="margin: 4px 0 0 0; font-size: 14px; color: #6b7280;">Perubahan password memerlukan verifikasi admin</p>
                    </div>
                    <div style="padding: 24px;">
                        @if(session('error'))
                            <div style="background: #fee2e2; border: 1px solid #fecaca; color: #dc2626; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px;">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(isset($pendingPasswordRequest) && $pendingPasswordRequest)
                            <!-- Pending Request Notice -->
                            <div style="background: #fef3c7; border: 1px solid #fde68a; border-radius: 8px; padding: 16px; margin-bottom: 16px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 40px; height: 40px; background: #fbbf24; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 20px; height: 20px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div style="flex: 1;">
                                        <p style="margin: 0; font-weight: 600; color: #92400e;">Menunggu Verifikasi Admin</p>
                                        <p style="margin: 4px 0 0 0; font-size: 13px; color: #a16207;">
                                            Permintaan diajukan pada {{ $pendingPasswordRequest->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>
                                </div>
                                <form action="{{ route('profile.cancel-password-request') }}" method="POST" style="margin-top: 12px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: #dc2626; color: white; padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 500; border: none; cursor: pointer;">
                                        Batalkan Permintaan
                                    </button>
                                </form>
                            </div>
                        @else
                            <form action="{{ route('profile.password') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                                    <div>
                                        <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">Password Saat Ini</label>
                                        <input type="password" name="current_password" 
                                               style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px 16px; font-size: 14px; box-sizing: border-box;">
                                        @error('current_password')
                                            <p style="color: #dc2626; font-size: 12px; margin: 4px 0 0 0;">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">Password Baru</label>
                                        <input type="password" name="password" 
                                               style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px 16px; font-size: 14px; box-sizing: border-box;">
                                        @error('password')
                                            <p style="color: #dc2626; font-size: 12px; margin: 4px 0 0 0;">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" 
                                               style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px 16px; font-size: 14px; box-sizing: border-box;">
                                    </div>
                                </div>

                                <div style="margin-top: 24px;">
                                    <button type="submit" style="background: #f3f4f6; color: #374151; padding: 12px 24px; border-radius: 8px; font-weight: 600; border: none; cursor: pointer; font-size: 14px;">
                                        Ajukan Perubahan Password
                                    </button>
                                    <p style="margin: 8px 0 0 0; font-size: 12px; color: #6b7280;">
                                        * Perubahan password akan diverifikasi oleh admin terlebih dahulu
                                    </p>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Recent Orders -->
                @if($recentOrders->count() > 0)
                <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb;">
                    <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h2 style="margin: 0; font-size: 18px; font-weight: 700;">Pesanan Terbaru</h2>
                            <p style="margin: 4px 0 0 0; font-size: 14px; color: #6b7280;">5 pesanan terakhir</p>
                        </div>
                        <a href="{{ route('profile.orders') }}" style="font-size: 14px; font-weight: 500; color: #000; text-decoration: none;">
                            Lihat Semua →
                        </a>
                    </div>
                    
                    @foreach($recentOrders as $order)
                    <a href="{{ route('profile.order.show', $order) }}" style="display: flex; justify-content: space-between; align-items: center; padding: 16px 24px; border-bottom: 1px solid #f3f4f6; text-decoration: none; color: inherit;">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div style="width: 48px; height: 48px; background: #f3f4f6; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 24px; height: 24px; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <div>
                                <p style="margin: 0; font-weight: 600;">#{{ $order->kode_pesanan ?? str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                                <p style="margin: 4px 0 0 0; font-size: 13px; color: #6b7280;">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;
                                @if($order->status === 'selesai') background: #d1fae5; color: #047857;
                                @elseif($order->status === 'pending') background: #fef3c7; color: #d97706;
                                @elseif($order->status === 'diproses') background: #dbeafe; color: #1d4ed8;
                                @else background: #f3f4f6; color: #374151; @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                            <p style="margin: 8px 0 0 0; font-weight: 700;">IDR {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
