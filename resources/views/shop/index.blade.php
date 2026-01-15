@extends('layouts.store')

@section('content')
<div class="pt-10 pb-20">
    <!-- Header / Filters -->
    <div class="px-8 md:px-12 mb-12 flex flex-col md:flex-row justify-between md:items-end sticky top-20 bg-white/95 backdrop-blur z-40 py-6 -mx-8 md:-mx-12 border-b border-gray-100 gap-4">
        <div class="w-full md:w-96">
            <form action="{{ route('shop.search') }}" method="GET" class="relative group">
                <input type="text" name="q" placeholder="Cari produk..." 
                       class="w-full border-b border-gray-300 py-3 text-sm uppercase tracking-wider focus:outline-none focus:border-black transition-colors bg-transparent placeholder-gray-400"
                       value="{{ request('q') }}">
                <button type="submit" class="absolute right-0 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-black transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>
        </div>
        
        <div class="flex flex-wrap gap-4 text-xs font-bold uppercase tracking-widest">
            <!-- Category Filter -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 hover:opacity-50 border border-gray-300 px-4 py-2">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="stroke-current">
                        <path d="M4 6h16M4 12h16M4 18h16" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span>Filter</span>
                    <svg width="10" height="6" viewBox="0 0 10 6" fill="none" class="stroke-current">
                        <path d="M1 1L5 5L9 1" stroke-width="1.5"/>
                    </svg>
                </button>
                
                <div x-show="open" @click.away="open = false" 
                     class="absolute top-full left-0 mt-2 bg-white border border-gray-200 shadow-lg min-w-48 z-50">
                    <div class="p-4">
                        <p class="text-[10px] text-gray-500 mb-3">Kategori</p>
                        <a href="{{ route('shop.index', request()->except('category')) }}" 
                           class="block py-2 hover:text-gray-500 {{ !request('category') ? 'font-bold' : '' }}">
                            Semua Kategori
                        </a>
                        @foreach($categories as $category)
                        <a href="{{ route('shop.index', array_merge(request()->except('category'), ['category' => $category->id])) }}" 
                           class="block py-2 hover:text-gray-500 {{ request('category') == $category->id ? 'font-bold' : '' }}">
                            {{ $category->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sort Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 hover:opacity-50 border border-gray-300 px-4 py-2">
                    <span>Urutkan</span>
                    <svg width="10" height="6" viewBox="0 0 10 6" fill="none" class="stroke-current">
                        <path d="M1 1L5 5L9 1" stroke-width="1.5"/>
                    </svg>
                </button>
                
                <div x-show="open" @click.away="open = false" 
                     class="absolute top-full right-0 mt-2 bg-white border border-gray-200 shadow-lg min-w-48 z-50">
                    <a href="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}" 
                       class="block px-4 py-3 hover:bg-gray-50 {{ request('sort', 'newest') === 'newest' ? 'font-bold bg-gray-50' : '' }}">
                        Terbaru
                    </a>
                    <a href="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'price_low'])) }}" 
                       class="block px-4 py-3 hover:bg-gray-50 {{ request('sort') === 'price_low' ? 'font-bold bg-gray-50' : '' }}">
                        Harga: Rendah ke Tinggi
                    </a>
                    <a href="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'price_high'])) }}" 
                       class="block px-4 py-3 hover:bg-gray-50 {{ request('sort') === 'price_high' ? 'font-bold bg-gray-50' : '' }}">
                        Harga: Tinggi ke Rendah
                    </a>
                    <a href="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'name_asc'])) }}" 
                       class="block px-4 py-3 hover:bg-gray-50 {{ request('sort') === 'name_asc' ? 'font-bold bg-gray-50' : '' }}">
                        Nama: A-Z
                    </a>
                    <a href="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'name_desc'])) }}" 
                       class="block px-4 py-3 hover:bg-gray-50 {{ request('sort') === 'name_desc' ? 'font-bold bg-gray-50' : '' }}">
                        Nama: Z-A
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Filters -->
    @if(request('category') || request('sort') !== 'newest')
    <div class="px-8 md:px-12 mb-8 flex flex-wrap gap-2">
        @if(request('category'))
            @php $activeCategory = $categories->find(request('category')); @endphp
            @if($activeCategory)
            <a href="{{ route('shop.index', request()->except('category')) }}" 
               class="inline-flex items-center gap-2 bg-gray-100 px-3 py-1 text-xs uppercase tracking-widest hover:bg-gray-200 transition-colors">
                {{ $activeCategory->name }}
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </a>
            @endif
        @endif
        
        <a href="{{ route('shop.index') }}" class="text-xs uppercase tracking-widest text-gray-500 hover:text-black underline underline-offset-4">
            Hapus Semua
        </a>
    </div>
    @endif

    <!-- Product Grid -->
    <div class="product-grid grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-8 px-4 md:px-12">
        @forelse($products as $product)
            <a href="{{ route('shop.show', $product) }}" class="product-card group cursor-pointer flex flex-col h-full bg-white border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300 rounded-lg overflow-hidden">
                <div class="product-image relative aspect-square md:aspect-[3/4] overflow-hidden bg-gray-50">
                    @if($product->gambar)
                         <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}" class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-105 {{ $product->stok <= 0 ? 'opacity-60' : '' }}">
                    @else
                        <!-- Fallback Image -->
                        <img src="{{ asset('images/square.png') }}" class="w-full h-full object-cover object-center grayscale opacity-80 transition-transform duration-700 group-hover:scale-105 group-hover:grayscale-0">
                    @endif
                    
                    @if($product->stok <= 0)
                    <!-- Out of Stock Overlay -->
                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                        <span class="bg-white text-black text-[10px] md:text-xs uppercase font-bold px-4 py-2 tracking-widest">Stok Habis</span>
                    </div>
                    @else
                    <form action="{{ route('cart.add') }}" method="POST" class="absolute bottom-4 left-1/2 -translate-x-1/2 w-[90%] hidden md:block" onclick="event.stopPropagation();">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="color" value="default">
                        <input type="hidden" name="size" value="all">
                        <button type="submit" class="w-full bg-white text-black text-[10px] uppercase font-bold px-6 py-2 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 text-center tracking-widest hover:bg-black hover:text-white rounded shadow-sm">
                            Tambah ke Tas
                        </button>
                    </form>
                    @endif
                </div>
                
                <div class="flex flex-col flex-grow justify-between p-2 md:p-4">
                    <div>
                        <h3 class="text-[10px] md:text-xs uppercase tracking-wider font-bold mb-1 group-hover:underline underline-offset-4 decoration-1 truncate">{{ $product->nama }}</h3>
                        <p class="text-[8px] md:text-[10px] text-gray-500 mb-2 md:mb-3 line-clamp-2 hidden md:block">
                           {{ $product->deskripsi }}
                        </p>
                    </div>
                    <div class="font-bold text-[10px] md:text-sm">
                        @if($product->harga_coret && $product->harga_coret > $product->harga)
                        <div class="flex flex-col">
                            <span class="text-[8px] md:text-xs text-gray-500" style="text-decoration: line-through; text-decoration-color: #ef4444; text-decoration-thickness: 2px;">IDR {{ number_format($product->harga_coret, 0, ',', '.') }}</span>
                            <span class="text-red-600 font-bold">IDR {{ number_format($product->harga, 0, ',', '.') }}</span>
                        </div>
                        @else
                            IDR {{ number_format($product->harga, 0, ',', '.') }}
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-2 md:col-span-3 lg:col-span-4 w-full py-16 md:py-24">
                <div class="flex flex-col items-center justify-center text-center mx-auto">
                    <svg class="w-16 h-16 text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="font-serif text-xl md:text-2xl text-gray-700 mb-3">Tidak ada produk ditemukan</p>
                    <p class="text-gray-400 text-xs uppercase tracking-widest">Silahkan cek kembali nanti</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-16 md:mt-24 px-4 md:px-12 pb-8">
        {{ $products->links() }}
    </div>
    
    <!-- Spacer -->
    <div class="h-8 md:h-16 w-full"></div>
</div>

<!-- Alpine.js for dropdowns -->
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
