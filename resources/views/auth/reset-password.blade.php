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
            <input id="password" name="password" type="password" minlength="8" required placeholder="Min. 8 karakter, huruf + angka">

            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <input id="password_confirmation" name="password_confirmation" type="password" minlength="8" required placeholder="Ulangi password baru">

            <div id="strength-bar" style="margin-top:8px;height:4px;border-radius:4px;background:#e2e8f0;overflow:hidden;">
                <div id="strength-fill" style="height:100%;width:0%;transition:width .3s,background .3s;border-radius:4px;"></div>
            </div>
            <p id="strength-label" style="font-size:11px;margin:4px 0 0;color:var(--muted);"></p>

            <button type="submit">Simpan Password Baru →</button>
        </form>

        <script>
            document.getElementById('password').addEventListener('input', function () {
                const val = this.value;
                let score = 0;
                if (val.length >= 8) score++;
                if (/[A-Z]/.test(val)) score++;
                if (/[0-9]/.test(val)) score++;
                if (/[^A-Za-z0-9]/.test(val)) score++;
                const colors = ['#ef4444','#f97316','#eab308','#22c55e'];
                const labels = ['Lemah','Cukup','Kuat','Sangat Kuat'];
                const fill = document.getElementById('strength-fill');
                const label = document.getElementById('strength-label');
                fill.style.width = (score * 25) + '%';
                fill.style.background = colors[score - 1] || '#e2e8f0';
                label.textContent = val.length ? labels[score - 1] || '' : '';
            });
        </script>

        <p class="link"><a href="/login">← Kembali ke login</a></p>
    </main>
</body>
</html>
