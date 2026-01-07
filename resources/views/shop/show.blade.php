@extends('layouts.store')

@section('content')
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
                    <p class="text-lg text-gray-400 line-through">IDR {{ number_format($product->harga_coret, 0, ',', '.') }}</p>
                    <p class="text-2xl font-medium text-red-600">IDR {{ number_format($product->harga, 0, ',', '.') }}</p>
                </div>
                @else
                <p class="text-2xl font-medium">IDR {{ number_format($product->harga, 0, ',', '.') }}</p>
                @endif
                
                <div class="mt-6 text-sm text-gray-600 leading-relaxed font-light">
                    {{ $product->deskripsi }}
                </div>
            </div>

            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <!-- Color Selection -->
                <div class="mb-10">
                    <div class="flex justify-between items-center mb-4">
                        <p class="text-xs font-bold uppercase tracking-widest">Warna</p>
                        <span class="text-xs text-gray-500 capitalize" x-text="selectedColorName"></span>
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <template x-for="color in colors" :key="color.id">
                            <button type="button" 
                                    @click="selectColor(color)"
                                    :class="{ 'ring-1 ring-offset-2 ring-black scale-110': selectedColor === color.id, 'border-gray-200': selectedColor !== color.id }"
                                    :style="'background-color: ' + color.hex"
                                    :title="color.name"
                                    class="w-8 h-8 rounded-full border shadow-sm transition-all hover:scale-110 focus:outline-none block">
                            </button>
                        </template>
                    </div>
                    <input type="hidden" name="color" x-model="selectedColorName">
                    <input type="hidden" name="color_hex" x-model="selectedColorHex">
                </div>

                <!-- Size Selection -->
                <div class="mb-10">
                    <div class="flex justify-between items-center mb-4">
                        <p class="text-xs font-bold uppercase tracking-widest">Ukuran</p>
                        <button type="button" @click="showSizeGuide = true" class="text-[10px] underline uppercase text-gray-500 hover:text-black transition-colors">
                            Panduan Ukuran
                        </button>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <template x-for="size in sizes" :key="size.id">
                            <button type="button" 
                                    @click="selectedSize = size.id; selectedSizeName = size.name"
                                    :class="selectedSize === size.id ? 'bg-black text-white border-black' : 'bg-white text-black border-gray-200 hover:border-black'"
                                    class="border py-3 text-xs font-bold uppercase transition-all duration-200 text-center">
                                <span x-text="size.name"></span>
                            </button>
                        </template>
                    </div>
                    <input type="hidden" name="size" x-model="selectedSizeName">
                </div>

                <!-- Custom Notes -->
                <div class="mb-10">
                    <div class="flex justify-between items-center mb-3">
                        <p class="text-xs font-bold uppercase tracking-widest">Catatan Khusus</p>
                        <span class="text-[10px] text-gray-400 uppercase tracking-widest">(Opsional)</span>
                    </div>
                    <textarea name="custom_note" 
                              placeholder="Tulis catatan di sini..." 
                              class="w-full border-b border-gray-300 py-2 text-sm focus:outline-none focus:border-black transition-colors bg-transparent resize-none h-20 placeholder-gray-300"
                              ></textarea>
                </div>

                <!-- Quantity -->
                <div class="mb-10">
                    <p class="text-xs font-bold uppercase tracking-widest mb-4">Jumlah</p>
                    <div class="flex items-center w-fit border border-gray-200">
                        <button type="button" @click="quantity = Math.max(1, quantity - 1)" 
                                class="w-10 h-10 flex items-center justify-center hover:bg-black hover:text-white transition-colors">
                            −
                        </button>
                        <input type="number" name="quantity" x-model="quantity" min="1" 
                               class="w-12 text-center text-sm font-bold border-none focus:outline-none appearance-none bg-transparent py-2 m-0">
                        <button type="button" @click="quantity++" 
                                class="w-10 h-10 flex items-center justify-center hover:bg-black hover:text-white transition-colors">
                            +
                        </button>
                    </div>
                </div>

                <div class="flex flex-col gap-3 mb-12 mt-8">
                    <button type="submit" class="w-full bg-black text-white py-4 uppercase text-xs font-bold tracking-widest hover:bg-gray-800 transition-colors shadow-sm flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        Tambah ke Keranjang
                    </button>
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
                <p class="text-xs text-gray-400 line-through">IDR {{ number_format($related->harga_coret, 0, ',', '.') }}</p>
                <p class="text-sm font-medium text-red-600">IDR {{ number_format($related->harga, 0, ',', '.') }}</p>
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
