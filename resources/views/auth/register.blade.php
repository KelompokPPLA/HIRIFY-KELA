<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hirify | Register</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap');

        :root {
            --bg: #f7f9fc;
            --paper: #fff;
            --ink: #0f172a;
            --muted: #5b6b82;
            --accent: #26c6da;
            --accent-2: #1aa8c0;
            --danger: #b42318;
            --ring: rgba(38, 198, 218, .18);
            --navy: #10182d;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 12% 10%, rgba(38, 198, 218, 0.16), transparent 22%),
                radial-gradient(circle at 90% 12%, rgba(38, 198, 218, 0.08), transparent 20%),
                var(--bg);
            display: grid;
            place-items: center;
            padding: 26px;
        }

        .panel {
            width: min(760px, 100%);
            background: var(--paper);
            border-radius: 30px;
            border: 1px solid rgba(15, 23, 42, 0.08);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
            padding: 38px;
            animation: pop .5s ease;
        }

        h1 {
            margin: 0;
            font-size: clamp(28px, 5vw, 40px);
            letter-spacing: -.04em;
        }

        .lead {
            margin: 8px 0 20px;
            color: var(--muted);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .field { display: flex; flex-direction: column; gap: 8px; }
        .full { grid-column: 1 / -1; }

        label {
            font-size: 13px;
            font-weight: 700;
        }

        input, select {
            width: 100%;
            border: 1px solid rgba(15, 23, 42, 0.12);
            background: #fbfdff;
            border-radius: 14px;
            padding: 12px 14px;
            font: inherit;
            outline: none;
            transition: box-shadow .2s, border-color .2s;
        }

        input:focus, select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px var(--ring);
        }

        .submit-btn {
            margin-top: 18px;
            width: 100%;
            border: 0;
            border-radius: 14px;
            padding: 13px;
            font: inherit;
            font-weight: 700;
            color: #fff;
            cursor: pointer;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
            box-shadow: 0 16px 30px rgba(38, 198, 218, 0.24);
        }

        .feedback {
            margin-top: 12px;
            min-height: 20px;
            font-size: 14px;
            display: none;
        }

        .danger { color: var(--danger); }
        .success { color: #0f7a41; }

        .link {
            margin-top: 12px;
            color: var(--muted);
            font-size: 14px;
        }

        .link a {
            color: var(--navy);
            font-weight: 700;
            text-decoration: none;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
            gap: 16px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
                        justify-content: center;
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
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            font-size: 20px;
            margin: 0;
            width: auto;
            padding: 4px 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s ease;
            line-height: 1;
        }

        .password-toggle:hover {
            transform: translateY(-50%) scale(1.1);
            color: var(--accent);
        }

        .password-toggle:active {
            transform: translateY(-50%) scale(0.95);
        }

        @keyframes pop {
            from { opacity: 0; transform: translateY(8px) scale(.99); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @media (max-width: 720px) {
            .panel { padding: 24px; }
            .grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 540px) {
            .panel { border-radius: 24px; }
        }
    </style>
</head>
<body>
    @include('components.auth.toast')

    <main class="panel">
        <div class="header-section">
            <div>
                <h1>Buat Akun Hirify</h1>
                <p class="lead">Mulai perjalanan kariermu dan dapatkan pengalaman belajar yang terarah.</p>
            </div>
            <a href="/" class="back-btn">← Beranda</a>
        </div>

        <form id="registerForm">
            <div class="grid">
                <div class="field full">
                    <label for="name">Nama Lengkap</label>
                    <input id="name" name="name" required>
                </div>

                <div class="field full">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" required>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input id="password" name="password" type="password" minlength="8" required>
                        <button type="button" class="password-toggle" id="togglePassword" title="Tampilkan/Sembunyikan password">👁</button>
                    </div>
                </div>

                <div class="field">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="password-wrapper">
                        <input id="password_confirmation" name="password_confirmation" type="password" minlength="8" required>
                        <button type="button" class="password-toggle" id="toggleConfirm" title="Tampilkan/Sembunyikan password">👁</button>
                    </div>
                </div>

                <div class="field full">
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="jobseeker">Job Seeker</option>
                        <option value="mentor">Mentor</option>
                    </select>
                </div>
            </div>

            <button type="submit" id="submitBtn" class="submit-btn">Daftar Sekarang</button>
            <div id="feedback" class="feedback"></div>
        </form>

        <p class="link">Sudah punya akun? <a href="/login">Masuk di sini</a></p>
    </main>

    <script>
        const form = document.getElementById('registerForm');
        const submitBtn = document.getElementById('submitBtn');
        const feedback = document.getElementById('feedback');
        const showToast = window.hirifyShowToast;
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const toggleBtn = document.getElementById('togglePassword');
        const toggleConfirm = document.getElementById('toggleConfirm');

        toggleBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            toggleBtn.textContent = isPassword ? '🙈' : '👁';
        });

        toggleConfirm.addEventListener('click', (e) => {
            e.preventDefault();
            const isPassword = confirmInput.type === 'password';
            confirmInput.type = isPassword ? 'text' : 'password';
            toggleConfirm.textContent = isPassword ? '🙈' : '👁';
        });

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            feedback.textContent = '';
            feedback.className = 'feedback';
            submitBtn.disabled = true;

            const payload = {
                name: form.name.value,
                email: form.email.value,
                password: form.password.value,
                password_confirmation: form.password_confirmation.value,
                role: form.role.value,
                device_name: 'hirify-web',
            };

            try {
                const response = await fetch('/api/auth/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.message || 'Register gagal.');
                }

                localStorage.removeItem('hirify_token');
                localStorage.removeItem('hirify_user');

                showToast('Registrasi berhasil. Silakan login untuk melanjutkan.', 'success');

                setTimeout(() => {
                    window.location.href = '/login';
                }, 1100);
            } catch (error) {
                showToast(error.message || 'Registrasi gagal. Periksa kembali data Anda.', 'error');
            } finally {
                submitBtn.disabled = false;
            }
        });
    </script>
</body>
</html>
