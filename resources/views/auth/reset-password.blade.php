<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hirify | Reset Password</title>
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
            width: min(760px, 100%);
            background: var(--paper);
            border-radius: 30px;
            border: 1px solid rgba(15, 23, 42, 0.08);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
            padding: 38px;
        }

        h1 {
            margin: 0;
            font-size: clamp(28px, 5vw, 40px);
            letter-spacing: -.04em;
        }

        p { color: var(--muted); }

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
        }

        .feedback { margin-top: 12px; min-height: 20px; font-size: 14px; }
        .danger { color: var(--danger); }
        .success { color: #118a4a; }

        .feedback { display: none; }

        .link {
            margin-top: 12px;
            font-size: 14px;
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
    @include('components.auth.toast')

    <main class="card">
        <h1>Buat Password Baru</h1>
        <p>Masukkan password baru Anda. Link ini valid selama 60 menit dan hanya bisa digunakan sekali.</p>

        @if ($errors->any())
            <div style="padding:10px 14px;border-radius:12px;font-size:13px;font-weight:600;margin-bottom:14px;background:rgba(180,35,24,0.08);color:#b42318;border:1px solid rgba(180,35,24,0.2);">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('error'))
            <div style="padding:10px 14px;border-radius:12px;font-size:13px;font-weight:600;margin-bottom:14px;background:rgba(180,35,24,0.08);color:#b42318;border:1px solid rgba(180,35,24,0.2);">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.reset.token') }}">
            @csrf
            <input name="token" type="hidden" value="{{ $token ?? request('token') }}">
            <input name="email" type="hidden" value="{{ $email ?? request('email') }}">

            <label for="password">Password Baru</label>
            <input id="password" name="password" type="password" minlength="8" required placeholder="Minimal 8 karakter">

            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <input id="password_confirmation" name="password_confirmation" type="password" minlength="8" required placeholder="Ulangi password baru">

            <button type="submit">Simpan Password Baru →</button>
        </form>

        <p class="link"><a href="/login">← Kembali ke login</a></p>
    </main>
</body>
</html>
