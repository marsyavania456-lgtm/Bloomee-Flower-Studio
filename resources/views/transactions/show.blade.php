@extends('layouts.app')
@section('title', 'Detail Pesanan')
@section('page-title', '🧾 Detail Pesanan')
@section('page-subtitle', $transaction->invoice_number)
@section('content')

@php use App\Models\Transaction; $s = Transaction::$statuses[$transaction->status] ?? []; @endphp

<div class="row g-3">
    <!-- Kiri: Info Transaksi -->
    <div class="col-lg-8">

        <!-- Status Banner -->
        <div class="card mb-3" style="border-left: 5px solid
            @if($transaction->status == 'completed') var(--green-700)
            @elseif($transaction->status == 'approved') #3B82F6
            @elseif($transaction->status == 'rejected') #EF4444
            @else #F59E0B @endif;">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div style="font-size:2.5rem;">{{ $s['icon'] ?? '📋' }}</div>
                <div>
                    <div class="fw-bold" style="font-size:1.05rem;">{{ $s['label'] ?? $transaction->status }}</div>
                    <div class="text-muted" style="font-size:0.82rem;">
                        Pesanan dibuat: {{ $transaction->created_at->format('d M Y H:i') }}
                        @if($transaction->approved_at)
                         · Disetujui: {{ $transaction->approved_at->format('d M Y H:i') }}
                        @endif
                    </div>
                    @if($transaction->admin_notes)
                    <div class="mt-1 p-2 rounded" style="background:var(--cream);font-size:0.82rem;">
                        <i class="bi bi-chat-left-text me-1"></i>
                        <strong>Catatan Admin:</strong> {{ $transaction->admin_notes }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Produk yang Dipesan -->
        <div class="card">
            <div class="card-header">🌸 Produk yang Dipesan</div>
            <div class="card-body p-0">
                @foreach($transaction->items as $item)
                <div class="d-flex gap-3 p-3 border-bottom align-items-center">
                    <img src="{{ $item->product?->image_url ?? asset('images/no-image.png') }}"
                         style="width:65px;height:65px;object-fit:cover;border-radius:10px;">
                    <div class="flex-grow-1">
                        <div class="fw-semibold">{{ $item->product_name }}</div>
                        <div class="text-muted" style="font-size:0.8rem;">
                            {{ $item->qty }} × Rp {{ number_format($item->price, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="fw-bold" style="color:var(--green-800);">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </div>
                </div>
                @endforeach

                <!-- Total -->
                <div class="p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold" style="font-size:1rem;">Total Pembayaran</span>
                        <span class="fw-bold" style="font-size:1.2rem;color:var(--green-800);font-family:'Playfair Display',serif;">
                            Rp {{ number_format($transaction->total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kanan: Info Ringkas -->
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header">📋 Info Pesanan</div>
            <div class="card-body">
                <table style="font-size:0.85rem;width:100%;">
                    <tr class="border-bottom">
                        <td class="py-2 text-muted">Invoice</td>
                        <td class="py-2 fw-semibold text-end"><code>{{ $transaction->invoice_number }}</code></td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="py-2 text-muted">Pembeli</td>
                        <td class="py-2 fw-semibold text-end">{{ $transaction->user->name }}</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="py-2 text-muted">Metode Bayar</td>
                        <td class="py-2 fw-semibold text-end">{{ strtoupper($transaction->payment_method) }}</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="py-2 text-muted">Status</td>
                        <td class="py-2 text-end">
                            <span class="badge-status badge-{{ $transaction->status }}">
                                {{ $s['icon'] ?? '' }} {{ $s['label'] ?? $transaction->status }}
                            </span>
                        </td>
                    </tr>
                    @if($transaction->notes)
                    <tr>
                        <td class="py-2 text-muted" colspan="2">
                            <div>Catatan:</div>
                            <div class="fw-semibold">{{ $transaction->notes }}</div>
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <!-- Aksi -->
        <div class="d-flex flex-column gap-2">
            @if(in_array($transaction->status, ['approved', 'completed']))
            <a href="/transaksi/{{ $transaction->id }}/cetak" target="_blank" class="btn btn-gold w-100">
                <i class="bi bi-printer me-1"></i> Cetak Struk
            </a>
            @endif
            <a href="/transaksi" class="btn btn-outline-secondary w-100">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>

@endsection