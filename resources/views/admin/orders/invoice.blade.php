<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->kode_pesanan }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; padding: 40px; color: #333; line-height: 1.6; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); }
        .header { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; color: #333; }
        .details { margin-bottom: 40px; }
        .details h2 { margin-bottom: 5px; font-size: 16px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #eee; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; }
        .total { text-align: right; margin-top: 20px; font-size: 18px; font-weight: bold; }
        .status { margin-top: 20px; padding: 10px; background: #f8f9fa; border-radius: 4px; text-align: center; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #777; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
            .invoice-box { box-shadow: none; border: none; padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="invoice-box">
        <div class="header">
            <div>
                <h1>INVOICE</h1>
                <p><strong>MAMA3RAJO</strong><br>Padang - Sumatera Barat</p>
            </div>
            <div style="text-align: right;">
                <p>Invoice #: {{ $order->kode_pesanan }}<br>
                Tanggal: {{ $order->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <div class="details">
            <div style="display: flex; justify-content: space-between;">
                <div style="width: 45%;">
                    <h2>Ditagihkan Kepada:</h2>
                    {{ $order->nama_penerima }}<br>
                    {{ $order->no_telp }}<br>
                    {{ $order->alamat }}<br>
                    {{ $order->kota }}, {{ $order->kode_pos }}
                </div>
                <div style="width: 45%; text-align: right;">
                    <h2>Status Pembayaran:</h2>
                    <span style="text-transform: uppercase; font-weight: bold; color: {{ $order->status_pembayaran == 'sudah_bayar' ? 'green' : 'orange' }};">
                        {{ str_replace('_', ' ', $order->status_pembayaran) }}
                    </span>
                </div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Harga Satuan</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                <tr>
                    <td>
                        {{ $item->product->nama ?? 'Produk dihapus' }}
                        @if($item->ukuran) <br><small>Ukuran: {{ $item->ukuran }}</small> @endif
                    </td>
                    <td style="text-align: center;">{{ $item->jumlah }}</td>
                    <td style="text-align: right;">IDR {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td style="text-align: right;">IDR {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="text-align: right; margin-top: 10px;">
            <p>Subtotal: IDR {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</p>
            <p>Ongkos Kirim: IDR {{ number_format($order->ongkir, 0, ',', '.') }}</p>
            <div class="total">
                Total: IDR {{ number_format($order->total_harga, 0, ',', '.') }}
            </div>
        </div>
        
        <div class="footer">
            <p>Terima kasih telah berbelanja di MAMA3RAJO.</p>
        </div>

        <div class="no-print" style="text-align: center; margin-top: 30px;">
            <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Cetak Invoice</button>
            <button onclick="window.history.back()" style="padding: 10px 20px; cursor: pointer;">Kembali</button>
        </div>
    </div>

</body>
</html>
