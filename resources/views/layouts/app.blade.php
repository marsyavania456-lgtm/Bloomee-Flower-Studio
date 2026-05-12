<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bloomee — @yield('title', 'Flower Studio')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --green-900: #1B4332;
            --green-800: #2D6A4F;
            --green-700: #40916C;
            --green-500: #52B788;
            --green-300: #95D5B2;
            --green-100: #D8F3DC;
            --gold:       #C9A84C;
            --gold-light: #F5E6C3;
            --cream:      #FAF7F2;
            --cream-dark: #F0E9DC;
            --dark:       #1A1A1A;
            --sidebar-w:  270px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--cream);
            overflow-x: hidden;
            color: var(--dark);
        }

        h1, h2, h3, h4, h5, .brand-title {
            font-family: 'Playfair Display', serif;
        }

        /* ── Sidebar ────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: linear-gradient(160deg, var(--green-900) 0%, var(--green-800) 60%, var(--green-700) 100%);
            position: fixed;
            left: 0; top: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
            transition: transform .3s ease;
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.12);
        }

        .brand-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 1px;
            line-height: 1.1;
        }

        .brand-sub {
            font-size: 0.72rem;
            color: var(--green-300);
            letter-spacing: 3px;
            text-transform: uppercase;
            font-family: 'Inter', sans-serif;
        }

        .sidebar-nav {
            padding: 1rem 0.75rem;
            flex: 1;
            overflow-y: auto;
        }

        .nav-section-title {
            font-size: 0.65rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--green-300);
            padding: 0.75rem 0.75rem 0.25rem;
            font-weight: 600;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.82);
            padding: 0.65rem 0.9rem;
            border-radius: 10px;
            margin-bottom: 3px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.88rem;
            font-weight: 500;
            transition: all .2s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: #fff;
            transform: translateX(4px);
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        .sidebar-user {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.12);
        }

        .user-card {
            background: rgba(255,255,255,0.12);
            border-radius: 12px;
            padding: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .user-card .user-name {
            font-size: 0.88rem;
            font-weight: 600;
            color: #fff;
        }

        .user-card .user-role {
            font-size: 0.72rem;
            color: var(--gold-light);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .badge-role-admin {
            background: linear-gradient(135deg, var(--gold), #E8C06A);
            color: var(--dark);
            font-size: 0.65rem;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .btn-logout {
            background: rgba(220, 38, 38, 0.2);
            color: #fca5a5;
            border: 1px solid rgba(220, 38, 38, 0.3);
            border-radius: 10px;
            padding: 0.5rem 0.9rem;
            font-size: 0.85rem;
            width: 100%;
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: center;
            transition: all .2s;
            cursor: pointer;
        }

        .btn-logout:hover {
            background: rgba(220, 38, 38, 0.4);
            color: #fff;
        }

        /* ── Content Area ───────────────────────────── */
        .content-area {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            padding: 0;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid rgba(0,0,0,0.06);
            padding: 0.9rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .page-content {
            padding: 1.75rem;
        }

        /* ── Cards ──────────────────────────────────── */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            background: #fff;
        }

        .card-header {
            border-radius: 16px 16px 0 0 !important;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1rem 1.25rem;
            font-weight: 600;
            background: #fff;
        }

        .stat-card {
            border-radius: 16px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        }

        .stat-card .stat-icon {
            width: 56px; height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            line-height: 1;
        }

        .stat-card .stat-label {
            font-size: 0.82rem;
            opacity: 0.8;
            margin-top: 4px;
            font-weight: 500;
        }

        .stat-green  { background: linear-gradient(135deg, var(--green-900), var(--green-700)); color: #fff; }
        .stat-gold   { background: linear-gradient(135deg, #8B6914, var(--gold)); color: #fff; }
        .stat-teal   { background: linear-gradient(135deg, #0d6e6e, #1a9a9a); color: #fff; }
        .stat-rose   { background: linear-gradient(135deg, #9b1d6b, #c84b96); color: #fff; }
        .stat-cream  { background: linear-gradient(135deg, var(--cream-dark), #e8ddd0); color: var(--dark); }

        /* ── Buttons ────────────────────────────────── */
        .btn-bloom {
            background: linear-gradient(135deg, var(--green-900), var(--green-700));
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            transition: all .2s;
        }

        .btn-bloom:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(27,67,50,0.35);
            color: #fff;
        }

        .btn-gold {
            background: linear-gradient(135deg, #8B6914, var(--gold));
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            transition: all .2s;
        }

        .btn-gold:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(201,168,76,0.4);
            color: #fff;
        }

        /* ── Tables ─────────────────────────────────── */
        .table-bloom thead th {
            background: var(--green-900);
            color: #fff;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            padding: 0.85rem 1rem;
            border: none;
        }

        .table-bloom tbody td {
            padding: 0.85rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--cream-dark);
            font-size: 0.88rem;
        }

        .table-bloom tbody tr:hover {
            background: var(--cream);
        }

        /* ── Form Controls ──────────────────────────── */
        .form-control, .form-select {
            border-radius: 10px;
            border: 1.5px solid #E0D9D0;
            padding: 0.55rem 0.9rem;
            font-size: 0.9rem;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--green-700);
            box-shadow: 0 0 0 3px rgba(64,145,108,0.15);
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--green-900);
            margin-bottom: 6px;
        }

        /* ── Badges ─────────────────────────────────── */
        .badge-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .badge-pending   { background: #FEF3C7; color: #92400E; }
        .badge-approved  { background: #DBEAFE; color: #1E40AF; }
        .badge-completed { background: var(--green-100); color: var(--green-900); }
        .badge-rejected  { background: #FEE2E2; color: #991B1B; }

        /* ── Product Cards ──────────────────────────── */
        .product-card {
            border-radius: 16px;
            overflow: hidden;
            transition: transform .25s, box-shadow .25s;
            border: none;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        }

        .product-card img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .product-card .card-body {
            padding: 1rem 1.1rem;
        }

        .product-price {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            color: var(--green-800);
            font-weight: 700;
        }

        .category-badge {
            background: var(--green-100);
            color: var(--green-800);
            font-size: 0.72rem;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        /* ── Alerts ─────────────────────────────────── */
        .alert {
            border-radius: 12px;
            border: none;
            font-size: 0.88rem;
        }

        .alert-success {
            background: var(--green-100);
            color: var(--green-900);
        }

        .alert-danger {
            background: #FEE2E2;
            color: #991B1B;
        }

        /* ── Notifikasi Bell ────────────────────────── */
        .notif-bell {
            position: relative;
        }

        .notif-bell .badge {
            position: absolute;
            top: -5px; right: -5px;
            font-size: 0.65rem;
            background: #ef4444;
        }

        /* ── Page Title ─────────────────────────────── */
        .page-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--green-900);
            margin: 0;
        }

        .page-subtitle {
            font-size: 0.82rem;
            color: #6B7280;
            margin: 0;
        }

        /* Scrollbar sidebar */
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.25); border-radius: 4px; }

        /* ── Responsive ──────────────────────────── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .content-area { margin-left: 0; }
        }
    </style>

    @stack('styles')
</head>
<body>

<!-- ═══════════════════════════════ SIDEBAR ═══════════════════════════════ -->
<aside class="sidebar" id="sidebar">

    <!-- Brand -->
    <div class="sidebar-brand">
        <div class="d-flex align-items-center gap-2 mb-1">
            <span style="font-size:1.8rem;">🌸</span>
            <div>
                <div class="brand-title">Bloomee</div>
                <div class="brand-sub">Flower Studio</div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">

        @auth
        @if(auth()->user()->isAdmin())

        <div class="nav-section-title">Main</div>
        <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section-title">Toko</div>
        <a href="/products" class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
            <i class="bi bi-flower1"></i> Kelola Produk
        </a>
        <a href="/shop" class="nav-link {{ request()->is('shop') ? 'active' : '' }}">
            <i class="bi bi-shop"></i> Preview Toko
        </a>

        <div class="nav-section-title">Transaksi</div>
        <a href="/admin/transaksi" class="nav-link {{ request()->is('admin/transaksi*') ? 'active' : '' }}">
            <i class="bi bi-receipt-cutoff"></i> Semua Transaksi
        </a>
        <a href="/admin/transaksi?status=pending" class="nav-link">
            <i class="bi bi-clock-history"></i> Menunggu Approve
        </a>

        <div class="nav-section-title">Admin</div>
        <a href="/laporan" class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i> Laporan
        </a>
        <a href="/users" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Data User
        </a>

        @else

        <div class="nav-section-title">Menu</div>
        <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-heart"></i> Dashboard
        </a>
        <a href="/shop" class="nav-link {{ request()->is('shop') ? 'active' : '' }}">
            <i class="bi bi-flower3"></i> Toko Bunga
        </a>
        <a href="/cart" class="nav-link {{ request()->is('cart') ? 'active' : '' }}">
            <i class="bi bi-basket3"></i> Keranjang
            @php $cartCount = array_sum(session()->get('cart', [])) @endphp
            @if($cartCount > 0)
                <span class="badge bg-warning text-dark ms-auto">{{ $cartCount }}</span>
            @endif
        </a>
        <a href="/transaksi" class="nav-link {{ request()->is('transaksi*') ? 'active' : '' }}">
            <i class="bi bi-bag-check"></i> Pesanan Saya
        </a>

        @endif

        <div class="nav-section-title">Akun</div>
        <a href="/profile" class="nav-link {{ request()->is('profile') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> Profile
        </a>
        @endauth

    </nav>

    <!-- User Info & Logout -->
    @auth
    <div class="sidebar-user">
        <div class="user-card">
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                     style="width:34px;height:34px;min-width:34px;">
                    <i class="bi bi-person-fill" style="color:var(--green-800);font-size:1rem;"></i>
                </div>
                <div>
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <span class="badge-role-admin">{{ strtoupper(auth()->user()->role) }}</span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
    @endauth

</aside>

<!-- ═══════════════════════════════ CONTENT ═══════════════════════════════ -->
<div class="content-area">

    <!-- Topbar -->
    <div class="topbar">
        <div>
            <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            <p class="page-subtitle">@yield('page-subtitle', '')</p>
        </div>
        <div class="d-flex align-items-center gap-3">

            @auth
            <!-- Notifikasi -->
            @if(!auth()->user()->isAdmin())
            @php $unread = auth()->user()->unreadNotifications->count() @endphp
            <div class="dropdown notif-bell">
                <button class="btn btn-light border rounded-circle p-2" data-bs-toggle="dropdown"
                        style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-bell fs-5"></i>
                    @if($unread > 0)
                        <span class="badge rounded-pill">{{ $unread }}</span>
                    @endif
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow" style="min-width:300px;border-radius:14px;">
                    <li class="px-3 py-2 d-flex justify-content-between align-items-center border-bottom">
                        <strong style="font-size:0.85rem;">Notifikasi</strong>
                        @if($unread > 0)
                            <a href="{{ route('notifikasi.readAll') }}" class="text-muted" style="font-size:0.75rem;">Tandai semua</a>
                        @endif
                    </li>
                    @forelse(auth()->user()->notifications->take(6) as $notif)
                    <li>
                        <a class="dropdown-item py-2 {{ is_null($notif->read_at) ? 'fw-semibold' : '' }}"
                           href="{{ route('notifikasi.read', $notif->id) }}"
                           style="font-size:0.82rem;white-space:normal;">
                            {{ $notif->data['icon'] ?? '📢' }} {{ $notif->data['message'] ?? '' }}
                            <div class="text-muted" style="font-size:0.72rem;">{{ $notif->created_at->diffForHumans() }}</div>
                        </a>
                    </li>
                    @empty
                    <li class="px-3 py-3 text-muted text-center" style="font-size:0.82rem;">Tidak ada notifikasi</li>
                    @endforelse
                </ul>
            </div>
            @endif

            <!-- User Dropdown -->
            <div class="dropdown">
                <button class="btn btn-light border d-flex align-items-center gap-2 rounded-pill px-3"
                        data-bs-toggle="dropdown" style="font-size:0.85rem;">
                    <i class="bi bi-person-circle"></i>
                    {{ auth()->user()->name }}
                    <i class="bi bi-chevron-down" style="font-size:0.7rem;"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow" style="border-radius:12px;">
                    <li><a class="dropdown-item" href="/profile"><i class="bi bi-person me-2"></i>Profile</a></li>
                    @if(!auth()->user()->isAdmin())
                    <li><a class="dropdown-item" href="/transaksi"><i class="bi bi-bag-check me-2"></i>Pesanan</a></li>
                    @endif
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            @endauth
        </div>
    </div>

    <!-- Page Content -->
    <div class="page-content">

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger d-flex align-items-center gap-2 mb-4">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>