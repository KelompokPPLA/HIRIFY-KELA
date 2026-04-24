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
            --danger: #bf2d5b;
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
        <h1>Lupa Password</h1>
        <p>Masukkan email akun Hirify Anda. Kami akan kirim link reset password jika email terdaftar.</p>

        <form id="forgotForm">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" required>

            <button type="submit" id="submitBtn">Kirim Link Reset</button>
            <div id="feedback" class="feedback"></div>
        </form>

        <p class="link"><a href="/login">Kembali ke login</a></p>
    </main>

    <script>
        const form = document.getElementById('forgotForm');
        const submitBtn = document.getElementById('submitBtn');
        const feedback = document.getElementById('feedback');
        const showToast = window.hirifyShowToast;

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            feedback.textContent = '';
            feedback.className = 'feedback';
            submitBtn.disabled = true;

            try {
                const response = await fetch('/api/auth/forgot-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ email: form.email.value }),
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.message || 'Permintaan gagal.');
                }

                showToast(result.message || 'Jika email terdaftar, link reset akan dikirim.', 'success');
            } catch (error) {
                showToast(error.message || 'Permintaan tidak dapat diproses.', 'error');
            } finally {
                submitBtn.disabled = false;
            }
        });
    </script>
</body>
</html>
