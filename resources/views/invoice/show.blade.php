<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->kode_pesanan }} - MAMA3RAJO</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #333;
            background: #f5f5f5;
        }
        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #000;
        }
        .logo {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 2px;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-title h1 {
            font-size: 32px;
            font-weight: 300;
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-bottom: 8px;
        }
        .invoice-number {
            font-size: 14px;
            color: #666;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        .info-section h3 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            margin-bottom: 8px;
        }
        .info-section p {
            margin-bottom: 4px;
        }
        .info-section .name {
            font-weight: 600;
            font-size: 16px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background: #f8f8f8;
            padding: 12px 16px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #666;
            border-bottom: 2px solid #eee;
        }
        .items-table td {
            padding: 16px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }
        .items-table .text-right {
            text-align: right;
        }
        .items-table .product-name {
            font-weight: 600;
        }
        .items-table .product-details {
            font-size: 12px;
            color: #888;
            margin-top: 4px;
        }
        .summary {
            margin-left: auto;
            width: 300px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }
        .summary-row.total {
            border-top: 2px solid #000;
            margin-top: 8px;
            padding-top: 16px;
            font-size: 18px;
            font-weight: 700;
        }
        .summary-row .label {
            color: #666;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .status-pending { background: #fef3c7; color: #d97706; }
        .status-diproses { background: #e0e7ff; color: #4f46e5; }
        .status-dikirim { background: #ede9fe; color: #7c3aed; }
        .status-selesai { background: #d1fae5; color: #059669; }
        .status-dibatalkan { background: #fee2e2; color: #dc2626; }
        .status-lunas { background: #d1fae5; color: #059669; }
        .status-belum_bayar { background: #fef3c7; color: #d97706; }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
        .print-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #000;
            color: white;
            border: none;
            padding: 16px 32px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .print-btn:hover {
            background: #333;
        }
        @media print {
            body {
                background: white;
            }
            .invoice-container {
                box-shadow: none;
                margin: 0;
                padding: 20px;
            }
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">MAMA3RAJO</div>
            <div class="invoice-title">
                <h1>Invoice</h1>
                <div class="invoice-number">#{{ $order->kode_pesanan }}</div>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="info-grid">
            <div class="info-section">
                <h3>Tagihan Kepada</h3>
                <p class="name">{{ $order->nama_penerima }}</p>
                <p>{{ $order->alamat }}</p>
                <p>{{ $order->kota }}, {{ $order->kode_pos }}</p>
                <p>{{ $order->no_telp }}</p>
            </div>
            <div class="info-section" style="text-align: right;">
                <h3>Detail Pesanan</h3>
                <p><strong>Tanggal:</strong> {{ $order->created_at->format('d F Y') }}</p>
                <p><strong>Ekspedisi:</strong> {{ $order->ekspedisi ?? '-' }}</p>
                <p style="margin-top: 12px;">
                    <span class="status-badge status-{{ $order->status }}">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>
                </p>
                <p style="margin-top: 8px;">
                    <span class="status-badge status-{{ $order->status_pembayaran }}">
                        {{ $order->status_pembayaran == 'lunas' ? 'Lunas' : 'Belum Bayar' }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%;">Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <div class="product-name">{{ $item->produk->nama ?? 'Produk' }}</div>
                        <div class="product-details">
                            {{ $item->warna ?? '-' }} / {{ $item->ukuran ?? 'All Size' }}
                        </div>
                    </td>
                    <td>IDR {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td class="text-right">IDR {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary -->
        @php
            $subtotal = $order->total_harga - ($order->ongkir ?? 0);
        @endphp
        <div class="summary">
            <div class="summary-row">
                <span class="label">Subtotal</span>
                <span>IDR {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span class="label">Ongkos Kirim</span>
                <span>
                    @if($order->ongkir > 0)
                        IDR {{ number_format($order->ongkir, 0, ',', '.') }}
                    @else
                        Gratis
                    @endif
                </span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span>IDR {{ number_format($order->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>

        @if($order->catatan)
        <div style="margin-top: 30px; padding: 16px; background: #fffef0; border: 1px solid #ffe066; border-radius: 8px;">
            <strong style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #886600;">Catatan:</strong>
            <p style="margin-top: 8px;">{{ $order->catatan }}</p>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih telah berbelanja di <strong>MAMA3RAJO</strong></p>
            <p style="margin-top: 8px;">Invoice ini dibuat secara otomatis dan sah tanpa tanda tangan.</p>
        </div>
    </div>

    <button class="print-btn" onclick="window.print()">
        🖨️ Cetak Invoice
    </button>
</body>
</html>
