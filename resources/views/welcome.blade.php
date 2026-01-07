@extends('layouts.store')

@section('content')
<!-- Hero Section -->
<section class="relative h-[65vh] w-full overflow-hidden">
    <img src="{{ asset('images/hero.png') }}" alt="MAMA3RAJO New Collection" class="w-full h-full object-cover object-top">
    <div class="absolute inset-0 bg-black/20 flex flex-col justify-center items-center text-center text-white">
        <h1 class="text-5xl md:text-7xl font-serif mb-6 tracking-widest uppercase">MAMA3RAJO</h1>
        <p class="text-sm md:text-xl font-light tracking-wide max-w-3xl px-6 leading-relaxed">
            Hijab mengangkat kearifan lokal, dengan potensi wisata budaya Sumatera Barat
        </p>
        <a href="{{ route('shop.index') }}" class="mt-10 inline-block bg-white text-black px-10 py-4 text-xs tracking-[0.2em] font-bold uppercase hover:bg-black hover:text-white transition-all duration-500">
            Lihat Koleksi
        </a>
    </div>
</section>

<!-- Categories Grid -->
<section class="max-w-[2400px] mx-auto px-8 md:px-12 py-24">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <!-- Category 1 -->
        <div class="relative group cursor-pointer overflow-hidden h-[600px]">
            <img src="{{ asset('images/pashmina.png') }}" alt="Pashmina Collection" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
            <div class="absolute bottom-10 left-10">
                <h3 class="text-3xl font-serif text-black mb-2 group-hover:text-white transition-colors duration-300">Pashmina</h3>
                <span class="text-xs tracking-widest uppercase border-b border-black pb-1 group-hover:text-white group-hover:border-white transition-all duration-300">Belanja Sekarang</span>
            </div>
        </div>
        
        <!-- Category 2 -->
        <div class="relative group cursor-pointer overflow-hidden h-[600px]">
            <img src="{{ asset('images/square.png') }}" alt="Square Hijab Collection" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
            <div class="absolute bottom-10 left-10">
                <h3 class="text-3xl font-serif text-black mb-2 group-hover:text-white transition-colors duration-300">Square</h3>
                <span class="text-xs tracking-widest uppercase border-b border-black pb-1 group-hover:text-white group-hover:border-white transition-all duration-300">Belanja Sekarang</span>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Scroll -->
<section class="max-w-[2400px] mx-auto px-8 md:px-12 mb-32">
    <div class="flex justify-between items-end mb-10">
        <div>
            <h2 class="text-2xl font-serif mb-2">PRODUK TERBARU</h2>
        </div>
         <a href="{{ route('shop.index') }}" class="text-xs font-bold uppercase tracking-widest hover:underline underline-offset-4 decoration-1">Lihat Semua</a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach($products as $product)
        <a href="{{ route('shop.show', $product) }}" class="group cursor-pointer bg-white border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300 rounded-lg overflow-hidden flex flex-col h-full">
            <div class="relative overflow-hidden aspect-[3/4] bg-gray-100">
                @if($product->gambar)
                     <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}" class="w-full h-full object-cover mix-blend-multiply opacity-90 group-hover:opacity-100 group-hover:scale-105 transition-all duration-500">
                @else
                    <img src="{{ asset('images/square.png') }}" class="w-full h-full object-cover mix-blend-multiply opacity-90 group-hover:opacity-100 group-hover:scale-105 transition-all duration-500 grayscale group-hover:grayscale-0">
                @endif
                <div class="absolute bottom-0 left-0 w-full bg-white/90 py-2 text-center transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                    <span class="text-xs font-bold tracking-widest uppercase">Lihat Detail</span>
                </div>
            </div>
            <div class="p-4 flex flex-col flex-grow">
                <div class="mb-2">
                    <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">{{ $product->category->nama ?? 'HIJAB' }}</span>
                </div>
                <h3 class="text-sm font-medium text-gray-900 mb-2 line-clamp-2 flex-grow font-serif">{{ $product->nama }}</h3>
                <div class="flex items-center justify-between mt-auto pt-2 border-t border-gray-50">
                    @if($product->harga_coret > $product->harga)
                        <div class="flex flex-col">
                           <span class="text-[10px] text-gray-400 line-through">IDR {{ number_format($product->harga_coret, 0, ',', '.') }}</span>
                            <span class="text-xs font-bold text-red-600">IDR {{ number_format($product->harga, 0, ',', '.') }}</span>
                        </div>
                    @else
                        <span class="text-xs font-bold">IDR {{ number_format($product->harga, 0, ',', '.') }}</span>
                    @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>



<div class="h-32 md:h-48 w-full"></div>
@endsection
