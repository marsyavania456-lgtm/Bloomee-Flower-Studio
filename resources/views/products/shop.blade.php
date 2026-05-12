@extends('layouts.app')
@section('title', 'Toko Bunga')
@section('page-title', '🌺 Toko Bunga')
@section('page-subtitle', 'Temukan buket bunga indah untuk setiap momen')

@section('content')

<!-- Search & Filter -->
<form method="GET" action="/shop" class="card p-3 mb-4">
    <div class="row g-2 align-items-center">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control" placeholder="Cari buket bunga..."
                       value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-4">
            <select name="category" class="form-select">
                <option value="">Semua Kategori</option>
                @foreach($categories as $key => $label)
                    <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-bloom flex-grow-1"><i class="bi bi-search me-1"></i>Cari</button>
            <a href="/shop" class="btn btn-outline-secondary">Reset</a>
        </div>
    </div>
</form>

<!-- Category Pills -->
<div class="d-flex gap-2 flex-wrap mb-4">
    <a href="/shop" class="btn btn-sm {{ !request('category') ? 'btn-bloom' : 'btn-outline-secondary' }} rounded-pill">
        Semua
    </a>
    @foreach($categories as $key => $label)
    <a href="/shop?category={{ $key }}"
       class="btn btn-sm {{ request('category') == $key ? 'btn-bloom' : 'btn-outline-secondary' }} rounded-pill">
        {{ $label }}
    </a>
    @endforeach
</div>

<!-- Products Grid -->
<div class="row g-3">
    @forelse($products as $p)
    <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="card product-card position-relative">
            @if($p->stock == 0)
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                 style="background:rgba(0,0,0,0.45);border-radius:16px;z-index:2;">
                <span class="badge bg-danger px-3 py-2" style="font-size:0.9rem;">Stok Habis</span>
            </div>
            @endif
            <img src="{{ $p->image_url }}" alt="{{ $p->name }}">
            <div class="card-body">
                <span class="category-badge mb-2 d-inline-block">{{ $p->category }}</span>
                <h6 class="fw-bold mb-1" style="font-size:0.92rem;">{{ $p->name }}</h6>
                @if($p->description)
                <p class="text-muted mb-2" style="font-size:0.78rem;line-height:1.4;">
                    {{ Str::limit($p->description, 60) }}
                </p>
                @endif
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="product-price">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                    <div class="text-muted" style="font-size:0.75rem;">Stok: {{ $p->stock }}</div>
                </div>

                @if($p->stock > 0)
                <form method="POST" action="/cart/add/{{ $p->id }}">
                    @csrf
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text">Qty</span>
                        <input type="number" name="qty" class="form-control" value="1" min="1" max="{{ $p->stock }}">
                    </div>
                    <button type="submit" class="btn btn-bloom btn-sm w-100">
                        <i class="bi bi-basket3 me-1"></i> Tambah ke Keranjang
                    </button>
                </form>
                @else
                <button class="btn btn-secondary btn-sm w-100" disabled>Stok Habis</button>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card text-center py-5">
            <div style="font-size:3rem;">🌺</div>
            <h5>Tidak ada produk ditemukan</h5>
            <p class="text-muted">Coba ubah filter atau kata kunci pencarian.</p>
        </div>
    </div>
    @endforelse
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $products->links() }}
</div>

@endsection