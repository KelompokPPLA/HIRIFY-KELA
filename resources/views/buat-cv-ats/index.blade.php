@extends('layouts.app')

@section('title', 'Buat CV ATS')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">CV ATS</p>
            <h1 class="text-3xl font-semibold text-slate-950">Buat CV ATS</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Buat CV yang mudah dibaca oleh sistem ATS dan memaksimalkan peluang lamaran Anda.</p>
        </div>
        <a href="{{ route('cv.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Mulai Buat CV
        </a>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.35fr_0.65fr]">
        <section class="rounded-2xl p-8 text-white shadow-lg" style="background: linear-gradient(135deg, #0b1021, #17253a);">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.24em] text-cyan-100/80">Template ATS</p>
                    <h2 class="mt-3 text-3xl font-semibold">Ciptakan CV yang Tepat</h2>
                </div>
                <span class="rounded-2xl bg-white/10 px-4 py-3 text-sm font-semibold text-white">Proses Cepat</span>
            </div>
            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                <div class="rounded-3xl bg-white/10 p-5">
                    <p class="text-sm text-cyan-100/80">Kesesuaian ATS</p>
                    <p class="mt-3 text-2xl font-semibold">100%</p>
                </div>
                <div class="rounded-3xl bg-white/10 p-5">
                    <p class="text-sm text-cyan-100/80">Template</p>
                    <p class="mt-3 text-2xl font-semibold">5+</p>
                </div>
                <div class="rounded-3xl bg-white/10 p-5">
                    <p class="text-sm text-cyan-100/80">Waktu</p>
                    <p class="mt-3 text-2xl font-semibold">10 menit</p>
                </div>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-950">Keunggulan CV ATS</h3>
                <ul class="mt-4 space-y-3 text-sm text-slate-600">
                    <li class="rounded-2xl bg-slate-50 px-4 py-3">Tata letak rapi sesuai standar perekrut.</li>
                    <li class="rounded-2xl bg-slate-50 px-4 py-3">Kata kunci otomatis disesuaikan.</li>
                    <li class="rounded-2xl bg-slate-50 px-4 py-3">Compatible dengan semua sistem rekrutmen.</li>
                </ul>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-950">Langkah Mudah</h3>
                <ol class="mt-4 space-y-3 text-sm text-slate-600">
                    <li class="rounded-2xl bg-slate-50 px-4 py-3">1. Masukkan data dan pengalaman.</li>
                    <li class="rounded-2xl bg-slate-50 px-4 py-3">2. Pilih template ATS.</li>
                    <li class="rounded-2xl bg-slate-50 px-4 py-3">3. Unduh CV profesional.</li>
                </ol>
            </div>
        </aside>
    </div>
</div>
@endsection
