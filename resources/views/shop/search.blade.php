@extends('layouts.store')

@section('content')
<div class="pt-10 pb-20">
    <!-- Header -->
    <div class="px-8 md:px-12 mb-12 flex justify-between items-end sticky top-20 bg-white/95 backdrop-blur z-40 py-6 -mx-8 md:-mx-12 border-b border-gray-100">
        <div>
            <h1 class="text-4xl font-serif">Search Results</h1>
            <span class="text-xs text-gray-500 uppercase tracking-wider">
                @if($products->total() > 0)
                    {{ $products->total() }} results for "{{ $searchQuery }}"
                @else
                    No results for "{{ $searchQuery }}"
                @endif
            </span>
        </div>
        
        <a href="{{ route('shop.index') }}" class="text-xs font-bold uppercase tracking-widest hover:underline underline-offset-4">
            View All Products
        </a>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 px-8 md:px-12">
        @forelse($products as $product)
            <a href="{{ route('shop.show', $product) }}" class="group cursor-pointer flex flex-col h-full bg-white border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300 rounded-lg overflow-hidden">
                <div class="relative aspect-[3/4] overflow-hidden bg-gray-100">
                    @if($product->gambar)
                         <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    @else
                        <img src="{{ asset('images/square.png') }}" class="w-full h-full object-cover grayscale opacity-80 transition-transform duration-700 group-hover:scale-105 group-hover:grayscale-0">
                    @endif
                    
                    <button class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-white text-black text-[10px] uppercase font-bold px-6 py-2 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 w-[90%] text-center tracking-widest hover:bg-black hover:text-white rounded shadow-sm">
                        Add to Bag
                    </button>
                </div>
                
                <div class="flex flex-col flex-grow justify-between p-4">
                    <div>
                        <h3 class="text-xs uppercase tracking-wider font-bold mb-1 group-hover:underline underline-offset-4 decoration-1 truncate">{{ $product->nama }}</h3>
                        <p class="text-[10px] text-gray-500 mb-3 line-clamp-2">
                           {{ $product->deskripsi }}
                        </p>
                    </div>
                    <div class="font-bold text-sm">
                        IDR {{ number_format($product->harga, 0, ',', '.') }}
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full py-32 text-center">
                <div class="max-w-md mx-auto">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                    </svg>
                    <h2 class="text-2xl font-serif mb-4">No products found</h2>
                    <p class="text-gray-500 text-sm mb-6">We couldn't find any products matching "{{ $searchQuery }}". Try a different search term.</p>
                    <a href="{{ route('shop.index') }}" class="inline-block bg-black text-white px-8 py-3 uppercase text-xs font-bold tracking-widest hover:bg-gray-800 transition-colors">
                        Browse All Products
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="mt-24 px-8 md:px-12">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
