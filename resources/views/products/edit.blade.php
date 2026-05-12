@extends('layouts.app')
@section('title', 'Edit Produk')
@section('page-title', '✏️ Edit Produk')
@section('page-subtitle', $product->name)

@section('content')

<div class="row justify-content-center">
<div class="col-lg-8">
<div class="card">
    <div class="card-header">
        <span style="font-weight:600;color:var(--green-900);">🌺 Form Edit Produk</span>
    </div>
    <div class="card-body p-4">
        <form method="POST" action="/products/{{ $product->id }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Nama Produk *</label>
                    <input type="text" name="name" class="form-control" required
                           value="{{ old('name', $product->name) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kategori *</label>
                    <select name="category" class="form-select" required>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ old('category', $product->category) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Harga (Rp) *</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="price" class="form-control" required
                               value="{{ old('price', $product->price) }}" min="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Stok *</label>
                    <input type="number" name="stock" class="form-control" required
                           value="{{ old('stock', $product->stock) }}" min="0">
                </div>

                <div class="col-12">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Foto Produk</label>
                    @if($product->image)
                    <div class="mb-2">
                        <img src="{{ $product->image_url }}" style="height:120px;border-radius:10px;object-fit:cover;">
                        <div class="text-muted" style="font-size:0.78rem;margin-top:4px;">Foto saat ini</div>
                    </div>
                    @endif
                    <input type="file" name="image" class="form-control" accept="image/*"
                           onchange="previewImage(this)">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                    <div id="imagePreview" class="mt-2" style="display:none;">
                        <img id="previewImg" style="height:150px;border-radius:10px;object-fit:cover;">
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive"
                               {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="isActive">Produk Aktif (tampil di toko)</label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-bloom px-4">
                    <i class="bi bi-check-circle me-1"></i> Update Produk
                </button>
                <a href="/products" class="btn btn-outline-secondary px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>

@endsection

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush