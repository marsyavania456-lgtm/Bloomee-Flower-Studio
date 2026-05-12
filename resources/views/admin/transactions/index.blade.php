@extends('layouts.app')
@section('title', 'Kelola Transaksi')
@section('page-title', '🧾 Semua Transaksi')
@section('page-subtitle', 'Approve, reject, dan pantau semua pesanan')

@section('content')

<!-- Filter Bar -->
<form method="GET" action="/admin/transaksi" class="card p-3 mb-4">
    <div class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label mb-1" style="font-size:0.78rem;">Cari Invoice / Pembeli</label>
            <input type="text" name="search" class="form-control" placeholder="Cari..."
                   value="{{ request('search') }}">
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
        <div class="col-md-3">
            <label class="form-label mb-1" style="font-size:0.78rem;">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button class="btn btn-bloom flex-grow-1"><i class="bi bi-search me-1"></i>Filter</button>
            <a href="/admin/transaksi" class="btn btn-outline-secondary">Reset</a>
        </div>
    </div>
</form>

<!-- Status Pills Summary -->
<div class="d-flex gap-2 flex-wrap mb-3">
    @foreach($statuses as $key => $s)
    <a href="/admin/transaksi?status={{ $key }}"
       class="btn btn-sm rounded-pill {{ request('status') == $key ? 'btn-bloom' : 'btn-outline-secondary' }}">
        {{ $s['icon'] }} {{ $s['label'] }}
    </a>
    @endforeach
</div>

<!-- Table -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bloom mb-0">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Pembeli</th>
                        <th>Item</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $t)
                    <tr>
                        <td>
                            <code style="font-size:0.78rem;">{{ $t->invoice_number }}</code>
                        </td>
                        <td>
                            <div style="font-size:0.85rem;font-weight:600;">{{ $t->user->name ?? '-' }}</div>
                            <div style="font-size:0.75rem;color:#9CA3AF;">{{ $t->user->email ?? '' }}</div>
                        </td>
                        <td style="font-size:0.82rem;">{{ $t->items->count() }} produk</td>
                        <td class="fw-bold" style="color:var(--green-800);">
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
                        <td style="font-size:0.78rem;">
                            {{ $t->created_at->format('d M Y') }}<br>
                            <span class="text-muted">{{ $t->created_at->format('H:i') }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="/admin/transaksi/{{ $t->id }}" class="btn btn-bloom btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($t->status == 'pending')
                                <form method="POST" action="/admin/transaksi/{{ $t->id }}/status">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button class="btn btn-sm btn-success" title="Approve">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                                <form method="POST" action="/admin/transaksi/{{ $t->id }}/status">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <button class="btn btn-sm btn-danger" title="Reject"
                                            onclick="return confirm('Tolak pesanan ini?')">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <div style="font-size:2.5rem;">📭</div>
                            Tidak ada transaksi ditemukan
                        </td>
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