@extends('layouts.app')
@section('title', 'Data User')
@section('page-title', '👥 Data User')
@section('page-subtitle', 'Kelola semua member Bloomee')

@section('content')

<!-- Toolbar -->
<div class="d-flex gap-2 flex-wrap mb-4">
    <a href="/users/create" class="btn btn-bloom">
        <i class="bi bi-person-plus me-1"></i> Tambah User
    </a>

    <form method="GET" action="/users" class="d-flex gap-2 ms-auto flex-wrap">
        <input type="text" name="search" class="form-control" style="width:200px;"
               placeholder="Cari nama / email..." value="{{ request('search') }}">
        <select name="role" class="form-select" style="width:130px;">
            <option value="">Semua Role</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="user"  {{ request('role') == 'user'  ? 'selected' : '' }}>User</option>
        </select>
        <button class="btn btn-bloom"><i class="bi bi-search"></i></button>
        <a href="/users" class="btn btn-outline-secondary">Reset</a>
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bloom mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>No. HP</th>
                        <th>Total Order</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $u)
                    <tr>
                        <td style="font-size:0.8rem;">{{ $users->firstItem() + $i }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                     style="width:32px;height:32px;min-width:32px;background:var(--green-100);color:var(--green-800);font-size:0.85rem;font-weight:700;">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-size:0.88rem;font-weight:600;">{{ $u->name }}</div>
                                    @if($u->address)
                                    <div style="font-size:0.72rem;color:#9CA3AF;">{{ Str::limit($u->address, 30) }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td style="font-size:0.82rem;">{{ $u->email }}</td>
                        <td>
                            @if($u->role == 'admin')
                            <span class="badge" style="background:linear-gradient(135deg,#8B6914,var(--gold));color:#fff;font-size:0.72rem;">
                                👑 ADMIN
                            </span>
                            @else
                            <span class="badge" style="background:var(--green-100);color:var(--green-900);font-size:0.72rem;">
                                👤 USER
                            </span>
                            @endif
                        </td>
                        <td style="font-size:0.82rem;">{{ $u->phone ?? '-' }}</td>
                        <td style="font-size:0.82rem;text-align:center;">
                            <span class="fw-semibold">{{ $u->transactions->count() }}</span>
                        </td>
                        <td style="font-size:0.78rem;">{{ $u->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="/users/{{ $u->id }}/edit" class="btn btn-gold btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="/users/{{ $u->id }}/reset"
                                   class="btn btn-outline-warning btn-sm"
                                   title="Reset Password ke: password123"
                                   onclick="return confirm('Reset password user ini ke password123?')">
                                    <i class="bi bi-key"></i>
                                </a>
                                @if($u->id !== auth()->id())
                                <form method="POST" action="/users/{{ $u->id }}"
                                      onsubmit="return confirm('Hapus user ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <div style="font-size:2rem;">👥</div>
                            Tidak ada user ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3 d-flex justify-content-center">
    {{ $users->links() }}
</div>

@endsection