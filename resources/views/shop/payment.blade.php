@extends('layouts.store')

@section('content')
<div style="min-height: 80vh; background: #f9fafb; padding: 32px 16px;">
    <div style="max-width: 900px; margin: 0 auto;">
        
        <!-- Breadcrumb -->
        <div style="margin-bottom: 24px; font-size: 14px;">
            <a href="{{ route('welcome') }}" style="color: #6b7280; text-decoration: none;">Home</a>
            <span style="margin: 0 8px; color: #9ca3af;">/</span>
            <span style="color: #000; font-weight: 500;">Konfirmasi Pembayaran</span>
        </div>

        <!-- Order Info -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; margin-bottom: 24px; overflow: hidden;">
            <div style="background: linear-gradient(135deg, #1f2937 0%, #374151 100%); color: white; padding: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                    <div>
                        <p style="font-size: 14px; color: #9ca3af; margin: 0;">Nomor Pesanan</p>
                        <h2 style="font-size: 24px; font-weight: 700; margin: 4px 0 0 0;">#{{ $order->kode_pesanan ?? str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h2>
                    </div>
                    <div style="text-align: right;">
                        <p style="font-size: 14px; color: #9ca3af; margin: 0;">Total Pembayaran</p>
                        <h2 style="font-size: 28px; font-weight: 700; margin: 4px 0 0 0; color: #fbbf24;">IDR {{ number_format($order->total_harga, 0, ',', '.') }}</h2>
                    </div>
                </div>
            </div>
            
            <div style="padding: 24px;">
                <div style="display: flex; align-items: center; gap: 12px; padding: 16px; background: #fef3c7; border-radius: 8px;">
                    <svg style="width: 24px; height: 24px; color: #d97706; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p style="font-weight: 600; color: #92400e; margin: 0;">Menunggu Pembayaran</p>
                        <p style="font-size: 13px; color: #b45309; margin: 4px 0 0 0;">Pilih metode pembayaran di bawah untuk menyelesaikan pesanan Anda.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Methods -->
        <div style="display: flex; gap: 24px; flex-wrap: wrap;">
            
            <!-- Left Column - Payment Options -->
            <div style="flex: 1; min-width: 300px;">
                
                <!-- Tab Navigation -->
                <div style="display: flex; margin-bottom: 16px; background: white; border-radius: 12px; padding: 4px; border: 1px solid #e5e7eb;">
                    <button onclick="switchTab('midtrans')" id="tab-midtrans" 
                            style="flex: 1; padding: 14px; border: none; background: #1f2937; color: white; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Pembayaran Online
                    </button>
                    <button onclick="switchTab('manual')" id="tab-manual" 
                            style="flex: 1; padding: 14px; border: none; background: transparent; color: #6b7280; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Transfer Manual
                    </button>
                </div>

                <!-- Midtrans Payment Section -->
                <div id="section-midtrans" style="display: block;">
                    <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 24px;">
                        <div style="text-align: center; margin-bottom: 24px;">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                <svg style="width: 40px; height: 40px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <h3 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 600;">Pembayaran Aman via Midtrans</h3>
                            <p style="margin: 0; font-size: 14px; color: #6b7280;">Dukung berbagai metode pembayaran: OVO, GoPay, Dana, Kartu Kredit, Bank Transfer, dan lainnya</p>
                        </div>

                        <!-- Payment Methods Grid -->
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 24px;">
                            <div style="padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; text-align: center; background: #f9fafb;">
                                <div style="font-size: 12px; font-weight: 600; color: #374151;">E-Wallet</div>
                                <div style="font-size: 10px; color: #6b7280; margin-top: 2px;">OVO, GoPay</div>
                            </div>
                            <div style="padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; text-align: center; background: #f9fafb;">
                                <div style="font-size: 12px; font-weight: 600; color: #374151;">QRIS</div>
                                <div style="font-size: 10px; color: #6b7280; margin-top: 2px;">Scan QR</div>
                            </div>
                            <div style="padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; text-align: center; background: #f9fafb;">
                                <div style="font-size: 12px; font-weight: 600; color: #374151;">Kartu Kredit</div>
                                <div style="font-size: 10px; color: #6b7280; margin-top: 2px;">Visa, Master</div>
                            </div>
                            <div style="padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; text-align: center; background: #f9fafb;">
                                <div style="font-size: 12px; font-weight: 600; color: #374151;">Bank</div>
                                <div style="font-size: 10px; color: #6b7280; margin-top: 2px;">VA Transfer</div>
                            </div>
                        </div>

                        <button id="pay-button" onclick="payWithMidtrans()" 
                                style="width: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 18px; border-radius: 10px; font-size: 16px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4); transition: all 0.3s;">
                            <svg style="width: 22px; height: 22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Bayar Sekarang - IDR {{ number_format($order->total_harga, 0, ',', '.') }}
                        </button>

                        <div id="payment-loading" style="display: none; text-align: center; padding: 18px;">
                            <div style="display: inline-block; width: 24px; height: 24px; border: 3px solid #e5e7eb; border-top-color: #667eea; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                            <p style="margin: 12px 0 0 0; color: #6b7280;">Memproses pembayaran...</p>
                        </div>

                        <p style="margin: 16px 0 0 0; font-size: 12px; color: #9ca3af; text-align: center;">
                            <svg style="width: 14px; height: 14px; display: inline; vertical-align: middle; margin-right: 4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Pembayaran 100% aman dengan enkripsi SSL
                        </p>
                    </div>

                    <!-- Midtrans Info -->
                    <div style="background: #f0fdf4; border-radius: 12px; padding: 20px; margin-top: 16px;">
                        <h4 style="margin: 0 0 12px 0; font-size: 14px; font-weight: 600; color: #166534;">✨ Keuntungan Pembayaran Online</h4>
                        <ul style="margin: 0; padding: 0 0 0 16px; font-size: 13px; color: #166534; line-height: 1.8;">
                            <li>Konfirmasi pembayaran otomatis & instan</li>
                            <li>Berbagai pilihan metode pembayaran</li>
                            <li>Tidak perlu upload bukti transfer</li>
                            <li>Pesanan langsung diproses setelah bayar</li>
                        </ul>
                    </div>
                </div>
                
                <!-- Manual Transfer Section -->
                <div id="section-manual" style="display: none;">
                    <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb;">
                        <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb;">
                            <h3 style="margin: 0; font-size: 16px; font-weight: 600;">Transfer ke Rekening</h3>
                            <p style="margin: 4px 0 0 0; font-size: 13px; color: #6b7280;">Pilih salah satu bank untuk transfer</p>
                        </div>
                        
                        <div style="padding: 16px;">
                            @foreach($bankAccounts as $bank)
                            <div style="padding: 16px; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 12px; cursor: pointer; transition: all 0.2s;" 
                                 onclick="selectBank('{{ $bank['bank'] }}')" id="bank-{{ $bank['bank'] }}">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <p style="font-weight: 600; margin: 0; font-size: 15px;">{{ $bank['bank'] }}</p>
                                        <p style="font-size: 20px; font-weight: 700; color: #111; margin: 8px 0 4px 0; letter-spacing: 1px;">{{ $bank['account_number'] }}</p>
                                        <p style="font-size: 13px; color: #6b7280; margin: 0;">a.n. {{ $bank['account_name'] }}</p>
                                    </div>
                                    <button type="button" onclick="copyToClipboard('{{ $bank['account_number'] }}', event)" 
                                            style="background: #f3f4f6; border: none; padding: 8px 12px; border-radius: 6px; font-size: 12px; cursor: pointer; transition: all 0.2s;">
                                        Salin
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Tips -->
                    <div style="background: #eff6ff; border-radius: 12px; padding: 20px; margin-top: 16px;">
                        <h4 style="margin: 0 0 12px 0; font-size: 14px; font-weight: 600; color: #1e40af;">💡 Tips Pembayaran</h4>
                        <ul style="margin: 0; padding: 0 0 0 16px; font-size: 13px; color: #1e40af; line-height: 1.8;">
                            <li>Pastikan transfer sesuai dengan jumlah yang tertera</li>
                            <li>Simpan bukti transfer untuk dikonfirmasi</li>
                            <li>Upload bukti dalam format JPG/PNG (max 2MB)</li>
                            <li>Pesanan akan diproses setelah pembayaran terverifikasi</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Upload Form (for manual transfer only) -->
            <div id="upload-section" style="width: 360px; flex-shrink: 0; display: none;">
                <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; position: sticky; top: 100px;">
                    <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb;">
                        <h3 style="margin: 0; font-size: 16px; font-weight: 600;">Upload Bukti Transfer</h3>
                    </div>
                    
                    <form action="{{ route('payment.confirm', $order) }}" method="POST" enctype="multipart/form-data" style="padding: 24px;">
                        @csrf
                        
                        <!-- Bank Selection -->
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">Bank Tujuan <span style="color: #dc2626;">*</span></label>
                            <select name="bank_tujuan" required id="bank_tujuan"
                                    style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px; font-size: 14px; box-sizing: border-box;">
                                <option value="">Pilih bank tujuan transfer</option>
                                @foreach($bankAccounts as $bank)
                                <option value="{{ $bank['bank'] }}">{{ $bank['bank'] }} - {{ $bank['account_number'] }}</option>
                                @endforeach
                            </select>
                            @error('bank_tujuan')
                                <p style="color: #dc2626; font-size: 12px; margin: 4px 0 0 0;">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- File Upload -->
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">Bukti Transfer <span style="color: #dc2626;">*</span></label>
                            <div id="dropzone" style="border: 2px dashed #d1d5db; border-radius: 8px; padding: 32px 16px; text-align: center; cursor: pointer; transition: all 0.2s;"
                                 onclick="document.getElementById('bukti_pembayaran').click()">
                                <svg style="width: 40px; height: 40px; color: #9ca3af; margin: 0 auto 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p style="margin: 0; font-size: 14px; color: #6b7280;" id="filename">Klik untuk upload gambar</p>
                                <p style="margin: 8px 0 0 0; font-size: 12px; color: #9ca3af;">JPG, PNG max 2MB</p>
                            </div>
                            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" accept="image/jpeg,image/png,image/jpg" required style="display: none;"
                                   onchange="updateFilename(this)">
                            @error('bukti_pembayaran')
                                <p style="color: #dc2626; font-size: 12px; margin: 4px 0 0 0;">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Preview -->
                        <div id="preview-container" style="display: none; margin-bottom: 20px;">
                            <img id="preview-image" style="width: 100%; border-radius: 8px; border: 1px solid #e5e7eb;">
                        </div>
                        
                        <!-- Notes -->
                        <div style="margin-bottom: 24px;">
                            <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">Catatan (Opsional)</label>
                            <textarea name="catatan_pembayaran" rows="2" placeholder="Nama pengirim, waktu transfer, dll"
                                      style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px; font-size: 14px; box-sizing: border-box; resize: vertical;"></textarea>
                        </div>
                        
                        <button type="submit" style="width: 100%; background: #d4a5a5; color: white; border: none; padding: 16px; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                            Konfirmasi Pembayaran
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Summary (for Midtrans) -->
            <div id="summary-section" style="width: 360px; flex-shrink: 0;">
                <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; position: sticky; top: 100px;">
                    <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb;">
                        <h3 style="margin: 0; font-size: 16px; font-weight: 600;">Ringkasan Pesanan</h3>
                    </div>
                    
                    <div style="padding: 24px;">
                        @foreach($order->items as $item)
                        <div style="display: flex; gap: 12px; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #f3f4f6;">
                            @if($item->product && $item->product->gambar)
                                <img src="{{ asset($item->product->gambar) }}" 
                                     alt="{{ $item->product->nama ?? 'Product' }}" 
                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; background: #f3f4f6;">
                            @else
                                <div style="width: 60px; height: 60px; background: #f3f4f6; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <svg style="width: 24px; height: 24px; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            <div style="flex: 1;">
                                <p style="margin: 0; font-weight: 500; font-size: 14px;">{{ $item->product->nama ?? 'Produk' }}</p>
                                <p style="margin: 4px 0 0 0; font-size: 13px; color: #6b7280;">{{ $item->jumlah }}x @ IDR {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                            </div>
                            <p style="margin: 0; font-weight: 600; font-size: 14px;">IDR {{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}</p>
                        </div>
                        @endforeach

                        <div style="space-y: 8px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <span style="color: #6b7280; font-size: 14px;">Subtotal</span>
                                <span style="font-weight: 500;">IDR {{ number_format($order->subtotal ?? ($order->total_harga - ($order->ongkir ?? 0)), 0, ',', '.') }}</span>
                            </div>
                            @if($order->ongkir > 0)
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <span style="color: #6b7280; font-size: 14px;">Ongkos Kirim</span>
                                <span style="font-weight: 500;">IDR {{ number_format($order->ongkir, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            <div style="display: flex; justify-content: space-between; padding-top: 16px; border-top: 2px solid #1f2937; margin-top: 16px;">
                                <span style="font-weight: 700; font-size: 16px;">Total</span>
                                <span style="font-weight: 700; font-size: 18px; color: #1f2937;">IDR {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Shipping Info -->
                        <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                            <h4 style="margin: 0 0 12px 0; font-size: 14px; font-weight: 600; color: #374151;">Alamat Pengiriman</h4>
                            <p style="margin: 0; font-size: 13px; color: #6b7280; line-height: 1.6;">
                                <strong>{{ $order->nama_penerima }}</strong><br>
                                {{ $order->alamat }}<br>
                                {{ $order->kota }} {{ $order->kode_pos }}<br>
                                {{ $order->no_telp }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Midtrans Snap.js -->
@if($midtransClientKey)
<script src="{{ $midtransProduction ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" 
        data-client-key="{{ $midtransClientKey }}"></script>
@endif

<style>
@keyframes spin {
    to { transform: rotate(360deg); }
}

#pay-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
}

#tab-midtrans:hover, #tab-manual:hover {
    opacity: 0.9;
}
</style>

<script>
// Switch between tabs
function switchTab(tab) {
    const tabMidtrans = document.getElementById('tab-midtrans');
    const tabManual = document.getElementById('tab-manual');
    const sectionMidtrans = document.getElementById('section-midtrans');
    const sectionManual = document.getElementById('section-manual');
    const uploadSection = document.getElementById('upload-section');
    const summarySection = document.getElementById('summary-section');

    if (tab === 'midtrans') {
        tabMidtrans.style.background = '#1f2937';
        tabMidtrans.style.color = 'white';
        tabManual.style.background = 'transparent';
        tabManual.style.color = '#6b7280';
        sectionMidtrans.style.display = 'block';
        sectionManual.style.display = 'none';
        uploadSection.style.display = 'none';
        summarySection.style.display = 'block';
    } else {
        tabManual.style.background = '#1f2937';
        tabManual.style.color = 'white';
        tabMidtrans.style.background = 'transparent';
        tabMidtrans.style.color = '#6b7280';
        sectionManual.style.display = 'block';
        sectionMidtrans.style.display = 'none';
        uploadSection.style.display = 'block';
        summarySection.style.display = 'none';
    }
}

// Pay with Midtrans
function payWithMidtrans() {
    const payButton = document.getElementById('pay-button');
    const loadingDiv = document.getElementById('payment-loading');
    
    payButton.style.display = 'none';
    loadingDiv.style.display = 'block';

    // Get snap token from server
    fetch('{{ route("midtrans.snap-token") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            order_id: {{ $order->id }}
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.snap_token) {
            // Open Midtrans Snap
            snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    console.log('Payment success:', result);
                    window.location.href = '{{ route("payment.success", $order) }}';
                },
                onPending: function(result) {
                    console.log('Payment pending:', result);
                    window.location.href = '{{ route("payment.show", $order) }}?status=pending';
                },
                onError: function(result) {
                    console.log('Payment error:', result);
                    alert('Pembayaran gagal. Silakan coba lagi.');
                    payButton.style.display = 'flex';
                    loadingDiv.style.display = 'none';
                },
                onClose: function() {
                    console.log('Payment popup closed');
                    payButton.style.display = 'flex';
                    loadingDiv.style.display = 'none';
                }
            });
        } else {
            alert('Gagal memproses pembayaran: ' + (data.message || 'Terjadi kesalahan'));
            payButton.style.display = 'flex';
            loadingDiv.style.display = 'none';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
        payButton.style.display = 'flex';
        loadingDiv.style.display = 'none';
    });
}

// Copy to clipboard
function copyToClipboard(text, event) {
    event.stopPropagation();
    navigator.clipboard.writeText(text);
    const btn = event.target;
    btn.textContent = 'Tersalin!';
    btn.style.background = '#d1fae5';
    btn.style.color = '#059669';
    setTimeout(() => {
        btn.textContent = 'Salin';
        btn.style.background = '#f3f4f6';
        btn.style.color = 'inherit';
    }, 2000);
}

// Select bank
function selectBank(bankName) {
    document.getElementById('bank_tujuan').value = bankName;
    
    // Highlight selected
    document.querySelectorAll('[id^="bank-"]').forEach(el => {
        el.style.borderColor = '#e5e7eb';
        el.style.background = 'white';
    });
    document.getElementById('bank-' + bankName).style.borderColor = '#d4a5a5';
    document.getElementById('bank-' + bankName).style.background = '#fdf2f2';
}

// Update filename
function updateFilename(input) {
    const filename = input.files[0]?.name || 'Klik untuk upload gambar';
    document.getElementById('filename').textContent = filename;
    document.getElementById('dropzone').style.borderColor = '#d4a5a5';
    
    // Show preview
    if (input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
            document.getElementById('preview-container').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
