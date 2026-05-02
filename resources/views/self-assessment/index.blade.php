@extends('layouts.app')

@section('title', 'Self Assessment')

@section('content')
@include('components.auth.toast')

<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Evaluasi</p>
            <h1 class="text-3xl font-semibold text-slate-950">Self Assessment</h1>
            <p class="mt-2 max-w-2xl text-sm text-slate-600">Nilai kesiapan kariermu, simpan hasilnya, lalu pakai rekomendasi untuk menentukan langkah belajar berikutnya.</p>
        </div>
        <button id="startBtn" type="button" class="rounded-2xl bg-slate-950 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">Mulai Penilaian</button>
    </div>

    <section class="rounded-[18px] border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-semibold text-slate-950">Hasil Terakhir</h2>
                <p class="text-sm text-slate-500">Riwayat hasil assessment akan muncul setelah kamu mengirim jawaban.</p>
            </div>
            <div id="latestScore" class="rounded-2xl bg-cyan-50 px-4 py-2 text-sm font-bold text-cyan-700">Belum ada hasil</div>
        </div>
        <div id="historyList" class="mt-5 grid gap-3 lg:grid-cols-2"></div>
    </section>

    <section id="assessmentPanel" class="hidden rounded-[18px] border border-slate-200 bg-white p-5 shadow-sm">
        <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-semibold text-slate-950">Pertanyaan Assessment</h2>
                <p class="text-sm text-slate-500">Pilih nilai 1 sampai 5 untuk setiap area. Nilai 5 berarti paling siap.</p>
            </div>
            <span id="questionCount" class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">Memuat...</span>
        </div>
        <div id="questionList" class="grid gap-3"></div>
        <div class="mt-5 flex justify-end">
            <button id="submitBtn" type="button" class="rounded-2xl bg-cyan-500 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600">Simpan Hasil</button>
        </div>
    </section>
</div>

<script src="/js/hirify-api.js"></script>
<script>
hirifyInitToken('{{ session("jwt_token") }}');
const showToast = window.hirifyShowToast;
const api = window.hirifyApi;
const esc = window.hirifyEsc;

async function loadHistory() {
    const res = await api('/api/self-assessment');
    const items = res.data || [];
    const latest = items[0];
    document.getElementById('latestScore').textContent = latest ? `${latest.score}% - ${latest.level}` : 'Belum ada hasil';

    document.getElementById('historyList').innerHTML = items.length ? items.map(item => `
        <article class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <div class="flex items-center justify-between gap-3">
                <strong class="text-slate-950">${esc(item.score)}% - ${esc(item.level)}</strong>
                <span class="text-xs font-semibold text-slate-500">${esc(item.created_at)}</span>
            </div>
            <div class="mt-3 grid gap-2 sm:grid-cols-2">
                ${Object.entries(item.category_scores || {}).map(([name, score]) => `
                    <div class="rounded-xl bg-white px-3 py-2 text-sm text-slate-600">
                        <span class="font-semibold text-slate-900">${esc(name)}</span>: ${esc(score)}%
                    </div>
                `).join('')}
            </div>
        </article>
    `).join('') : '<div class="rounded-2xl border border-dashed border-slate-300 p-5 text-sm font-semibold text-slate-500">Belum ada riwayat assessment.</div>';
}

async function loadQuestions() {
    document.getElementById('assessmentPanel').classList.remove('hidden');
    document.getElementById('questionList').innerHTML = '<div class="rounded-2xl bg-slate-50 p-5 text-sm font-semibold text-slate-500">Memuat pertanyaan...</div>';
    const res = await api('/api/self-assessment/questions');
    const questions = res.data || [];
    document.getElementById('questionCount').textContent = `${questions.length} pertanyaan`;
    document.getElementById('questionList').innerHTML = questions.map(q => `
        <div class="rounded-2xl border border-slate-200 p-4">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-cyan-600">${esc(q.category)}</p>
                    <p class="mt-1 font-semibold text-slate-950">${esc(q.text)}</p>
                </div>
                <div class="flex gap-1 rounded-xl bg-slate-100 p-1">
                    ${[1,2,3,4,5].map(n => `
                        <label class="cursor-pointer">
                            <input class="peer sr-only" type="radio" name="answer_${q.id}" value="${n}" ${n === 3 ? 'checked' : ''}>
                            <span class="grid h-9 w-9 place-items-center rounded-lg text-sm font-bold text-slate-500 peer-checked:bg-slate-950 peer-checked:text-white">${n}</span>
                        </label>
                    `).join('')}
                </div>
            </div>
        </div>
    `).join('');
}

async function submitAssessment() {
    const answers = [];
    document.querySelectorAll('#questionList [name^="answer_"]').forEach(input => {
        if (input.checked) answers.push(Number(input.value));
    });
    if (answers.length < 10) {
        showToast('Lengkapi semua jawaban assessment.', 'error');
        return;
    }

    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    try {
        await api('/api/self-assessment', { method: 'POST', body: JSON.stringify({ answers }) });
        showToast('Hasil assessment berhasil disimpan.', 'success');
        document.getElementById('assessmentPanel').classList.add('hidden');
        await loadHistory();
    } catch (error) {
        showToast(error.message || 'Gagal menyimpan assessment.', 'error');
    } finally {
        btn.disabled = false;
    }
}

document.getElementById('startBtn').addEventListener('click', loadQuestions);
document.getElementById('submitBtn').addEventListener('click', submitAssessment);
loadHistory().catch(error => showToast(error.message || 'Gagal memuat assessment.', 'error'));
</script>
@endsection
