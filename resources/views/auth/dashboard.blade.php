<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hirify | Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>

        :root {
            --bg: #f7f9fc;
            --card: #ffffff;
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
            padding: 24px;
        }

        .shell {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            gap: 16px;
        }

        .top {
            background: linear-gradient(145deg, #0b1021 0%, #10182d 45%, #17253a 100%);
            color: #eff7ea;
            border-radius: 20px;
            padding: 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
        }

        .top h1 { margin: 0 0 8px; font-size: clamp(24px, 5vw, 34px); letter-spacing: -0.04em; }
        .top p { margin: 0; color: rgba(255, 255, 255, 0.76); }

        .btn {
            border: 0;
            border-radius: 12px;
            padding: 11px 16px;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
            transition: transform .15s ease, opacity .2s ease, box-shadow .2s ease;
        }

        .btn-primary { background: #fff; color: #0f172a; }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 10px 20px rgba(255, 255, 255, 0.2); }
        .btn-danger { background: rgba(180, 35, 24, 0.1); color: var(--danger); border: 1px solid rgba(180, 35, 24, 0.2); }
        .btn-danger:hover { background: rgba(180, 35, 24, 0.15); }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 16px;
        }

        .card {
            background: var(--card);
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
            animation: fadeIn .5s ease;
        }

        .card h2 {
            margin: 0 0 20px;
            font-size: 22px;
            letter-spacing: -0.02em;
            font-weight: 700;
        }

        .meta {
            display: grid;
            gap: 8px;
            color: var(--muted);
        }

        .meta b { color: var(--ink); }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th, td {
            padding: 12px 10px;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
            text-align: left;
            font-size: 14px;
        }

        th { color: var(--muted); font-weight: 600; }

        .helper {
            margin-top: 10px;
            font-size: 13px;
            color: var(--muted);
        }


        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }


        @media (max-width: 920px) {
            .grid { grid-template-columns: 1fr; }
            .top { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
    @include('components.auth.toast')

    <main class="shell">
        <section class="top">
            <div>
                <h1>Dashboard Hirify</h1>
                <p id="welcome">Memuat data user...</p>
            </div>
            <div style="display:flex; gap:10px;">
                <a id="mentorSettingsBtn" href="/mentor/settings" class="btn btn-primary" style="display:none; text-decoration:none;">Pengaturan Mentor</a>
                <a id="mentorshipBtn" href="/mentorship" class="btn btn-primary" style="display:none; text-decoration:none;">Cari Mentor</a>
                <a id="skillTrainingBtn" href="/skill-training" class="btn btn-primary" style="display:none; text-decoration:none;">Pelatihan Skill</a>
                <a id="statisticsBtn" href="/admin/statistics" class="btn btn-primary" style="display:none; text-decoration:none;">📊 Statistik Platform</a>
                <a href="/forum" class="btn btn-primary" style="text-decoration:none;">Forum Diskusi</a>
                <button id="reloadBtn" class="btn btn-primary">Refresh</button>
                <button id="logoutBtn" class="btn btn-danger">Logout</button>
            </div>
        </section>

        <section class="grid">
            <article class="card">
                <h2>Profil Saya</h2>
                <div id="profile" class="meta"></div>
            </article>

            <article class="card">
                <h2>Manajemen User (Admin)</h2>
                <table id="usersTable" style="display:none;">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody id="usersBody"></tbody>
                </table>
                <p id="adminHint" class="helper">Fitur ini hanya tampil untuk role admin.</p>
            </article>
        </section>
    </main>

    <script>
        const welcome = document.getElementById('welcome');
        const profile = document.getElementById('profile');
        const usersTable = document.getElementById('usersTable');
        const usersBody = document.getElementById('usersBody');
        const adminHint = document.getElementById('adminHint');
        const mentorSettingsBtn = document.getElementById('mentorSettingsBtn');
        const mentorshipBtn = document.getElementById('mentorshipBtn');
        const reloadBtn = document.getElementById('reloadBtn');
        const showToast = window.hirifyShowToast;

        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]')?.content ?? '';
        }

        function printProfile(user) {
            welcome.textContent = `Halo ${user.name}, role Anda ${user.role}.`;
            profile.innerHTML = `
                <div><b>ID:</b> ${user.id}</div>
                <div><b>Nama:</b> ${user.name}</div>
                <div><b>Email:</b> ${user.email}</div>
                <div><b>Role:</b> ${user.role}</div>
            `;
        }

        // ============= Load dashboard via session-based /me =============
        (async () => {
            try {
                const response = await fetch('/me', {
                    method: 'GET',
                    headers: { 'Accept': 'application/json' },
                    credentials: 'include',
                });

                if (!response.ok) {
                    window.location.href = '/login';
                    return;
                }

                const result = await response.json();
                const user = result.user;

                printProfile(user);

                mentorSettingsBtn.style.display = user.role === 'mentor' ? 'inline-flex' : 'none';
                mentorshipBtn.style.display = user.role === 'jobseeker' ? 'inline-flex' : 'none';

                if (user.role === 'admin') {
                    if (usersTable) usersTable.style.display = 'block';
                    if (adminHint) adminHint.style.display = 'block';
                }
            } catch (error) {
                console.error('Failed to load user:', error);
                window.location.href = '/login';
            }
        })();

        // ============= Logout =============
        async function logout() {
            try {
                const response = await fetch('/logout', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                    credentials: 'include',
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    showToast('Logout berhasil', 'success');
                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 600);
                } else {
                    showToast('Logout gagal', 'error');
                }
            } catch (error) {
                showToast('Logout error: ' + error.message, 'error');
            }
        }

        // ============= Event listeners =============
        if (reloadBtn) {
            reloadBtn.addEventListener('click', () => {
                window.location.reload();
            });
        }

        document.getElementById('logoutBtn')?.addEventListener('click', logout);
        document.querySelectorAll('[data-action="logout"]').forEach(btn => {
            btn.addEventListener('click', logout);
        });
    </script>
</body>
</html>
