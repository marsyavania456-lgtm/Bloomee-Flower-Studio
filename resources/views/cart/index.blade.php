@extends('layouts.app')
@section('title', 'Keranjang Belanja')
@section('page-title', '🛒 Keranjang Belanja')
@section('page-subtitle', 'Review pesananmu sebelum checkout')
@section('content')

@if(empty($items))
<div class="card text-center py-5">
    <div style="font-size:4rem;">🧺</div>
    <h4>Keranjangmu masih kosong</h4>
    <p class="text-muted">Yuk, pilih bunga indah untuk kamu atau orang tersayang!</p>
    <a href="/shop" class="btn btn-bloom mx-auto" style="width:fit-content;">
        🌸 Belanja Sekarang
    </a>
</div>

@else

<div class="row g-3">
    <!-- Cart Items -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>🌸 Item Keranjang ({{ count($items) }} produk)</span>
                <a href="{{ route('cart.clear') }}" class="btn btn-outline-danger btn-sm"
                   onclick="return confirm('Kosongkan keranjang?')">
                    <i class="bi bi-trash me-1"></i>Kosongkan
                </a>
            </div>
            <div class="card-body p-0">
                @foreach($items as $item)
                <div class="d-flex gap-3 p-3 border-bottom align-items-center">
                    <img src="{{ $item['product']->image_url }}"
                         style="width:80px;height:80px;object-fit:cover;border-radius:12px;">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{ $item['product']->name }}</h6>
                        <div class="text-muted" style="font-size:0.8rem;">{{ $item['product']->category }}</div>
                        <div class="product-price">Rp {{ number_format($item['product']->price, 0, ',', '.') }}</div>
                    </div>

                    <!-- Qty Control -->
                    <form method="POST" action="/cart/update/{{ $item['product']->id }}" class="d-flex align-items-center gap-1">
                        @csrf
                        <input type="number" name="qty" class="form-control text-center"
                               style="width:65px;" value="{{ $item['qty'] }}"
                               min="1" max="{{ $item['product']->stock }}">
                        <button class="btn btn-outline-secondary btn-sm" title="Update">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>
                    </form>

                    <div class="text-end" style="min-width:120px;">
                        <div class="fw-bold" style="color:var(--green-800);">
                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                        </div>
                        <a href="{{ route('cart.remove', $item['product']->id) }}"
                           class="text-danger" style="font-size:0.78rem;">
                            <i class="bi bi-trash"></i> Hapus
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Order Summary + Checkout -->
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header">💰 Ringkasan Pesanan</div>
            <div class="card-body">
                @foreach($items as $item)
                <div class="d-flex justify-content-between mb-2" style="font-size:0.85rem;">
                    <span>{{ Str::limit($item['product']->name, 25) }} × {{ $item['qty'] }}</span>
                    <span>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between fw-bold">
                    <span>Total</span>
                    <span style="color:var(--green-800);font-size:1.1rem;">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <div class="card">
            <div class="card-header">🎯 Checkout</div>
            <div class="card-body">
                <form method="POST" action="/transaksi/checkout">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="transfer">🏦 Transfer Bank</option>
                            <option value="qris">📱 QRIS</option>
                            <option value="cod">🚗 COD (Bayar di Tempat)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea name="notes" class="form-control" rows="2"
                                  placeholder="cth: Minta pita warna pink..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-bloom w-100 py-2">
                        🌸 Buat Pesanan — Rp {{ number_format($total, 0, ',', '.') }}
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-3">
            <a href="/shop" class="btn btn-outline-secondary w-100">
                <i class="bi bi-arrow-left me-1"></i>Lanjut Belanja
            </a>
        </div>
    </div>
</div>
@endif

@endsection