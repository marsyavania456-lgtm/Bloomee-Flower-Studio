@extends('layouts.app')
@section('title', 'Edit User')
@section('page-title', '✏️ Edit User')
@section('page-subtitle', $user->name)

@section('content')

<div class="row justify-content-center">
<div class="col-lg-7">
<div class="card">
    <div class="card-header">📝 Form Edit User</div>
    <div class="card-body p-4">
        <form method="POST" action="/users/{{ $user->id }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" name="name" class="form-control" required
                           value="{{ old('name', $user->name) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" required
                           value="{{ old('email', $user->email) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Role *</label>
                    <select name="role" class="form-select" required
                            {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                        <option value="user"  {{ old('role', $user->role) == 'user'  ? 'selected' : '' }}>👤 User</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>👑 Admin</option>
                    </select>
                    @if($user->id === auth()->id())
                    <input type="hidden" name="role" value="{{ $user->role }}">
                    <small class="text-muted">Tidak bisa mengubah role akun sendiri</small>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="phone" class="form-control"
                           value="{{ old('phone', $user->phone) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea name="address" class="form-control" rows="2">{{ old('address', $user->address) }}</textarea>
                </div>

                <!-- Info Password -->
                <div class="col-12">
                    <div class="p-3 rounded-3" style="background:var(--cream);border:1px dashed #C9A84C;">
                        <div style="font-size:0.82rem;color:#6B7280;">
                            <i class="bi bi-info-circle me-1" style="color:var(--gold);"></i>
                            Untuk mengubah password, gunakan tombol <strong>Reset Password</strong> di halaman Data User
                            (password akan direset ke <code>password123</code>).
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-bloom px-4">
                    <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                </button>
                <a href="/users" class="btn btn-outline-secondary px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>

@endsection