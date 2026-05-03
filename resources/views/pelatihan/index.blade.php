@extends('layouts.app')

@section('title', 'Pelatihan')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Pelatihan</p>
            <h1 class="text-3xl font-semibold text-slate-950">Pelatihan</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Pilih pelatihan yang tepat untuk meningkatkan kemampuan profesional dan memperkuat CV Anda.</p>
        </div>
        <a href="/skill-training" class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">Jelajahi Pelatihan</a>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.35fr_0.65fr]">
        <section class="rounded-2xl p-8 text-white shadow-lg" style="background: linear-gradient(135deg, #0b1021, #17253a);">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.24em] text-cyan-100/80">Kursus</p>
                    <h2 class="mt-3 text-3xl font-semibold">Program Pelatihan Unggulan</h2>
                </div>
                <div class="rounded-3xl bg-white/10 px-4 py-3 text-sm font-semibold text-white">6 Tersedia</div>
            </div>
            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                <div class="rounded-3xl bg-white/10 p-5">
                    <p class="text-sm text-cyan-100/80">Durasi</p>
                    <p class="mt-3 text-2xl font-semibold">4 Minggu</p>
                </div>
                <div class="rounded-3xl bg-white/10 p-5">
                    <p class="text-sm text-cyan-100/80">Instruktur</p>
                    <p class="mt-3 text-2xl font-semibold">Top Mentor</p>
                </div>
                <div class="rounded-3xl bg-white/10 p-5">
                    <p class="text-sm text-cyan-100/80">Level</p>
                    <p class="mt-3 text-2xl font-semibold">Menengah</p>
                </div>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-950">Rekomendasi</h3>
                <p class="mt-4 text-sm text-slate-600">Pilih pelatihan berdasarkan tujuan karier Anda, mulai dari UI/UX hingga strategi digital marketing.</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-950">Keuntungan</h3>
                <ul class="mt-4 space-y-3 text-sm text-slate-600">
                    <li class="rounded-2xl bg-slate-50 px-4 py-3">Sertifikat profesional</li>
                    <li class="rounded-2xl bg-slate-50 px-4 py-3">Akses materi 24/7</li>
                    <li class="rounded-2xl bg-slate-50 px-4 py-3">Sesi praktik langsung</li>
                </ul>
            </div>
        </aside>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Design</p>
                    <h3 class="mt-3 text-xl font-semibold text-slate-950">Pelatihan UI/UX</h3>
                </div>
                <span class="rounded-2xl bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700">Populer</span>
            </div>
            <p class="mt-4 text-sm text-slate-600">Pelajari prinsip desain antarmuka dan pengalaman pengguna yang modern.</p>
            <div class="mt-6 flex items-center justify-between">
                <span class="text-sm font-medium text-slate-900">4 Minggu</span>
                <button class="rounded-2xl bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700">Daftar</button>
            </div>
        </article>
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Coding</p>
                    <h3 class="mt-3 text-xl font-semibold text-slate-950">Frontend Developer</h3>
                </div>
                <span class="rounded-2xl bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">Baru</span>
            </div>
            <p class="mt-4 text-sm text-slate-600">Kuasi HTML, CSS, dan JavaScript untuk membangun antarmuka responsif.</p>
            <div class="mt-6 flex items-center justify-between">
                <span class="text-sm font-medium text-slate-900">6 Minggu</span>
                <button class="rounded-2xl bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700">Daftar</button>
            </div>
        </article>
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Karier</p>
                    <h3 class="mt-3 text-xl font-semibold text-slate-950">Persiapan Wawancara</h3>
                </div>
                <span class="rounded-2xl bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">Fokus</span>
            </div>
            <p class="mt-4 text-sm text-slate-600">Simulasi wawancara dan tips presentasi diri untuk job interview.</p>
            <div class="mt-6 flex items-center justify-between">
                <span class="text-sm font-medium text-slate-900">2 Minggu</span>
                <button class="rounded-2xl bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700">Daftar</button>
            </div>
        </article>
    </div>
</div>
@endsection
