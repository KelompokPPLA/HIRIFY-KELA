<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hirify | Statistik Platform</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap');

        :root {
            --bg: #f4f8fd;
            --card: #ffffff;
            --ink: #0d1b3d;
            --muted: #6c7a93;
            --line: #e5edf6;
            --brand: #06cbe5;
            --shadow: 0 20px 45px rgba(9,20,51,.08);
            --ok: #0b7f53;
            --warn: #b98007;
            --danger: #b42318;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 5% 15%, rgba(6,203,229,.16), transparent 24%),
                radial-gradient(circle at 95% 5%, rgba(6,203,229,.12), transparent 20%),
                var(--bg);
            min-height: 100vh;
        }

        .layout { display: grid; grid-template-columns: 250px 1fr; min-height: 100vh; }

        /* ── Sidebar ── */
        .sidebar {
            background: #fff;
            border-right: 1px solid var(--line);
            padding: 22px 16px;
            display: flex;
            flex-direction: column;
            gap: 18px;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .brand { display: flex; align-items: center; gap: 10px; font-weight: 800; font-size: 28px; letter-spacing: -0.02em; }
        .brand-mark { width: 34px; height: 34px; border-radius: 12px; background: linear-gradient(145deg,#0399b7,#06d8ee); display: grid; place-items: center; color: #fff; font-size: 17px; font-weight: 800; flex-shrink: 0; }

        .menu { display: grid; gap: 8px; }
        .menu button { border: 0; background: transparent; color: #1a2a4c; font: inherit; font-size: .93rem; text-align: left; border-radius: 12px; padding: 11px 13px; display: flex; align-items: center; gap: 10px; cursor: pointer; font-weight: 600; transition: background .15s; width: 100%; }
        .menu button:hover { background: #f2f8ff; }
        .menu button.active { background: linear-gradient(145deg,#0a1632,#111f45); color: #f2fbff; box-shadow: 0 8px 20px rgba(11,24,54,.2); }

        .profile-mini { margin-top: auto; background: #f8fbff; border: 1px solid var(--line); border-radius: 14px; padding: 12px; display: flex; align-items: center; gap: 10px; }
        .avatar-mini { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(140deg,#0499b3,#05d5ef); color: #fff; display: grid; place-items: center; font-weight: 800; font-size: .9rem; flex-shrink: 0; }
        .profile-mini strong { display: block; font-size: .88rem; }
        .profile-mini span { color: var(--muted); font-size: .78rem; }

        /* ── Content ── */
        .content { padding: 28px 28px 48px; display: flex; flex-direction: column; gap: 22px; }

        .page-header h1 { font-size: clamp(26px,3.5vw,36px); letter-spacing: -0.03em; }
        .page-header p { color: var(--muted); font-weight: 500; margin-top: 5px; font-size: .95rem; }

        /* ── Summary cards ── */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px,1fr)); gap: 14px; }

        .stat-card {
            background: #fff;
            border: 1.5px solid var(--line);
            border-radius: 18px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            box-shadow: var(--shadow);
        }

        .stat-icon { font-size: 1.8rem; line-height: 1; }
        .stat-label { font-size: .8rem; color: var(--muted); font-weight: 700; text-transform: uppercase; letter-spacing: .04em; }
        .stat-value { font-size: 2rem; font-weight: 800; letter-spacing: -0.03em; color: var(--ink); }
        .stat-sub { font-size: .78rem; color: var(--muted); font-weight: 600; }

        /* ── Charts ── */
        .charts-row { display: grid; grid-template-columns: 2fr 1fr; gap: 14px; }
        .chart-card { background: #fff; border: 1.5px solid var(--line); border-radius: 18px; padding: 22px; box-shadow: var(--shadow); }
        .chart-card h3 { font-size: 1rem; font-weight: 800; letter-spacing: -0.01em; margin-bottom: 16px; }
        .chart-wrap { position: relative; }

        .charts-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

        /* ── Table ── */
        .table-card { background: #fff; border: 1.5px solid var(--line); border-radius: 18px; padding: 22px; box-shadow: var(--shadow); }
        .table-card h3 { font-size: 1rem; font-weight: 800; letter-spacing: -0.01em; margin-bottom: 16px; }

        table { width: 100%; border-collapse: collapse; font-size: .88rem; }
        th, td { padding: 11px 12px; border-bottom: 1px solid var(--line); text-align: left; }
        th { color: var(--muted); font-weight: 700; font-size: .78rem; text-transform: uppercase; letter-spacing: .04em; }
        tr:last-child td { border-bottom: 0; }
        tr:hover td { background: #f9fcff; }

        .role-badge { display: inline-flex; padding: 3px 9px; border-radius: 999px; font-size: .72rem; font-weight: 700; }
        .role-badge.jobseeker { background: #edfcff; color: #0494ab; }
        .role-badge.mentor { background: #eafff5; color: #0b7f53; }
        .role-badge.admin { background: #fff3e0; color: #e65100; }

        /* ── Spinner ── */
        .loading-row { display: flex; justify-content: center; align-items: center; padding: 60px; }
        .spinner { display: inline-block; width: 24px; height: 24px; border: 3px solid rgba(6,203,229,.2); border-top-color: var(--brand); border-radius: 50%; animation: spin .7s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Responsive ── */
        @media (max-width: 980px) {
            .layout { grid-template-columns: 1fr; }
            .sidebar { position: static; height: auto; border-right: 0; border-bottom: 1px solid var(--line); }
            .charts-row, .charts-row-2 { grid-template-columns: 1fr; }
        }

        @media (max-width: 640px) {
            .content { padding: 14px 14px 32px; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>
@include('components.auth.toast')

<div class="layout">
    {{-- Sidebar --}}
    <aside class="sidebar">
        <div class="brand">
            <span class="brand-mark">H</span>
            <span>Hirify!</span>
        </div>
        <div class="menu">
            <button type="button" data-goto="/dashboard">Dashboard</button>
            <button type="button" class="active">Statistik Platform</button>
            <button type="button" data-goto="/dashboard">Manajemen User</button>
            <button type="button" id="logoutBtn">Logout</button>
        </div>
        <div class="profile-mini">
            <div class="avatar-mini" id="miniAvatar">A</div>
            <div>
                <strong id="miniName">Loading…</strong>
                <span id="miniEmail">-</span>
            </div>
        </div>
    </aside>

    {{-- Main --}}
    <main class="content">

        <div class="page-header">
            <h1>Statistik Platform</h1>
            <p>Pantau perkembangan platform Hirify secara real-time berdasarkan data pengguna, sesi, dan aktivitas.</p>
        </div>

        {{-- Summary cards --}}
        <div class="stats-grid" id="statsGrid">
            <div class="loading-row" style="grid-column:1/-1;"><span class="spinner"></span></div>
        </div>

        {{-- Bar chart + Donut role --}}
        <div class="charts-row">
            <div class="chart-card">
                <h3>Aktivitas Bulanan (6 Bulan Terakhir)</h3>
                <div class="chart-wrap" style="height:260px;">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>
            <div class="chart-card">
                <h3>Distribusi Pengguna per Role</h3>
                <div class="chart-wrap" style="height:260px;">
                    <canvas id="roleChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Donut booking status + course enrollment --}}
        <div class="charts-row-2">
            <div class="chart-card">
                <h3>Status Sesi Mentorship</h3>
                <div class="chart-wrap" style="height:220px;">
                    <canvas id="bookingChart"></canvas>
                </div>
            </div>
            <div class="chart-card">
                <h3>Progress Enrollment Kursus</h3>
                <div class="chart-wrap" style="height:220px;">
                    <canvas id="enrollChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Recent users table --}}
        <div class="table-card">
            <h3>Pengguna Terbaru</h3>
            <div id="recentUsersWrap">
                <div class="loading-row"><span class="spinner"></span></div>
            </div>
        </div>

    </main>
</div>

<script>
const showToast = window.hirifyShowToast;

let token = localStorage.getItem('hirify_token') || sessionStorage.getItem('hirify_token');
if (!token) { window.location.href = '/login'; }

function activeStorage() { return localStorage.getItem('hirify_token') ? localStorage : sessionStorage; }
function clearAuth() { ['hirify_token','hirify_user','hirify_remember'].forEach(k => { localStorage.removeItem(k); sessionStorage.removeItem(k); }); }

async function refreshToken() {
    try {
        const res = await fetch('/api/auth/refresh', { method:'POST', headers:{ 'Accept':'application/json','Authorization':`Bearer ${token}` } });
        const d   = await res.json();
        if (!res.ok || !d?.data?.token) return false;
        token = d.data.token;
        activeStorage().setItem('hirify_token', token);
        return true;
    } catch { return false; }
}

async function api(path, opts={}, retry=true) {
    const headers = { 'Accept':'application/json','Authorization':`Bearer ${token}`,'Content-Type':'application/json', ...(opts.headers||{}) };
    const res  = await fetch(path, { ...opts, headers });
    let   data = {};
    try { data = await res.json(); } catch {}
    if (res.status===401 && retry) { if (await refreshToken()) return api(path,opts,false); clearAuth(); window.location.href='/login'; return; }
    if (!res.ok || data.success===false) throw new Error(data.message || 'Terjadi kesalahan.');
    return data;
}

function esc(str) { return String(str??'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#39;'); }
function initial(name) { return (String(name||'A').trim()[0]||'A').toUpperCase(); }

const MONTH_LABELS = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
function monthLabel(ym) {
    const [y, m] = ym.split('-');
    return `${MONTH_LABELS[parseInt(m,10)-1]} ${y}`;
}

/* ── Load me ── */
async function loadMe() {
    const res = await api('/api/auth/me');
    const user = res.data;
    if (user.role !== 'admin') {
        showToast('Halaman ini khusus untuk admin.', 'error');
        setTimeout(() => { window.location.href = '/dashboard'; }, 1000);
        return;
    }
    document.getElementById('miniName').textContent   = user.name  || 'Admin';
    document.getElementById('miniEmail').textContent  = user.email || '-';
    document.getElementById('miniAvatar').textContent = initial(user.name);
}

/* ── Render summary cards ── */
function renderSummaryCards(s) {
    const cards = [
        { icon:'👥', label:'Total Pengguna', value: s.total_users, sub: `${s.users_by_role.jobseeker} pencari · ${s.users_by_role.mentor} mentor · ${s.users_by_role.admin} admin` },
        { icon:'🎓', label:'Sesi Mentorship', value: s.total_bookings, sub: `${s.bookings_by_status.completed} selesai · ${s.bookings_by_status.pending} menunggu` },
        { icon:'📚', label:'Kursus Tersedia', value: s.total_courses, sub: `${s.total_enrollments} total enrollment` },
        { icon:'🎯', label:'Enrollment Selesai', value: s.completed_enrollments, sub: `dari ${s.total_enrollments} enrollment` },
        { icon:'💬', label:'Thread Forum', value: s.total_forum_threads, sub: 'diskusi aktif komunitas' },
    ];

    document.getElementById('statsGrid').innerHTML = cards.map(c => `
        <div class="stat-card">
            <div class="stat-icon">${c.icon}</div>
            <div class="stat-label">${esc(c.label)}</div>
            <div class="stat-value">${esc(String(c.value))}</div>
            <div class="stat-sub">${esc(c.sub)}</div>
        </div>
    `).join('');
}

/* ── Charts ── */
let chartActivity, chartRole, chartBooking, chartEnroll;

function destroyChart(c) { if (c) { try { c.destroy(); } catch {} } }

function renderCharts(data) {
    const summary = data.summary;
    const monthly = data.monthly_activity || [];

    const labels = monthly.map(m => monthLabel(m.month));
    const usersData       = monthly.map(m => m.users);
    const bookingsData    = monthly.map(m => m.bookings);
    const enrollmentsData = monthly.map(m => m.enrollments);

    /* Bar: aktivitas bulanan */
    destroyChart(chartActivity);
    chartActivity = new Chart(document.getElementById('activityChart'), {
        type: 'bar',
        data: {
            labels,
            datasets: [
                { label:'Pengguna Baru', data: usersData, backgroundColor:'rgba(6,203,229,.75)', borderRadius: 6 },
                { label:'Sesi Mentorship', data: bookingsData, backgroundColor:'rgba(11,127,83,.75)', borderRadius: 6 },
                { label:'Enrollment Kursus', data: enrollmentsData, backgroundColor:'rgba(180,35,24,.65)', borderRadius: 6 },
            ],
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position:'bottom', labels:{ font:{ family:'Manrope', weight:'600' }, boxRadius:6 } } },
            scales: {
                x: { grid:{ display:false }, ticks:{ font:{ family:'Manrope', weight:'600' } } },
                y: { beginAtZero:true, grid:{ color:'rgba(0,0,0,.04)' }, ticks:{ font:{ family:'Manrope', weight:'600' }, precision:0 } },
            },
        },
    });

    /* Donut: role */
    destroyChart(chartRole);
    const r = summary.users_by_role;
    chartRole = new Chart(document.getElementById('roleChart'), {
        type: 'doughnut',
        data: {
            labels: ['Pencari Kerja','Mentor','Admin'],
            datasets: [{ data:[r.jobseeker, r.mentor, r.admin], backgroundColor:['#06cbe5','#0b7f53','#e65100'], borderWidth:0 }],
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            cutout: '65%',
            plugins: { legend: { position:'bottom', labels:{ font:{ family:'Manrope', weight:'600' }, boxRadius:4 } } },
        },
    });

    /* Donut: booking status */
    destroyChart(chartBooking);
    const bs = summary.bookings_by_status;
    chartBooking = new Chart(document.getElementById('bookingChart'), {
        type: 'doughnut',
        data: {
            labels: ['Menunggu','Dikonfirmasi','Selesai','Dibatalkan'],
            datasets: [{ data:[bs.pending, bs.confirmed, bs.completed, bs.cancelled], backgroundColor:['#b98007','#0494ab','#0b7f53','#b42318'], borderWidth:0 }],
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            cutout: '65%',
            plugins: { legend: { position:'bottom', labels:{ font:{ family:'Manrope', weight:'600' }, boxRadius:4 } } },
        },
    });

    /* Donut: enrollment progress */
    destroyChart(chartEnroll);
    const done = summary.completed_enrollments;
    const ongoing = summary.total_enrollments - done;
    chartEnroll = new Chart(document.getElementById('enrollChart'), {
        type: 'doughnut',
        data: {
            labels: ['Selesai','Sedang Berjalan'],
            datasets: [{ data:[done, ongoing], backgroundColor:['#0b7f53','#e5edf6'], borderWidth:0 }],
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            cutout: '65%',
            plugins: { legend: { position:'bottom', labels:{ font:{ family:'Manrope', weight:'600' }, boxRadius:4 } } },
        },
    });
}

/* ── Table: recent users ── */
function renderRecentUsers(users) {
    if (!users || !users.length) {
        document.getElementById('recentUsersWrap').innerHTML = '<p style="color:var(--muted);font-weight:600;padding:12px 0;">Belum ada data pengguna.</p>';
        return;
    }

    document.getElementById('recentUsersWrap').innerHTML = `
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Bergabung</th>
                </tr>
            </thead>
            <tbody>
                ${users.map(u => `
                    <tr>
                        <td><strong>${esc(u.name)}</strong></td>
                        <td style="color:var(--muted);">${esc(u.email)}</td>
                        <td><span class="role-badge ${esc(u.role)}">${esc(u.role)}</span></td>
                        <td style="color:var(--muted); font-size:.82rem;">${esc(u.created_at ? new Date(u.created_at).toLocaleDateString('id-ID',{day:'2-digit',month:'short',year:'numeric'}) : '-')}</td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    `;
}

/* ── Load statistics ── */
async function loadStatistics() {
    try {
        const res  = await api('/api/admin/statistics');
        const data = res.data;

        renderSummaryCards(data.summary);
        renderCharts(data);
        renderRecentUsers(data.recent_users);
    } catch (err) {
        showToast(err.message || 'Gagal memuat statistik.', 'error');
    }
}

/* ── Events ── */
function bindEvents() {
    document.querySelectorAll('[data-goto]').forEach(btn => {
        btn.addEventListener('click', () => { window.location.href = btn.dataset.goto; });
    });

    document.getElementById('logoutBtn').addEventListener('click', async () => {
        try { await api('/api/auth/logout', { method:'POST' }); } catch {}
        showToast('Sampai jumpa! 👋', 'info', 900);
        setTimeout(() => { clearAuth(); window.location.href = '/login'; }, 900);
    });
}

/* ── Boot ── */
async function boot() {
    try {
        await loadMe();
        bindEvents();
        await loadStatistics();
    } catch (err) {
        if (String(err.message).toLowerCase().includes('unauthenticated')) {
            clearAuth(); window.location.href = '/login'; return;
        }
        showToast(err.message || 'Gagal memuat halaman.', 'error');
    }
}

boot();
</script>
</body>
</html>
