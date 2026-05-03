@extends('layouts.app')

@section('title', 'Manajemen CV')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Manajemen</p>
            <h1 class="text-3xl font-semibold text-slate-950">Manajemen CV</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Kelola dokumen CV Anda dengan cepat, unggah versi terbaru, dan lihat riwayat perubahan.</p>
        </div>
        <a href="{{ route('cv.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Unggah CV Baru
        </a>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.35fr_0.65fr]">
        <section class="rounded-2xl p-8 text-white shadow-lg" style="background: linear-gradient(135deg, #0b1021, #17253a);">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.24em] text-cyan-100/80">Riwayat Dokumen</p>
                    <h2 class="mt-3 text-3xl font-semibold">CV terbaik untuk Lamaranmu</h2>
                </div>
                <div class="rounded-3xl bg-white/10 px-4 py-3 text-sm font-semibold text-white">4 CV Aktif</div>
            </div>
            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                <div class="rounded-3xl bg-white/10 p-5">
                    <p class="text-sm text-cyan-100/80">Terakhir diperbarui</p>
                    <p class="mt-3 text-2xl font-semibold">14 Apr 2026</p>
                </div>
                <div class="rounded-3xl bg-white/10 p-5">
                    <p class="text-sm text-cyan-100/80">Format CV</p>
                    <p class="mt-3 text-2xl font-semibold">PDF</p>
                </div>
                <div class="rounded-3xl bg-white/10 p-5">
                    <p class="text-sm text-cyan-100/80">Rekomendasi</p>
                    <p class="mt-3 text-2xl font-semibold">ATS Ready</p>
                </div>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Status</p>
                        <h3 class="mt-2 text-xl font-semibold text-slate-950">Dokumen Aktif</h3>
                    </div>
                    <span class="rounded-2xl bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700">Siap Kirim</span>
                </div>
                <p class="mt-4 text-sm text-slate-600">Pastikan CV Anda menggunakan struktur yang mudah dibaca oleh perekrut dan ATS.</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-950">Tips Cepat</h3>
                <ul class="mt-4 space-y-3 text-sm text-slate-600">
                    <li class="rounded-2xl bg-slate-50 px-4 py-3">1. Simpan versi terbaru setiap minggu.</li>
                    <li class="rounded-2xl bg-slate-50 px-4 py-3">2. Gunakan kata kunci yang sesuai pekerjaan.</li>
                </ul>
            </div>
        </aside>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">CV Profesional</p>
                    <h3 class="mt-3 text-xl font-semibold text-slate-950">Hirify Growth</h3>
                </div>
                <span class="rounded-2xl bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">PDF</span>
            </div>
            <p class="mt-4 text-sm text-slate-600">Resume lengkap dengan ringkasan karier dan pengalaman terbaik Anda.</p>
            <div class="mt-6 flex items-center justify-between">
                <span class="text-sm font-medium text-slate-900">Aktif sejak 2026</span>
                <button class="rounded-2xl bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700">Unduh</button>
            </div>
        </article>
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">CV Ringkas</p>
                    <h3 class="mt-3 text-xl font-semibold text-slate-950">ATS Friendly</h3>
                </div>
                <span class="rounded-2xl bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">ATS</span>
            </div>
            <p class="mt-4 text-sm text-slate-600">Desain format yang mudah terbaca sistem dan recruiter.</p>
            <div class="mt-6 flex items-center justify-between">
                <span class="text-sm font-medium text-slate-900">Rekomendasi</span>
                <button class="rounded-2xl bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700">Lihat</button>
            </div>
        </article>
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">CV Khusus</p>
                    <h3 class="mt-3 text-xl font-semibold text-slate-950">Lamaran Marketing</h3>
                </div>
                <span class="rounded-2xl bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">Draft</span>
            </div>
            <p class="mt-4 text-sm text-slate-600">Template khusus untuk posisi marketing dan business development.</p>
            <div class="mt-6 flex items-center justify-between">
                <span class="text-sm font-medium text-slate-900">Draf</span>
                <button class="rounded-2xl bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700">Edit</button>
            </div>
        </article>
    </div>
</div>
@endsection
