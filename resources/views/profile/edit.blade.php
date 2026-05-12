@extends('layouts.app')
@section('title', 'Profile')
@section('page-title', '👤 Profile Saya')
@section('page-subtitle', 'Kelola informasi akun kamu')

@section('content')

<div class="row g-3 justify-content-center">

    <!-- Info Akun -->
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-header" style="background:var(--green-900);color:white;">
                🌸 Informasi Akun
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PATCH')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" required
                                   value="{{ old('name', auth()->user()->name) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required
                                   value="{{ old('email', auth()->user()->email) }}">
                            @if(auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                            <div class="mt-1 text-warning" style="font-size:0.78rem;">
                                ⚠️ Email belum diverifikasi
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. HP</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone', auth()->user()->phone) }}"
                                   placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control" value="{{ strtoupper(auth()->user()->role) }}" disabled>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="address" class="form-control" rows="2"
                                      placeholder="Alamat pengiriman bunga...">{{ old('address', auth()->user()->address) }}</textarea>
                        </div>
                    </div>

                    @if(session('status') === 'profile-updated')
                    <div class="alert alert-success mt-3 mb-0 py-2">✅ Profile berhasil diupdate!</div>
                    @endif

                    <button type="submit" class="btn btn-bloom mt-4 px-4">
                        <i class="bi bi-check-circle me-1"></i> Simpan Profile
                    </button>
                </form>
            </div>
        </div>

        <!-- Ganti Password -->
        <div class="card">
            <div class="card-header" style="background:linear-gradient(135deg,#8B6914,var(--gold));color:white;">
                🔑 Ganti Password
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf @method('PUT')

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control"
                                   autocomplete="current-password">
                            @error('current_password')
                            <div class="text-danger" style="font-size:0.8rem;margin-top:4px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control"
                                   autocomplete="new-password" placeholder="Min. 8 karakter">
                            @error('password')
                            <div class="text-danger" style="font-size:0.8rem;margin-top:4px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                   autocomplete="new-password">
                        </div>
                    </div>

                    @if(session('status') === 'password-updated')
                    <div class="alert alert-success mt-3 mb-0 py-2">✅ Password berhasil diubah!</div>
                    @endif

                    <button type="submit" class="btn btn-gold mt-4 px-4">
                        <i class="bi bi-lock me-1"></i> Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="col-lg-4">
        <!-- Avatar Card -->
        <div class="card mb-3">
            <div class="card-body text-center py-4"
                 style="background:linear-gradient(135deg,var(--green-900),var(--green-700));border-radius:16px;">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                     style="width:80px;height:80px;background:rgba(255,255,255,0.2);">
                    <span style="font-size:2.2rem;color:white;font-family:'Playfair Display',serif;font-weight:700;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                </div>
                <div style="color:white;font-size:1.1rem;font-weight:700;font-family:'Playfair Display',serif;">
                    {{ auth()->user()->name }}
                </div>
                <div style="color:rgba(255,255,255,0.7);font-size:0.8rem;">{{ auth()->user()->email }}</div>
                <div class="mt-2">
                    <span style="background:rgba(255,255,255,0.2);color:white;padding:3px 14px;border-radius:20px;font-size:0.75rem;font-weight:700;letter-spacing:1px;">
                        {{ strtoupper(auth()->user()->role) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Stats (User Only) -->
        @if(!auth()->user()->isAdmin())
        <div class="card mb-3">
            <div class="card-header">📊 Statistik Belanja</div>
            <div class="card-body">
                @php
                    $user = auth()->user();
                    $totalOrder = $user->transactions()->count();
                    $totalBelanja = $user->transactions()->whereIn('status',['approved','completed'])->sum('total');
                @endphp
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted" style="font-size:0.85rem;">Total Pesanan</span>
                    <span class="fw-semibold">{{ $totalOrder }}</span>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted" style="font-size:0.85rem;">Total Belanja</span>
                    <span class="fw-semibold" style="color:var(--green-800);">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Hapus Akun -->
        <div class="card border" style="border-color:#FEE2E2 !important;">
            <div class="card-header" style="background:#FEF2F2;color:#991B1B;">⚠️ Hapus Akun</div>
            <div class="card-body">
                <p style="font-size:0.82rem;color:#6B7280;">
                    Tindakan ini tidak bisa dibatalkan. Semua data akunmu akan dihapus permanen.
                </p>
                <button type="button" class="btn btn-outline-danger btn-sm"
                        onclick="document.getElementById('deleteModal').style.display='flex'">
                    Hapus Akun Saya
                </button>
            </div>
        </div>
    </div>

</div>

<!-- Delete Modal -->
<div id="deleteModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:white;border-radius:16px;padding:28px;width:380px;max-width:90vw;">
        <h5 style="color:#991B1B;">⚠️ Hapus Akun?</h5>
        <p style="font-size:0.85rem;color:#6B7280;">
            Masukkan password untuk konfirmasi penghapusan akun.
        </p>
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf @method('DELETE')
            <input type="password" name="password" class="form-control mb-3"
                   placeholder="Password kamu" required>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-danger flex-grow-1">Hapus Akun</button>
                <button type="button" class="btn btn-outline-secondary flex-grow-1"
                        onclick="document.getElementById('deleteModal').style.display='none'">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

@endsection