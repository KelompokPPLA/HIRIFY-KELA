<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hirify | Reset Password (OTP)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>

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
                radial-gradient(circle at 18% 20%, rgba(38, 198, 218, .16), transparent 22%),
                radial-gradient(circle at 82% 14%, rgba(38, 198, 218, .08), transparent 18%),
                linear-gradient(180deg, #fbfdff, var(--bg));
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .card {
            width: min(560px, 100%);
            background: var(--paper);
            border-radius: 30px;
            border: 1px solid rgba(15, 23, 42, 0.08);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
            padding: 38px;
        }

        h1 {
            margin: 0 0 8px;
            font-size: clamp(26px, 5vw, 34px);
            letter-spacing: -.04em;
        }

        p.lead { color: var(--muted); margin: 0 0 22px; line-height: 1.55; }

        .otp-display {
            background: linear-gradient(135deg, rgba(38, 198, 218, 0.12) 0%, rgba(38, 198, 218, 0.04) 100%);
            border: 1.5px dashed rgba(38, 198, 218, 0.5);
            border-radius: 16px;
            padding: 18px 20px;
            margin-bottom: 22px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .otp-display .otp-label {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--accent-2);
        }

        .otp-display .otp-code {
            font-family: 'Manrope', monospace;
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 0.4em;
            color: var(--navy);
            cursor: pointer;
            user-select: all;
            padding: 6px 14px;
            border-radius: 10px;
            transition: background .15s ease;
        }

        .otp-display .otp-code:hover { background: rgba(38, 198, 218, 0.1); }

        .otp-display .otp-hint {
            font-size: 12px;
            color: var(--muted);
        }

        .otp-display .copy-btn {
            border: 0;
            background: var(--accent);
            color: #fff;
            border-radius: 10px;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: background .15s;
        }

        .otp-display .copy-btn:hover { background: var(--accent-2); }

        label {
            display: block;
            margin: 14px 0 8px;
            font-weight: 700;
            font-size: 13px;
        }

        input {
            width: 100%;
            border-radius: 14px;
            border: 1px solid rgba(15, 23, 42, 0.12);
            background: #fbfdff;
            padding: 12px 14px;
            font: inherit;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px var(--ring);
        }

        input[name="otp"] {
            text-align: center;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 0.4em;
        }

        button[type="submit"] {
            margin-top: 22px;
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
            transition: transform .15s ease, box-shadow .2s ease;
        }

        button[type="submit"]:hover { transform: translateY(-1px); box-shadow: 0 18px 36px rgba(38, 198, 218, 0.3); }

        .alert {
            padding: 10px 14px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 14px;
        }

        .alert-error {
            background: rgba(180, 35, 24, 0.08);
            color: var(--danger);
            border: 1px solid rgba(180, 35, 24, 0.2);
        }

        .alert-success {
            background: rgba(15, 122, 65, 0.08);
            color: #0f7a41;
            border: 1px solid rgba(15, 122, 65, 0.2);
        }

        .link {
            margin-top: 14px;
            font-size: 14px;
            color: var(--muted);
        }

        .link a {
            color: var(--navy);
            font-weight: 700;
            text-decoration: none;
        }

        @media (max-width: 540px) {
            .card { border-radius: 24px; padding: 24px; }
            .otp-display .otp-code { font-size: 28px; letter-spacing: 0.3em; }
        }
    </style>
</head>
<body>
    <main class="card">
        <h1>Reset Password</h1>
        <p class="lead">Salin kode OTP di bawah, lalu masukkan ke kolom OTP dan tentukan password baru Anda.</p>

        @if ($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (!empty($otpCode))
            <div class="otp-display">
                <span class="otp-label">Kode OTP Anda</span>
                <span class="otp-code" id="otpCode">{{ $otpCode }}</span>
                <button type="button" class="copy-btn" id="copyBtn">Salin Kode</button>
                <span class="otp-hint">Kode berlaku 10 menit. Klik atau salin untuk paste ke bawah.</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.otp.reset') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <label for="email_display">Email</label>
            <input id="email_display" type="email" value="{{ $email }}" disabled>

            <label for="otp">Kode OTP (6 digit)</label>
            <input id="otp" name="otp" type="text" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required autofocus>

            <label for="password">Password Baru</label>
            <input id="password" name="password" type="password" minlength="8" required>

            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <input id="password_confirmation" name="password_confirmation" type="password" minlength="8" required>

            <button type="submit">Reset Password →</button>
        </form>

        <p class="link"><a href="/login">← Kembali ke login</a></p>
    </main>

    <script>
        const otpEl = document.getElementById('otpCode');
        const copyBtn = document.getElementById('copyBtn');
        const otpInput = document.getElementById('otp');

        if (otpEl && copyBtn && otpInput) {
            const fillOtp = () => {
                otpInput.value = otpEl.textContent.trim();
                otpInput.focus();
            };

            otpEl.addEventListener('click', fillOtp);

            copyBtn.addEventListener('click', async () => {
                const code = otpEl.textContent.trim();
                fillOtp();
                try {
                    await navigator.clipboard.writeText(code);
                    copyBtn.textContent = '✓ Disalin';
                    setTimeout(() => (copyBtn.textContent = 'Salin Kode'), 1400);
                } catch (_) {
                    copyBtn.textContent = '✓ Diisi otomatis';
                    setTimeout(() => (copyBtn.textContent = 'Salin Kode'), 1400);
                }
            });
        }
    </script>
</body>
</html>
