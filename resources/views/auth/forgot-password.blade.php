<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hirify | Lupa Password</title>
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
                radial-gradient(circle at 12% 18%, rgba(38, 198, 218, .16), transparent 22%),
                radial-gradient(circle at 88% 12%, rgba(38, 198, 218, .08), transparent 20%),
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
            font-size: clamp(28px, 5vw, 36px);
            letter-spacing: -.04em;
        }

        p { color: var(--muted); margin: 0 0 18px; line-height: 1.55; }

        label {
            display: block;
            margin: 16px 0 8px;
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

        button {
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
            transition: transform .15s ease, box-shadow .2s ease;
        }

        button:hover { transform: translateY(-1px); box-shadow: 0 18px 36px rgba(38, 198, 218, 0.3); }

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
        }
    </style>
</head>
<body>
    <main class="card">
        <h1>Lupa Password</h1>
        <p>Masukkan email akun Hirify Anda. Kami akan kirim kode OTP untuk mereset password.</p>

        @if ($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('password.send-otp') }}">
            @csrf
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>

            <button type="submit">Kirim Kode OTP →</button>
        </form>

        <p class="link"><a href="/login">← Kembali ke login</a></p>
    </main>
</body>
</html>
