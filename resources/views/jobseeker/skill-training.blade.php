<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hirify | Pelatihan Skill</title>
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

        /* Sidebar */
        .sidebar {
            background: #fff; border-right: 1px solid var(--line);
            padding: 22px 16px; display: flex; flex-direction: column;
            gap: 18px; position: sticky; top: 0; height: 100vh;
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

        /* Content */
        .content { padding: 28px 28px 40px; display: flex; flex-direction: column; gap: 20px; }

        /* Buttons */
        .btn { border: 0; border-radius: 12px; padding: 11px 16px; font: inherit; font-size: .9rem; font-weight: 700; cursor: pointer; transition: transform .15s, opacity .15s; display: inline-flex; align-items: center; gap: 6px; }
        .btn:hover:not(:disabled) { transform: translateY(-1px); }
        .btn:disabled { opacity: .45; cursor: not-allowed; }
        .btn-brand { background: linear-gradient(140deg,#08cde6,#00b2cb); color: #fff; }
        .btn-ghost { background: #f3f8fe; color: #17315f; border: 1px solid #dbe8f6; }
        .btn-dark { background: #07193d; color: #fff; }
        .btn-sm { padding: 7px 12px; font-size: .82rem; border-radius: 9px; }
        .btn-success { background: rgba(11,127,83,.1); color: var(--ok); border: 1px solid rgba(11,127,83,.25); }

        /* Card */
        .card { background: var(--card); border: 1px solid var(--line); border-radius: 18px; box-shadow: var(--shadow); }

        /* Input */
        .input, .select { width: 100%; border-radius: 12px; border: 1.5px solid #d5e3f1; background: #fff; padding: 11px 14px; font: inherit; font-size: .93rem; color: var(--ink); outline: none; transition: border-color .2s, box-shadow .2s; }
        .input:focus, .select:focus { border-color: var(--brand); box-shadow: 0 0 0 4px rgba(6,203,229,.14); }

        /* Page header */
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
        .page-header h1 { font-size: clamp(26px,3.5vw,38px); letter-spacing: -0.03em; }
        .page-header p { color: var(--muted); font-weight: 500; margin-top: 5px; font-size: .95rem; }

        /* Tabs */
        .tabs { display: flex; gap: 6px; background: #f0f5fc; border-radius: 14px; padding: 5px; width: fit-content; }
        .tab-btn { border: 0; background: transparent; border-radius: 10px; padding: 9px 18px; font: inherit; font-size: .88rem; font-weight: 700; color: var(--muted); cursor: pointer; transition: background .15s, color .15s; }
        .tab-btn.active { background: #fff; color: var(--ink); box-shadow: 0 2px 8px rgba(9,20,51,.08); }

        /* Search & filter */
        .filter-bar { padding: 14px 16px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
        .filter-bar .input { flex: 1; min-width: 200px; }
        .filter-bar .select { width: auto; min-width: 150px; }

        /* Course grid */
        .section-label { font-size: 1.5rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 14px; }

        .course-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 14px; }

        .course-card { background: #fff; border: 1.5px solid var(--line); border-radius: 18px; padding: 20px; display: flex; flex-direction: column; gap: 12px; cursor: pointer; transition: border-color .2s, box-shadow .2s, transform .15s; }
        .course-card:hover { border-color: rgba(6,203,229,.5); box-shadow: 0 8px 28px rgba(6,180,210,.1); transform: translateY(-2px); }

        .course-emoji { font-size: 2.5rem; line-height: 1; }
        .course-category { display: inline-flex; padding: 3px 10px; border-radius: 999px; font-size: .73rem; font-weight: 700; background: #edfcff; color: #0494ab; }
        .course-title { font-size: 1.05rem; font-weight: 800; color: #0d1b3d; letter-spacing: -0.01em; line-height: 1.3; }
        .course-desc { color: #516080; font-size: .87rem; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

        .course-meta { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; }
        .level-badge { display: inline-flex; padding: 3px 9px; border-radius: 999px; font-size: .72rem; font-weight: 700; }
        .level-badge.beginner { background: #eafff5; color: #0b7f53; }
        .level-badge.intermediate { background: #fff8e1; color: #9c6c00; }
        .level-badge.advanced { background: #ffeef0; color: #c0122a; }

        .course-stat { font-size: .8rem; color: var(--muted); font-weight: 600; }
        .dot { color: #c5d4e3; }

        .course-footer { border-top: 1px solid var(--line); padding-top: 12px; display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-top: auto; }
        .enrolled-badge { display: inline-flex; align-items: center; gap: 5px; padding: 5px 11px; border-radius: 999px; font-size: .78rem; font-weight: 700; background: #eafff5; color: var(--ok); }

        /* Progress bar */
        .progress-wrap { display: grid; gap: 5px; }
        .progress-bar { height: 8px; background: #e5edf6; border-radius: 999px; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 999px; background: linear-gradient(90deg, #06cbe5, #0399b7); transition: width .4s ease; }
        .progress-label { font-size: .78rem; color: var(--muted); font-weight: 600; }

        /* Empty state */
        .empty-state { text-align: center; padding: 40px 20px; color: var(--muted); border: 1.5px dashed #cfdded; border-radius: 18px; background: #fff; }
        .empty-icon { font-size: 3rem; margin-bottom: 10px; }
        .empty-state p { font-weight: 600; margin-top: 6px; }

        /* Loading */
        .loading-row { display: flex; justify-content: center; padding: 40px; }
        .spinner { display: inline-block; width: 22px; height: 22px; border: 3px solid rgba(6,203,229,.2); border-top-color: var(--brand); border-radius: 50%; animation: spin .7s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Detail panel */
        #detailView { display: none; flex-direction: column; gap: 18px; }
        #detailView.show { display: flex; }

        .detail-hero { background: linear-gradient(145deg,#0a1530,#0f2147); color: #f0f8ff; border-radius: 18px; padding: 28px 30px; display: grid; gap: 14px; }
        .detail-hero-top { display: flex; align-items: flex-start; gap: 18px; }
        .detail-hero-emoji { font-size: 3.5rem; line-height: 1; flex-shrink: 0; }
        .detail-hero h2 { font-size: clamp(1.2rem, 2.5vw, 1.7rem); letter-spacing: -0.02em; margin-bottom: 6px; }
        .detail-hero-meta { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; color: rgba(240,248,255,.7); font-size: .83rem; font-weight: 600; }
        .detail-progress-row { background: rgba(255,255,255,.1); border-radius: 12px; padding: 14px 16px; display: grid; gap: 8px; }
        .detail-progress-label { color: rgba(240,248,255,.85); font-size: .88rem; font-weight: 700; display: flex; justify-content: space-between; }

        .lessons-section { display: grid; gap: 10px; }
        .lesson-card { background: #fff; border: 1.5px solid var(--line); border-radius: 14px; padding: 14px 18px; display: flex; align-items: center; gap: 14px; cursor: pointer; transition: border-color .2s, background .2s; }
        .lesson-card:hover { border-color: rgba(6,203,229,.4); background: #f9feff; }
        .lesson-card.completed { border-color: rgba(11,127,83,.3); background: #f7fffa; }
        .lesson-num { width: 32px; height: 32px; border-radius: 50%; background: #edfcff; color: #0494ab; display: grid; place-items: center; font-weight: 800; font-size: .85rem; flex-shrink: 0; }
        .lesson-card.completed .lesson-num { background: rgba(11,127,83,.15); color: var(--ok); }
        .lesson-info { flex: 1; }
        .lesson-title { font-size: .93rem; font-weight: 700; color: #1a2a4c; }
        .lesson-dur { font-size: .78rem; color: var(--muted); font-weight: 600; margin-top: 2px; }
        .lesson-check { width: 22px; height: 22px; border-radius: 50%; background: rgba(11,127,83,.15); color: var(--ok); display: grid; place-items: center; font-size: .85rem; flex-shrink: 0; }

        /* Lesson reader modal */
        .modal { position: fixed; inset: 0; background: rgba(6,16,38,.55); display: none; place-items: center; z-index: 50; padding: 16px; backdrop-filter: blur(2px); }
        .modal.show { display: grid; animation: fadeUp .22s ease; }
        .modal-box { width: min(780px,100%); max-height: calc(100vh - 32px); background: #fff; border-radius: 20px; border: 1.5px solid #dce9f6; box-shadow: 0 28px 70px rgba(7,18,40,.22); display: flex; flex-direction: column; overflow: hidden; }
        .modal-head { padding: 18px 22px 14px; border-bottom: 1px solid var(--line); display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; flex-shrink: 0; }
        .modal-head h3 { font-size: 1.05rem; letter-spacing: -0.01em; font-weight: 800; }
        .modal-close { border: 0; background: #f3f8fe; border-radius: 9px; width: 30px; height: 30px; cursor: pointer; color: var(--muted); font-size: 18px; display: grid; place-items: center; flex-shrink: 0; }
        .modal-close:hover { background: #e8f0fb; }
        .modal-body { padding: 20px 24px; overflow-y: auto; flex: 1; }
        .lesson-content { white-space: pre-wrap; word-break: break-word; line-height: 1.8; color: #1a2a4c; font-size: .93rem; }
        .lesson-content code { background: #f0f5fc; padding: 2px 6px; border-radius: 5px; font-family: 'Courier New', monospace; font-size: .85em; }
        .modal-foot { padding: 14px 22px; border-top: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-shrink: 0; background: #fff; }

        @keyframes fadeUp { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }

        /* Responsive */
        @media (max-width: 980px) {
            .layout { grid-template-columns: 1fr; }
            .sidebar { position: static; height: auto; border-right: 0; border-bottom: 1px solid var(--line); }
        }
        @media (max-width: 640px) {
            .content { padding: 14px 14px 30px; }
            .course-grid { grid-template-columns: 1fr; }
            .page-header { flex-direction: column; }
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
            <button type="button" data-goto="/profile">Profil</button>
            <button type="button" data-goto="/manajemen-cv">Manajemen CV</button>
            <button type="button" data-goto="/roadmap-karier">Roadmap Karier</button>
            <button type="button" data-goto="/self-assessment">Self Assessment</button>
            <button type="button" class="active">Pelatihan Skill</button>
            <button type="button" data-goto="/forum">Forum Diskusi</button>
            <button type="button" data-goto="/mentorship">Mentorship</button>
            <button type="button" data-goto="/notifikasi">Notifikasi</button>
            <button type="button" id="logoutBtn">Logout</button>
        </div>
        <div class="profile-mini">
            <div class="avatar-mini" id="miniAvatar">U</div>
            <div>
                <strong id="miniName">Loading…</strong>
                <span id="miniEmail">-</span>
            </div>
        </div>
    </aside>

    {{-- Main --}}
    <main class="content">

        {{-- LIST VIEW --}}
        <div id="listView">
            <div class="page-header">
                <div>
                    <h1>Pelatihan Skill</h1>
                    <p>Tingkatkan kompetensimu dengan kursus terstruktur dari para praktisi industri.</p>
                </div>
            </div>

            {{-- Tabs --}}
            <div class="tabs">
                <button class="tab-btn active" data-tab="catalog" type="button">🔍 Katalog Kursus</button>
                <button class="tab-btn" data-tab="my-courses" type="button">📖 Kursus Saya</button>
            </div>

            {{-- CATALOG TAB --}}
            <div id="catalogTab">
                <div class="card filter-bar">
                    <input id="searchInput" class="input" placeholder="Cari kursus, topik, atau instruktur…">
                    <select id="categoryFilter" class="select">
                        <option value="">Semua Kategori</option>
                    </select>
                    <select id="levelFilter" class="select">
                        <option value="">Semua Level</option>
                        <option value="beginner">Pemula</option>
                        <option value="intermediate">Menengah</option>
                        <option value="advanced">Lanjutan</option>
                    </select>
                    <button id="searchBtn" class="btn btn-brand" type="button">Cari</button>
                </div>

                <div>
                    <p class="section-label" id="catalogLabel">Semua Kursus</p>
                    <div id="courseGrid" class="course-grid"></div>
                </div>
            </div>

            {{-- MY COURSES TAB --}}
            <div id="myCoursesTab" style="display:none;">
                <div>
                    <p class="section-label">Kursus Saya</p>
                    <div id="myCourseGrid" class="course-grid"></div>
                </div>
            </div>
        </div>

        {{-- DETAIL VIEW --}}
        <div id="detailView">
            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
                <button class="btn btn-ghost" type="button" id="backBtn">← Kembali ke Katalog</button>
                <button class="btn btn-brand" type="button" id="enrollBtn" style="display:none;">✅ Daftar Kursus Ini</button>
            </div>

            <div class="detail-hero" id="detailHero">
                <div class="detail-hero-top">
                    <div class="detail-hero-emoji" id="detailEmoji">📚</div>
                    <div>
                        <h2 id="detailTitle">Memuat…</h2>
                        <div class="detail-hero-meta" id="detailMeta"></div>
                    </div>
                </div>
                <div class="detail-progress-row" id="detailProgressRow" style="display:none;">
                    <div class="detail-progress-label">
                        <span>Progress Pembelajaran</span>
                        <span id="progressPct">0%</span>
                    </div>
                    <div class="progress-bar"><div class="progress-fill" id="progressFill" style="width:0%"></div></div>
                    <div style="color:rgba(240,248,255,.65); font-size:.8rem;" id="progressDetail"></div>
                </div>
            </div>

            <div>
                <p class="section-label" id="lessonsHeading">Materi Kursus</p>
                <div id="lessonList" class="lessons-section"></div>
            </div>
        </div>

    </main>
</div>

{{-- Lesson Reader Modal --}}
<div id="lessonModal" class="modal">
    <div class="modal-box">
        <div class="modal-head">
            <div>
                <div style="font-size:.75rem; color:var(--muted); font-weight:700; margin-bottom:4px;" id="modalCourseTitle"></div>
                <h3 id="modalLessonTitle">Materi</h3>
            </div>
            <button class="modal-close" type="button" id="closeModalBtn">✕</button>
        </div>
        <div class="modal-body">
            <div class="lesson-content" id="lessonContent"></div>
        </div>
        <div class="modal-foot">
            <div style="font-size:.82rem; color:var(--muted); font-weight:600;" id="modalDuration"></div>
            <div style="display:flex; gap:8px;">
                <button class="btn btn-ghost btn-sm" type="button" id="prevLessonBtn" disabled>← Sebelumnya</button>
                <button class="btn btn-brand btn-sm" type="button" id="completeLessonBtn">✓ Tandai Selesai</button>
                <button class="btn btn-dark btn-sm" type="button" id="nextLessonBtn" disabled>Berikutnya →</button>
            </div>
        </div>
    </div>
</div>

<script>
const showToast = window.hirifyShowToast;

let token = '{{ session("jwt_token") }}' || localStorage.getItem('hirify_token') || sessionStorage.getItem('hirify_token');
if (token) { localStorage.setItem('hirify_token', token); }
let currentUser = null;
let activeCourse = null;
let activeLessons = [];
let activeLesson  = null;
let activeLessonIdx = 0;
let activeTab = 'catalog';

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
    const headers = { 'Accept':'application/json','Authorization':`Bearer ${token}`, ...(opts.body instanceof FormData ? {} : {'Content-Type':'application/json'}), ...(opts.headers||{}) };
    const res  = await fetch(path, { ...opts, headers });
    let   data = {};
    try { data = await res.json(); } catch {}
    if (res.status===401 && retry) { if (await refreshToken()) return api(path,opts,false); clearAuth(); window.location.href='/login'; throw new Error('Sesi berakhir. Silakan login kembali.'); }
    if (!res.ok || data.success===false) throw new Error(data.message || 'Terjadi kesalahan.');
    return data;
}

function esc(str) { return String(str??'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#39;'); }
function initial(name) { return (String(name||'U').trim()[0]||'U').toUpperCase(); }

/* ── Load me ── */
async function loadMe() {
    const res = await api('/api/auth/me');
    currentUser = res.data;
    if (currentUser.role !== 'jobseeker') {
        showToast('Halaman ini khusus untuk pencari kerja.', 'error');
        setTimeout(() => { window.location.href = '/dashboard'; }, 1000);
        return;
    }
    document.getElementById('miniName').textContent   = currentUser.name  || 'User';
    document.getElementById('miniEmail').textContent  = currentUser.email || '-';
    document.getElementById('miniAvatar').textContent = initial(currentUser.name);
}

/* ── Catalog ── */
async function loadCatalog() {
    document.getElementById('courseGrid').innerHTML = '<div class="loading-row"><span class="spinner"></span></div>';

    const search   = document.getElementById('searchInput').value.trim();
    const category = document.getElementById('categoryFilter').value;
    const level    = document.getElementById('levelFilter').value;
    const params   = new URLSearchParams({ per_page: 24 });
    if (search)   params.set('search', search);
    if (category) params.set('category', category);
    if (level)    params.set('level', level);

    const res  = await api(`/api/skill-training/courses?${params}`);
    const data = res.data;

    const catSel = document.getElementById('categoryFilter');
    if (catSel.options.length <= 1 && data.categories?.length) {
        data.categories.forEach(c => {
            const o = document.createElement('option');
            o.value = c; o.textContent = c;
            catSel.appendChild(o);
        });
    }

    document.getElementById('catalogLabel').textContent =
        `${data.total} Kursus Tersedia${search ? ` untuk "${search}"` : ''}`;

    renderCourseGrid(document.getElementById('courseGrid'), data.items || [], false);
}

/* ── My courses ── */
async function loadMyCourses() {
    document.getElementById('myCourseGrid').innerHTML = '<div class="loading-row"><span class="spinner"></span></div>';
    const res  = await api('/api/skill-training/my-courses');
    renderCourseGrid(document.getElementById('myCourseGrid'), res.data.items || [], true);
}

function renderCourseGrid(container, items, isMy) {
    if (!items.length) {
        container.innerHTML = `<div class="empty-state" style="grid-column:1/-1;"><div class="empty-icon">${isMy?'📖':'🔍'}</div><p>${isMy?'Kamu belum mendaftar ke kursus apapun. Jelajahi katalog dan mulai belajar!':'Tidak ada kursus yang ditemukan.'}</p></div>`;
        return;
    }

    container.innerHTML = items.map(c => {
        const levelCls  = esc(c.level || 'beginner');
        const levelLbl  = esc(c.level_label || 'Pemula');
        const enrolled  = c.is_enrolled ?? true;
        const pct       = c.progress_pct ?? 0;
        const done      = c.course_completed;
        const total     = c.total_lessons ?? c.lessons_count ?? 0;
        const completed = c.completed_count ?? 0;

        return `
        <article class="course-card" data-course-id="${esc(c.course_id||c.id)}">
            <div>${esc(c.thumbnail_emoji)}</div>
            <div style="display:flex;gap:6px;flex-wrap:wrap;align-items:center;">
                <span class="course-category">${esc(c.category)}</span>
                <span class="level-badge ${levelCls}">${levelLbl}</span>
                ${c.is_free===false ? '<span style="font-size:.72rem;font-weight:700;background:#fff3e0;color:#e65100;padding:3px 9px;border-radius:999px;">Berbayar</span>' : '<span style="font-size:.72rem;font-weight:700;background:#e8f5e9;color:#2e7d32;padding:3px 9px;border-radius:999px;">Gratis</span>'}
            </div>
            <div class="course-title">${esc(c.title)}</div>
            <div class="course-desc">${esc(c.description)}</div>
            <div class="course-meta">
                <span class="course-stat">👨‍🏫 ${esc(c.instructor_name)}</span>
                <span class="dot">·</span>
                <span class="course-stat">⏱ ${esc(String(c.estimated_hours))} jam</span>
                <span class="dot">·</span>
                <span class="course-stat">📝 ${esc(String(total))} materi</span>
            </div>
            ${enrolled ? `
            <div class="progress-wrap">
                <div class="progress-bar"><div class="progress-fill" style="width:${pct}%"></div></div>
                <div class="progress-label">${done?'✅ Selesai':''}${!done?`${completed}/${total} materi · ${pct}% selesai`:''}</div>
            </div>` : ''}
            <div class="course-footer">
                ${enrolled ? `<span class="enrolled-badge">✓ Terdaftar</span>` : `<span style="font-size:.82rem;color:var(--muted);font-weight:600;">Belum terdaftar</span>`}
                <button class="btn btn-${enrolled?'ghost':'brand'} btn-sm">${enrolled?'Lanjutkan Belajar →':'Lihat Detail'}</button>
            </div>
        </article>`;
    }).join('');

    container.querySelectorAll('.course-card').forEach(el => {
        el.addEventListener('click', () => openCourseDetail(el.dataset.courseId));
    });
}

/* ── Course detail ── */
async function openCourseDetail(id) {
    if (!id) return;
    showDetail();

    document.getElementById('detailTitle').textContent = 'Memuat…';
    document.getElementById('lessonList').innerHTML = '<div class="loading-row"><span class="spinner"></span></div>';
    document.getElementById('detailProgressRow').style.display = 'none';
    document.getElementById('enrollBtn').style.display = 'none';

    try {
        const res = await api(`/api/skill-training/courses/${id}`);
        activeCourse  = res.data;
        activeLessons = activeCourse.lessons || [];

        document.getElementById('detailEmoji').textContent  = activeCourse.thumbnail_emoji;
        document.getElementById('detailTitle').textContent  = activeCourse.title;
        document.getElementById('detailMeta').innerHTML = `
            <span class="level-badge ${esc(activeCourse.level)}" style="font-size:.75rem;">${esc(activeCourse.level_label)}</span>
            <span>${esc(activeCourse.category)}</span>
            <span class="dot">·</span>
            <span>👨‍🏫 ${esc(activeCourse.instructor_name)}</span>
            <span class="dot">·</span>
            <span>⏱ ${esc(String(activeCourse.estimated_hours))} jam</span>
            <span class="dot">·</span>
            <span>📝 ${esc(String(activeCourse.total_lessons))} materi</span>
        `;

        document.getElementById('lessonsHeading').textContent =
            `Materi Kursus (${activeCourse.total_lessons} pelajaran)`;

        if (activeCourse.is_enrolled) {
            const pct = activeCourse.progress_pct;
            document.getElementById('detailProgressRow').style.display = '';
            document.getElementById('progressPct').textContent  = `${pct}%`;
            document.getElementById('progressFill').style.width = `${pct}%`;
            document.getElementById('progressDetail').textContent =
                activeCourse.course_completed
                    ? '🎉 Kamu telah menyelesaikan seluruh materi kursus ini!'
                    : `${activeCourse.completed_count} dari ${activeCourse.total_lessons} materi selesai`;
        } else {
            document.getElementById('enrollBtn').style.display = '';
        }

        renderLessons();
    } catch (err) {
        showToast(err.message || 'Gagal memuat kursus.', 'error');
        showList();
    }
}

function renderLessons() {
    const container = document.getElementById('lessonList');
    if (!activeLessons.length) {
        container.innerHTML = '<div class="empty-state"><p>Belum ada materi dalam kursus ini.</p></div>';
        return;
    }

    container.innerHTML = activeLessons.map((l, idx) => `
        <div class="lesson-card ${l.is_completed ? 'completed' : ''}" data-lesson-idx="${idx}">
            <div class="lesson-num">${l.is_completed ? '✓' : esc(String(l.order_number))}</div>
            <div class="lesson-info">
                <div class="lesson-title">${esc(l.title)}</div>
                <div class="lesson-dur">⏱ ${esc(String(l.duration_minutes))} menit</div>
            </div>
            ${l.is_completed ? '<div class="lesson-check">✓</div>' : ''}
            ${activeCourse.is_enrolled && !l.is_completed ? '<span style="font-size:.75rem;font-weight:700;color:#0494ab;">Mulai →</span>' : ''}
            ${!activeCourse.is_enrolled ? '<span style="font-size:.75rem;color:var(--muted);font-weight:600;">🔒 Daftar dulu</span>' : ''}
        </div>
    `).join('');

    container.querySelectorAll('.lesson-card').forEach(el => {
        el.addEventListener('click', () => {
            if (!activeCourse.is_enrolled) {
                showToast('Daftar ke kursus ini terlebih dahulu untuk mengakses materi.', 'info');
                return;
            }
            openLessonReader(parseInt(el.dataset.lessonIdx));
        });
    });
}

/* ── Lesson reader ── */
function openLessonReader(idx) {
    activeLessonIdx = idx;
    activeLesson    = activeLessons[idx];
    if (!activeLesson) return;

    document.getElementById('modalCourseTitle').textContent  = activeCourse.title;
    document.getElementById('modalLessonTitle').textContent  = activeLesson.title;
    document.getElementById('modalDuration').textContent     = `⏱ ${activeLesson.duration_minutes} menit`;
    document.getElementById('lessonContent').textContent     = activeLesson.content || '';

    const completeBtn = document.getElementById('completeLessonBtn');
    if (activeLesson.is_completed) {
        completeBtn.textContent  = '✓ Sudah Selesai';
        completeBtn.className    = 'btn btn-success btn-sm';
        completeBtn.disabled     = true;
    } else {
        completeBtn.textContent  = '✓ Tandai Selesai';
        completeBtn.className    = 'btn btn-brand btn-sm';
        completeBtn.disabled     = false;
    }

    document.getElementById('prevLessonBtn').disabled = idx <= 0;
    document.getElementById('nextLessonBtn').disabled = idx >= activeLessons.length - 1;

    document.getElementById('lessonModal').classList.add('show');
    document.getElementById('lessonModal').querySelector('.modal-body').scrollTop = 0;
}

function closeLessonModal() {
    document.getElementById('lessonModal').classList.remove('show');
}

/* ── Actions ── */
async function doEnroll() {
    const btn = document.getElementById('enrollBtn');
    btn.disabled = true;
    try {
        await api(`/api/skill-training/courses/${activeCourse.id}/enroll`, { method: 'POST' });
        showToast('Berhasil mendaftar! Sekarang kamu bisa mengakses semua materi. 🎉', 'success');
        await openCourseDetail(activeCourse.id);
    } catch (err) {
        showToast(err.message || 'Gagal mendaftar.', 'error');
        btn.disabled = false;
    }
}

async function doCompleteLesson() {
    if (!activeCourse || !activeLesson) return;
    const btn = document.getElementById('completeLessonBtn');
    btn.disabled = true;

    try {
        const res = await api(
            `/api/skill-training/courses/${activeCourse.id}/lessons/${activeLesson.id}/complete`,
            { method: 'POST' }
        );
        const data = res.data;

        activeLesson.is_completed = true;
        activeLessons[activeLessonIdx].is_completed = true;

        activeCourse.progress_pct    = data.progress_pct;
        activeCourse.completed_count = data.completed_count;
        activeCourse.course_completed= data.course_completed;

        document.getElementById('progressPct').textContent  = `${data.progress_pct}%`;
        document.getElementById('progressFill').style.width = `${data.progress_pct}%`;
        document.getElementById('progressDetail').textContent =
            data.course_completed
                ? '🎉 Kamu telah menyelesaikan seluruh materi kursus ini!'
                : `${data.completed_count} dari ${activeCourse.total_lessons} materi selesai`;

        btn.textContent = '✓ Sudah Selesai';
        btn.className   = 'btn btn-success btn-sm';

        renderLessons();

        if (data.course_completed) {
            showToast('🎉 Selamat! Kamu telah menyelesaikan seluruh kursus!', 'success', 4000);
        } else {
            showToast('Materi berhasil ditandai selesai!', 'success');
        }

        if (activeLessonIdx < activeLessons.length - 1) {
            setTimeout(() => openLessonReader(activeLessonIdx + 1), 800);
        }
    } catch (err) {
        showToast(err.message || 'Gagal menandai selesai.', 'error');
        btn.disabled = false;
    }
}

/* ── View switching ── */
function showList() {
    document.getElementById('listView').style.display = '';
    document.getElementById('detailView').classList.remove('show');
    activeCourse = null;
}

function showDetail() {
    document.getElementById('listView').style.display = 'none';
    document.getElementById('detailView').classList.add('show');
}

function switchTab(tab) {
    activeTab = tab;
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.toggle('active', b.dataset.tab === tab));
    document.getElementById('catalogTab').style.display   = tab === 'catalog'    ? '' : 'none';
    document.getElementById('myCoursesTab').style.display = tab === 'my-courses' ? '' : 'none';
    if (tab === 'my-courses') loadMyCourses();
}

async function doLogout() {
    try { await api('/api/auth/logout', { method:'POST' }); } catch {}
    showToast('Sampai jumpa! 👋', 'info', 900);
    setTimeout(() => { clearAuth(); window.location.href = '/login'; }, 900);
}

/* ── Events ── */
function bindEvents() {
    document.querySelectorAll('[data-goto]').forEach(btn => {
        btn.addEventListener('click', () => { window.location.href = btn.dataset.goto; });
    });

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => switchTab(btn.dataset.tab));
    });

    document.getElementById('searchBtn').addEventListener('click', loadCatalog);
    document.getElementById('searchInput').addEventListener('keydown', e => { if (e.key==='Enter') loadCatalog(); });
    document.getElementById('categoryFilter').addEventListener('change', loadCatalog);
    document.getElementById('levelFilter').addEventListener('change', loadCatalog);

    document.getElementById('backBtn').addEventListener('click', () => {
        showList();
        if (activeTab === 'my-courses') loadMyCourses(); else loadCatalog();
    });

    document.getElementById('enrollBtn').addEventListener('click', doEnroll);
    document.getElementById('logoutBtn').addEventListener('click', doLogout);

    document.getElementById('closeModalBtn').addEventListener('click', closeLessonModal);
    document.getElementById('lessonModal').addEventListener('click', e => {
        if (e.target === document.getElementById('lessonModal')) closeLessonModal();
    });

    document.getElementById('completeLessonBtn').addEventListener('click', doCompleteLesson);

    document.getElementById('prevLessonBtn').addEventListener('click', () => {
        if (activeLessonIdx > 0) openLessonReader(activeLessonIdx - 1);
    });

    document.getElementById('nextLessonBtn').addEventListener('click', () => {
        if (activeLessonIdx < activeLessons.length - 1) openLessonReader(activeLessonIdx + 1);
    });
}

/* ── Boot ── */
async function boot() {
    try {
        await loadMe();
        bindEvents();
        await loadCatalog();
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
