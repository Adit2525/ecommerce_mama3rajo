<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MAMA3RAJO') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind CSS via CDN (for shared hosting) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased text-gray-900 bg-white flex flex-col min-h-screen" x-data="{ searchOpen: false }">
    


    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-[2400px] mx-auto px-8 md:px-12 h-20 flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ route('welcome') }}" class="text-2xl font-serif font-bold tracking-widest uppercase">
                MAMA3RAJO
            </a>

            <!-- Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('shop.index') }}" class="text-xs font-bold uppercase tracking-widest hover:text-gray-600 transition-colors">Belanja</a>
                <a href="{{ route('shop.index') }}" class="text-xs font-bold uppercase tracking-widest hover:text-gray-600 transition-colors">Koleksi</a>
                <a href="{{ route('about') }}" class="text-xs font-bold uppercase tracking-widest hover:text-gray-600 transition-colors">Tentang Kami</a>
            </div>

            <!-- Right Icons -->
            <div class="flex items-center space-x-6">
                 <!-- Search -->
                 <div class="flex items-center">
                     <form action="{{ route('shop.search') }}" method="GET" 
                           x-show="searchOpen"
                           x-transition:enter="transition ease-out duration-300"
                           x-transition:enter-start="opacity-0 w-0"
                           x-transition:enter-end="opacity-100 w-48"
                           class="overflow-hidden mr-2">
                         <input type="text" name="q" placeholder="Cari..." 
                                class="w-48 border-b border-black text-xs uppercase tracking-widest py-1 focus:outline-none bg-transparent placeholder-gray-400"
                                x-ref="navSearchInput"
                                @keydown.escape="searchOpen = false"
                                @blur="setTimeout(() => searchOpen = false, 200)">
                     </form>
                     <button @click="searchOpen = !searchOpen; if(searchOpen) $nextTick(() => $refs.navSearchInput.focus())" class="hover:text-gray-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                     </button>
                 </div>

                 <!-- User/Login -->
                 @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold uppercase tracking-widest hover:text-gray-600 transition-colors">Dashboard</a>
                    @else
                        <!-- Account Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="text-xs font-bold uppercase tracking-widest hover:text-gray-600 transition-colors flex items-center gap-1">
                                Akun
                                <svg class="w-3 h-3 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 style="position: absolute; right: 0; margin-top: 12px; width: 220px; background: white; border-radius: 8px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); border: 1px solid #e5e7eb; padding: 8px 0; z-index: 50;">
                                
                                <!-- User Info -->
                                <div style="padding: 12px 16px; border-bottom: 1px solid #f3f4f6;">
                                    <p style="font-size: 14px; font-weight: 500; color: #111; margin: 0;">{{ auth()->user()->name }}</p>
                                    <p style="font-size: 12px; color: #6b7280; margin: 4px 0 0 0;">{{ auth()->user()->email }}</p>
                                </div>
                                
                                <a href="{{ route('profile.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; font-size: 14px; color: #374151; text-decoration: none;">
                                    <svg style="width: 16px; height: 16px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Profil Saya
                                </a>
                                <a href="{{ route('profile.orders') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; font-size: 14px; color: #374151; text-decoration: none;">
                                    <svg style="width: 16px; height: 16px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    Pesanan Saya
                                </a>
                                
                                <div style="height: 1px; background: #f3f4f6; margin: 8px 0;"></div>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; font-size: 14px; color: #dc2626; background: none; border: none; cursor: pointer; width: 100%; text-align: left;">
                                        <svg style="width: 16px; height: 16px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                 @else
                    <a href="{{ route('login') }}" class="text-xs font-bold uppercase tracking-widest hover:text-gray-600 transition-colors">Login</a>
                 @endauth

                 <!-- Cart Link - Goes to cart page -->
                 <a href="{{ route('cart.index') }}" class="hover:text-gray-600 transition-colors relative">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    @php $cartCount = count(session('cart', [])); @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-black text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                    @endif
                 </a>
            </div>
        </div>
    </nav>

    <main class="flex-grow flex flex-col">
        @yield('content')
    </main>

    <!-- Footer - Minimalist White Theme -->
    <footer style="background: #fff; border-top: 1px solid #e5e7eb; margin-top: auto;">
        <!-- Main Footer -->
        <div style="max-width: 1200px; margin: 0 auto; padding: 60px 24px 40px 24px;">
            <div style="display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr; gap: 48px;">
                
                <!-- Brand -->
                <div>
                    <h3 style="font-size: 24px; font-family: 'Playfair Display', serif; color: #d4a5a5; margin: 0 0 16px 0; font-weight: 400;">MAMA3RAJO</h3>
                    <p style="font-size: 14px; color: #6b7280; line-height: 1.6; margin: 0;">
                        Get up, dress up, and never give up! Cause every woman is a Ladyboss!
                    </p>
                </div>
                
                <!-- Layanan Pelanggan -->
                <div>
                    <h4 style="font-size: 14px; font-weight: 600; color: #111; margin: 0 0 20px 0;">Layanan Pelanggan</h4>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 12px;"><a href="{{ route('register') }}" style="font-size: 14px; color: #6b7280; text-decoration: none;">Gabung</a></li>
                        <li style="margin-bottom: 12px;"><a href="{{ route('login') }}" style="font-size: 14px; color: #6b7280; text-decoration: none;">Daftar</a></li>
                        <li style="margin-bottom: 12px;"><a href="#" style="font-size: 14px; color: #6b7280; text-decoration: none;">Pertanyaan Umum</a></li>
                        <li style="margin-bottom: 12px;"><a href="#" style="font-size: 14px; color: #6b7280; text-decoration: none;">Pengiriman dan Pengembalian</a></li>
                        <li style="margin-bottom: 12px;"><a href="#" style="font-size: 14px; color: #6b7280; text-decoration: none;">Syarat dan Ketentuan</a></li>
                    </ul>
                </div>
                
                <!-- Kontak -->
                <div>
                    <h4 style="font-size: 14px; font-weight: 600; color: #111; margin: 0 0 20px 0;">Kontak</h4>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 12px;"><a href="#" style="font-size: 14px; color: #6b7280; text-decoration: none;">Hubungi kami</a></li>
                        <li style="margin-bottom: 12px;"><span style="font-size: 14px; color: #6b7280;">Email: cs@mama3rajo.com</span></li>
                        <li style="margin-bottom: 12px;"><span style="font-size: 14px; color: #6b7280;">WhatsApp: +62 812-xxxx-xxxx</span></li>
                    </ul>
                </div>
                
                <!-- Social -->
                <div>
                    <h4 style="font-size: 14px; font-weight: 600; color: #111; margin: 0 0 20px 0;">Ikuti kami</h4>
                    <div style="display: flex; gap: 16px;">
                        <a href="https://www.instagram.com/hijab_mama3rajo?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" rel="noopener noreferrer" style="color: #374151; text-decoration: none;">
                            <svg style="width: 24px; height: 24px;" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="https://www.tiktok.com/@hijab.mama3rajo?is_from_webapp=1&sender_device=pc" target="_blank" rel="noopener noreferrer" style="color: #374151; text-decoration: none;">
                            <svg style="width: 24px; height: 24px;" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div style="border-top: 1px solid #e5e7eb; padding: 20px 24px;">
            <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;">
                <p style="font-size: 13px; color: #9ca3af; margin: 0;">© {{ date('Y') }} <a href="{{ route('welcome') }}" style="color: #d4a5a5; text-decoration: none;">MAMA3RAJO</a>.</p>
                <p style="font-size: 13px; color: #9ca3af; margin: 0;">Indonesia / ID</p>
            </div>
        </div>
    </footer>
    <!-- Promotion Modal -->
    @php
        $activePromo = \App\Models\Promotion::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('tanggal_mulai')->orWhere('tanggal_mulai', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('tanggal_berakhir')->orWhere('tanggal_berakhir', '>=', now());
            })
            ->latest()
            ->first();
    @endphp

    @if($activePromo)
    <div x-data="{ showPromo: false }"
         x-init="if(!localStorage.getItem('promo_seen_{{ $activePromo->id }}')) { setTimeout(() => showPromo = true, 1000); }">
        
        <div x-show="showPromo" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showPromo = false; localStorage.setItem('promo_seen_{{ $activePromo->id }}', 'true')"></div>
            
            <!-- Modal Content -->
            <div class="relative bg-white w-full shadow-2xl overflow-hidden transform transition-all"
                 style="max-width: 400px; border-radius: 12px;" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                
                <button @click="showPromo = false; localStorage.setItem('promo_seen_{{ $activePromo->id }}', 'true')" class="absolute top-3 right-3 z-10 text-gray-500 hover:text-black bg-white/80 backdrop-blur-sm rounded-full p-1.5 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                @if($activePromo->gambar)
                <div class="w-full relative" style="height: 200px;">
                    <img src="{{ asset($activePromo->gambar) }}" alt="{{ $activePromo->judul }}" class="w-full h-full object-cover">
                </div>
                @endif
                
                <div class="text-center" style="padding: 20px;">
                    <h3 class="text-xl font-serif mb-2 uppercase tracking-wide">{{ $activePromo->judul }}</h3>
                    @if($activePromo->deskripsi)
                    <p class="text-gray-600 mb-4 text-xs leading-relaxed line-clamp-2">{{ $activePromo->deskripsi }}</p>
                    @endif
                    
                    <button @click="showPromo = false; localStorage.setItem('promo_seen_{{ $activePromo->id }}', 'true'); window.location.href='{{ route('shop.index') }}'" 
                            class="bg-black text-white px-6 py-2.5 uppercase text-[10px] font-bold tracking-widest hover:bg-gray-800 transition-colors w-full">
                        Belanja Sekarang
                    </button>
                    
                    <div class="mt-3">
                        <button @click="showPromo = false; localStorage.setItem('promo_seen_{{ $activePromo->id }}', 'true')" 
                                class="text-[9px] text-gray-400 uppercase tracking-widest hover:text-gray-600">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</body>
</html>
