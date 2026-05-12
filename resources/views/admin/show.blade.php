@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('page-title', '🧾 Detail Transaksi')
@section('page-subtitle', $transaction->invoice_number)

@section('content')

@php $s = \App\Models\Transaction::$statuses[$transaction->status] ?? []; @endphp

<div class="row g-3">
    <!-- Kiri -->
    <div class="col-lg-8">

        <!-- Status Banner -->
        <div class="card mb-3" style="border-left: 5px solid
            @if($transaction->status == 'completed') #059669
            @elseif($transaction->status == 'approved') #3B82F6
            @elseif($transaction->status == 'rejected') #EF4444
            @else #F59E0B @endif;">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div style="font-size:2.5rem;">{{ $s['icon'] ?? '📋' }}</div>
                <div>
                    <div class="fw-bold" style="font-size:1.05rem;">{{ $s['label'] ?? $transaction->status }}</div>
                    <div class="text-muted" style="font-size:0.82rem;">
                        Dibuat: {{ $transaction->created_at->format('d M Y H:i') }}
                        @if($transaction->approved_at)
                         · Disetujui: {{ $transaction->approved_at->format('d M Y H:i') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Produk -->
        <div class="card mb-3">
            <div class="card-header">🛍️ Item Pesanan</div>
            <div class="card-body p-0">
                @foreach($transaction->items as $item)
                <div class="d-flex gap-3 p-3 border-bottom align-items-center">
                    <img src="{{ $item->product?->image_url ?? asset('images/no-image.png') }}"
                         style="width:60px;height:60px;object-fit:cover;border-radius:10px;">
                    <div class="flex-grow-1">
                        <div class="fw-semibold" style="font-size:0.88rem;">{{ $item->product_name }}</div>
                        <div class="text-muted" style="font-size:0.78rem;">
                            {{ $item->qty }} pcs × Rp {{ number_format($item->price, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="fw-bold" style="color:var(--green-800);">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
                <div class="p-3 d-flex justify-content-between align-items-center">
                    <span class="fw-bold">TOTAL</span>
                    <span class="fw-bold" style="font-size:1.2rem;color:var(--green-800);font-family:'Playfair Display',serif;">
                        Rp {{ number_format($transaction->total, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Catatan User -->
        @if($transaction->notes)
        <div class="card mb-3">
            <div class="card-header">💬 Catatan dari Pembeli</div>
            <div class="card-body">
                <p class="mb-0" style="font-size:0.9rem;">{{ $transaction->notes }}</p>
            </div>
        </div>
        @endif

        <!-- Admin Notes (view) -->
        @if($transaction->admin_notes)
        <div class="card mb-3" style="border-left:4px solid var(--gold);">
            <div class="card-body">
                <div style="font-size:0.78rem;color:var(--gold);font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">
                    Catatan Admin
                </div>
                <p class="mb-0" style="font-size:0.9rem;">{{ $transaction->admin_notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Kanan: Info + Action -->
    <div class="col-lg-4">

        <!-- Info Pembeli -->
        <div class="card mb-3">
            <div class="card-header">👤 Info Pembeli</div>
            <div class="card-body">
                <table style="font-size:0.85rem;width:100%;">
                    <tr class="border-bottom">
                        <td class="py-2 text-muted">Nama</td>
                        <td class="py-2 fw-semibold text-end">{{ $transaction->user->name }}</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="py-2 text-muted">Email</td>
                        <td class="py-2 text-end" style="font-size:0.78rem;">{{ $transaction->user->email }}</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="py-2 text-muted">No. HP</td>
                        <td class="py-2 text-end">{{ $transaction->user->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-muted">Alamat</td>
                        <td class="py-2 text-end">{{ $transaction->user->address ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Ubah Status -->
        <div class="card mb-3">
            <div class="card-header" style="background:var(--green-900);color:white;">
                ⚡ Ubah Status Pesanan
            </div>
            <div class="card-body">
                <form method="POST" action="/admin/transaksi/{{ $transaction->id }}/status">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Status Baru</label>
                        <select name="status" class="form-select" required>
                            @foreach($statuses as $key => $st)
                            <option value="{{ $key }}" {{ $transaction->status == $key ? 'selected' : '' }}>
                                {{ $st['icon'] }} {{ $st['label'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan Admin (opsional)</label>
                        <textarea name="admin_notes" class="form-control" rows="2"
                                  placeholder="cth: Pesanan siap dikirim besok...">{{ $transaction->admin_notes }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-bloom w-100">
                        <i class="bi bi-check-circle me-1"></i> Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="d-flex flex-column gap-2">
            <a href="/transaksi/{{ $transaction->id }}/cetak" target="_blank" class="btn btn-gold w-100">
                <i class="bi bi-printer me-1"></i> Cetak Struk
            </a>
            <a href="/admin/transaksi" class="btn btn-outline-secondary w-100">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>

@endsection