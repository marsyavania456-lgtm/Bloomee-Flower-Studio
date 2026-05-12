<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Struk — {{ $transaction->invoice_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            padding: 30px 15px;
        }

        .receipt {
            background: #fff;
            width: 380px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.1);
        }

        .receipt-header {
            background: linear-gradient(135deg, #1B4332, #2D6A4F);
            color: white;
            padding: 28px 24px 20px;
            text-align: center;
        }

        .receipt-logo {
            font-size: 2.2rem;
            margin-bottom: 4px;
        }

        .receipt-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .receipt-sub {
            font-size: 0.72rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.7);
            margin-top: 2px;
        }

        .receipt-body {
            padding: 20px 24px;
        }

        /* QR Code */
        .qr-section {
            text-align: center;
            padding: 16px 0;
            border-bottom: 1px dashed #ddd;
            margin-bottom: 16px;
        }

        .qr-section img {
            border-radius: 8px;
        }

        /* Invoice Info */
        .invoice-section {
            background: #F5F0E8;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 16px;
            font-size: 0.82rem;
        }

        .invoice-section .inv-row {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
        }

        .invoice-section .inv-row .label { color: #6B7280; }
        .invoice-section .inv-row .value { font-weight: 600; text-align: right; }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .status-approved  { background: #DBEAFE; color: #1D4ED8; }
        .status-completed { background: #D1FAE5; color: #065F46; }

        /* Items */
        .items-section { margin-bottom: 16px; }

        .items-section .section-title {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #9CA3AF;
            margin-bottom: 10px;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 7px 0;
            border-bottom: 1px solid #F3F4F6;
            font-size: 0.82rem;
        }

        .item-name { font-weight: 500; color: #111; }
        .item-qty  { color: #6B7280; font-size: 0.75rem; }
        .item-subtotal { font-weight: 600; }

        /* Total */
        .total-section {
            background: linear-gradient(135deg, #1B4332, #2D6A4F);
            color: white;
            border-radius: 10px;
            padding: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .total-label { font-size: 0.85rem; opacity: 0.85; }
        .total-value { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; }

        /* Footer */
        .receipt-footer {
            text-align: center;
            font-size: 0.78rem;
            color: #6B7280;
            padding: 16px 24px 24px;
            border-top: 1px dashed #ddd;
        }

        .receipt-footer .thankyou {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            color: #1B4332;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .btn-print {
            display: block;
            margin: 0 auto 20px;
            padding: 10px 30px;
            background: linear-gradient(135deg, #1B4332, #2D6A4F);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            letter-spacing: 0.5px;
            transition: all .2s;
        }

        .btn-print:hover { opacity: 0.9; transform: scale(1.02); }

        @media print {
            body { background: white; padding: 0; }
            .receipt { box-shadow: none; border-radius: 0; width: 100%; }
            .btn-print, .btn-back { display: none !important; }
        }
    </style>
</head>
<body>
<div class="receipt">

    <!-- Header -->
    <div class="receipt-header">
        <div class="receipt-logo">🌸</div>
        <div class="receipt-brand">Bloomee</div>
        <div class="receipt-sub">Flower Studio</div>
    </div>

    <div class="receipt-body">

        <!-- QR Code -->
        <div class="qr-section">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=110x110&data={{ urlencode($transaction->invoice_number . '|' . $transaction->user->name . '|Rp' . number_format($transaction->total, 0)) }}"
                 alt="QR Code" width="110" height="110">
            <div style="font-size:0.7rem;color:#9CA3AF;margin-top:6px;">Scan untuk verifikasi</div>
        </div>

        <!-- Invoice Info -->
        <div class="invoice-section">
            <div class="inv-row">
                <span class="label">Invoice</span>
                <span class="value" style="font-family:monospace;">{{ $transaction->invoice_number }}</span>
            </div>
            <div class="inv-row">
                <span class="label">Pembeli</span>
                <span class="value">{{ $transaction->user->name }}</span>
            </div>
            <div class="inv-row">
                <span class="label">Tanggal</span>
                <span class="value">{{ $transaction->created_at->format('d M Y H:i') }}</span>
            </div>
            <div class="inv-row">
                <span class="label">Metode Bayar</span>
                <span class="value">{{ strtoupper($transaction->payment_method) }}</span>
            </div>
            <div class="inv-row">
                <span class="label">Status</span>
                <span class="value">
                    <span class="status-badge status-{{ $transaction->status }}">
                        {{ \App\Models\Transaction::$statuses[$transaction->status]['icon'] ?? '' }}
                        {{ \App\Models\Transaction::$statuses[$transaction->status]['label'] ?? $transaction->status }}
                    </span>
                </span>
            </div>
        </div>

        <!-- Item List -->
        <div class="items-section">
            <div class="section-title">Detail Pesanan</div>
            @foreach($transaction->items as $item)
            <div class="item-row">
                <div>
                    <div class="item-name">{{ $item->product_name }}</div>
                    <div class="item-qty">{{ $item->qty }} × Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                </div>
                <div class="item-subtotal">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
            </div>
            @endforeach
        </div>

        <!-- Total -->
        <div class="total-section">
            <div>
                <div class="total-label">Total Pembayaran</div>
                <div style="font-size:0.72rem;opacity:0.7;">{{ $transaction->items->count() }} item</div>
            </div>
            <div class="total-value">Rp {{ number_format($transaction->total, 0, ',', '.') }}</div>
        </div>

        <!-- Buttons -->
        <button class="btn-print" onclick="window.print()">
            🖨️ Cetak Struk
        </button>
        <a href="/transaksi/{{ $transaction->id }}" class="btn-back"
           style="display:block;text-align:center;font-size:0.8rem;color:#6B7280;margin-bottom:16px;">
            ← Kembali ke Detail
        </a>
    </div>

    <!-- Footer -->
    <div class="receipt-footer">
        <div class="thankyou">🌸 Terima Kasih! 🌸</div>
        <div>Terima kasih telah berbelanja di Bloomee.</div>
        <div style="margin-top:4px;">Semoga bunga kami memperindah harimu 💐</div>
        <div style="margin-top:10px;font-size:0.72rem;color:#D1D5DB;">
            Dicetak: {{ now()->format('d M Y H:i') }}
        </div>
    </div>

</div>
</body>
</html>