@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', '📊 Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->name . ' · Ringkasan Hari Ini')

@section('content')

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-green">
            <div class="stat-icon" style="background:rgba(255,255,255,0.15);">🌸</div>
            <div class="stat-value">{{ $totalProduk }}</div>
            <div class="stat-label">Total Produk</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-gold">
            <div class="stat-icon" style="background:rgba(255,255,255,0.15);">👥</div>
            <div class="stat-value">{{ $totalUser }}</div>
            <div class="stat-label">Total Member</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-teal">
            <div class="stat-icon" style="background:rgba(255,255,255,0.15);">🛒</div>
            <div class="stat-value">{{ $totalTransaksi }}</div>
            <div class="stat-label">Total Transaksi</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-rose">
            <div class="stat-icon" style="background:rgba(255,255,255,0.15);">⏳</div>
            <div class="stat-value">{{ $transaksiPending }}</div>
            <div class="stat-label">Menunggu Approve</div>
        </div>
    </div>
</div>

<!-- Revenue Row -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center p-4">
                <div style="font-size:2rem;">💰</div>
                <div style="font-size:1.5rem;font-weight:700;font-family:'Playfair Display',serif;color:var(--green-800);">
                    Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}
                </div>
                <div class="text-muted" style="font-size:0.82rem;">Pendapatan Hari Ini</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center p-4">
                <div style="font-size:2rem;">📅</div>
                <div style="font-size:1.5rem;font-weight:700;font-family:'Playfair Display',serif;color:var(--green-800);">
                    Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
                </div>
                <div class="text-muted" style="font-size:0.82rem;">Pendapatan Bulan Ini</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center p-4">
                <div style="font-size:2rem;">🏆</div>
                <div style="font-size:1.5rem;font-weight:700;font-family:'Playfair Display',serif;color:var(--green-800);">
                    Rp {{ number_format($pendapatanTotal, 0, ',', '.') }}
                </div>
                <div class="text-muted" style="font-size:0.82rem;">Total Pendapatan</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Chart -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>📈 Transaksi 7 Hari Terakhir</span>
            </div>
            <div class="card-body p-3">
                <canvas id="chartTransaksi" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Produk Terlaris -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">🌟 Produk Terlaris</div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($produkTerlaris as $i => $p)
                    <div class="list-group-item d-flex align-items-center gap-2 py-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                             style="width:30px;height:30px;min-width:30px;background:var(--green-100);color:var(--green-800);font-size:0.8rem;">
                            {{ $i + 1 }}
                        </div>
                        <div class="flex-grow-1">
                            <div style="font-size:0.85rem;font-weight:600;">{{ $p->product_name }}</div>
                        </div>
                        <div class="text-muted" style="font-size:0.78rem;">{{ $p->total_terjual }} terjual</div>
                    </div>
                    @empty
                    <div class="list-group-item text-muted text-center py-4">Belum ada data</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Transaksi Terbaru -->
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>🕐 Transaksi Terbaru</span>
        <a href="/admin/transaksi" class="btn btn-bloom btn-sm">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bloom mb-0">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Pembeli</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksiTerbaru as $t)
                    <tr>
                        <td><code style="font-size:0.8rem;">{{ $t->invoice_number }}</code></td>
                        <td>{{ $t->user->name ?? '-' }}</td>
                        <td class="fw-semibold">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                        <td>{!! $t->status_badge !!}</td>
                        <td style="font-size:0.82rem;">{{ $t->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <a href="/admin/transaksi/{{ $t->id }}" class="btn btn-bloom btn-sm">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada transaksi</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartTransaksi');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            label: 'Jumlah Transaksi',
            data: {!! json_encode($chartData) !!},
            backgroundColor: 'rgba(27, 67, 50, 0.75)',
            borderColor: 'rgba(27, 67, 50, 1)',
            borderRadius: 8,
            borderWidth: 2,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { precision: 0 } },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endpush