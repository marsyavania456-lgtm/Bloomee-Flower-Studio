<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Bloomee Flower Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --green-900: #1B4332;
            --green-800: #2D6A4F;
            --green-700: #40916C;
            --green-300: #95D5B2;
            --green-100: #D8F3DC;
            --gold:      #C9A84C;
            --cream:     #FAF7F2;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: var(--cream);
            overflow: hidden;
        }
        /* LEFT PANEL */
        .left-panel {
            width: 50%;
            background: linear-gradient(160deg, var(--green-900) 0%, var(--green-800) 55%, var(--green-700) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 48px;
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            width: 420px; height: 420px;
            border-radius: 50%;
            border: 60px solid rgba(255,255,255,0.04);
            top: -120px; left: -120px;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            border: 50px solid rgba(255,255,255,0.05);
            bottom: -80px; right: -80px;
        }
        .left-content { position: relative; z-index: 2; text-align: center; }
        .brand-logo {
            font-size: 3.5rem;
            margin-bottom: 12px;
            display: block;
            animation: floatAnim 3s ease-in-out infinite;
        }
        @keyframes floatAnim {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-8px); }
        }
        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 2.6rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 2px;
            line-height: 1.1;
            margin-bottom: 8px;
        }
        .brand-tagline {
            font-size: 0.78rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--green-300);
            margin-bottom: 36px;
        }
        .brand-desc {
            color: rgba(255,255,255,0.72);
            font-size: 0.9rem;
            line-height: 1.8;
            max-width: 340px;
            margin: 0 auto 36px;
        }
        .feature-pills { display: flex; flex-direction: column; gap: 10px; align-items: flex-start; width: 100%; max-width: 300px; margin: 0 auto; }
        .feature-pill {
            display: flex;
            width: 300px; 
            align-items: center;
            gap: 15px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 30px;
            padding: 8px 18px;
            font-size: 0.82rem;
            color: rgba(255,255,255,0.9);
        }
        .deco-flower { position: absolute; opacity: 0.08; font-size: 5rem; pointer-events: none; }
        .deco-flower.f1 { top: 15%; left: 8%; transform: rotate(-20deg); }
        .deco-flower.f2 { bottom: 18%; right: 5%; transform: rotate(30deg); font-size: 3rem; }
        .deco-flower.f3 { top: 55%; left: 3%; font-size: 2.5rem; transform: rotate(10deg); }
        /* RIGHT PANEL */
        .right-panel {
            width: 45%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 48px;
            background: var(--cream);
        }
        .login-box { width: 100%; max-width: 380px; }
        .login-header { margin-bottom: 32px; }
        .login-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--green-900);
            margin-bottom: 6px;
        }
        .login-header p { color: #6B7280; font-size: 0.85rem; }
        .input-group-bloom { margin-bottom: 18px; }
        .input-group-bloom label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--green-900);
            margin-bottom: 6px;
        }
        .input-icon-wrap { position: relative; }
        .input-icon-wrap i.icon-left {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            font-size: 0.95rem;
        }
        .input-icon-wrap input {
            width: 100%;
            padding: 11px 40px 11px 38px;
            border: 1.5px solid #E0D9D0;
            border-radius: 10px;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        .input-icon-wrap input:focus {
            border-color: var(--green-700);
            box-shadow: 0 0 0 3px rgba(64,145,108,0.15);
        }
        .toggle-pw {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9CA3AF;
            font-size: 0.95rem;
            border: none;
            background: none;
            padding: 0;
        }
        .toggle-pw:hover { color: var(--green-700); }
        .field-error {
            color: #DC2626;
            font-size: 0.75rem;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .remember-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }
        .remember-row label {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 0.82rem;
            color: #6B7280;
            cursor: pointer;
        }
        .remember-row input[type="checkbox"] { width: 15px; height: 15px; accent-color: var(--green-700); }
        .forgot-link { font-size: 0.82rem; color: var(--green-700); text-decoration: none; font-weight: 500; }
        .forgot-link:hover { color: var(--green-900); text-decoration: underline; }
        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--green-900), var(--green-700));
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all .25s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(27,67,50,0.35); }
        .btn-login:active { transform: translateY(0); }
        .register-link { text-align: center; margin-top: 22px; font-size: 0.84rem; color: #6B7280; }
        .register-link a { color: var(--green-700); font-weight: 600; text-decoration: none; }
        .register-link a:hover { text-decoration: underline; }
        .session-status {
            background: var(--green-100);
            color: var(--green-900);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.82rem;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        @media (max-width: 768px) {
            body { flex-direction: column; overflow: auto; }
            .left-panel { width: 100%; padding: 36px 24px; min-height: auto; }
            .right-panel { width: 100%; padding: 32px 24px; }
            .brand-name { font-size: 2rem; }
            .feature-pills { display: none; }
            .brand-desc { margin-bottom: 0; }
        }
    </style>
</head>
<body>

<!-- LEFT PANEL -->
<div class="left-panel">
    <div class="deco-flower f1">🌸</div>
    <div class="deco-flower f2">🌷</div>
    <div class="deco-flower f3">🌺</div>
    <div class="left-content">
        <span class="brand-logo">🌸</span>
        <div class="brand-name">Bloomee</div>
        <div class="brand-tagline">Flower Studio</div>
        <p class="brand-desc">
            Temukan keindahan dalam setiap kelopak. Kami menghadirkan buket bunga
            segar pilihan untuk setiap momen spesialmu.
        </p>
        <div class="feature-pills">
            <div class="feature-pill"><span>🌹</span> Buket Premium &amp; Segar</div>
            <div class="feature-pill"><span>🚗</span> Pengiriman Cepat &amp; Aman</div>
            <div class="feature-pill"><span>🎁</span> Cocok untuk Semua Momen</div>
            <div class="feature-pill"><span>✨</span> Desain Elegan &amp; Custom</div>
        </div>
    </div>
</div>

<!-- RIGHT PANEL -->
<div class="right-panel">
    <div class="login-box">
        <div class="login-header">
            <h2>Selamat Datang 👋</h2>
            <p>Masuk ke akun Bloomee kamu dan mulai temukan bunga impianmu.</p>
        </div>

        @if (session('status'))
        <div class="session-status">
            <i class="bi bi-check-circle-fill"></i> {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="input-group-bloom">
                <label for="email">Alamat Email</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-envelope icon-left"></i>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="contoh@email.com"
                           required autofocus autocomplete="username">
                </div>
                @error('email')
                <div class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="input-group-bloom">
                <label for="password">Password</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-lock icon-left"></i>
                    <input type="password" id="password" name="password"
                           placeholder="Masukkan password"
                           required autocomplete="current-password">
                    <button type="button" class="toggle-pw" onclick="togglePassword()">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
                @error('password')
                <div class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <!-- Remember + Forgot -->
            <div class="remember-row">
                <label>
                    <input type="checkbox" name="remember" id="remember_me">
                    Ingat saya
                </label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                @endif
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i>
                Masuk ke Bloomee
            </button>
        </form>

        <div class="register-link">
            Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang 🌸</a>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const pw = document.getElementById('password');
    const ic = document.getElementById('eyeIcon');
    if (pw.type === 'password') {
        pw.type = 'text';
        ic.className = 'bi bi-eye-slash';
    } else {
        pw.type = 'password';
        ic.className = 'bi bi-eye';
    }
}
</script>
</body>
</html>