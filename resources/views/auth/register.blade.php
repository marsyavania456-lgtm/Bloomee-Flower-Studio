<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar — Bloomee Flower Studio</title>
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

        /* ── LEFT PANEL ── */
        .left-panel {
            width: 58%;
            background: linear-gradient(160deg, var(--green-900) 0%, var(--green-800) 55%, var(--green-700) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 40px;
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            width: 420px; height: 420px;
            border-radius: 50%;
            border: 60px solid rgba(255,255,255,0.04);
            top: -130px; left: -130px;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            width: 280px; height: 280px;
            border-radius: 50%;
            border: 45px solid rgba(255,255,255,0.05);
            bottom: -70px; right: -70px;
        }
        .left-content { position: relative; z-index: 2; text-align: center; width: 100%; }
        .brand-logo {
            font-size: 3rem;
            display: block;
            margin-bottom: 10px;
            animation: floatAnim 3s ease-in-out infinite;
        }
        @keyframes floatAnim {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-8px); }
        }
        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 2.3rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 2px;
            margin-bottom: 6px;
        }
        .brand-tagline {
            font-size: 0.72rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--green-300);
            margin-bottom: 32px;
        }

        /* Steps */
        .steps-title {
            font-size: 0.72rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.45);
            margin-bottom: 30px;
        }
        .step-list { display: flex; flex-direction: column; gap: 12px;  margin-left: 120px}
        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            text-align: left;
        }
        .step-num {
            width: 32px; height: 32px;
            min-width: 32px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            color: #fff;
        }
        .step-text { padding-top: 5px; }
        .step-text strong { display: block; font-size: 0.85rem; color: #fff; margin-bottom: 2px; }
        .step-text span   { font-size: 0.75rem; color: rgba(255,255,255,0.55); }

        /* Divider */
        .left-divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin: 28px 0;
        }

        /* Quote */
        .brand-quote {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.55);
            line-height: 1.7;
            font-style: italic;
        }

        /* Deco */
        .deco { position: absolute; opacity: 0.07; font-size: 5rem; pointer-events: none; }
        .deco.d1 { top: 10%; right: 6%; transform: rotate(20deg); }
        .deco.d2 { bottom: 12%; left: 4%; transform: rotate(-15deg); font-size: 3rem; }

        /* ── RIGHT PANEL ── */
        .right-panel {
            width: 58%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 36px 52px;
            background: var(--cream);
            overflow-y: auto;
        }
        .register-box { width: 100%; max-width: 460px; }
        .register-header { margin-bottom: 28px; }
        .register-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.65rem;
            font-weight: 700;
            color: var(--green-900);
            margin-bottom: 5px;
        }
        .register-header p { color: #6B7280; font-size: 0.84rem; }

        /* Form Row */
        .form-row { display: flex; gap: 14px; }
        .form-row .input-group-bloom { flex: 1; }

        /* Input */
        .input-group-bloom { margin-bottom: 16px; }
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
            font-size: 0.92rem;
        }
        .input-icon-wrap input {
            width: 100%;
            padding: 11px 40px 11px 38px;
            border: 1.5px solid #E0D9D0;
            border-radius: 10px;
            font-size: 0.88rem;
            font-family: 'Inter', sans-serif;
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
            color: #1A1A1A;
        }
        .input-icon-wrap input:focus {
            border-color: var(--green-700);
            box-shadow: 0 0 0 3px rgba(64,145,108,0.15);
        }
        .input-icon-wrap input.is-error { border-color: #DC2626; }
        .toggle-pw {
            position: absolute;
            right: 13px; top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9CA3AF;
            font-size: 0.92rem;
            border: none;
            background: none;
            padding: 0;
        }
        .toggle-pw:hover { color: var(--green-700); }
        .field-error {
            color: #DC2626;
            font-size: 0.74rem;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Password Strength */
        .pw-strength { margin-top: 6px; }
        .pw-strength-bar {
            height: 4px;
            border-radius: 4px;
            background: #E5E7EB;
            margin-bottom: 4px;
            overflow: hidden;
        }
        .pw-strength-fill {
            height: 100%;
            border-radius: 4px;
            width: 0%;
            transition: width .3s, background .3s;
        }
        .pw-strength-label { font-size: 0.72rem; color: #9CA3AF; }

        /* Terms */
        .terms-row {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-bottom: 20px;
            font-size: 0.82rem;
            color: #6B7280;
        }
        .terms-row input[type="checkbox"] {
            margin-top: 2px;
            width: 15px; height: 15px;
            accent-color: var(--green-700);
            flex-shrink: 0;
        }
        .terms-row a { color: var(--green-700); font-weight: 500; text-decoration: none; }
        .terms-row a:hover { text-decoration: underline; }

        /* Button */
        .btn-register {
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
        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(27,67,50,0.35); }
        .btn-register:active { transform: translateY(0); }

        /* Login Link */
        .login-link { text-align: center; margin-top: 18px; font-size: 0.84rem; color: #6B7280; }
        .login-link a { color: var(--green-700); font-weight: 600; text-decoration: none; }
        .login-link a:hover { text-decoration: underline; }

        /* Section divider */
        .section-label {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #9CA3AF;
            margin-bottom: 12px;
            margin-top: 4px;
        }

        @media (max-width: 768px) {
            body { flex-direction: column; overflow: auto; }
            .left-panel  { width: 100%; padding: 32px 24px; min-height: auto; }
            .right-panel { width: 100%; padding: 28px 20px; }
            .form-row    { flex-direction: column; gap: 0; }
            .brand-name  { font-size: 1.8rem; }
            .step-list   { display: none; }
        }
    </style>
</head>
<body>

<!-- ══════════════ LEFT PANEL ══════════════ -->
<div class="left-panel">
    <div class="deco d1">🌷</div>
    <div class="deco d2">🌸</div>

    <div class="left-content">
        <span class="brand-logo">🌸</span>
        <div class="brand-name">Bloomee</div>
        <div class="brand-tagline">Flower Studio</div>

        <div class="steps-title">Cara Bergabung</div>
        <div class="step-list">
            <div class="step-item">
                <div class="step-num">1</div>
                <div class="step-text">
                    <strong>Buat Akun</strong>
                    <span>Isi form pendaftaran dengan data kamu</span>
                </div>
            </div>
            <div class="step-item">
                <div class="step-num">2</div>
                <div class="step-text">
                    <strong>Jelajahi Toko</strong>
                    <span>Pilih buket bunga favoritmu</span>
                </div>
            </div>
            <div class="step-item">
                <div class="step-num">3</div>
                <div class="step-text">
                    <strong>Pesan &amp; Bayar</strong>
                    <span>Checkout mudah, berbagai metode bayar</span>
                </div>
            </div>
            <div class="step-item">
                <div class="step-num">4</div>
                <div class="step-text">
                    <strong>Terima Bunga 💐</strong>
                    <span>Bunga segar dikirim ke lokasimu</span>
                </div>
            </div>
        </div>

        <hr class="left-divider">

        <p class="brand-quote">
            "Setiap bunga adalah kata-kata yang tak terucap,<br>
            dan kami membantu kamu mengatakannya."
        </p>
    </div>
</div>

<!-- ══════════════ RIGHT PANEL ══════════════ -->
<div class="right-panel">
    <div class="register-box">

        <div class="register-header">
            <h2>Buat Akun Baru 🌺</h2>
            <p>Bergabung dengan ribuan pelanggan Bloomee dan temukan bunga impianmu.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Info Pribadi -->
            <div class="section-label">Informasi Pribadi</div>

            <!-- Name -->
            <div class="input-group-bloom">
                <label for="name">Nama Lengkap</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-person icon-left"></i>
                    <input type="text" id="name" name="name"
                           value="{{ old('name') }}"
                           placeholder="cth: Marsyah Vania"
                           required autofocus autocomplete="name"
                           class="{{ $errors->has('name') ? 'is-error' : '' }}">
                </div>
                @error('name')
                <div class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="input-group-bloom">
                <label for="email">Alamat Email</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-envelope icon-left"></i>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="contoh@email.com"
                           required autocomplete="username"
                           class="{{ $errors->has('email') ? 'is-error' : '' }}">
                </div>
                @error('email')
                <div class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="section-label" style="margin-top:4px;">Keamanan Akun</div>

            <div class="form-row">
                <!-- Password -->
                <div class="input-group-bloom">
                    <label for="password">Password</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-lock icon-left"></i>
                        <input type="password" id="password" name="password"
                               placeholder="Min. 8 karakter"
                               required autocomplete="new-password"
                               oninput="checkStrength(this.value)"
                               class="{{ $errors->has('password') ? 'is-error' : '' }}">
                        <button type="button" class="toggle-pw" onclick="togglePw('password','eye1')">
                            <i class="bi bi-eye" id="eye1"></i>
                        </button>
                    </div>
                    <!-- Strength Bar -->
                    <div class="pw-strength">
                    </div>
                    @error('password')
                    <div class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="input-group-bloom">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-lock-fill icon-left"></i>
                        <input type="password" id="password_confirmation"
                               name="password_confirmation"
                               placeholder="Ulangi password"
                               required autocomplete="new-password"
                               oninput="checkMatch()"
                               class="{{ $errors->has('password_confirmation') ? 'is-error' : '' }}">
                        <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation','eye2')">
                            <i class="bi bi-eye" id="eye2"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                    <div class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-register">
                <i class="bi bi-flower1"></i>
                Buat Akun Bloomee
            </button>
        </form>

        <div class="login-link">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini →</a>
        </div>

    </div>
</div>

<script>
function togglePw(inputId, iconId) {
    const pw = document.getElementById(inputId);
    const ic = document.getElementById(iconId);
    if (pw.type === 'password') {
        pw.type = 'text';
        ic.className = 'bi bi-eye-slash';
    } else {
        pw.type = 'password';
        ic.className = 'bi bi-eye';
    }
}

function checkStrength(val) {
    const fill  = document.getElementById('strengthFill');
    const label = document.getElementById('strengthLabel');
    let score = 0;
    if (val.length >= 8)              score++;
    if (/[A-Z]/.test(val))           score++;
    if (/[0-9]/.test(val))           score++;
    if (/[^A-Za-z0-9]/.test(val))   score++;

    const levels = [
        { w: '0%',   c: '#E5E7EB', t: 'Masukkan password' },
        { w: '25%',  c: '#EF4444', t: 'Lemah' },
        { w: '50%',  c: '#F59E0B', t: 'Cukup' },
        { w: '75%',  c: '#3B82F6', t: 'Kuat' },
        { w: '100%', c: '#10B981', t: 'Sangat Kuat 💪' },
    ];
    const lvl = val.length === 0 ? levels[0] : levels[score];
    fill.style.width      = lvl.w;
    fill.style.background = lvl.c;
    label.textContent     = lvl.t;
    label.style.color     = lvl.c;
}

function checkMatch() {
    const pw   = document.getElementById('password').value;
    const conf = document.getElementById('password_confirmation').value;
    const lbl  = document.getElementById('matchLabel');
    if (conf.length === 0) {
        lbl.textContent = '—'; lbl.style.color = '#9CA3AF'; return;
    }
    if (pw === conf) {
        lbl.textContent = '✓ Password cocok'; lbl.style.color = '#10B981';
    } else {
        lbl.textContent = '✗ Password tidak cocok'; lbl.style.color = '#EF4444';
    }
}
</script>

</body>
</html>