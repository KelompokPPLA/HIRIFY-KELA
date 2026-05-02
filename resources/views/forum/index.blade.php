@extends('layouts.app')

@section('title', 'Hirify | Forum Diskusi')

@section('content')
<style>
    :root {
        --forum-card: #ffffff;
        --forum-ink: #0d1b3d;
        --forum-muted: #6c7a93;
        --forum-line: #e5edf6;
        --forum-brand: #06cbe5;
        --forum-brand-dark: #06b0c6;
        --forum-deep: #08152f;
        --forum-ok: #0b7f53;
        --forum-danger: #b42318;
    }

    .forum-page { color: var(--forum-ink); display: flex; flex-direction: column; gap: 20px; font-family: 'Manrope', sans-serif; }

    .forum-page .btn { border: 0; border-radius: 12px; padding: 11px 16px; font: inherit; font-size: .9rem; font-weight: 700; cursor: pointer; transition: transform .15s, opacity .15s, background .15s; display: inline-flex; align-items: center; gap: 6px; }
    .forum-page .btn:hover:not(:disabled) { transform: translateY(-1px); }
    .forum-page .btn:disabled { opacity: .45; cursor: not-allowed; }
    .forum-page .btn-brand { background: linear-gradient(140deg, #08cde6, #00b2cb); color: #fff; }
    .forum-page .btn-ghost { background: #f3f8fe; color: #17315f; border: 1px solid #dbe8f6; }
    .forum-page .btn-dark { background: #07193d; color: #fff; }
    .forum-page .btn-danger { background: rgba(180,35,24,.1); color: var(--forum-danger); border: 1px solid rgba(180,35,24,.25); }
    .forum-page .btn-sm { padding: 7px 12px; font-size: .82rem; border-radius: 9px; }

    .forum-page .card { background: var(--forum-card); border: 1px solid var(--forum-line); border-radius: 18px; box-shadow: 0 20px 45px rgba(9,20,51,.06); }
    .forum-page .input, .forum-page .textarea, .forum-page .select { width: 100%; border-radius: 12px; border: 1.5px solid #d5e3f1; background: #fff; padding: 11px 14px; font: inherit; font-size: .93rem; color: var(--forum-ink); outline: none; transition: border-color .2s, box-shadow .2s; }
    .forum-page .input:focus, .forum-page .textarea:focus { border-color: var(--forum-brand); box-shadow: 0 0 0 4px rgba(6,203,229,.14); }
    .forum-page .textarea { resize: vertical; min-height: 100px; }

    .forum-page .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
    .forum-page .page-header h1 { font-size: clamp(26px,3.5vw,38px); letter-spacing: -0.03em; font-weight: 800; }
    .forum-page .page-header p { color: var(--forum-muted); margin-top: 5px; font-size: .95rem; font-weight: 500; }

    .forum-page .search-wrap { padding: 14px 16px; display: flex; gap: 10px; align-items: center; }
    .forum-page .search-wrap .input { flex: 1; }

    .forum-page .list-header { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 12px; }
    .forum-page .list-header h2 { font-size: 1.5rem; letter-spacing: -0.02em; font-weight: 800; }

    .forum-page .thread-list { display: flex; flex-direction: column; gap: 10px; }

    .forum-page .thread-card { background: #fff; border: 1.5px solid var(--forum-line); border-radius: 16px; padding: 16px 20px; cursor: pointer; transition: border-color .2s, box-shadow .2s, transform .15s; display: grid; gap: 7px; }
    .forum-page .thread-card:hover { border-color: rgba(6,203,229,.5); box-shadow: 0 6px 22px rgba(6,180,210,.1); transform: translateY(-1px); }

    .forum-page .thread-card-title { font-size: 1rem; font-weight: 800; color: var(--forum-ink); letter-spacing: -0.01em; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
    .forum-page .thread-card-preview { color: #516080; font-size: .88rem; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .forum-page .thread-card-meta { display: flex; align-items: center; flex-wrap: wrap; gap: 8px; font-size: .8rem; color: var(--forum-muted); font-weight: 600; }

    .forum-page .role-pill { display: inline-flex; padding: 2px 9px; border-radius: 999px; font-size: .72rem; font-weight: 700; }
    .forum-page .role-pill.jobseeker { background: #edfcff; color: #0494ab; }
    .forum-page .role-pill.mentor    { background: #f0edff; color: #6c47c9; }
    .forum-page .role-pill.admin     { background: #fff5ed; color: #c97b10; }
    .forum-page .dot { color: #c5d4e3; }

    .forum-page .pagination { display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 6px; }

    .forum-page .empty-state { text-align: center; padding: 36px 20px; color: var(--forum-muted); border: 1.5px dashed #cfdded; border-radius: 16px; background: #fff; }
    .forum-page .empty-state .empty-icon { font-size: 2.5rem; margin-bottom: 10px; }
    .forum-page .empty-state p { font-weight: 600; }

    .forum-page #detailView { display: none; flex-direction: column; gap: 18px; }
    .forum-page #detailView.show { display: flex; }
    .forum-page .detail-topbar { display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap; }
    .forum-page .detail-hero { background: linear-gradient(145deg, #0a1530, #0f2147); color: #f0f8ff; border-radius: 18px; padding: 24px 26px; display: grid; gap: 10px; }
    .forum-page .detail-hero h2 { font-size: clamp(1.1rem, 2.5vw, 1.55rem); letter-spacing: -0.02em; font-weight: 800; }
    .forum-page .detail-hero-meta { display: flex; flex-wrap: wrap; gap: 10px; color: rgba(240,248,255,.65); font-size: .83rem; font-weight: 600; align-items: center; }
    .forum-page .detail-body-card { background: #fff; border: 1.5px solid var(--forum-line); border-radius: 16px; padding: 20px 24px; color: #1a2a4c; line-height: 1.75; white-space: pre-wrap; word-break: break-word; font-size: .95rem; }

    .forum-page .comments-header { font-size: 1.2rem; font-weight: 800; letter-spacing: -0.02em; }
    .forum-page .comment-list { display: flex; flex-direction: column; gap: 10px; }
    .forum-page .comment-card { background: #f8fbff; border: 1.5px solid #dbeef8; border-radius: 14px; padding: 14px 16px; display: grid; gap: 7px; }
    .forum-page .comment-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; }
    .forum-page .comment-author-wrap { display: flex; align-items: center; gap: 8px; }
    .forum-page .comment-avatar { width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(140deg, #0499b3, #05d5ef); color: #fff; display: grid; place-items: center; font-weight: 800; font-size: .75rem; flex-shrink: 0; }
    .forum-page .comment-author-name { font-size: .88rem; font-weight: 700; color: #1a2a4c; }
    .forum-page .comment-time { font-size: .76rem; color: var(--forum-muted); font-weight: 600; }
    .forum-page .comment-body { color: #334d70; line-height: 1.6; font-size: .9rem; white-space: pre-wrap; word-break: break-word; }
    .forum-page .add-comment-card { padding: 18px 20px; display: grid; gap: 12px; }
    .forum-page .add-comment-card h3 { font-size: .95rem; font-weight: 800; color: #172c52; }

    .forum-modal { position: fixed; inset: 0; background: rgba(6,16,38,.55); display: none; place-items: center; z-index: 50; padding: 20px; backdrop-filter: blur(2px); }
    .forum-modal.show { display: grid; animation: forumFadeUp .22s ease; }
    .forum-modal-box { width: min(540px, 100%); background: #fff; border-radius: 20px; border: 1.5px solid #dce9f6; box-shadow: 0 28px 70px rgba(7,18,40,.24); padding: 26px 28px; display: grid; gap: 18px; }
    .forum-modal-head { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
    .forum-modal-head h3 { font-size: 1.15rem; letter-spacing: -0.02em; font-weight: 800; }
    .forum-modal-close { border: 0; background: #f3f8fe; border-radius: 9px; width: 30px; height: 30px; cursor: pointer; color: var(--forum-muted); font-size: 18px; font-weight: 700; display: grid; place-items: center; transition: background .15s; }
    .forum-modal-close:hover { background: #e8f0fb; }
    .forum-page .form-grid { display: grid; gap: 12px; }
    .forum-page .field-label { display: block; font-weight: 700; margin-bottom: 6px; font-size: .88rem; color: #172c52; }
    .forum-modal-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }

    .forum-page .char-counter { font-size: .75rem; color: var(--forum-muted); text-align: right; margin-top: 4px; font-weight: 600; }
    .forum-page .char-counter.warn { color: #c97b10; }
    .forum-page .char-counter.limit { color: var(--forum-danger); }

    @keyframes forumFadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .forum-page .spinner { display: inline-block; width: 18px; height: 18px; border: 2.5px solid rgba(6,203,229,.25); border-top-color: var(--forum-brand); border-radius: 50%; animation: forumSpin .7s linear infinite; }
    @keyframes forumSpin { to { transform: rotate(360deg); } }
    .forum-page .loading-row { display: flex; justify-content: center; padding: 30px; }

    @media (max-width: 640px) {
        .forum-page .page-header { flex-direction: column; }
        .forum-modal-actions { grid-template-columns: 1fr; }
    }
</style>

@include('components.auth.toast')

<div class="forum-page">
    <div id="listView">
        <div class="page-header">
            <div>
                <h1>Forum Diskusi</h1>
                <p>Bertukar pikiran, berbagi pengalaman, dan belajar bersama komunitas Hirify.</p>
            </div>
            <button class="btn btn-brand" type="button" id="openNewThreadBtn">Buat Thread</button>
        </div>

        <div class="card search-wrap">
            <input id="searchInput" class="input" placeholder="Cari topik diskusi...">
            <button id="searchBtn" class="btn btn-brand" type="button">Cari</button>
        </div>

        <div>
            <div class="list-header">
                <h2>Semua Thread</h2>
                <div style="display:flex; gap:8px; align-items:center;">
                    <select id="sortSelect" class="input" style="width:auto; padding:7px 14px; font-size:.82rem; border-radius:9px; font-weight:600;">
                        <option value="latest">Terbaru</option>
                        <option value="popular">Terpopuler</option>
                        <option value="active">Paling Aktif</option>
                    </select>
                    <button class="btn btn-ghost btn-sm" type="button" id="refreshBtn">Refresh</button>
                </div>
            </div>
            <div id="threadList" class="thread-list"></div>
            <div id="pagination" class="pagination" style="margin-top:14px;"></div>
        </div>
    </div>

    <div id="detailView">
        <div class="detail-topbar">
            <button class="btn btn-ghost" type="button" id="backBtn">← Kembali ke Forum</button>
            <div style="display:flex; gap:8px;">
                <button class="btn btn-ghost btn-sm" type="button" id="editThreadBtn" style="display:none;">Edit Thread</button>
                <button class="btn btn-danger btn-sm" type="button" id="deleteThreadBtn" style="display:none;">Hapus Thread</button>
            </div>
        </div>

        <div class="detail-hero" id="detailHero">
            <h2 id="detailTitle">Memuat…</h2>
            <div class="detail-hero-meta" id="detailMeta"></div>
        </div>

        <div class="detail-body-card" id="detailBody"></div>

        <div>
            <p class="comments-header" id="commentsHeading">Komentar</p>
            <div style="margin-top:10px;">
                <div id="commentList" class="comment-list"></div>
            </div>
        </div>

        <div class="card add-comment-card">
            <h3>Tambahkan Komentar</h3>
            <div class="form-grid">
                <textarea id="commentBody" class="textarea" style="min-height:90px;" placeholder="Tulis komentar Anda…" maxlength="5000"></textarea>
                <div class="char-counter" id="commentBodyCounter">0 / 5000</div>
                <div style="display:flex; justify-content:flex-end;">
                    <button class="btn btn-brand" type="button" id="submitCommentBtn">Kirim Komentar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="newThreadModal" class="forum-modal">
    <div class="forum-modal-box">
        <div class="forum-modal-head">
            <h3>Buat Thread Baru</h3>
            <button class="forum-modal-close" type="button" id="closeModalBtn">x</button>
        </div>
        <div class="form-grid">
            <div>
                <label class="field-label" for="threadTitle">Judul Thread</label>
                <input id="threadTitle" class="input" placeholder="Tuliskan judul yang jelas dan menarik…" maxlength="255">
            </div>
            <div>
                <label class="field-label" for="threadBody">Isi Diskusi</label>
                <textarea id="threadBody" class="textarea" style="min-height:150px;" placeholder="Jelaskan topik yang ingin kamu diskusikan dengan komunitas…" maxlength="10000"></textarea>
                <div class="char-counter" id="threadBodyCounter">0 / 10000</div>
            </div>
        </div>
        <div class="forum-modal-actions">
            <button class="btn btn-ghost" type="button" id="cancelModalBtn">Batal</button>
            <button class="btn btn-dark" type="button" id="submitThreadBtn">Publikasikan</button>
        </div>
    </div>
</div>

<div id="editThreadModal" class="forum-modal">
    <div class="forum-modal-box">
        <div class="forum-modal-head">
            <h3>Edit Thread</h3>
            <button class="forum-modal-close" type="button" id="closeEditThreadModalBtn">x</button>
        </div>
        <div class="form-grid">
            <div>
                <label class="field-label" for="editThreadTitle">Judul Thread</label>
                <input id="editThreadTitle" class="input" placeholder="Tuliskan judul yang jelas dan menarik…" maxlength="255">
            </div>
            <div>
                <label class="field-label" for="editThreadBody">Isi Diskusi</label>
                <textarea id="editThreadBody" class="textarea" style="min-height:150px;" placeholder="Jelaskan topik yang ingin kamu diskusikan…" maxlength="10000"></textarea>
                <div class="char-counter" id="editThreadBodyCounter">0 / 10000</div>
            </div>
        </div>
        <div class="forum-modal-actions">
            <button class="btn btn-ghost" type="button" id="cancelEditThreadModalBtn">Batal</button>
            <button class="btn btn-dark" type="button" id="submitEditThreadBtn">Simpan Perubahan</button>
        </div>
    </div>
</div>

<script src="/js/hirify-api.js"></script>
<script>
(function () {
    hirifyInitToken('{{ session("jwt_token") }}');
    const showToast = window.hirifyShowToast;
    const api = window.hirifyApi;
    const esc = window.hirifyEsc;

    let currentUser = null;
    let activeThreadId = null;
    let activeThread   = null;
    let page = 1, lastPage = 1, searchQuery = '', sortBy = 'latest';

    function initial(name) { return (String(name || 'U').trim()[0] || 'U').toUpperCase(); }
    function rolePill(role) {
        const labels = { jobseeker: 'Pencari Kerja', mentor: 'Mentor', admin: 'Admin' };
        const cls = ['jobseeker','mentor','admin'].includes(role) ? role : 'jobseeker';
        return `<span class="role-pill ${cls}">${esc(labels[role] ?? role)}</span>`;
    }

    function showList() {
        document.getElementById('listView').style.display = '';
        document.getElementById('detailView').classList.remove('show');
        activeThreadId = null;
    }
    function showDetail() {
        document.getElementById('listView').style.display = 'none';
        document.getElementById('detailView').classList.add('show');
    }

    async function loadMe() {
        const res = await api('/api/auth/me');
        currentUser = res.data;
    }

    async function loadThreads(p = 1) {
        page = p;
        const threadList = document.getElementById('threadList');
        threadList.innerHTML = '<div class="loading-row"><span class="spinner"></span></div>';
        const params = new URLSearchParams({ per_page: 12, page, sort: sortBy });
        if (searchQuery.trim()) params.set('search', searchQuery.trim());
        const res = await api(`/api/forum/threads?${params}`);
        const data = res.data;
        lastPage = data.last_page || 1;
        renderThreadList(data.items || []);
        renderPagination(data.total || 0);
    }

    function renderThreadList(items) {
        const container = document.getElementById('threadList');
        if (!items.length) {
            container.innerHTML = `<div class="empty-state"><p>Belum ada thread diskusi.<br>Jadilah yang pertama memulai diskusi!</p></div>`;
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
                    <span>Komentar: ${esc(String(t.comments_count))}</span>
                    <span class="dot">·</span>
                    <span>Views: ${esc(String(t.views_count))}</span>
                </div>
            </article>`).join('');
        container.querySelectorAll('.thread-card').forEach(el => {
            el.addEventListener('click', () => openThread(el.dataset.id));
        });
    }

    function renderPagination(total) {
        const wrap = document.getElementById('pagination');
        if (lastPage <= 1) { wrap.innerHTML = ''; return; }
        wrap.innerHTML = `
            <button class="btn btn-ghost btn-sm" ${page <= 1 ? 'disabled' : ''} data-p="${page - 1}">‹ Prev</button>
            <span style="font-size:.85rem;font-weight:600;color:var(--forum-muted);">Halaman ${page} / ${lastPage} · ${total} thread</span>
            <button class="btn btn-ghost btn-sm" ${page >= lastPage ? 'disabled' : ''} data-p="${page + 1}">Next ›</button>`;
        wrap.querySelectorAll('[data-p]').forEach(btn => btn.addEventListener('click', () => loadThreads(Number(btn.dataset.p))));
    }

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
            const res = await api(`/api/forum/threads/${id}`);
            const thread = res.data;
            activeThread = thread;
            document.getElementById('detailTitle').textContent = thread.title;
            document.getElementById('detailBody').textContent  = thread.body;
            document.getElementById('detailMeta').innerHTML =
                `${rolePill(thread.author_role)}
                 <span>${esc(thread.author)}</span>
                 <span class="dot">·</span>
                 <span>${esc(thread.created_at)}</span>
                 <span class="dot">·</span>
                 <span>${esc(String(thread.views_count))} views</span>`;
            if (currentUser && currentUser.id === thread.user_id) document.getElementById('editThreadBtn').style.display = '';
            if (currentUser && (currentUser.id === thread.user_id || currentUser.role === 'admin')) document.getElementById('deleteThreadBtn').style.display = '';
            renderComments(thread.comments || []);
        } catch (err) {
            showToast(err.message || 'Gagal memuat thread.', 'error');
            showList();
        }
    }

    function renderComments(comments) {
        const heading = document.getElementById('commentsHeading');
        const container = document.getElementById('commentList');
        heading.textContent = `Komentar (${comments.length})`;
        if (!comments.length) {
            container.innerHTML = `<div class="empty-state" style="padding:20px;"><p>Belum ada komentar. Jadilah yang pertama berkomentar!</p></div>`;
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
        container.querySelectorAll('[data-del-comment]').forEach(btn => btn.addEventListener('click', () => deleteComment(btn.dataset.delComment)));
        container.querySelectorAll('[data-edit-comment]').forEach(btn => btn.addEventListener('click', () => startEditComment(btn.dataset.editComment)));
    }

    async function createThread() {
        const title = document.getElementById('threadTitle').value.trim();
        const body  = document.getElementById('threadBody').value.trim();
        if (!title) { showToast('Judul thread wajib diisi.', 'error'); return; }
        if (!body)  { showToast('Isi diskusi wajib diisi.', 'error'); return; }
        const btn = document.getElementById('submitThreadBtn');
        btn.disabled = true;
        try {
            await api('/api/forum/threads', { method: 'POST', body: JSON.stringify({ title, body }) });
            showToast('Thread berhasil dipublikasikan.', 'success');
            document.getElementById('threadTitle').value = '';
            document.getElementById('threadBody').value  = '';
            closeModal();
            await loadThreads(1);
        } catch (err) {
            showToast(err.message || 'Gagal membuat thread.', 'error');
        } finally { btn.disabled = false; }
    }

    async function postComment() {
        if (!activeThreadId) return;
        const body = document.getElementById('commentBody').value.trim();
        if (!body) { showToast('Komentar tidak boleh kosong.', 'error'); return; }
        const btn = document.getElementById('submitCommentBtn');
        btn.disabled = true;
        try {
            await api(`/api/forum/threads/${activeThreadId}/comments`, { method: 'POST', body: JSON.stringify({ body }) });
            document.getElementById('commentBody').value = '';
            showToast('Komentar berhasil ditambahkan.', 'success');
            await openThread(activeThreadId);
        } catch (err) {
            showToast(err.message || 'Gagal mengirim komentar.', 'error');
        } finally { btn.disabled = false; }
    }

    function openEditThreadModal() {
        if (!activeThread) return;
        document.getElementById('editThreadTitle').value = activeThread.title;
        document.getElementById('editThreadBody').value  = activeThread.body;
        document.getElementById('editThreadModal').classList.add('show');
    }
    function closeEditThreadModal() { document.getElementById('editThreadModal').classList.remove('show'); }

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
        } catch (err) { showToast(err.message || 'Gagal memperbarui thread.', 'error'); }
        finally { btn.disabled = false; }
    }

    async function deleteThread() {
        if (!activeThreadId || !confirm('Hapus thread ini secara permanen?')) return;
        try {
            await api(`/api/forum/threads/${activeThreadId}`, { method: 'DELETE' });
            showToast('Thread berhasil dihapus.', 'success');
            showList();
            await loadThreads(1);
        } catch (err) { showToast(err.message || 'Gagal menghapus thread.', 'error'); }
    }

    async function deleteComment(commentId) {
        if (!activeThreadId || !commentId) return;
        try {
            await api(`/api/forum/threads/${activeThreadId}/comments/${commentId}`, { method: 'DELETE' });
            showToast('Komentar dihapus.', 'success');
            await openThread(activeThreadId);
        } catch (err) { showToast(err.message || 'Gagal menghapus komentar.', 'error'); }
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
        bodyEl.querySelector(`[data-cancel-edit]`).addEventListener('click', () => { bodyEl.dataset.editing = ''; bodyEl.textContent = original; });
        bodyEl.querySelector(`[data-save-edit]`).addEventListener('click', () => submitEditComment(commentId, bodyEl));
    }

    async function submitEditComment(commentId, bodyEl) {
        const newBody = bodyEl.querySelector('textarea')?.value?.trim();
        if (!newBody) { showToast('Komentar tidak boleh kosong.', 'error'); return; }
        const saveBtn = bodyEl.querySelector(`[data-save-edit]`);
        if (saveBtn) saveBtn.disabled = true;
        try {
            await api(`/api/forum/threads/${activeThreadId}/comments/${commentId}`, { method: 'PUT', body: JSON.stringify({ body: newBody }) });
            showToast('Komentar berhasil diperbarui.', 'success');
            bodyEl.dataset.editing = '';
            bodyEl.textContent = newBody;
        } catch (err) {
            showToast(err.message || 'Gagal memperbarui komentar.', 'error');
            if (saveBtn) saveBtn.disabled = false;
        }
    }

    function openModal() { document.getElementById('newThreadModal').classList.add('show'); }
    function closeModal() { document.getElementById('newThreadModal').classList.remove('show'); }

    function bindEvents() {
        function attachCounter(textareaId, counterId, max) {
            const ta = document.getElementById(textareaId);
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
        document.getElementById('newThreadModal').addEventListener('click', e => { if (e.target === document.getElementById('newThreadModal')) closeModal(); });
        document.getElementById('submitThreadBtn').addEventListener('click', createThread);

        document.getElementById('threadBody').addEventListener('keydown', e => { if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) createThread(); });
        document.getElementById('editThreadBody').addEventListener('keydown', e => { if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) submitEditThread(); });
        document.getElementById('commentBody').addEventListener('keydown', e => { if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) postComment(); });

        document.getElementById('searchBtn').addEventListener('click', () => { searchQuery = document.getElementById('searchInput').value; loadThreads(1); });
        document.getElementById('searchInput').addEventListener('keydown', e => { if (e.key === 'Enter') { searchQuery = e.target.value; loadThreads(1); } });

        document.getElementById('sortSelect').addEventListener('change', e => { sortBy = e.target.value; loadThreads(1); });
        document.getElementById('refreshBtn').addEventListener('click', () => loadThreads(page));
        document.getElementById('backBtn').addEventListener('click', () => { showList(); loadThreads(page); });
        document.getElementById('editThreadBtn').addEventListener('click', openEditThreadModal);
        document.getElementById('closeEditThreadModalBtn').addEventListener('click', closeEditThreadModal);
        document.getElementById('cancelEditThreadModalBtn').addEventListener('click', closeEditThreadModal);
        document.getElementById('editThreadModal').addEventListener('click', e => { if (e.target === document.getElementById('editThreadModal')) closeEditThreadModal(); });
        document.getElementById('submitEditThreadBtn').addEventListener('click', submitEditThread);
        document.getElementById('deleteThreadBtn').addEventListener('click', deleteThread);
        document.getElementById('submitCommentBtn').addEventListener('click', postComment);
    }

    async function boot() {
        try {
            await loadMe();
            bindEvents();
            await loadThreads(1);
        } catch (err) {
            if (String(err.message).toLowerCase().includes('unauthenticated')) { hirifyClearAuth(); window.location.href = '/login'; return; }
            showToast(err.message || 'Gagal memuat halaman forum.', 'error');
        }
    }

    boot();
})();
</script>
@endsection
