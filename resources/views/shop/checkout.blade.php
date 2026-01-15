@extends('layouts.store')

@section('content')
<div style="min-height: 80vh; background: #f9fafb; padding: 32px 16px;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        <!-- Breadcrumb -->
        <div style="margin-bottom: 24px; font-size: 14px;">
            <a href="{{ route('welcome') }}" style="color: #6b7280; text-decoration: none;">Home</a>
            <span style="margin: 0 8px; color: #9ca3af;">/</span>
            <a href="{{ route('cart.index') }}" style="color: #6b7280; text-decoration: none;">Keranjang</a>
            <span style="margin: 0 8px; color: #9ca3af;">/</span>
            <span style="color: #000; font-weight: 500;">Checkout</span>
        </div>

        <div style="display: flex; gap: 32px; flex-wrap: wrap;">
            
            <!-- Shipping Form -->
            <div style="flex: 1; min-width: 400px;">
                <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;">
                    <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb;">
                        <h1 style="margin: 0; font-size: 20px; font-weight: 700;">Informasi Pengiriman</h1>
                        <p style="margin: 4px 0 0 0; font-size: 14px; color: #6b7280;">Masukkan detail pengiriman Anda</p>
                    </div>
                    
                    <form action="{{ route('checkout.store') }}" method="POST" style="padding: 24px;" id="checkout-form">
                        @csrf
                        
                        @if(session('error'))
                        <div style="background: #fee2e2; color: #dc2626; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                            {{ session('error') }}
                        </div>
                        @endif
                        
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                            <!-- Full Name -->
                            <div style="grid-column: span 2;">
                                <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">
                                    Nama Lengkap <span style="color: #dc2626;">*</span>
                                </label>
                                <input type="text" name="nama_penerima" value="{{ old('nama_penerima', auth()->user()->name) }}" required
                                       style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px 16px; font-size: 14px; box-sizing: border-box;">
                                @error('nama_penerima')
                                    <p style="color: #dc2626; font-size: 12px; margin: 4px 0 0 0;">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div style="grid-column: span 2;">
                                <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">
                                    No. Telepon <span style="color: #dc2626;">*</span>
                                </label>
                                <input type="tel" name="telepon" value="{{ old('telepon') }}" required placeholder="+62 812 xxxx xxxx"
                                       style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px 16px; font-size: 14px; box-sizing: border-box;">
                                @error('telepon')
                                    <p style="color: #dc2626; font-size: 12px; margin: 4px 0 0 0;">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div style="grid-column: span 2;">
                                <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">
                                    Alamat Lengkap <span style="color: #dc2626;">*</span>
                                </label>
                                <textarea name="alamat" required rows="3" placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan"
                                          style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px 16px; font-size: 14px; box-sizing: border-box; resize: vertical;">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p style="color: #dc2626; font-size: 12px; margin: 4px 0 0 0;">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- City -->
                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">
                                    Kota <span style="color: #dc2626;">*</span>
                                </label>
                                <input type="text" name="kota" value="{{ old('kota') }}" required placeholder="Jakarta Selatan"
                                       style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px 16px; font-size: 14px; box-sizing: border-box;">
                                @error('kota')
                                    <p style="color: #dc2626; font-size: 12px; margin: 4px 0 0 0;">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Postal Code -->
                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">
                                    Kode Pos <span style="color: #dc2626;">*</span>
                                </label>
                                <input type="text" name="kode_pos" value="{{ old('kode_pos') }}" required placeholder="12345"
                                       style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px 16px; font-size: 14px; box-sizing: border-box;">
                                @error('kode_pos')
                                    <p style="color: #dc2626; font-size: 12px; margin: 4px 0 0 0;">{{ $message }}</p>
                                @enderror
                            </div>


                            <!-- Shipping Method -->
                            <div style="grid-column: span 2;">
                                <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">
                                    Metode Pengiriman <span style="color: #dc2626;">*</span>
                                </label>
                                <select name="shipping_rate_id" id="shipping_rate_id" required
                                       style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px 16px; font-size: 14px; box-sizing: border-box; background-color: white;"
                                       onchange="updateShippingCost()">
                                    <option value="" disabled selected data-price="0">Pilih Ekspedisi</option>
                                    @foreach($shippingRates as $rate)
                                    <option value="{{ $rate->id }}" data-price="{{ $rate->price }}" {{ old('shipping_rate_id') == $rate->id ? 'selected' : '' }}>
                                        {{ $rate->courier_name }} 
                                        @if($rate->destination) - {{ $rate->destination }} @endif
                                        @if($rate->min_distance || $rate->max_distance) ({{ $rate->min_distance ?? 0 }}-{{ $rate->max_distance ?? '∞' }} KM) @endif
                                        - IDR {{ number_format($rate->price, 0, ',', '.') }}
                                        @if($rate->estimate) ({{ $rate->estimate }}) @endif
                                    </option>
                                    @endforeach
                                </select>
                                @error('shipping_rate_id')
                                    <p style="color: #dc2626; font-size: 12px; margin: 4px 0 0 0;">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div style="grid-column: span 2;">
                                <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">
                                    Catatan <span style="color: #6b7280; font-weight: 400;">(Opsional)</span>
                                </label>
                                <textarea name="catatan" rows="2" placeholder="Instruksi khusus untuk pengiriman"
                                          style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px 16px; font-size: 14px; box-sizing: border-box; resize: vertical;">{{ old('catatan') }}</textarea>
                            </div>
                        </div>

                        <!-- Submit Button (Mobile) -->
                        <div style="margin-top: 24px; display: none;" class="mobile-submit">
                            <button type="submit" style="width: 100%; background: black; color: white; padding: 16px; border-radius: 8px; font-weight: 600; border: none; cursor: pointer; font-size: 16px;">
                                Buat Pesanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div style="width: 380px; flex-shrink: 0;">
                <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; position: sticky; top: 100px;">
                    <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb;">
                        <h2 style="margin: 0; font-size: 18px; font-weight: 700;">Ringkasan Pesanan</h2>
                        <p style="margin: 4px 0 0 0; font-size: 14px; color: #6b7280;">{{ count($cart) }} item</p>
                    </div>
                    
                    <!-- Items -->
                    <div style="max-height: 300px; overflow-y: auto;">
                        @foreach($cart as $item)
                        <div style="padding: 16px 24px; border-bottom: 1px solid #f3f4f6; display: flex; gap: 12px;">
                            <!-- Image - FIXED SIZE -->
                            <div style="width: 60px; height: 75px; min-width: 60px; background: #f3f4f6; border-radius: 6px; overflow: hidden; flex-shrink: 0;">
                                @if($item['image'])
                                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" style="width: 60px; height: 75px; object-fit: cover; display: block;">
                                @else
                                    <div style="width: 60px; height: 75px; background: #e5e7eb; display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 24px; height: 24px; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <h4 style="margin: 0; font-size: 14px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $item['name'] }}</h4>
                                <p style="margin: 4px 0 0 0; font-size: 12px; color: #6b7280;">{{ $item['color'] ?? 'Hitam' }} • {{ $item['size'] ?? 'All Size' }}</p>
                                <p style="margin: 4px 0 0 0; font-size: 12px; color: #9ca3af;">Qty: {{ $item['quantity'] }}</p>
                                <p style="margin: 8px 0 0 0; font-size: 14px; font-weight: 600;">IDR {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Totals -->
                    <div style="padding: 24px;">
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 8px;">
                                <span style="color: #6b7280;">Subtotal</span>
                                <span>IDR {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 14px;">
                                <span style="color: #6b7280;">Ongkos Kirim</span>
                                <span id="shipping-cost" style="color: #6b7280;">Pilih ekspedisi</span>
                            </div>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 16px; border-top: 1px solid #e5e7eb;">
                            <span style="font-weight: 700; font-size: 16px;">Total</span>
                            <span id="grand-total" style="font-weight: 700; font-size: 22px;">IDR {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" form="checkout-form"
                                style="width: 100%; background: black; color: white; padding: 16px; border-radius: 8px; font-weight: 600; border: none; cursor: pointer; font-size: 16px; margin-top: 20px;">
                            Buat Pesanan
                        </button>
                        
                        <a href="{{ route('cart.index') }}" style="display: block; text-align: center; padding: 12px; font-size: 14px; color: #6b7280; text-decoration: none; margin-top: 8px;">
                            ← Kembali ke Keranjang
                        </a>
                        
                        <!-- Security Badge -->
                        <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: #6b7280; background: #f9fafb; border-radius: 8px; padding: 12px; margin-top: 16px;">
                            <svg style="width: 16px; height: 16px; color: #059669; flex-shrink: 0;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Transaksi aman & terenkripsi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const subtotal = {{ $total }};
    
    function formatRupiah(number) {
        return 'IDR ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    function updateShippingCost() {
        const select = document.getElementById('shipping_rate_id');
        const selectedOption = select.options[select.selectedIndex];
        const shippingPrice = parseInt(selectedOption.dataset.price) || 0;
        
        const shippingCostEl = document.getElementById('shipping-cost');
        const grandTotalEl = document.getElementById('grand-total');
        
        if (shippingPrice > 0) {
            shippingCostEl.textContent = formatRupiah(shippingPrice);
            shippingCostEl.style.color = '#000';
        } else {
            shippingCostEl.textContent = 'Pilih ekspedisi';
            shippingCostEl.style.color = '#6b7280';
        }
        
        const grandTotal = subtotal + shippingPrice;
        grandTotalEl.textContent = formatRupiah(grandTotal);
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', updateShippingCost);
</script>
@endsection
