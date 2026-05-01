@extends('layouts.app')

@section('title', 'Roadmap Karier')

@section('content')
@include('components.auth.toast')

<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Roadmap</p>
            <h1 class="text-3xl font-semibold text-slate-950">Roadmap Karier</h1>
            <p class="mt-2 max-w-2xl text-sm text-slate-600">Pilih jalur karier, lihat milestone, lalu gunakan pelatihan dan CV ATS untuk mengejar targetmu.</p>
        </div>
        <div id="selectedBadge" class="rounded-2xl bg-cyan-50 px-4 py-2 text-sm font-bold text-cyan-700">Belum memilih roadmap</div>
    </div>

    <section class="rounded-[18px] border border-slate-200 bg-white p-5 shadow-sm">
        <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-semibold text-slate-950">Pilih Jalur Karier</h2>
                <p class="text-sm text-slate-500">Klik salah satu jalur untuk menyimpan roadmap pilihanmu.</p>
            </div>
            <a href="/skill-training" class="rounded-2xl bg-slate-950 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">Lanjut Pelatihan</a>
        </div>
        <div id="pathGrid" class="grid gap-4 lg:grid-cols-2 xl:grid-cols-3"></div>
    </section>

    <section id="milestonePanel" class="hidden rounded-[18px] border border-slate-200 bg-white p-5 shadow-sm">
        <div class="mb-4">
            <p id="detailMeta" class="text-xs font-bold uppercase tracking-[0.18em] text-cyan-600"></p>
            <h2 id="detailTitle" class="mt-1 text-2xl font-semibold text-slate-950"></h2>
            <p id="detailDesc" class="mt-2 text-sm text-slate-600"></p>
        </div>
        <div id="milestoneList" class="grid gap-3"></div>
    </section>
</div>

<script>
const showToast = window.hirifyShowToast;
let token = '{{ session("jwt_token") }}' || localStorage.getItem('hirify_token') || sessionStorage.getItem('hirify_token');
if (token) localStorage.setItem('hirify_token', token);
if (!token) window.location.href = '/login';

let paths = [];
let selectedPath = null;

function activeStorage() { return localStorage.getItem('hirify_token') ? localStorage : sessionStorage; }
function clearAuth() { ['hirify_token','hirify_user','hirify_remember'].forEach(k => { localStorage.removeItem(k); sessionStorage.removeItem(k); }); }

async function refreshToken() {
    try {
        const res = await fetch('/api/auth/refresh', { method: 'POST', headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` } });
        const data = await res.json();
        if (!res.ok || !data?.data?.token) return false;
        token = data.data.token;
        activeStorage().setItem('hirify_token', token);
        return true;
    } catch { return false; }
}

async function api(path, opts = {}, retry = true) {
    const headers = { 'Accept': 'application/json', 'Authorization': `Bearer ${token}`, 'Content-Type': 'application/json', ...(opts.headers || {}) };
    const res = await fetch(path, { ...opts, headers });
    let data = {};
    try { data = await res.json(); } catch {}
    if (res.status === 401 && retry) {
        if (await refreshToken()) return api(path, opts, false);
        clearAuth(); window.location.href = '/login';
        throw new Error('Sesi berakhir. Silakan login kembali.');
    }
    if (!res.ok || data.success === false) throw new Error(data.message || 'Terjadi kesalahan.');
    return data;
}

function esc(value) {
    return String(value ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
}

async function loadRoadmap() {
    document.getElementById('pathGrid').innerHTML = '<div class="rounded-2xl bg-slate-50 p-5 text-sm font-semibold text-slate-500">Memuat roadmap...</div>';
    const res = await api('/api/roadmap-karier');
    paths = res.data.paths || [];
    selectedPath = res.data.selected_path;
    renderPaths();
    if (selectedPath) {
        showPath(selectedPath);
    }
}

function renderPaths() {
    const selectedTitle = paths.find(path => path.id === selectedPath)?.title;
    document.getElementById('selectedBadge').textContent = selectedTitle ? `Dipilih: ${selectedTitle}` : 'Belum memilih roadmap';

    document.getElementById('pathGrid').innerHTML = paths.map(path => {
        const active = path.id === selectedPath;
        return `
            <article class="rounded-[18px] border ${active ? 'border-cyan-400 bg-cyan-50' : 'border-slate-200 bg-white'} p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-cyan-300">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-cyan-600">${esc(path.level)}</p>
                        <h3 class="mt-2 text-lg font-semibold text-slate-950">${esc(path.title)}</h3>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">${esc(path.duration)}</span>
                </div>
                <p class="mt-3 text-sm leading-6 text-slate-600">${esc(path.description)}</p>
                <div class="mt-4 flex flex-wrap gap-2">
                    <button type="button" data-detail="${esc(path.id)}" class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50">Lihat Milestone</button>
                    <button type="button" data-select="${esc(path.id)}" class="rounded-xl bg-cyan-500 px-3 py-2 text-sm font-bold text-white hover:bg-cyan-600">${active ? 'Terpilih' : 'Pilih Roadmap'}</button>
                </div>
            </article>
        `;
    }).join('');

    document.querySelectorAll('[data-detail]').forEach(button => {
        button.addEventListener('click', () => showPath(button.dataset.detail));
    });
    document.querySelectorAll('[data-select]').forEach(button => {
        button.addEventListener('click', () => selectPath(button.dataset.select));
    });
}

function showPath(pathId) {
    const path = paths.find(item => item.id === pathId);
    if (!path) return;
    document.getElementById('milestonePanel').classList.remove('hidden');
    document.getElementById('detailMeta').textContent = `${path.duration} - ${path.level}`;
    document.getElementById('detailTitle').textContent = path.title;
    document.getElementById('detailDesc').textContent = path.description;
    document.getElementById('milestoneList').innerHTML = path.milestones.map(item => `
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <div class="flex items-start gap-3">
                <div class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-slate-950 text-sm font-bold text-white">${esc(item.step)}</div>
                <div>
                    <p class="font-semibold text-slate-950">${esc(item.title)}</p>
                    <p class="mt-1 text-sm text-slate-600">${esc(item.desc)}</p>
                </div>
            </div>
        </div>
    `).join('');
}

async function selectPath(pathId) {
    try {
        await api('/api/roadmap-karier/select', { method: 'POST', body: JSON.stringify({ path_id: pathId }) });
        selectedPath = pathId;
        renderPaths();
        showPath(pathId);
        showToast('Roadmap karier berhasil dipilih.', 'success');
    } catch (error) {
        showToast(error.message || 'Gagal memilih roadmap.', 'error');
    }
}

loadRoadmap().catch(error => showToast(error.message || 'Gagal memuat roadmap.', 'error'));
</script>
@endsection
