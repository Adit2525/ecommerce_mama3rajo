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
                        <p style="font-size: 13px; color: #b45309; margin: 4px 0 0 0;">Silakan transfer ke salah satu rekening di bawah dan upload bukti pembayaran.</p>
                    </div>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 24px; flex-wrap: wrap;">
            
            <!-- Bank Accounts -->
            <div style="flex: 1; min-width: 300px;">
                <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb;">
                    <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb;">
                        <h3 style="margin: 0; font-size: 16px; font-weight: 600;">Transfer ke Rekening</h3>
                        <p style="margin: 4px 0 0 0; font-size: 13px; color: #6b7280;">Pilih salah satu bank untuk transfer</p>
                    </div>
                    
                    <div style="padding: 16px;">
                        @foreach($bankAccounts as $bank)
                        <div style="padding: 16px; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 12px; cursor: pointer;" 
                             onclick="selectBank('{{ $bank['bank'] }}')" id="bank-{{ $bank['bank'] }}">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <p style="font-weight: 600; margin: 0; font-size: 15px;">{{ $bank['bank'] }}</p>
                                    <p style="font-size: 20px; font-weight: 700; color: #111; margin: 8px 0 4px 0; letter-spacing: 1px;">{{ $bank['account_number'] }}</p>
                                    <p style="font-size: 13px; color: #6b7280; margin: 0;">a.n. {{ $bank['account_name'] }}</p>
                                </div>
                                <button type="button" onclick="copyToClipboard('{{ $bank['account_number'] }}', event)" 
                                        style="background: #f3f4f6; border: none; padding: 8px 12px; border-radius: 6px; font-size: 12px; cursor: pointer;">
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
            
            <!-- Upload Form -->
            <div style="width: 360px; flex-shrink: 0;">
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
                        
                        <button type="submit" style="width: 100%; background: #d4a5a5; color: white; border: none; padding: 16px; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer;">
                            Konfirmasi Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text, event) {
    event.stopPropagation();
    navigator.clipboard.writeText(text);
    const btn = event.target;
    btn.textContent = 'Tersalin!';
    setTimeout(() => btn.textContent = 'Salin', 2000);
}

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
