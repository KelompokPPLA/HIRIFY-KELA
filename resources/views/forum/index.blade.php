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
            --warn: #b98007;
            --danger: #b42318;
            --shadow: 0 20px 45px rgba(9, 20, 51, 0.08);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 5% 15%, rgba(6, 203, 229, 0.16), transparent 24%),
                radial-gradient(circle at 95% 5%, rgba(6, 203, 229, 0.12), transparent 20%),
                var(--bg);
        }

        .layout {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 250px 1fr;
        }

        /* ── Sidebar ── */
        .sidebar {
            background: #ffffff;
            border-right: 1px solid var(--line);
            padding: 22px 16px;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 30px;
            letter-spacing: -0.02em;
        }

        .brand-mark {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            background: linear-gradient(145deg, #0399b7, #06d8ee);
            display: grid;
            place-items: center;
            color: #fff;
            font-size: 17px;
            font-weight: 800;
        }

        .menu { display: grid; gap: 8px; }

        .menu button {
            border: 0;
            background: transparent;
            color: #1a2a4c;
            font: inherit;
            text-align: left;
            border-radius: 12px;
            padding: 11px 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-weight: 600;
        }

        .menu button:hover { background: #f2f8ff; }

        .menu button.active {
            background: linear-gradient(145deg, #0a1632, #111f45);
            color: #f2fbff;
            box-shadow: 0 10px 20px rgba(11, 24, 54, 0.22);
        }

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
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(140deg, #0499b3, #05d5ef);
            color: #fff;
            display: grid;
            place-items: center;
            font-weight: 800;
            flex-shrink: 0;
        }

        .profile-mini strong { display: block; font-size: .92rem; }
        .profile-mini span { color: var(--muted); font-size: .82rem; }

        /* ── Content ── */
        .content {
            padding: 24px;
            display: grid;
            gap: 18px;
            align-content: start;
        }

        .title-wrap h1 {
            margin: 0;
            font-size: clamp(28px, 4vw, 40px);
            letter-spacing: -0.03em;
        }

        .title-wrap p {
            margin: 6px 0 0;
            color: var(--muted);
            font-weight: 500;
        }

        /* ── Cards ── */
        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: var(--shadow);
        }

        /* ── Buttons ── */
        .btn {
            border: 0;
            border-radius: 12px;
            padding: 11px 14px;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
            transition: transform .15s ease, box-shadow .2s ease, opacity .2s ease;
        }

        .btn:hover { transform: translateY(-1px); }
        .btn:disabled { opacity: .5; cursor: not-allowed; transform: none; }

        .btn-brand {
            background: linear-gradient(140deg, #08cde6, #00b2cb);
            color: #fff;
        }

        .btn-ghost {
            background: #f3f8fe;
            color: #17315f;
            border: 1px solid #dbe8f6;
        }

        .btn-danger {
            background: rgba(180, 35, 24, 0.08);
            color: var(--danger);
            border: 1px solid rgba(180, 35, 24, 0.24);
        }

        .btn-solid {
            background: #07193d;
            color: #fff;
        }

        /* ── Form controls ── */
        .input, .textarea {
            width: 100%;
            border-radius: 12px;
            border: 1px solid #d5e3f1;
            background: #fff;
            padding: 11px 13px;
            font: inherit;
            color: var(--ink);
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .input:focus, .textarea:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(6, 203, 229, 0.16);
        }

        .textarea { resize: vertical; min-height: 100px; }

        /* ── Search bar ── */
        .search-card { padding: 14px; }

        .search-row {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;
            align-items: center;
        }

        /* ── New thread form ── */
        .new-thread-card { padding: 16px; }

        .new-thread-card h2 {
            margin: 0 0 14px;
            font-size: 1.15rem;
        }

        .form-grid { display: grid; gap: 10px; }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 4px;
        }

        /* ── Thread list ── */
        .section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .section-head h2 { margin: 0; font-size: 1.6rem; letter-spacing: -0.02em; }

        .thread-list { display: grid; gap: 12px; }

        .thread-item {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 16px 18px;
            display: grid;
            gap: 8px;
            cursor: pointer;
            transition: box-shadow .2s ease, border-color .2s ease;
        }

        .thread-item:hover {
            border-color: rgba(6, 203, 229, 0.45);
            box-shadow: 0 8px 24px rgba(6, 180, 210, 0.1);
        }

        .thread-title {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 800;
            color: #0d1b3d;
            letter-spacing: -0.01em;
        }

        .thread-preview {
            color: #476186;
            font-size: .9rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .thread-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            font-size: .82rem;
            color: var(--muted);
            font-weight: 600;
        }

        .thread-meta .role-badge {
            display: inline-flex;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: .73rem;
            font-weight: 700;
            background: #edfcff;
            color: #0494ab;
        }

        .thread-meta .role-badge.mentor { background: #f0edff; color: #6c47c9; }
        .thread-meta .role-badge.admin  { background: #fff5ed; color: #c97b10; }

        /* ── Thread detail panel ── */
        .detail-panel { display: none; }
        .detail-panel.show { display: grid; gap: 14px; }

        .detail-header {
            background: linear-gradient(145deg, #0a1530, #0f2147);
            color: #f0f8ff;
            border-radius: 18px;
            padding: 20px 22px;
        }

        .detail-header h2 {
            margin: 0 0 8px;
            font-size: clamp(1.15rem, 3vw, 1.5rem);
            letter-spacing: -0.02em;
        }

        .detail-header .meta {
            color: rgba(240, 248, 255, 0.7);
            font-size: .85rem;
            font-weight: 600;
        }

        .detail-body {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 18px 20px;
            line-height: 1.7;
            color: #1a2a4c;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .comments-section { display: grid; gap: 12px; }

        .comment-item {
            background: #f8fbff;
            border: 1px solid #dbeef8;
            border-radius: 14px;
            padding: 13px 15px;
            display: grid;
            gap: 6px;
        }

        .comment-author {
            font-size: .85rem;
            font-weight: 700;
            color: #1a2a4c;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .comment-body {
            color: #334d70;
            line-height: 1.55;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .comment-time { color: var(--muted); font-size: .78rem; font-weight: 600; }

        .comment-actions { display: flex; justify-content: flex-end; }

        .add-comment-card { padding: 14px; }
        .add-comment-card h3 { margin: 0 0 10px; font-size: 1rem; }

        /* ── Back button bar ── */
        .back-bar {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ── Empty / loading states ── */
        .empty {
            padding: 26px;
            text-align: center;
            color: var(--muted);
            background: #fff;
            border-radius: 16px;
            border: 1px dashed #cfdded;
        }

        /* ── Pagination ── */
        .pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 4px;
        }

        /* ── Modal ── */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(6, 16, 38, 0.52);
            display: none;
            place-items: center;
            z-index: 30;
            padding: 20px;
        }

        .modal.show { display: grid; animation: fadeIn .2s ease; }

        .modal-card {
            width: min(520px, 100%);
            background: #fff;
            border-radius: 20px;
            border: 1px solid #dce9f6;
            box-shadow: 0 26px 70px rgba(7, 18, 40, .22);
            padding: 22px 24px;
            display: grid;
            gap: 14px;
        }

        .modal-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-head h3 { margin: 0; font-size: 1.2rem; letter-spacing: -0.02em; }

        .modal-close-btn {
            border: 0;
            background: transparent;
            cursor: pointer;
            color: var(--muted);
            font-size: 20px;
            line-height: 1;
            padding: 2px 6px;
            border-radius: 8px;
        }

        .modal-close-btn:hover { background: #f3f8fe; }

        .modal-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── Responsive ── */
        @media (max-width: 980px) {
            .layout { grid-template-columns: 1fr; }
            .sidebar { border-right: 0; border-bottom: 1px solid var(--line); }
        }

        @media (max-width: 640px) {
            .content { padding: 14px; }
            .search-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    @include('components.auth.toast')

    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="brand">
                <span class="brand-mark">H</span>
                <span>Hirify!</span>
            </div>

            <div class="menu">
                <button type="button" data-nav="dashboard">🏠 Dashboard</button>
                <button type="button" data-nav="profile">👤 Profil</button>
                <button type="button" data-nav="mentorship" id="menuMentorship" style="display:none;">🎓 Mentorship</button>
                <button type="button" class="active" data-nav="forum">💬 Forum Diskusi</button>
                <button type="button" data-nav="logout" id="logoutBtn">🚪 Logout</button>
            </div>

            <div class="profile-mini">
                <div class="avatar-mini" id="miniAvatar">U</div>
                <div>
                    <strong id="miniName">User Name</strong>
                    <span id="miniEmail">user@email.com</span>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="content">

            <!-- Thread list view -->
            <div id="listView">
                <section class="title-wrap">
                    <h1>Forum Diskusi</h1>
                    <p>Berinteraksi, berbagi pengetahuan, dan belajar bersama komunitas Hirify.</p>
                </section>

                <!-- New thread button / toggle -->
                <div style="display:flex; justify-content:flex-end;">
                    <button class="btn btn-brand" type="button" id="openNewThreadBtn">+ Buat Thread Baru</button>
                </div>

                <!-- Search -->
                <section class="card search-card">
                    <div class="search-row">
                        <input id="searchInput" class="input" placeholder="Cari topik diskusi...">
                        <button id="searchBtn" class="btn btn-brand" type="button">Cari</button>
                    </div>
                </section>

                <!-- Thread list -->
                <section>
                    <div class="section-head">
                        <h2>Semua Thread</h2>
                        <button class="btn btn-ghost" type="button" id="refreshBtn">Refresh</button>
                    </div>
                    <div id="threadList" class="thread-list"></div>
                    <div class="pagination" id="pagination" style="margin-top:12px;"></div>
                </section>
            </div>

            <!-- Thread detail view -->
            <div id="detailView" class="detail-panel">
                <div class="back-bar">
                    <button class="btn btn-ghost" type="button" id="backBtn">← Kembali ke Forum</button>
                    <button class="btn btn-danger" type="button" id="deleteThreadBtn" style="display:none;">Hapus Thread</button>
                </div>

                <div class="detail-header" id="detailHeader">
                    <h2 id="detailTitle">Memuat...</h2>
                    <div class="meta" id="detailMeta"></div>
                </div>

                <div class="detail-body" id="detailBody"></div>

                <!-- Comments -->
                <section>
                    <div class="section-head">
                        <h2 id="commentsHeading">Komentar</h2>
                    </div>
                    <div id="commentList" class="comments-section"></div>
                </section>

                <!-- Add comment -->
                <section class="card add-comment-card">
                    <h3>Tambahkan Komentar</h3>
                    <div class="form-grid">
                        <textarea id="commentBody" class="textarea" placeholder="Tulis komentar Anda..." style="min-height:80px;"></textarea>
                        <div class="form-actions">
                            <button class="btn btn-brand" type="button" id="submitCommentBtn">Kirim Komentar</button>
                        </div>
                    </div>
                </section>
            </div>

        </main>
    </div>

    <!-- Modal: New Thread -->
    <div id="newThreadModal" class="modal">
        <div class="modal-card">
            <div class="modal-head">
                <h3>Buat Thread Baru</h3>
                <button class="modal-close-btn" type="button" id="closeNewThreadModal">✕</button>
            </div>
            <div class="form-grid">
                <div>
                    <label style="display:block; font-weight:700; margin-bottom:6px; font-size:.9rem;">Judul Thread</label>
                    <input id="threadTitle" class="input" placeholder="Masukkan judul yang jelas dan deskriptif...">
                </div>
                <div>
                    <label style="display:block; font-weight:700; margin-bottom:6px; font-size:.9rem;">Isi Diskusi</label>
                    <textarea id="threadBody" class="textarea" style="min-height:140px;" placeholder="Jelaskan topik yang ingin Anda diskusikan dengan komunitas..."></textarea>
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn btn-ghost" type="button" id="cancelNewThreadBtn">Batal</button>
                <button class="btn btn-solid" type="button" id="submitNewThreadBtn">Publikasikan Thread</button>
            </div>
        </div>
    </div>

    <script>
        const showToast = window.hirifyShowToast;

        let token = localStorage.getItem('hirify_token') || sessionStorage.getItem('hirify_token');
        let currentUser = null;
        let currentThreadId = null;
        let currentPage = 1;
        let currentSearch = '';
        let totalPages = 1;

        if (!token) {
            window.location.href = '/login';
        }

        function clearAuthStorage() {
            localStorage.removeItem('hirify_token');
            localStorage.removeItem('hirify_user');
            localStorage.removeItem('hirify_remember');
            sessionStorage.removeItem('hirify_token');
            sessionStorage.removeItem('hirify_user');
        }

        function activeStorage() {
            return localStorage.getItem('hirify_token') ? localStorage : sessionStorage;
        }

        async function refreshToken() {
            if (!token) return false;
            try {
                const response = await fetch('/api/auth/refresh', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` },
                });
                const result = await response.json();
                if (!response.ok || result.success === false || !result?.data?.token) return false;
                token = result.data.token;
                activeStorage().setItem('hirify_token', token);
                if (result.data.user) activeStorage().setItem('hirify_user', JSON.stringify(result.data.user));
                return true;
            } catch (_) { return false; }
        }

        async function api(path, options = {}, canRetry = true) {
            const response = await fetch(path, {
                ...options,
                headers: {
                    'Accept': 'application/json',
                    ...(options.body instanceof FormData ? {} : { 'Content-Type': 'application/json' }),
                    'Authorization': `Bearer ${token}`,
                    ...(options.headers || {}),
                },
            });

            let data = {};
            try { data = await response.json(); } catch (_) { data = {}; }

            if (response.status === 401 && canRetry) {
                const refreshed = await refreshToken();
                if (refreshed) return api(path, options, false);
            }

            if (!response.ok || data.success === false) {
                throw new Error(data.message || 'Terjadi kesalahan request.');
            }
            return data;
        }

        function escapeHtml(text) {
            return String(text || '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#39;');
        }

        function getInitial(name) {
            return (name?.trim()?.[0] || 'U').toUpperCase();
        }

        function roleBadge(role) {
            const cls = role === 'mentor' ? 'mentor' : role === 'admin' ? 'admin' : '';
            const label = role === 'jobseeker' ? 'Pencari Kerja' : role === 'mentor' ? 'Mentor' : role === 'admin' ? 'Admin' : role;
            return `<span class="role-badge ${cls}">${escapeHtml(label)}</span>`;
        }

        /* ─── Load me ─── */
        async function loadMe() {
            const me = await api('/api/auth/me');
            currentUser = me.data;

            document.getElementById('miniName').textContent = currentUser.name || 'User';
            document.getElementById('miniEmail').textContent = currentUser.email || '-';
            document.getElementById('miniAvatar').textContent = getInitial(currentUser.name);

            if (currentUser.role === 'jobseeker') {
                document.getElementById('menuMentorship').style.display = '';
            }
        }

        /* ─── Thread List ─── */
        async function loadThreads(page = 1) {
            currentPage = page;
            const params = new URLSearchParams({ per_page: 12, page });
            if (currentSearch.trim()) params.set('search', currentSearch.trim());

            const response = await api(`/api/forum/threads?${params.toString()}`);
            const { items, total, last_page } = response.data;
            totalPages = last_page || 1;

            renderThreads(items || []);
            renderPagination(total || 0);
        }

        function renderThreads(items) {
            const container = document.getElementById('threadList');
            if (!items.length) {
                container.innerHTML = '<div class="empty">Belum ada thread. Jadilah yang pertama membuat diskusi!</div>';
                return;
            }

            container.innerHTML = items.map((thread) => `
                <article class="thread-item" data-thread-id="${escapeHtml(thread.id)}">
                    <h3 class="thread-title">${escapeHtml(thread.title)}</h3>
                    <p class="thread-preview">${escapeHtml(thread.body_preview)}</p>
                    <div class="thread-meta">
                        ${roleBadge(thread.author_role)}
                        <span>${escapeHtml(thread.author)}</span>
                        <span>·</span>
                        <span>${escapeHtml(thread.created_at)}</span>
                        <span>·</span>
                        <span>💬 ${escapeHtml(String(thread.comments_count))} komentar</span>
                        <span>·</span>
                        <span>👁 ${escapeHtml(String(thread.views_count))} views</span>
                    </div>
                </article>
            `).join('');

            container.querySelectorAll('.thread-item').forEach((el) => {
                el.addEventListener('click', () => openThread(el.getAttribute('data-thread-id')));
            });
        }

        function renderPagination(total) {
            const container = document.getElementById('pagination');
            if (totalPages <= 1) { container.innerHTML = ''; return; }

            let html = `<button class="btn btn-ghost" ${currentPage <= 1 ? 'disabled' : ''} data-page="${currentPage - 1}">‹ Prev</button>`;
            html += `<span style="font-weight:600; color:var(--muted);">Halaman ${currentPage} / ${totalPages}</span>`;
            html += `<button class="btn btn-ghost" ${currentPage >= totalPages ? 'disabled' : ''} data-page="${currentPage + 1}">Next ›</button>`;
            container.innerHTML = html;

            container.querySelectorAll('[data-page]').forEach((btn) => {
                btn.addEventListener('click', () => loadThreads(Number(btn.getAttribute('data-page'))));
            });
        }

        /* ─── Thread Detail ─── */
        async function openThread(id) {
            if (!id) return;
            currentThreadId = id;

            document.getElementById('listView').style.display = 'none';
            document.getElementById('detailView').classList.add('show');
            document.getElementById('detailTitle').textContent = 'Memuat...';
            document.getElementById('detailBody').textContent = '';
            document.getElementById('detailMeta').textContent = '';
            document.getElementById('commentList').innerHTML = '';
            document.getElementById('deleteThreadBtn').style.display = 'none';

            try {
                const response = await api(`/api/forum/threads/${id}`);
                const thread = response.data;

                document.getElementById('detailTitle').textContent = thread.title;
                document.getElementById('detailMeta').innerHTML =
                    `${escapeHtml(thread.author)} &nbsp;·&nbsp; ${escapeHtml(thread.author_role)} &nbsp;·&nbsp; ${escapeHtml(thread.created_at)} &nbsp;·&nbsp; 👁 ${escapeHtml(String(thread.views_count))} views`;
                document.getElementById('detailBody').textContent = thread.body;
                document.getElementById('commentsHeading').textContent = `Komentar (${thread.comments.length})`;

                if (currentUser && (currentUser.id === thread.user_id || currentUser.role === 'admin')) {
                    document.getElementById('deleteThreadBtn').style.display = '';
                }

                renderComments(thread.comments);
            } catch (error) {
                showToast(error.message || 'Gagal memuat thread.', 'error');
                showListView();
            }
        }

        function renderComments(comments) {
            const container = document.getElementById('commentList');
            if (!comments.length) {
                container.innerHTML = '<div class="empty">Belum ada komentar. Jadilah yang pertama berkomentar!</div>';
                return;
            }

            container.innerHTML = comments.map((c) => {
                const canDelete = currentUser && (currentUser.id === c.user_id || currentUser.role === 'admin');
                return `
                    <div class="comment-item">
                        <div class="comment-author">
                            ${roleBadge(c.author_role)}
                            <span>${escapeHtml(c.author)}</span>
                            <span class="comment-time">${escapeHtml(c.created_at)}</span>
                        </div>
                        <div class="comment-body">${escapeHtml(c.body)}</div>
                        ${canDelete ? `<div class="comment-actions"><button class="btn btn-danger" style="padding:6px 10px; font-size:.8rem;" data-delete-comment="${escapeHtml(c.id)}">Hapus</button></div>` : ''}
                    </div>
                `;
            }).join('');

            container.querySelectorAll('[data-delete-comment]').forEach((btn) => {
                btn.addEventListener('click', () => deleteComment(btn.getAttribute('data-delete-comment')));
            });
        }

        function showListView() {
            document.getElementById('listView').style.display = '';
            document.getElementById('detailView').classList.remove('show');
            currentThreadId = null;
        }

        /* ─── Actions ─── */
        async function submitNewThread() {
            const title = document.getElementById('threadTitle').value.trim();
            const body = document.getElementById('threadBody').value.trim();

            if (!title) { showToast('Judul thread wajib diisi.', 'error'); return; }
            if (!body)  { showToast('Isi diskusi wajib diisi.', 'error'); return; }

            try {
                await api('/api/forum/threads', {
                    method: 'POST',
                    body: JSON.stringify({ title, body }),
                });
                showToast('Thread berhasil dibuat!', 'success');
                document.getElementById('threadTitle').value = '';
                document.getElementById('threadBody').value = '';
                document.getElementById('newThreadModal').classList.remove('show');
                await loadThreads(1);
            } catch (error) {
                showToast(error.message || 'Gagal membuat thread.', 'error');
            }
        }

        async function submitComment() {
            if (!currentThreadId) return;
            const body = document.getElementById('commentBody').value.trim();
            if (!body) { showToast('Komentar tidak boleh kosong.', 'error'); return; }

            try {
                const response = await api(`/api/forum/threads/${currentThreadId}/comments`, {
                    method: 'POST',
                    body: JSON.stringify({ body }),
                });
                document.getElementById('commentBody').value = '';
                showToast('Komentar berhasil ditambahkan.', 'success');

                const newComment = response.data;
                const container = document.getElementById('commentList');
                const emptyEl = container.querySelector('.empty');
                if (emptyEl) emptyEl.remove();

                const canDelete = true;
                const el = document.createElement('div');
                el.className = 'comment-item';
                el.innerHTML = `
                    <div class="comment-author">
                        ${roleBadge(newComment.author_role)}
                        <span>${escapeHtml(newComment.author)}</span>
                        <span class="comment-time">${escapeHtml(newComment.created_at)}</span>
                    </div>
                    <div class="comment-body">${escapeHtml(newComment.body)}</div>
                    ${canDelete ? `<div class="comment-actions"><button class="btn btn-danger" style="padding:6px 10px; font-size:.8rem;" data-delete-comment="${escapeHtml(newComment.id)}">Hapus</button></div>` : ''}
                `;
                el.querySelector('[data-delete-comment]')?.addEventListener('click', () => deleteComment(newComment.id));
                container.appendChild(el);

                const heading = document.getElementById('commentsHeading');
                const match = heading.textContent.match(/\d+/);
                const count = match ? Number(match[0]) + 1 : 1;
                heading.textContent = `Komentar (${count})`;
            } catch (error) {
                showToast(error.message || 'Gagal mengirim komentar.', 'error');
            }
        }

        async function deleteThread() {
            if (!currentThreadId) return;
            try {
                await api(`/api/forum/threads/${currentThreadId}`, { method: 'DELETE' });
                showToast('Thread berhasil dihapus.', 'success');
                showListView();
                await loadThreads(1);
            } catch (error) {
                showToast(error.message || 'Gagal menghapus thread.', 'error');
            }
        }

        async function deleteComment(commentId) {
            if (!currentThreadId || !commentId) return;
            try {
                await api(`/api/forum/threads/${currentThreadId}/comments/${commentId}`, { method: 'DELETE' });
                showToast('Komentar berhasil dihapus.', 'success');
                await openThread(currentThreadId);
            } catch (error) {
                showToast(error.message || 'Gagal menghapus komentar.', 'error');
            }
        }

        async function doLogout() {
            try {
                await api('/api/auth/logout', { method: 'POST' });
                showToast('Logout berhasil.', 'success', 900);
            } catch (_) {
                showToast('Sesi lokal dibersihkan.', 'info', 900);
            } finally {
                setTimeout(() => { clearAuthStorage(); window.location.href = '/login'; }, 850);
            }
        }

        /* ─── Event bindings ─── */
        function bindEvents() {
            document.getElementById('openNewThreadBtn').addEventListener('click', () => {
                document.getElementById('newThreadModal').classList.add('show');
            });

            document.getElementById('closeNewThreadModal').addEventListener('click', () => {
                document.getElementById('newThreadModal').classList.remove('show');
            });

            document.getElementById('cancelNewThreadBtn').addEventListener('click', () => {
                document.getElementById('newThreadModal').classList.remove('show');
            });

            document.getElementById('newThreadModal').addEventListener('click', (e) => {
                if (e.target === document.getElementById('newThreadModal')) {
                    document.getElementById('newThreadModal').classList.remove('show');
                }
            });

            document.getElementById('submitNewThreadBtn').addEventListener('click', submitNewThread);

            document.getElementById('searchBtn').addEventListener('click', async () => {
                currentSearch = document.getElementById('searchInput').value;
                await loadThreads(1);
            });

            document.getElementById('searchInput').addEventListener('keydown', async (e) => {
                if (e.key === 'Enter') {
                    currentSearch = document.getElementById('searchInput').value;
                    await loadThreads(1);
                }
            });

            document.getElementById('refreshBtn').addEventListener('click', () => loadThreads(currentPage));
            document.getElementById('backBtn').addEventListener('click', () => { showListView(); loadThreads(currentPage); });
            document.getElementById('deleteThreadBtn').addEventListener('click', deleteThread);
            document.getElementById('submitCommentBtn').addEventListener('click', submitComment);
            document.getElementById('logoutBtn').addEventListener('click', doLogout);

            document.querySelector('[data-nav="dashboard"]').addEventListener('click', () => {
                window.location.href = '/dashboard';
            });

            document.querySelector('[data-nav="profile"]').addEventListener('click', () => {
                window.location.href = '/dashboard';
            });

            document.getElementById('menuMentorship').addEventListener('click', () => {
                window.location.href = '/mentorship';
            });
        }

        /* ─── Boot ─── */
        async function boot() {
            try {
                await loadMe();
                bindEvents();
                await loadThreads(1);
            } catch (error) {
                if (error.message.toLowerCase().includes('unauthenticated')) {
                    clearAuthStorage();
                    window.location.href = '/login';
                    return;
                }
                showToast(error.message || 'Gagal memuat halaman forum.', 'error');
            }
        }

        boot();
    </script>
</body>
</html>
