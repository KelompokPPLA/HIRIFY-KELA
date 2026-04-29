<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hirify | Forum Diskusi</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap');

        :root {
            --bg: #f4f8fd;
            --card: #ffffff;
            --ink: #0d1b3d;
            --muted: #6c7a93;
            --line: #e5edf6;
            --brand: #06cbe5;
            --brand-dark: #06b0c6;
            --deep: #08152f;
            --ok: #0b7f53;
            --danger: #b42318;
            --shadow: 0 20px 45px rgba(9,20,51,.08);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 5% 15%, rgba(6,203,229,.16), transparent 24%),
                radial-gradient(circle at 95% 5%,  rgba(6,203,229,.12), transparent 20%),
                var(--bg);
            min-height: 100vh;
        }

        /* ── Layout ── */
        .layout {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }

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

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 28px;
            letter-spacing: -0.02em;
            text-decoration: none;
            color: var(--ink);
        }

        .brand-mark {
            width: 34px; height: 34px;
            border-radius: 12px;
            background: linear-gradient(145deg, #0399b7, #06d8ee);
            display: grid; place-items: center;
            color: #fff; font-size: 17px; font-weight: 800;
            flex-shrink: 0;
        }

        .menu { display: grid; gap: 4px; }

        .menu-item {
            border: 0;
            background: transparent;
            color: #1a2a4c;
            font: inherit;
            font-size: .93rem;
            text-align: left;
            border-radius: 12px;
            padding: 11px 13px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: background .15s;
            width: 100%;
        }

        .menu-item:hover { background: #f2f8ff; }

        .menu-item.active {
            background: linear-gradient(145deg, #0a1632, #111f45);
            color: #f2fbff;
            box-shadow: 0 8px 20px rgba(11,24,54,.2);
        }

        .menu-item .icon { font-size: 1rem; width: 18px; text-align: center; }

        .profile-mini {
            margin-top: auto;
            background: #f8fbff;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar-mini {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: linear-gradient(140deg, #0499b3, #05d5ef);
            color: #fff;
            display: grid; place-items: center;
            font-weight: 800; font-size: .9rem;
            flex-shrink: 0;
        }

        .profile-mini-info strong { display: block; font-size: .88rem; }
        .profile-mini-info span   { color: var(--muted); font-size: .78rem; }

        /* ── Main content ── */
        .content { padding: 28px 28px 40px; display: flex; flex-direction: column; gap: 20px; }

        /* ── Page header ── */
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; }
        .page-header h1 { font-size: clamp(26px,3.5vw,38px); letter-spacing: -0.03em; }
        .page-header p  { color: var(--muted); font-weight: 500; margin-top: 5px; font-size: .95rem; }

        /* ── Buttons ── */
        .btn {
            border: 0; border-radius: 12px;
            padding: 11px 16px;
            font: inherit; font-size: .9rem; font-weight: 700;
            cursor: pointer;
            transition: transform .15s, box-shadow .15s, opacity .15s;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn:hover:not(:disabled) { transform: translateY(-1px); }
        .btn:disabled { opacity: .45; cursor: not-allowed; }

        .btn-brand  { background: linear-gradient(140deg,#08cde6,#00b2cb); color: #fff; }
        .btn-ghost  { background: #f3f8fe; color: #17315f; border: 1px solid #dbe8f6; }
        .btn-danger { background: rgba(180,35,24,.07); color: var(--danger); border: 1px solid rgba(180,35,24,.22); }
        .btn-dark   { background: #07193d; color: #fff; }
        .btn-sm     { padding: 7px 12px; font-size: .82rem; border-radius: 9px; }

        /* ── Cards ── */
        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: var(--shadow);
        }

        /* ── Inputs ── */
        .input, .textarea {
            width: 100%;
            border-radius: 12px;
            border: 1.5px solid #d5e3f1;
            background: #fff;
            padding: 11px 14px;
            font: inherit; font-size: .93rem;
            color: var(--ink);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .input:focus, .textarea:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(6,203,229,.14);
        }
        .textarea { resize: vertical; min-height: 100px; }

        /* ── Search ── */
        .search-wrap {
            padding: 14px 16px;
            display: flex; gap: 10px; align-items: center;
        }
        .search-wrap .input { flex: 1; }

        /* ── Thread list ── */
        .list-header {
            display: flex; align-items: center;
            justify-content: space-between; gap: 12px;
            margin-bottom: 12px;
        }
        .list-header h2 { font-size: 1.5rem; letter-spacing: -0.02em; }

        .thread-list { display: flex; flex-direction: column; gap: 10px; }

        .thread-card {
            background: #fff;
            border: 1.5px solid var(--line);
            border-radius: 16px;
            padding: 16px 20px;
            cursor: pointer;
            transition: border-color .2s, box-shadow .2s, transform .15s;
            display: grid; gap: 7px;
        }
        .thread-card:hover {
            border-color: rgba(6,203,229,.5);
            box-shadow: 0 6px 22px rgba(6,180,210,.1);
            transform: translateY(-1px);
        }

        .thread-card-title {
            font-size: 1rem; font-weight: 800;
            color: #0d1b3d; letter-spacing: -0.01em;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .thread-card-preview {
            color: #516080; font-size: .88rem; line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .thread-card-meta {
            display: flex; align-items: center; flex-wrap: wrap; gap: 8px;
            font-size: .8rem; color: var(--muted); font-weight: 600;
        }

        .role-pill {
            display: inline-flex;
            padding: 2px 9px; border-radius: 999px;
            font-size: .72rem; font-weight: 700;
        }
        .role-pill.jobseeker { background: #edfcff; color: #0494ab; }
        .role-pill.mentor    { background: #f0edff; color: #6c47c9; }
        .role-pill.admin     { background: #fff5ed; color: #c97b10; }

        .dot { color: #c5d4e3; }

        /* ── Pagination ── */
        .pagination { display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 6px; }

        /* ── Empty state ── */
        .empty-state {
            text-align: center; padding: 36px 20px;
            color: var(--muted); border: 1.5px dashed #cfdded;
            border-radius: 16px; background: #fff;
        }
        .empty-state .empty-icon { font-size: 2.5rem; margin-bottom: 10px; }
        .empty-state p { font-weight: 600; }

        /* ── Detail view ── */
        #detailView { display: none; flex-direction: column; gap: 18px; }
        #detailView.show { display: flex; }

        .detail-topbar { display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap; }

        .detail-hero {
            background: linear-gradient(145deg, #0a1530, #0f2147);
            color: #f0f8ff;
            border-radius: 18px;
            padding: 24px 26px;
            display: grid; gap: 10px;
        }
        .detail-hero h2 {
            font-size: clamp(1.1rem, 2.5vw, 1.55rem);
            letter-spacing: -0.02em; font-weight: 800;
        }
        .detail-hero-meta {
            display: flex; flex-wrap: wrap; gap: 10px;
            color: rgba(240,248,255,.65); font-size: .83rem; font-weight: 600;
            align-items: center;
        }

        .detail-body-card {
            background: #fff;
            border: 1.5px solid var(--line);
            border-radius: 16px;
            padding: 20px 24px;
            color: #1a2a4c;
            line-height: 1.75;
            white-space: pre-wrap;
            word-break: break-word;
            font-size: .95rem;
        }

        /* ── Comments ── */
        .comments-header { font-size: 1.2rem; font-weight: 800; letter-spacing: -0.02em; }

        .comment-list { display: flex; flex-direction: column; gap: 10px; }

        .comment-card {
            background: #f8fbff;
            border: 1.5px solid #dbeef8;
            border-radius: 14px;
            padding: 14px 16px;
            display: grid; gap: 7px;
        }

        .comment-header {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 8px;
        }

        .comment-author-wrap { display: flex; align-items: center; gap: 8px; }

        .comment-avatar {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: linear-gradient(140deg, #0499b3, #05d5ef);
            color: #fff;
            display: grid; place-items: center;
            font-weight: 800; font-size: .75rem;
            flex-shrink: 0;
        }

        .comment-author-name { font-size: .88rem; font-weight: 700; color: #1a2a4c; }
        .comment-time        { font-size: .76rem; color: var(--muted); font-weight: 600; }

        .comment-body {
            color: #334d70; line-height: 1.6; font-size: .9rem;
            white-space: pre-wrap; word-break: break-word;
        }

        /* ── Add comment ── */
        .add-comment-card { padding: 18px 20px; display: grid; gap: 12px; }
        .add-comment-card h3 { font-size: .95rem; font-weight: 800; color: #172c52; }

        /* ── Modal ── */
        .modal {
            position: fixed; inset: 0;
            background: rgba(6,16,38,.55);
            display: none; place-items: center;
            z-index: 50; padding: 20px;
            backdrop-filter: blur(2px);
        }
        .modal.show { display: grid; animation: fadeUp .22s ease; }

        .modal-box {
            width: min(540px, 100%);
            background: #fff;
            border-radius: 20px;
            border: 1.5px solid #dce9f6;
            box-shadow: 0 28px 70px rgba(7,18,40,.24);
            padding: 26px 28px;
            display: grid; gap: 18px;
        }

        .modal-head {
            display: flex; align-items: center;
            justify-content: space-between; gap: 10px;
        }
        .modal-head h3 { font-size: 1.15rem; letter-spacing: -0.02em; }

        .modal-close {
            border: 0; background: #f3f8fe; border-radius: 9px;
            width: 30px; height: 30px; cursor: pointer;
            color: var(--muted); font-size: 18px; font-weight: 700;
            display: grid; place-items: center;
            transition: background .15s;
        }
        .modal-close:hover { background: #e8f0fb; }

        .form-grid { display: grid; gap: 12px; }

        .field-label {
            display: block; font-weight: 700;
            margin-bottom: 6px; font-size: .88rem; color: #172c52;
        }

        .modal-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }

        /* ── Character counter ── */
        .char-counter {
            font-size: .75rem;
            color: var(--muted);
            text-align: right;
            margin-top: 4px;
            font-weight: 600;
        }
        .char-counter.warn  { color: #c97b10; }
        .char-counter.limit { color: var(--danger); }

        /* ── Animations ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Loading spinner ── */
        .spinner {
            display: inline-block;
            width: 18px; height: 18px;
            border: 2.5px solid rgba(6,203,229,.25);
            border-top-color: var(--brand);
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        .loading-row { display: flex; justify-content: center; padding: 30px; }

        /* ── Responsive ── */
        @media (max-width: 980px) {
            .layout { grid-template-columns: 1fr; }
            .sidebar { position: static; height: auto; border-right: 0; border-bottom: 1px solid var(--line); }
        }
        @media (max-width: 640px) {
            .content { padding: 14px 14px 30px; }
            .page-header { flex-direction: column; }
            .modal-actions { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
@include('components.auth.toast')

<div class="layout">

    {{-- ── Sidebar ── --}}
    <aside class="sidebar">
        <div class="brand">
            <span class="brand-mark">H</span>
            <span>Hirify!</span>
        </div>

        <nav class="menu">
            <button class="menu-item" type="button" data-goto="/dashboard">
                <span class="icon">🏠</span> Dashboard
            </button>
            <button class="menu-item" type="button" id="menuMentorship" style="display:none;" data-goto="/mentorship">
                <span class="icon">🎓</span> Mentorship
            </button>
            <button class="menu-item active" type="button">
                <span class="icon">💬</span> Forum Diskusi
            </button>
            <button class="menu-item" type="button" id="logoutBtn">
                <span class="icon">🚪</span> Logout
            </button>
        </nav>

        <div class="profile-mini">
            <div class="avatar-mini" id="miniAvatar">U</div>
            <div class="profile-mini-info">
                <strong id="miniName">Loading…</strong>
                <span id="miniEmail">-</span>
            </div>
        </div>
    </aside>

    {{-- ── Main ── --}}
    <main class="content">

        {{-- ── LIST VIEW ── --}}
        <div id="listView">

            <div class="page-header">
                <div>
                    <h1>Forum Diskusi</h1>
                    <p>Bertukar pikiran, berbagi pengalaman, dan belajar bersama komunitas Hirify.</p>
                </div>
                <button class="btn btn-brand" type="button" id="openNewThreadBtn">
                    ✏️ Buat Thread
                </button>
            </div>

            {{-- Search --}}
            <div class="card search-wrap">
                <input id="searchInput" class="input" placeholder="Cari topik diskusi...">
                <button id="searchBtn" class="btn btn-brand" type="button">Cari</button>
            </div>

            {{-- Thread list --}}
            <div>
                <div class="list-header">
                    <h2>Semua Thread</h2>
                    <div style="display:flex; gap:8px; align-items:center;">
                        <select id="sortSelect" class="input" style="width:auto; padding:7px 14px; font-size:.82rem; border-radius:9px; font-weight:600;">
                            <option value="latest">Terbaru</option>
                            <option value="popular">Terpopuler</option>
                            <option value="active">Paling Aktif</option>
                        </select>
                        <button class="btn btn-ghost btn-sm" type="button" id="refreshBtn">↺ Refresh</button>
                    </div>
                </div>
                <div id="threadList" class="thread-list"></div>
                <div id="pagination" class="pagination" style="margin-top:14px;"></div>
            </div>

        </div>

        {{-- ── DETAIL VIEW ── --}}
        <div id="detailView">

            <div class="detail-topbar">
                <button class="btn btn-ghost" type="button" id="backBtn">← Kembali ke Forum</button>
                <div style="display:flex; gap:8px;">
                    <button class="btn btn-ghost btn-sm" type="button" id="editThreadBtn" style="display:none;">
                        ✏️ Edit Thread
                    </button>
                    <button class="btn btn-danger btn-sm" type="button" id="deleteThreadBtn" style="display:none;">
                        🗑 Hapus Thread
                    </button>
                </div>
            </div>

            <div class="detail-hero" id="detailHero">
                <h2 id="detailTitle">Memuat…</h2>
                <div class="detail-hero-meta" id="detailMeta"></div>
            </div>

            <div class="detail-body-card" id="detailBody"></div>

            {{-- Comments --}}
            <div>
                <p class="comments-header" id="commentsHeading">Komentar</p>
                <div style="margin-top:10px;">
                    <div id="commentList" class="comment-list"></div>
                </div>
            </div>

            {{-- Add comment --}}
            <div class="card add-comment-card">
                <h3>💬 Tambahkan Komentar</h3>
                <div class="form-grid">
                    <textarea id="commentBody" class="textarea" style="min-height:90px;"
                        placeholder="Tulis komentar Anda…" maxlength="5000"></textarea>
                    <div class="char-counter" id="commentBodyCounter">0 / 5000</div>
                    <div style="display:flex; justify-content:flex-end;">
                        <button class="btn btn-brand" type="button" id="submitCommentBtn">Kirim Komentar</button>
                    </div>
                </div>
            </div>

        </div>

    </main>
</div>

{{-- ── Modal: New Thread ── --}}
<div id="newThreadModal" class="modal">
    <div class="modal-box">
        <div class="modal-head">
            <h3>✏️ Buat Thread Baru</h3>
            <button class="modal-close" type="button" id="closeModalBtn">✕</button>
        </div>
        <div class="form-grid">
            <div>
                <label class="field-label" for="threadTitle">Judul Thread</label>
                <input id="threadTitle" class="input" placeholder="Tuliskan judul yang jelas dan menarik…" maxlength="255">
            </div>
            <div>
                <label class="field-label" for="threadBody">Isi Diskusi</label>
                <textarea id="threadBody" class="textarea" style="min-height:150px;"
                    placeholder="Jelaskan topik yang ingin kamu diskusikan dengan komunitas…" maxlength="10000"></textarea>
                <div class="char-counter" id="threadBodyCounter">0 / 10000</div>
            </div>
        </div>
        <div class="modal-actions">
            <button class="btn btn-ghost" type="button" id="cancelModalBtn">Batal</button>
            <button class="btn btn-dark" type="button" id="submitThreadBtn">🚀 Publikasikan</button>
        </div>
    </div>
</div>

{{-- ── Modal: Edit Thread ── --}}
<div id="editThreadModal" class="modal">
    <div class="modal-box">
        <div class="modal-head">
            <h3>✏️ Edit Thread</h3>
            <button class="modal-close" type="button" id="closeEditThreadModalBtn">✕</button>
        </div>
        <div class="form-grid">
            <div>
                <label class="field-label" for="editThreadTitle">Judul Thread</label>
                <input id="editThreadTitle" class="input" placeholder="Tuliskan judul yang jelas dan menarik…" maxlength="255">
            </div>
            <div>
                <label class="field-label" for="editThreadBody">Isi Diskusi</label>
                <textarea id="editThreadBody" class="textarea" style="min-height:150px;"
                    placeholder="Jelaskan topik yang ingin kamu diskusikan…" maxlength="10000"></textarea>
                <div class="char-counter" id="editThreadBodyCounter">0 / 10000</div>
            </div>
        </div>
        <div class="modal-actions">
            <button class="btn btn-ghost" type="button" id="cancelEditThreadModalBtn">Batal</button>
            <button class="btn btn-dark" type="button" id="submitEditThreadBtn">💾 Simpan Perubahan</button>
        </div>
    </div>
</div>

<script>
const showToast = window.hirifyShowToast;

/* ── State ── */
let token       = localStorage.getItem('hirify_token') || sessionStorage.getItem('hirify_token');
let currentUser = null;
let activeThreadId = null;
let activeThread   = null;
let page        = 1;
let lastPage    = 1;
let searchQuery = '';
let sortBy      = 'latest';

if (!token) { window.location.href = '/login'; }

/* ── Storage helpers ── */
function activeStorage() {
    return localStorage.getItem('hirify_token') ? localStorage : sessionStorage;
}

function clearAuth() {
    ['hirify_token','hirify_user','hirify_remember'].forEach(k => {
        localStorage.removeItem(k);
        sessionStorage.removeItem(k);
    });
}

/* ── API helper with auto-refresh ── */
async function refreshToken() {
    try {
        const res  = await fetch('/api/auth/refresh', {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` },
        });
        const data = await res.json();
        if (!res.ok || !data?.data?.token) return false;
        token = data.data.token;
        activeStorage().setItem('hirify_token', token);
        return true;
    } catch { return false; }
}

async function api(path, opts = {}, retry = true) {
    const headers = {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`,
        ...(opts.body instanceof FormData ? {} : { 'Content-Type': 'application/json' }),
        ...(opts.headers || {}),
    };
    const res  = await fetch(path, { ...opts, headers });
    let   data = {};
    try { data = await res.json(); } catch {}

    if (res.status === 401 && retry) {
        if (await refreshToken()) return api(path, opts, false);
        clearAuth(); window.location.href = '/login'; return;
    }
    if (!res.ok || data.success === false) throw new Error(data.message || 'Terjadi kesalahan.');
    return data;
}

/* ── Utility ── */
function esc(str) {
    return String(str ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;')
        .replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#39;');
}
function initial(name) { return (String(name || 'U').trim()[0] || 'U').toUpperCase(); }

function rolePill(role) {
    const labels = { jobseeker: 'Pencari Kerja', mentor: 'Mentor', admin: 'Admin' };
    const cls    = ['jobseeker','mentor','admin'].includes(role) ? role : 'jobseeker';
    return `<span class="role-pill ${cls}">${esc(labels[role] ?? role)}</span>`;
}

/* ── View switching ── */
function showList() {
    document.getElementById('listView').style.display = '';
    document.getElementById('detailView').classList.remove('show');
    activeThreadId = null;
}

function showDetail() {
    document.getElementById('listView').style.display = 'none';
    document.getElementById('detailView').classList.add('show');
}

/* ── Load current user ── */
async function loadMe() {
    const res  = await api('/api/auth/me');
    currentUser = res.data;
    document.getElementById('miniName').textContent   = currentUser.name  || 'User';
    document.getElementById('miniEmail').textContent  = currentUser.email || '-';
    document.getElementById('miniAvatar').textContent = initial(currentUser.name);

    if (currentUser.role === 'jobseeker') {
        document.getElementById('menuMentorship').style.display = '';
    }
}

/* ── Thread list ── */
async function loadThreads(p = 1) {
    page = p;
    const threadList = document.getElementById('threadList');
    threadList.innerHTML = '<div class="loading-row"><span class="spinner"></span></div>';

    const params = new URLSearchParams({ per_page: 12, page, sort: sortBy });
    if (searchQuery.trim()) params.set('search', searchQuery.trim());

    const res  = await api(`/api/forum/threads?${params}`);
    const data = res.data;
    lastPage   = data.last_page || 1;

    renderThreadList(data.items || []);
    renderPagination(data.total || 0);
}

function renderThreadList(items) {
    const container = document.getElementById('threadList');
    if (!items.length) {
        container.innerHTML = `
            <div class="empty-state">
                <div class="empty-icon">💬</div>
                <p>Belum ada thread diskusi.<br>Jadilah yang pertama memulai diskusi!</p>
            </div>`;
        return;
    }

    container.innerHTML = items.map(t => `
        <article class="thread-card" data-id="${esc(t.id)}">
            <div class="thread-card-title">${esc(t.title)}</div>
            <div class="thread-card-preview">${esc(t.body_preview)}</div>
            <div class="thread-card-meta">
                ${rolePill(t.author_role)}
                <span>${esc(t.author)}</span>
                <span class="dot">·</span>
                <span>${esc(t.created_at)}</span>
                <span class="dot">·</span>
                <span>💬 ${esc(String(t.comments_count))}</span>
                <span class="dot">·</span>
                <span>👁 ${esc(String(t.views_count))}</span>
            </div>
        </article>
    `).join('');

    container.querySelectorAll('.thread-card').forEach(el => {
        el.addEventListener('click', () => openThread(el.dataset.id));
    });
}

function renderPagination(total) {
    const wrap = document.getElementById('pagination');
    if (lastPage <= 1) { wrap.innerHTML = ''; return; }
    wrap.innerHTML = `
        <button class="btn btn-ghost btn-sm" ${page <= 1 ? 'disabled' : ''} data-p="${page - 1}">‹ Prev</button>
        <span style="font-size:.85rem;font-weight:600;color:var(--muted);">
            Halaman ${page} / ${lastPage} &nbsp;·&nbsp; ${total} thread
        </span>
        <button class="btn btn-ghost btn-sm" ${page >= lastPage ? 'disabled' : ''} data-p="${page + 1}">Next ›</button>
    `;
    wrap.querySelectorAll('[data-p]').forEach(btn => {
        btn.addEventListener('click', () => loadThreads(Number(btn.dataset.p)));
    });
}

/* ── Thread detail ── */
async function openThread(id) {
    if (!id) return;
    activeThreadId = id;
    showDetail();

    document.getElementById('detailTitle').textContent = 'Memuat…';
    document.getElementById('detailBody').textContent  = '';
    document.getElementById('detailMeta').innerHTML    = '';
    document.getElementById('commentList').innerHTML   = '<div class="loading-row"><span class="spinner"></span></div>';
    document.getElementById('deleteThreadBtn').style.display = 'none';
    document.getElementById('editThreadBtn').style.display   = 'none';
    document.getElementById('commentBody').value = '';

    try {
        const res    = await api(`/api/forum/threads/${id}`);
        const thread = res.data;
        activeThread = thread;

        document.getElementById('detailTitle').textContent = thread.title;
        document.getElementById('detailBody').textContent  = thread.body;
        document.getElementById('detailMeta').innerHTML    =
            `${rolePill(thread.author_role)}
             <span>${esc(thread.author)}</span>
             <span class="dot">·</span>
             <span>${esc(thread.created_at)}</span>
             <span class="dot">·</span>
             <span>👁 ${esc(String(thread.views_count))} views</span>`;

        if (currentUser && currentUser.id === thread.user_id) {
            document.getElementById('editThreadBtn').style.display   = '';
        }
        if (currentUser && (currentUser.id === thread.user_id || currentUser.role === 'admin')) {
            document.getElementById('deleteThreadBtn').style.display = '';
        }

        renderComments(thread.comments || []);
    } catch (err) {
        showToast(err.message || 'Gagal memuat thread.', 'error');
        showList();
    }
}

function renderComments(comments) {
    const heading   = document.getElementById('commentsHeading');
    const container = document.getElementById('commentList');
    heading.textContent = `Komentar (${comments.length})`;

    if (!comments.length) {
        container.innerHTML = `
            <div class="empty-state" style="padding:20px;">
                <p>Belum ada komentar. Jadilah yang pertama berkomentar!</p>
            </div>`;
        return;
    }

    container.innerHTML = comments.map(c => {
        const canEdit = currentUser && currentUser.id === c.user_id;
        const canDel  = currentUser && (currentUser.id === c.user_id || currentUser.role === 'admin');
        return `
            <div class="comment-card" data-comment-id="${esc(c.id)}">
                <div class="comment-header">
                    <div class="comment-author-wrap">
                        <div class="comment-avatar">${esc(initial(c.author))}</div>
                        <div>
                            <div class="comment-author-name">${esc(c.author)} ${rolePill(c.author_role)}</div>
                            <div class="comment-time">${esc(c.created_at)}</div>
                        </div>
                    </div>
                    <div style="display:flex; gap:6px;">
                        ${canEdit ? `<button class="btn btn-ghost btn-sm" data-edit-comment="${esc(c.id)}">Edit</button>` : ''}
                        ${canDel  ? `<button class="btn btn-danger btn-sm" data-del-comment="${esc(c.id)}">Hapus</button>` : ''}
                    </div>
                </div>
                <div class="comment-body" data-body-for="${esc(c.id)}">${esc(c.body)}</div>
            </div>`;
    }).join('');

    container.querySelectorAll('[data-del-comment]').forEach(btn => {
        btn.addEventListener('click', () => deleteComment(btn.dataset.delComment));
    });

    container.querySelectorAll('[data-edit-comment]').forEach(btn => {
        btn.addEventListener('click', () => startEditComment(btn.dataset.editComment));
    });
}

/* ── Actions ── */
async function createThread() {
    const title = document.getElementById('threadTitle').value.trim();
    const body  = document.getElementById('threadBody').value.trim();
    if (!title) { showToast('Judul thread wajib diisi.', 'error'); return; }
    if (!body)  { showToast('Isi diskusi wajib diisi.',  'error'); return; }

    const btn = document.getElementById('submitThreadBtn');
    btn.disabled = true;
    try {
        await api('/api/forum/threads', { method: 'POST', body: JSON.stringify({ title, body }) });
        showToast('Thread berhasil dipublikasikan! 🎉', 'success');
        document.getElementById('threadTitle').value = '';
        document.getElementById('threadBody').value  = '';
        closeModal();
        await loadThreads(1);
    } catch (err) {
        showToast(err.message || 'Gagal membuat thread.', 'error');
    } finally {
        btn.disabled = false;
    }
}

async function postComment() {
    if (!activeThreadId) return;
    const body = document.getElementById('commentBody').value.trim();
    if (!body) { showToast('Komentar tidak boleh kosong.', 'error'); return; }

    const btn = document.getElementById('submitCommentBtn');
    btn.disabled = true;
    try {
        const res = await api(`/api/forum/threads/${activeThreadId}/comments`, {
            method: 'POST',
            body: JSON.stringify({ body }),
        });
        document.getElementById('commentBody').value = '';
        showToast('Komentar berhasil ditambahkan.', 'success');

        const c         = res.data;
        const canDel    = true;
        const container = document.getElementById('commentList');
        const emptyEl   = container.querySelector('.empty-state');
        if (emptyEl) emptyEl.remove();

        const div = document.createElement('div');
        div.className = 'comment-card';
        div.innerHTML = `
            <div class="comment-header">
                <div class="comment-author-wrap">
                    <div class="comment-avatar">${esc(initial(c.author))}</div>
                    <div>
                        <div class="comment-author-name">${esc(c.author)} ${rolePill(c.author_role)}</div>
                        <div class="comment-time">${esc(c.created_at)}</div>
                    </div>
                </div>
                ${canDel ? `<button class="btn btn-danger btn-sm" data-del-comment="${esc(c.id)}">Hapus</button>` : ''}
            </div>
            <div class="comment-body">${esc(c.body)}</div>`;

        div.querySelector('[data-del-comment]')?.addEventListener('click', () => deleteComment(c.id));
        container.appendChild(div);

        const h = document.getElementById('commentsHeading');
        const n = (parseInt(h.textContent.match(/\d+/)?.[0] || '0')) + 1;
        h.textContent = `Komentar (${n})`;
    } catch (err) {
        showToast(err.message || 'Gagal mengirim komentar.', 'error');
    } finally {
        btn.disabled = false;
    }
}

function openEditThreadModal() {
    if (!activeThread) return;
    document.getElementById('editThreadTitle').value = activeThread.title;
    document.getElementById('editThreadBody').value  = activeThread.body;
    document.getElementById('editThreadModal').classList.add('show');
}

function closeEditThreadModal() {
    document.getElementById('editThreadModal').classList.remove('show');
}

async function submitEditThread() {
    const title = document.getElementById('editThreadTitle').value.trim();
    const body  = document.getElementById('editThreadBody').value.trim();
    if (!title) { showToast('Judul thread wajib diisi.', 'error'); return; }
    if (!body)  { showToast('Isi diskusi wajib diisi.', 'error'); return; }

    const btn = document.getElementById('submitEditThreadBtn');
    btn.disabled = true;
    try {
        await api(`/api/forum/threads/${activeThreadId}`, { method: 'PUT', body: JSON.stringify({ title, body }) });
        showToast('Thread berhasil diperbarui.', 'success');
        closeEditThreadModal();
        await openThread(activeThreadId);
    } catch (err) {
        showToast(err.message || 'Gagal memperbarui thread.', 'error');
    } finally {
        btn.disabled = false;
    }
}

async function deleteThread() {
    if (!activeThreadId || !confirm('Hapus thread ini secara permanen?')) return;
    try {
        await api(`/api/forum/threads/${activeThreadId}`, { method: 'DELETE' });
        showToast('Thread berhasil dihapus.', 'success');
        showList();
        await loadThreads(1);
    } catch (err) {
        showToast(err.message || 'Gagal menghapus thread.', 'error');
    }
}

async function deleteComment(commentId) {
    if (!activeThreadId || !commentId) return;
    try {
        await api(`/api/forum/threads/${activeThreadId}/comments/${commentId}`, { method: 'DELETE' });
        showToast('Komentar dihapus.', 'success');
        await openThread(activeThreadId);
    } catch (err) {
        showToast(err.message || 'Gagal menghapus komentar.', 'error');
    }
}

function startEditComment(commentId) {
    const bodyEl = document.querySelector(`[data-body-for="${commentId}"]`);
    if (!bodyEl || bodyEl.dataset.editing === 'true') return;
    const original = bodyEl.textContent;
    bodyEl.dataset.editing = 'true';
    bodyEl.innerHTML = `
        <textarea class="textarea" style="min-height:70px; margin-bottom:8px;">${esc(original)}</textarea>
        <div style="display:flex; gap:6px; justify-content:flex-end;">
            <button class="btn btn-ghost btn-sm" data-cancel-edit="${commentId}">Batal</button>
            <button class="btn btn-brand btn-sm" data-save-edit="${commentId}">Simpan</button>
        </div>`;

    bodyEl.querySelector(`[data-cancel-edit]`).addEventListener('click', () => {
        bodyEl.dataset.editing = '';
        bodyEl.textContent = original;
    });
    bodyEl.querySelector(`[data-save-edit]`).addEventListener('click', () => submitEditComment(commentId, bodyEl));
}

async function submitEditComment(commentId, bodyEl) {
    const newBody = bodyEl.querySelector('textarea')?.value?.trim();
    if (!newBody) { showToast('Komentar tidak boleh kosong.', 'error'); return; }
    const saveBtn = bodyEl.querySelector(`[data-save-edit]`);
    if (saveBtn) saveBtn.disabled = true;
    try {
        await api(`/api/forum/threads/${activeThreadId}/comments/${commentId}`, {
            method: 'PUT',
            body: JSON.stringify({ body: newBody }),
        });
        showToast('Komentar berhasil diperbarui.', 'success');
        bodyEl.dataset.editing = '';
        bodyEl.textContent = newBody;
    } catch (err) {
        showToast(err.message || 'Gagal memperbarui komentar.', 'error');
        if (saveBtn) saveBtn.disabled = false;
    }
}

async function doLogout() {
    try { await api('/api/auth/logout', { method: 'POST' }); } catch {}
    showToast('Sampai jumpa! 👋', 'info', 900);
    setTimeout(() => { clearAuth(); window.location.href = '/login'; }, 900);
}

/* ── Modal helpers ── */
function openModal() { document.getElementById('newThreadModal').classList.add('show'); }
function closeModal() { document.getElementById('newThreadModal').classList.remove('show'); }

/* ── Event bindings ── */
function bindEvents() {
    function attachCounter(textareaId, counterId, max) {
        const ta  = document.getElementById(textareaId);
        const ctr = document.getElementById(counterId);
        if (!ta || !ctr) return;
        ta.addEventListener('input', () => {
            const len = ta.value.length;
            ctr.textContent = `${len} / ${max}`;
            ctr.className = 'char-counter' + (len >= max ? ' limit' : len >= max * 0.85 ? ' warn' : '');
        });
    }
    attachCounter('threadBody', 'threadBodyCounter', 10000);
    attachCounter('editThreadBody', 'editThreadBodyCounter', 10000);
    attachCounter('commentBody', 'commentBodyCounter', 5000);

    document.getElementById('openNewThreadBtn').addEventListener('click', openModal);
    document.getElementById('closeModalBtn').addEventListener('click', closeModal);
    document.getElementById('cancelModalBtn').addEventListener('click', closeModal);
    document.getElementById('newThreadModal').addEventListener('click', e => {
        if (e.target === document.getElementById('newThreadModal')) closeModal();
    });
    document.getElementById('submitThreadBtn').addEventListener('click', createThread);

    document.getElementById('threadBody').addEventListener('keydown', e => {
        if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) createThread();
    });
    document.getElementById('editThreadBody').addEventListener('keydown', e => {
        if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) submitEditThread();
    });
    document.getElementById('commentBody').addEventListener('keydown', e => {
        if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) postComment();
    });

    document.getElementById('searchBtn').addEventListener('click', () => {
        searchQuery = document.getElementById('searchInput').value;
        loadThreads(1);
    });
    document.getElementById('searchInput').addEventListener('keydown', e => {
        if (e.key === 'Enter') {
            searchQuery = e.target.value;
            loadThreads(1);
        }
    });

    document.getElementById('sortSelect').addEventListener('change', e => {
        sortBy = e.target.value;
        loadThreads(1);
    });
    document.getElementById('refreshBtn').addEventListener('click', () => loadThreads(page));
    document.getElementById('backBtn').addEventListener('click', () => { showList(); loadThreads(page); });
    document.getElementById('editThreadBtn').addEventListener('click', openEditThreadModal);
    document.getElementById('closeEditThreadModalBtn').addEventListener('click', closeEditThreadModal);
    document.getElementById('cancelEditThreadModalBtn').addEventListener('click', closeEditThreadModal);
    document.getElementById('editThreadModal').addEventListener('click', e => {
        if (e.target === document.getElementById('editThreadModal')) closeEditThreadModal();
    });
    document.getElementById('submitEditThreadBtn').addEventListener('click', submitEditThread);
    document.getElementById('deleteThreadBtn').addEventListener('click', deleteThread);
    document.getElementById('submitCommentBtn').addEventListener('click', postComment);
    document.getElementById('logoutBtn').addEventListener('click', doLogout);

    document.querySelectorAll('[data-goto]').forEach(btn => {
        btn.addEventListener('click', () => { window.location.href = btn.dataset.goto; });
    });
}

/* ── Boot ── */
async function boot() {
    try {
        await loadMe();
        bindEvents();
        await loadThreads(1);
    } catch (err) {
        if (String(err.message).toLowerCase().includes('unauthenticated')) {
            clearAuth(); window.location.href = '/login'; return;
        }
        showToast(err.message || 'Gagal memuat halaman forum.', 'error');
    }
}

boot();
</script>
</body>
</html>
