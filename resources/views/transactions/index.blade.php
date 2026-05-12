@extends('layouts.app')
@section('title', 'Pesanan Saya')
@section('page-title', '📋 Pesanan Saya')
@section('page-subtitle', 'Riwayat semua pesananmu di Bloomee')

@section('content')

@php use App\Models\Transaction; @endphp

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bloom mb-0">
                <thead>
                    <tr>
                        <th>Invoice</th>
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
                        <td><code style="font-size:0.8rem;">{{ $t->invoice_number }}</code></td>
                        <td style="font-size:0.82rem;">{{ $t->items->count() }} produk</td>
                        <td class="fw-semibold" style="color:var(--green-800);">
                            Rp {{ number_format($t->total, 0, ',', '.') }}
                        </td>
                        <td>
                            <span class="badge" style="background:var(--green-100);color:var(--green-900);">
                                {{ strtoupper($t->payment_method) }}
                            </span>
                        </td>
                        <td>
                            @php $s = Transaction::$statuses[$t->status] ?? []; @endphp
                            <span class="badge-status badge-{{ $t->status }}">
                                {{ $s['icon'] ?? '' }} {{ $s['label'] ?? $t->status }}
                            </span>
                        </td>
                        <td style="font-size:0.8rem;">{{ $t->created_at->format('d M Y') }}<br><span class="text-muted">{{ $t->created_at->format('H:i') }}</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="/transaksi/{{ $t->id }}" class="btn btn-bloom btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(in_array($t->status, ['approved', 'completed']))
                                <a href="/transaksi/{{ $t->id }}/cetak" class="btn btn-gold btn-sm" target="_blank">
                                    <i class="bi bi-printer"></i>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <div style="font-size:2.5rem;">📭</div>
                            Belum ada pesanan.<br>
                            <a href="/shop" class="btn btn-bloom btn-sm mt-2">Mulai Belanja 🌸</a>
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