@extends('layouts.app')

@section('title', 'Self Assessment')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Evaluasi</p>
            <h1 class="text-3xl font-semibold text-slate-950">Self Assessment</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Nilai kesiapan karier Anda dengan rangkaian pertanyaan dan hasil analisis otomatis.</p>
        </div>
        <button class="inline-flex items-center rounded-2xl bg-[var(--color-primary)] px-4 py-2 text-sm font-semibold text-[var(--color-primary-foreground)] transition hover:bg-[var(--color-primary)]/90">Mulai Penilaian</button>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.35fr_0.65fr]">
        <section class="rounded-3xl bg-gradient-to-br from-[var(--color-primary)] to-[var(--color-secondary)] p-8 text-[var(--color-primary-foreground)] shadow-lg">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.24em] text-cyan-100/80">Hasil</p>
                    <h2 class="mt-3 text-3xl font-semibold">Skor Kesiapan Anda</h2>
                </div>
                <div class="rounded-3xl bg-white/10 px-4 py-3 text-sm font-semibold text-white">Tingkat Menengah</div>
            </div>
            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                <div class="rounded-3xl bg-white/10 p-5">
                    <p class="text-sm text-cyan-100/80">Kompetensi</p>
                    <p class="mt-3 text-2xl font-semibold">68%</p>
                </div>
                <div class="rounded-3xl bg-white/10 p-5">
                    <p class="text-sm text-cyan-100/80">Kesiapan</p>
                    <p class="mt-3 text-2xl font-semibold">72%</p>
                </div>
                <div class="rounded-3xl bg-white/10 p-5">
                    <p class="text-sm text-cyan-100/80">Rekomendasi</p>
                    <p class="mt-3 text-2xl font-semibold">3 langkah</p>
                </div>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-950">Area Evaluasi</h3>
                <div class="mt-5 space-y-4 text-sm text-slate-600">
                    <div class="rounded-3xl bg-slate-50 px-4 py-3">Keterampilan teknis</div>
                    <div class="rounded-3xl bg-slate-50 px-4 py-3">Soft skills</div>
                    <div class="rounded-3xl bg-slate-50 px-4 py-3">Persiapan wawancara</div>
                </div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-950">Saran Tindakan</h3>
                <ul class="mt-4 space-y-3 text-sm text-slate-600">
                    <li class="rounded-2xl bg-slate-50 px-4 py-3">Tingkatkan skill melalui pelatihan.</li>
                    <li class="rounded-2xl bg-slate-50 px-4 py-3">Siapkan portofolio terbaru.</li>
                </ul>
            </div>
        </aside>
    </div>
</div>
@endsection
