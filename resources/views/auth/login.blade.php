<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hirify | Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap');

        :root {
            --bg: #f7f9fc;
            --paper: #ffffff;
            --ink: #0f172a;
            --muted: #5b6b82;
            --accent: #26c6da;
            --accent-2: #1aa8c0;
            --danger: #b42318;
            --ring: rgba(38, 198, 218, 0.18);
            --navy: #10182d;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 10% 10%, rgba(38, 198, 218, 0.16), transparent 24%),
                radial-gradient(circle at 88% 8%, rgba(38, 198, 218, 0.08), transparent 20%),
                radial-gradient(circle at 70% 80%, rgba(38, 198, 218, 0.08), transparent 18%),
                var(--bg);
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .auth-card {
            width: min(960px, 100%);
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            background: var(--paper);
            border-radius: 30px;
            overflow: hidden;
            border: 1px solid rgba(15, 23, 42, 0.08);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
            animation: floatIn .6s ease;
        }

        .hero {
            padding: 42px;
            background:
                radial-gradient(circle at 18% 12%, rgba(255, 255, 255, 0.08), transparent 16%),
                linear-gradient(145deg, #0b1021 0%, #10182d 45%, #17253a 100%);
            color: #eff7ea;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .hero h1 {
            margin: 0;
            font-size: clamp(30px, 5vw, 44px);
            line-height: 1.05;
            letter-spacing: -0.04em;
            max-width: 12ch;
        }

        .hero p {
            color: rgba(255, 255, 255, 0.76);
            max-width: 34ch;
            line-height: 1.7;
        }

        .tag {
            width: fit-content;
            padding: 8px 14px;
            border: 1px solid rgba(38, 198, 218, 0.35);
            border-radius: 999px;
            font-size: 12px;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #18d5e6;
            background: rgba(8, 31, 48, 0.72);
        }

        .form-wrap { padding: 38px; }

        .title {
            margin: 0 0 8px;
            font-size: 30px;
            letter-spacing: -0.04em;
        }

        .subtitle {
            margin: 0 0 26px;
            color: var(--muted);
        }

        label {
            display: block;
            font-size: 13px;
            margin: 14px 0 8px;
            font-weight: 700;
        }

        input {
            width: 100%;
            border: 1px solid rgba(15, 23, 42, 0.12);
            background: #fbfdff;
            border-radius: 14px;
            padding: 12px 14px;
            font: inherit;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px var(--ring);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: center;
            gap: 12px;
            margin: 14px 0 20px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: var(--accent);
        }

        .checkbox-label {
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            color: var(--ink);
            margin: 0;
        }

        .forgot-link {
            font-size: 13px;
            text-align: right;
        }

        .forgot-link a {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
            transition: color .2s ease;
        }

        .forgot-link a:hover {
            color: var(--accent-2);
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
                    gap: 16px;
        }

        .back-btn {
            display: inline-flex;
                        justify-content: center;
            align-items: center;
            gap: 6px;
            padding: 10px 16px;
            background: linear-gradient(135deg, rgba(38, 198, 218, 0.12) 0%, rgba(38, 198, 218, 0.08) 100%);
            border: 1.5px solid rgba(38, 198, 218, 0.35);
            border-radius: 12px;
            color: var(--accent);
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
            transition: all .25s ease;
            box-shadow: 0 4px 12px rgba(38, 198, 218, 0.1);
            white-space: nowrap;
            flex-shrink: 0;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, rgba(38, 198, 218, 0.18) 0%, rgba(38, 198, 218, 0.12) 100%);
            border-color: rgba(38, 198, 218, 0.6);
            transform: translateX(-3px);
            box-shadow: 0 6px 16px rgba(38, 198, 218, 0.15);
        }

        .password-wrapper {
            position: relative;
                    display: flex;
                    align-items: center;
        }

        .password-wrapper input {
            width: 100%;
            padding-right: 42px;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            font-size: 20px;
            padding: 4px 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s ease;
            line-height: 1;
        }

        .password-toggle:hover {
                        transform: scale(1.1);
            color: var(--accent);
        }

        .password-toggle:active {
            transform: scale(0.95);
        }

        .btn {
            width: 100%;
            border: 0;
            border-radius: 14px;
            margin-top: 8px;
            padding: 13px 16px;
            font: inherit;
            font-weight: 700;
            letter-spacing: .02em;
            cursor: pointer;
            color: #fff;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
            box-shadow: 0 16px 30px rgba(38, 198, 218, 0.24);
            transition: transform .15s ease, opacity .2s ease, box-shadow .2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn:hover { transform: translateY(-1px); box-shadow: 0 18px 36px rgba(38, 198, 218, 0.3); }
        .btn:disabled { opacity: .7; cursor: not-allowed; }

        .feedback {
            margin-top: 14px;
            font-size: 14px;
            min-height: 22px;
            display: none;
        }

        .danger { color: var(--danger); }
        .success { color: #0f7a41; }

        .link {
            margin-top: 14px;
            color: var(--muted);
            font-size: 14px;
        }

        .link a {
            color: var(--navy);
            font-weight: 700;
            text-decoration: none;
        }

        @keyframes floatIn {
            from { opacity: 0; transform: translateY(14px) scale(.985); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @media (max-width: 900px) {
            .auth-card { grid-template-columns: 1fr; }
            .hero { gap: 22px; }
        }

        @media (max-width: 540px) {
            .auth-card { border-radius: 24px; }
            .hero,
            .form-wrap { padding: 24px; }
        }
    </style>
</head>
<body>
    @include('components.auth.toast')

    <main class="auth-card">
        <section class="hero">
            <div>
                <span class="tag">HIRIFY PLATFORM</span>
                <h1>Masuk dan lanjutkan progress kariermu.</h1>
            </div>
            <p>Kelola kesiapan kerja, akses mentoring, dan bangun portofolio profesional dari satu dashboard.</p>
        </section>

        <section class="form-wrap">
            <div class="header-top">
                <div>
                    <h2 class="title">Login</h2>
                    <p class="subtitle">Gunakan akun yang sudah terdaftar di Hirify.</p>
                </div>
                <a href="/" class="back-btn">← Beranda</a>
            </div>

            <form id="loginForm">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" required>

                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input id="password" name="password" type="password" minlength="8" required>
                    <button type="button" class="password-toggle" id="togglePassword" title="Tampilkan/Sembunyikan password">👁</button>
                </div>

                <div class="form-row">
                    <div class="checkbox-wrapper">
                        <input id="remember" type="checkbox" name="remember">
                        <label for="remember" class="checkbox-label">Ingat saya</label>
                    </div>
                    <p class="forgot-link"><a href="/forgot-password">Lupa password?</a></p>
                </div>

                <button class="btn" type="submit" id="submitBtn"><span>Masuk</span><span>→</span></button>
                <div id="feedback" class="feedback"></div>
            </form>

            <p class="link">Belum punya akun? <a href="/register">Daftar di sini</a></p>
        </section>
    </main>

    <script>
        const form = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        const feedback = document.getElementById('feedback');
        const showToast = window.hirifyShowToast;
        const rememberCheckbox = document.getElementById('remember');
        const passwordInput = document.getElementById('password');
        const toggleBtn = document.getElementById('togglePassword');
        const rememberPrefKey = 'hirify_remember';

        if (localStorage.getItem(rememberPrefKey) === '1') {
            rememberCheckbox.checked = true;
        }

        (async () => {
            const rememberedToken = localStorage.getItem('hirify_token');

            if (!rememberedToken) {
                return;
            }

            try {
                const response = await fetch('/api/auth/me', {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${rememberedToken}`,
                    },
                });

                if (response.ok) {
                    window.location.href = '/dashboard';
                    return;
                }

                localStorage.removeItem('hirify_token');
                localStorage.removeItem('hirify_user');
                localStorage.removeItem(rememberPrefKey);
            } catch (_) {
                // Abaikan error network sementara, user tetap bisa login manual.
            }
        })();

        toggleBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            toggleBtn.textContent = isPassword ? '🙈' : '👁';
        });

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            feedback.textContent = '';
            feedback.className = 'feedback';
            submitBtn.disabled = true;

            const payload = {
                email: form.email.value,
                password: form.password.value,
                device_name: 'hirify-web',
                remember: rememberCheckbox.checked,
            };

            try {
                const response = await fetch('/api/auth/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.message || 'Login gagal.');
                }

                const targetStorage = rememberCheckbox.checked ? localStorage : sessionStorage;
                const otherStorage = rememberCheckbox.checked ? sessionStorage : localStorage;

                otherStorage.removeItem('hirify_token');
                otherStorage.removeItem('hirify_user');

                targetStorage.setItem('hirify_token', result.data.token);
                targetStorage.setItem('hirify_user', JSON.stringify(result.data.user));

                if (rememberCheckbox.checked) {
                    localStorage.setItem(rememberPrefKey, '1');
                } else {
                    localStorage.removeItem(rememberPrefKey);
                }

                showToast('Login berhasil. Anda akan diarahkan ke dashboard.', 'success');
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 800);
            } catch (error) {
                showToast(error.message || 'Email atau password tidak valid.', 'error');
            } finally {
                submitBtn.disabled = false;
            }
        });
    </script>
</body>
</html>
