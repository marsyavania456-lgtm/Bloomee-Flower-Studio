<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan Bloomee</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 11px; color: #1A1A1A; margin: 0; }

        .header {
            background: #1B4332;
            color: white;
            padding: 18px 24px;
            margin-bottom: 20px;
        }

        .header h1 { font-size: 20px; margin: 0 0 2px; font-weight: 700; }
        .header p  { margin: 0; opacity: 0.8; font-size: 10px; }

        .summary {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        .summary-card {
            flex: 1;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            padding: 10px 14px;
            text-align: center;
        }

        .summary-card .val { font-size: 16px; font-weight: 700; color: #1B4332; }
        .summary-card .lbl { font-size: 9px; color: #6B7280; margin-top: 2px; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        thead th {
            background: #1B4332;
            color: white;
            padding: 8px 10px;
            text-align: left;
            font-weight: 600;
            font-size: 9px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        tbody td {
            padding: 7px 10px;
            border-bottom: 1px solid #F3F4F6;
        }

        tbody tr:nth-child(even) td { background: #F9FAF8; }

        .status-badge {
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: 700;
        }

        .status-pending   { background: #FEF3C7; color: #92400E; }
        .status-approved  { background: #DBEAFE; color: #1E40AF; }
        .status-completed { background: #D1FAE5; color: #065F46; }
        .status-rejected  { background: #FEE2E2; color: #991B1B; }

        .total-row td {
            font-weight: 700;
            background: #F0F9F4 !important;
            border-top: 2px solid #1B4332;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 9px;
            color: #9CA3AF;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>🌸 Bloomee — Laporan Penjualan</h1>
    <p>Dicetak: {{ now()->format('d M Y H:i') }} · Total Transaksi: {{ $transaksi->count() }}</p>
</div>

<!-- Summary -->
<table style="margin-bottom:16px;">
    <tr>
        <td style="width:25%;padding:8px;border:1px solid #E5E7EB;border-radius:6px;text-align:center;">
            <div style="font-size:16px;font-weight:700;color:#1B4332;">{{ $transaksi->count() }}</div>
            <div style="font-size:9px;color:#6B7280;">Total Transaksi</div>
        </td>
        <td style="width:5%;"></td>
        <td style="width:25%;padding:8px;border:1px solid #E5E7EB;border-radius:6px;text-align:center;">
            <div style="font-size:16px;font-weight:700;color:#1B4332;">{{ $transaksi->whereIn('status', ['approved','completed'])->count() }}</div>
            <div style="font-size:9px;color:#6B7280;">Transaksi Selesai</div>
        </td>
        <td style="width:5%;"></td>
        <td style="width:40%;padding:8px;border:1px solid #E5E7EB;border-radius:6px;text-align:center;">
            <div style="font-size:16px;font-weight:700;color:#1B4332;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            <div style="font-size:9px;color:#6B7280;">Total Pendapatan</div>
        </td>
    </tr>
</table>

<!-- Table -->
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Invoice</th>
            <th>Pembeli</th>
            <th>Item</th>
            <th>Total</th>
            <th>Metode</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaksi as $i => $t)
        @php $statuses = \App\Models\Transaction::$statuses; $s = $statuses[$t->status] ?? []; @endphp
        <tr>
            <td>{{ $i + 1 }}</td>
            <td style="font-family:monospace;">{{ $t->invoice_number }}</td>
            <td>{{ $t->user->name ?? '-' }}</td>
            <td>{{ $t->items->count() }} item</td>
            <td style="font-weight:600;">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
            <td>{{ strtoupper($t->payment_method) }}</td>
            <td>
                <span class="status-badge status-{{ $t->status }}">
                    {{ $s['label'] ?? $t->status }}
                </span>
            </td>
            <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        @endforeach

        <!-- Total Row -->
        <tr class="total-row">
            <td colspan="4" style="text-align:right;padding-right:12px;">TOTAL PENDAPATAN</td>
            <td colspan="4">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>

<div class="footer">
    <p>Laporan ini dihasilkan secara otomatis oleh sistem Bloomee Flower Studio</p>
    <p>© {{ date('Y') }} Bloomee — All Rights Reserved</p>
</div>

</body>
</html>