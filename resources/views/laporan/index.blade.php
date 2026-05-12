@extends('layouts.app')
@section('title', 'Laporan')
@section('page-title', '📊 Laporan Penjualan')
@section('page-subtitle', 'Rekap dan analisis transaksi Bloomee')

@section('content')

<!-- Filter Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="/laporan">
            <div class="row g-2 align-items-end">
                <div class="col-md-2">
                    <label class="form-label mb-1" style="font-size:0.78rem;">Dari Tanggal</label>
                    <input type="date" name="tanggal_mulai" class="form-control"
                           value="{{ request('tanggal_mulai') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-1" style="font-size:0.78rem;">Sampai Tanggal</label>
                    <input type="date" name="tanggal_akhir" class="form-control"
                           value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-1" style="font-size:0.78rem;">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach($statuses as $key => $s)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $s['icon'] }} {{ $s['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-bloom flex-grow-1"><i class="bi bi-funnel me-1"></i>Filter</button>
                    <a href="/laporan" class="btn btn-outline-secondary">Reset</a>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <a href="/laporan/excel?{{ http_build_query(request()->all()) }}"
                       class="btn btn-success flex-grow-1">
                        <i class="bi bi-file-earmark-excel me-1"></i> Excel
                    </a>
                    <a href="/laporan/pdf?{{ http_build_query(request()->all()) }}"
                       class="btn btn-danger flex-grow-1">
                        <i class="bi bi-file-earmark-pdf me-1"></i> PDF
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card stat-green">
            <div class="stat-icon" style="background:rgba(255,255,255,0.15);">📦</div>
            <div class="stat-value">{{ $totalTransaksi }}</div>
            <div class="stat-label">Total Transaksi</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card stat-teal">
            <div class="stat-icon" style="background:rgba(255,255,255,0.15);">✅</div>
            <div class="stat-value">{{ $totalApproved }}</div>
            <div class="stat-label">Transaksi Selesai</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card stat-gold">
            <div class="stat-icon" style="background:rgba(255,255,255,0.15);">⏳</div>
            <div class="stat-value">{{ $totalPending }}</div>
            <div class="stat-label">Menunggu Approve</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card stat-rose">
            <div class="stat-icon" style="background:rgba(255,255,255,0.15);">💰</div>
            <div class="stat-value" style="font-size:1.2rem;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            <div class="stat-label">Total Pendapatan</div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>📋 Data Laporan</span>
        <span class="text-muted" style="font-size:0.82rem;">{{ $transaksi->total() }} transaksi</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bloom mb-0">
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
                    @forelse($transaksi as $i => $t)
                    <tr>
                        <td style="font-size:0.8rem;">{{ $transaksi->firstItem() + $i }}</td>
                        <td>
                            <a href="/admin/transaksi/{{ $t->id }}" style="font-size:0.78rem;color:var(--green-700);">
                                {{ $t->invoice_number }}
                            </a>
                        </td>
                        <td style="font-size:0.85rem;">{{ $t->user->name ?? '-' }}</td>
                        <td style="font-size:0.82rem;">{{ $t->items->count() }} item</td>
                        <td class="fw-semibold" style="color:var(--green-800);">
                            Rp {{ number_format($t->total, 0, ',', '.') }}
                        </td>
                        <td>
                            <span class="badge" style="background:var(--green-100);color:var(--green-900);font-size:0.72rem;">
                                {{ strtoupper($t->payment_method) }}
                            </span>
                        </td>
                        <td>
                            @php $s = \App\Models\Transaction::$statuses[$t->status] ?? []; @endphp
                            <span class="badge-status badge-{{ $t->status }}">
                                {{ $s['icon'] ?? '' }} {{ $s['label'] ?? $t->status }}
                            </span>
                        </td>
                        <td style="font-size:0.78rem;">{{ $t->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">Tidak ada data laporan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3 d-flex justify-content-center">
    {{ $transaksi->links() }}
</div>

@endsection