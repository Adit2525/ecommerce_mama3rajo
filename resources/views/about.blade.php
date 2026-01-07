@extends('layouts.store')

@section('title', 'About Us')

@section('content')
<!-- Hero Section -->
<section class="relative h-[60vh] w-full overflow-hidden">
    <div class="absolute inset-0 bg-gray-100">
        <!-- Placeholder for About Hero Image -->
        <img src="{{ asset('images/hero.png') }}" alt="About MAMA3RAJO" class="w-full h-full object-cover opacity-80 grayscale">
    </div>
    <div class="absolute inset-0 flex items-center justify-center">
        <h1 class="text-5xl md:text-7xl font-serif text-black tracking-tight">Cerita Kami</h1>
    </div>
</section>

<!-- Content Section -->
<section class="max-w-[2400px] mx-auto px-8 md:px-12 py-32">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center mb-32">
        <div class="prose prose-lg">
            <h2 class="text-3xl font-serif mb-6 uppercase tracking-widest">Awal Mula</h2>
            <p class="text-gray-600 font-light leading-relaxed mb-6">
                Didirikan dengan visi untuk mendefinisikan kembali *modest fashion*, MAMA3RAJO memadukan desain kontemporer dengan keanggunan tradisional. Kami percaya bahwa gaya hijab tidak boleh mengorbankan gaya ataupun kenyamanan.
            </p>
            <p class="text-gray-600 font-light leading-relaxed">
                Perjalanan kami dimulai di sebuah studio kecil dengan satu tujuan: menciptakan karya yang memberdayakan wanita untuk mengekspresikan individualitas mereka melalui desain minimalis yang canggih.
            </p>
        </div>
        <div class="h-[600px] bg-gray-100 overflow-hidden relative">
             <img src="{{ asset('images/pashmina.png') }}" alt="Our Studio" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <div class="h-[600px] bg-gray-100 overflow-hidden relative order-2 md:order-1">
            <img src="{{ asset('images/square.png') }}" alt="Craftsmanship" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
        </div>
        <div class="prose prose-lg order-1 md:order-2">
            <h2 class="text-3xl font-serif mb-6 uppercase tracking-widest">Keahlian</h2>
            <p class="text-gray-600 font-light leading-relaxed mb-6">
                Setiap karya dalam koleksi kami adalah bukti komitmen kami terhadap kualitas. Kami secara ketat memilih kain premium yang jatuh dengan indah dan tahan lama.
            </p>
            <p class="text-gray-600 font-light leading-relaxed">
                Dari sketsa awal hingga jahitan terakhir, pengrajin kami mencurahkan segenap hati untuk memastikan bahwa setiap pakaian memenuhi standar keunggulan kami.
            </p>
        </div>
    </div>
</section>


@endsection
