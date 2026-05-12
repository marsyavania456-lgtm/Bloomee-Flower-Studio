@php
use App\Models\Transaction;
@endphp
@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', '🌸 Halo, ' . auth()->user()->name . '!')
@section('page-subtitle', 'Selamat datang di Bloomee Flower Studio')

@section('content')

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card stat-green">
            <div class="stat-icon" style="background:rgba(255,255,255,0.15);">🛒</div>
            <div class="stat-value">{{ $totalOrder }}</div>
            <div class="stat-label">Total Pesanan</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card stat-gold">
            <div class="stat-icon" style="background:rgba(255,255,255,0.15);">⏳</div>
            <div class="stat-value">{{ $orderPending }}</div>
            <div class="stat-label">Menunggu Konfirmasi</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card stat-teal">
            <div class="stat-icon" style="background:rgba(255,255,255,0.15);">✅</div>
            <div class="stat-value">{{ $orderSelesai }}</div>
            <div class="stat-label">Pesanan Selesai</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card stat-cream">
            <div class="stat-icon" style="background:rgba(255,255,255,0.5);">💰</div>
            <div class="stat-value" style="font-size:1.2rem;">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</div>
            <div class="stat-label">Total Belanja</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Produk Unggulan -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>🌺 Produk Unggulan</span>
                <a href="/shop" class="btn btn-bloom btn-sm">Lihat Toko</a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @forelse($produkUnggulan as $produk)
                    <div class="col-md-6">
                        <div class="d-flex gap-3 align-items-center p-3 rounded-3" style="background:var(--cream);border:1px solid var(--cream-dark);">
                            <img src="{{ $produk->image_url }}" alt="{{ $produk->name }}"
                                 style="width:60px;height:60px;object-fit:cover;border-radius:10px;">
                            <div class="flex-grow-1">
                                <div class="fw-semibold" style="font-size:0.88rem;">{{ $produk->name }}</div>
                                <div class="product-price" style="font-size:0.95rem;">
                                    Rp {{ number_format($produk->price, 0, ',', '.') }}
                                </div>
                                <div style="font-size:0.75rem;color:#6B7280;">Stok: {{ $produk->stock }}</div>
                            </div>
                            <a href="/shop" class="btn btn-bloom btn-sm">Beli</a>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-muted text-center py-3">Belum ada produk</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Pesanan Terbaru -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>📋 Pesanan Terbaru</span>
                <a href="/transaksi" class="btn btn-bloom btn-sm" style="font-size:0.75rem;">Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($orderTerbaru as $t)
                    <a href="/transaksi/{{ $t->id }}" class="list-group-item list-group-item-action py-3">
                        <div class="d-flex justify-content-between">
                            <code style="font-size:0.75rem;">{{ $t->invoice_number }}</code>
                            <span class="badge-status badge-{{ $t->status }}" style="font-size:0.7rem;padding:3px 8px;">
                                {{ Transaction::$statuses[$t->status]['icon'] ?? '' }}
                                {{ Transaction::$statuses[$t->status]['label'] ?? $t->status }}
                            </span>
                        </div>
                        <div class="text-muted" style="font-size:0.78rem;margin-top:2px;">
                            {{ $t->items->count() }} item · Rp {{ number_format($t->total, 0, ',', '.') }}
                        </div>
                    </a>
                    @empty
                    <div class="list-group-item text-muted text-center py-4">
                        Belum ada pesanan.<br>
                        <a href="/shop" class="btn btn-bloom btn-sm mt-2">Mulai Belanja 🌸</a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Expose Transaction statuses for Blade inline
</script>
@endpush