@extends('layouts.app')
@section('title', 'Tambah User')
@section('page-title', '👤 Tambah User')
@section('page-subtitle', 'Buat akun user baru')

@section('content')

<div class="row justify-content-center">
<div class="col-lg-7">
<div class="card">
    <div class="card-header">📝 Form Tambah User</div>
    <div class="card-body p-4">
        <form method="POST" action="/users">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" name="name" class="form-control" required
                           value="{{ old('name') }}" placeholder="cth: Siti Rahayu">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" required
                           value="{{ old('email') }}" placeholder="cth: siti@email.com">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Role *</label>
                    <select name="role" class="form-select" required>
                        <option value="user"  {{ old('role') == 'user'  ? 'selected' : '' }}>👤 User</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>👑 Admin</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="phone" class="form-control"
                           value="{{ old('phone') }}" placeholder="cth: 08123456789">
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea name="address" class="form-control" rows="2"
                              placeholder="Alamat lengkap...">{{ old('address') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password *</label>
                    <input type="password" name="password" class="form-control" required
                           placeholder="Min. 8 karakter">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Konfirmasi Password *</label>
                    <input type="password" name="password_confirmation" class="form-control" required
                           placeholder="Ulangi password">
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-bloom px-4">
                    <i class="bi bi-person-plus me-1"></i> Buat Akun
                </button>
                <a href="/users" class="btn btn-outline-secondary px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>

@endsection