@extends('layouts.store')

@section('content')
<style>
    /* Hide number input spinner arrows */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>
<div class="max-w-[2400px] mx-auto pt-10" x-data="productOptions()">
    <div class="flex flex-col lg:flex-row h-full">
        <!-- Product Images (Left Side) -->
        <div class="w-full lg:w-1/2 px-1 lg:px-0 lg:h-screen lg:sticky lg:top-0 flex items-center justify-center bg-gray-50">
             @if($product->gambar)
                <div class="w-full h-full lg:h-screen relative overflow-hidden">
                    <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}" class="w-full h-full object-cover" style="height: 85vh; object-fit: cover;">
                </div>
             @else
                <div class="w-full h-full lg:h-screen relative overflow-hidden flex items-center justify-center bg-gray-100">
                    <img src="{{ asset('images/square.png') }}" alt="{{ $product->nama }}" class="w-full h-full object-cover grayscale opacity-50">
                </div>
             @endif
        </div>

        <!-- Product Details (Right Side) -->
        <div class="w-full lg:w-1/2 px-6 lg:px-20 py-10 lg:py-24 bg-white">
            <div class="mb-10 border-b border-gray-100 pb-10">
                <h1 class="text-3xl font-serif uppercase tracking-widest mb-4">{{ $product->nama }}</h1>
                 <p class="text-xs text-gray-400 uppercase tracking-widest mb-6">SKU: {{ $product->slug }}</p>
                @if($product->harga_coret && $product->harga_coret > $product->harga)
                <div class="flex items-center gap-4">
                    <p class="text-lg text-gray-500" style="text-decoration: line-through; text-decoration-color: #ef4444; text-decoration-thickness: 2px;">IDR {{ number_format($product->harga_coret, 0, ',', '.') }}</p>
                    <p class="text-2xl font-bold text-red-600">IDR {{ number_format($product->harga, 0, ',', '.') }}</p>
                </div>
                @else
                <p class="text-2xl font-medium">IDR {{ number_format($product->harga, 0, ',', '.') }}</p>
                @endif
                
                <div class="mt-6 text-sm text-gray-600 leading-relaxed font-light">
                    {{ $product->deskripsi }}
                </div>
                
                <!-- Stock Status -->
                <div class="mt-4">
                    @if($product->stok > 0)
                        <span class="inline-flex items-center gap-1.5 text-xs text-green-600">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Stok: {{ $product->stok }}
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-xs text-red-500">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                            Habis
                        </span>
                    @endif
                </div>
            </div>

            @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <!-- Color Selection - Minimalist -->
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-3">
                        <p class="text-[10px] font-medium uppercase tracking-widest text-gray-500">Warna:</p>
                        <span class="text-[10px] text-gray-700 capitalize" x-text="selectedColorName"></span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="color in colors" :key="color.id">
                            <button type="button" 
                                    @click="selectColor(color)"
                                    :class="{ 'ring-1 ring-offset-1 ring-black': selectedColor === color.id }"
                                    :style="'background-color: ' + color.hex"
                                    :title="color.name"
                                    class="w-5 h-5 rounded-full border border-gray-300 transition-all hover:scale-110 focus:outline-none">
                            </button>
                        </template>
                    </div>
                    <input type="hidden" name="color" x-model="selectedColorName">
                    <input type="hidden" name="color_hex" x-model="selectedColorHex">
                </div>

                <!-- Size Selection - Minimalist Inline -->
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-3">
                        <p class="text-[10px] font-medium uppercase tracking-widest text-gray-500">Ukuran:</p>
                        <button type="button" @click="showSizeGuide = true" class="text-[9px] underline text-gray-400 hover:text-black">
                            Panduan
                        </button>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="size in sizes" :key="size.id">
                            <button type="button" 
                                    @click="selectedSize = size.id; selectedSizeName = size.name"
                                    :class="selectedSize === size.id ? 'bg-black text-white' : 'bg-white text-gray-700 hover:border-gray-400'"
                                    class="border border-gray-200 px-3 py-1.5 text-[10px] font-medium uppercase transition-all">
                                <span x-text="size.name"></span>
                            </button>
                        </template>
                    </div>
                    <input type="hidden" name="size" x-model="selectedSizeName">
                </div>

                <!-- Custom Notes - Minimalist -->
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-2">
                        <p class="text-[10px] font-medium uppercase tracking-widest text-gray-500">Catatan:</p>
                        <span class="text-[9px] text-gray-400">(opsional)</span>
                    </div>
                    <textarea name="custom_note" 
                              placeholder="Tulis catatan..." 
                              class="w-full border border-gray-200 rounded px-3 py-2 text-xs focus:outline-none focus:border-gray-400 transition-colors bg-transparent resize-none h-14 placeholder-gray-300"
                              ></textarea>
                </div>

                <!-- Quantity -->
                <div class="mb-4">
                    <div class="flex items-center gap-3">
                        <p class="text-[10px] font-medium uppercase tracking-widest text-gray-500">Qty:</p>
                        <div class="flex items-center border border-gray-200 rounded">
                            <button type="button" @click="quantity = Math.max(1, quantity - 1)" 
                                    class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors text-sm">
                                −
                            </button>
                            <input type="number" name="quantity" x-model="quantity" min="1" 
                                   class="w-10 text-center text-xs font-medium border-none focus:outline-none bg-transparent">
                            <button type="button" @click="quantity++" 
                                    class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors text-sm">
                                +
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Add to Cart Button -->
                <div class="mb-6">
                    @if($product->stok > 0)
                    <button type="submit" class="w-full h-11 bg-black text-white uppercase text-[11px] font-semibold tracking-widest hover:bg-gray-800 transition-colors">
                        TAMBAH KE KERANJANG
                    </button>
                    @else
                    <button type="button" disabled class="w-full h-11 bg-gray-300 text-gray-500 uppercase text-[11px] font-semibold tracking-widest cursor-not-allowed">
                        STOK HABIS
                    </button>
                    @endif
                </div>
            </form>

            <!-- Accordions -->
            <div class="border-t border-gray-200">
                <details class="group py-4 cursor-pointer border-b border-gray-200">
                    <summary class="flex justify-between items-center text-xs font-bold uppercase tracking-widest list-none">
                        <span>Komposisi & Perawatan</span>
                        <span class="transition group-open:rotate-180">
                            <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                        </span>
                    </summary>
                    <div class="text-xs text-gray-500 mt-4 leading-relaxed font-light">
                        <p>Kami bekerja dengan program pemantauan untuk memastikan kepatuhan terhadap standar sosial, lingkungan, kesehatan dan keselamatan untuk produk kami.</p>
                        <br>
                        <ul class="list-disc pl-4 space-y-1">
                            <li>Cuci mesin pada suhu maks. 30ºC dengan siklus peras pendek</li>
                            <li>Jangan gunakan pemutih</li>
                            <li>Setrika pada suhu maksimum 110ºC</li>
                        </ul>
                    </div>
                </details>
                <details class="group py-4 cursor-pointer border-b border-gray-200">
                    <summary class="flex justify-between items-center text-xs font-bold uppercase tracking-widest list-none">
                        <span>Pengiriman & Pengembalian</span>
                        <span class="transition group-open:rotate-180">
                            <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                        </span>
                    </summary>
                    <div class="text-xs text-gray-500 mt-4 leading-relaxed font-light">
                        <p>Gratis ongkir untuk pesanan di atas IDR 500.000.</p>
                        <br>
                        <p>Anda memiliki 7 hari dari tanggal pengiriman untuk mengembalikan pembelian Anda sepenuhnya gratis.</p>
                    </div>
                </details>
            </div>
        </div>
    </div>

    <!-- Size Guide Modal -->
    <div x-show="showSizeGuide" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
         @click.self="showSizeGuide = false">
        <div class="bg-white max-w-md w-full p-8" @click.stop>
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold uppercase tracking-widest">Panduan Ukuran</h3>
                <button @click="showSizeGuide = false" class="hover:opacity-50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="py-3 text-left font-bold uppercase text-xs">Ukuran</th>
                        <th class="py-3 text-center font-bold uppercase text-xs">Panjang (cm)</th>
                        <th class="py-3 text-center font-bold uppercase text-xs">Lebar (cm)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100">
                        <td class="py-3">S</td>
                        <td class="py-3 text-center">110</td>
                        <td class="py-3 text-center">110</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-3">M</td>
                        <td class="py-3 text-center">115</td>
                        <td class="py-3 text-center">115</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-3">L</td>
                        <td class="py-3 text-center">120</td>
                        <td class="py-3 text-center">120</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-3">XL</td>
                        <td class="py-3 text-center">130</td>
                        <td class="py-3 text-center">130</td>
                    </tr>
                    <tr>
                        <td class="py-3">XXL / Jumbo</td>
                        <td class="py-3 text-center">140</td>
                        <td class="py-3 text-center">140</td>
                    </tr>
                </tbody>
            </table>
            <p class="text-xs text-gray-400 mt-4">* Ukuran dapat bervariasi 1-2cm</p>
        </div>
    </div>
</div>

@if($relatedProducts && $relatedProducts->count() > 0)
<!-- Related Products -->
<section class="max-w-[2400px] mx-auto px-8 md:px-12 py-16 border-t border-gray-100">
    <h2 class="text-xl font-serif mb-8">Produk Serupa</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($relatedProducts as $related)
        <a href="{{ route('shop.show', $related) }}" class="group">
            <div class="aspect-[3/4] bg-gray-100 overflow-hidden mb-3">
                @if($related->gambar)
                    <img src="{{ asset($related->gambar) }}" alt="{{ $related->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <img src="{{ asset('images/square.png') }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                @endif
            </div>
            <h3 class="text-xs font-bold uppercase tracking-wider group-hover:underline">{{ $related->nama }}</h3>
            @if($related->harga_coret && $related->harga_coret > $related->harga)
            <div class="flex gap-2 items-center mt-1">
                <p class="text-xs text-gray-500" style="text-decoration: line-through; text-decoration-color: #ef4444; text-decoration-thickness: 2px;">IDR {{ number_format($related->harga_coret, 0, ',', '.') }}</p>
                <p class="text-sm font-bold text-red-600">IDR {{ number_format($related->harga, 0, ',', '.') }}</p>
            </div>
            @else
            <p class="text-sm font-medium mt-1">IDR {{ number_format($related->harga, 0, ',', '.') }}</p>
            @endif
        </a>
        @endforeach
    </div>
</section>
@endif

<script src="//unpkg.com/alpinejs" defer></script>
<script>
    function productOptions() {
        return {
            // Available colors
            colors: [
                { id: 'black', name: 'Hitam', hex: '#000000' },
                { id: 'white', name: 'Putih', hex: '#FFFFFF' },
                { id: 'navy', name: 'Navy', hex: '#1e3a5f' },
                { id: 'maroon', name: 'Maroon', hex: '#800020' },
                { id: 'dusty-pink', name: 'Dusty Pink', hex: '#D4A5A5' },
                { id: 'sage', name: 'Sage Green', hex: '#9CAF88' },
                { id: 'mocca', name: 'Mocca', hex: '#967969' },
                { id: 'cream', name: 'Cream', hex: '#FFFDD0' },
                { id: 'grey', name: 'Abu-abu', hex: '#808080' },
                { id: 'brown', name: 'Coklat', hex: '#8B4513' },
            ],
            // Available sizes
            sizes: [
                { id: 's', name: 'S' },
                { id: 'm', name: 'M' },
                { id: 'l', name: 'L' },
                { id: 'xl', name: 'XL' },
                { id: 'xxl', name: 'XXL' },
                { id: 'all', name: 'All Size' },
            ],
            selectedColor: 'black',
            selectedColorName: 'Hitam',
            selectedColorHex: '#000000',
            selectedSize: 'all',
            selectedSizeName: 'All Size',
            quantity: 1,
            showSizeGuide: false,
            
            selectColor(color) {
                this.selectedColor = color.id;
                this.selectedColorName = color.name;
                this.selectedColorHex = color.hex;
            }
        }
    }
</script>
@endsection
