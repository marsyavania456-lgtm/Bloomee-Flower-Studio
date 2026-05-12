@extends('layouts.app')
@section('title', 'Kelola Produk')
@section('page-title', '🌸 Kelola Produk')
@section('page-subtitle', 'Tambah, edit, dan kelola buket bunga')

@section('content')

<!-- Toolbar -->
<div class="d-flex gap-2 flex-wrap mb-4">
    <a href="/products/create" class="btn btn-bloom">
        <i class="bi bi-plus-circle me-1"></i> Tambah Produk
    </a>

    <form method="GET" action="/products" class="d-flex gap-2 ms-auto flex-wrap">
        <input type="text" name="search" class="form-control" style="width:200px;"
               placeholder="Cari produk..." value="{{ request('search') }}">
        <select name="category" class="form-select" style="width:160px;">
            <option value="">Semua Kategori</option>
            @foreach($categories as $key => $label)
                <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <select name="status" class="form-select" style="width:130px;">
            <option value="">Semua Status</option>
            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
        </select>
        <button class="btn btn-bloom"><i class="bi bi-search"></i></button>
        <a href="/products" class="btn btn-outline-secondary">Reset</a>
    </form>
</div>

<!-- Product Grid -->
<div class="row g-3">
    @forelse($products as $p)
    <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="card product-card">
            <img src="{{ $p->image_url }}" alt="{{ $p->name }}">
            @if(!$p->is_active)
                <div class="position-absolute top-0 start-0 m-2">
                    <span class="badge bg-secondary">Nonaktif</span>
                </div>
            @endif
            @if($p->stock == 0)
                <div class="position-absolute top-0 end-0 m-2">
                    <span class="badge bg-danger">Habis</span>
                </div>
            @endif
            <div class="card-body">
                <span class="category-badge mb-2 d-inline-block">{{ $p->category }}</span>
                <h6 class="fw-bold mb-1">{{ $p->name }}</h6>
                <div class="product-price mb-2">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted" style="font-size:0.78rem;">Stok: {{ $p->stock }}</span>
                    <span class="badge {{ $p->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $p->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <a href="/products/{{ $p->id }}/edit" class="btn btn-gold btn-sm flex-grow-1">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form method="POST" action="/products/{{ $p->id }}" onsubmit="return confirm('Hapus produk ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card text-center py-5">
            <div style="font-size:3rem;">🌺</div>
            <h5>Belum ada produk</h5>
            <p class="text-muted">Mulai tambah produk bunga pertama kamu!</p>
            <a href="/products/create" class="btn btn-bloom mx-auto" style="width:fit-content;">+ Tambah Produk</a>
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-4 d-flex justify-content-center">
    {{ $products->links() }}
</div>

@endsection