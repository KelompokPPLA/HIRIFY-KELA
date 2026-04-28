@extends('layouts.app')

@section('title', 'Mentorship')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Mentorship</p>
            <h1 class="text-3xl font-semibold text-slate-950">Mentorship</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Dapatkan arahan profesional dari mentor yang berpengalaman dan tingkatkan perkembangan karier Anda.</p>
        </div>
        <button class="inline-flex items-center rounded-2xl bg-[var(--color-primary)] px-4 py-2 text-sm font-semibold text-[var(--color-primary-foreground)] transition hover:bg-[var(--color-primary)]/90">Minta Bimbingan</button>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.35fr_0.65fr]">
        <section class="rounded-3xl bg-gradient-to-br from-[var(--color-primary)] to-[var(--color-secondary)] p-8 text-[var(--color-primary-foreground)] shadow-lg">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.24em] text-cyan-100/80">Mentor</p>
                    <h2 class="mt-3 text-3xl font-semibold">Temukan Mentor Tepat</h2>
                </div>
                <div class="rounded-3xl bg-white/10 px-4 py-3 text-sm font-semibold text-white">3 aktif</div>
            </div>
            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                <div class="rounded-3xl bg-white/10 p-5">
                    <p class="text-sm text-cyan-100/80">Bidang</p>
                    <p class="mt-3 text-2xl font-semibold">Karier</p>
                </div>
                <div class="rounded-3xl bg-white/10 p-5">
                    <p class="text-sm text-cyan-100/80">Rating</p>
                    <p class="mt-3 text-2xl font-semibold">4.8</p>
                </div>
                <div class="rounded-3xl bg-white/10 p-5">
                    <p class="text-sm text-cyan-100/80">Sesi</p>
                    <p class="mt-3 text-2xl font-semibold">12</p>
                </div>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-950">Keuntungan Mentor</h3>
                <ul class="mt-4 space-y-3 text-sm text-slate-600">
                    <li class="rounded-2xl bg-slate-50 px-4 py-3">Saran praktis untuk portfolio.</li>
                    <li class="rounded-2xl bg-slate-50 px-4 py-3">Umpan balik karier langsung.</li>
                    <li class="rounded-2xl bg-slate-50 px-4 py-3">Jadwal fleksibel online.</li>
                </ul>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-950">Cara Kerja</h3>
                <p class="mt-4 text-sm text-slate-600">Pilih mentor, atur sesi, dan terima ringkasan tindakan setelah setiap pertemuan.</p>
            </div>
        </aside>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Mentor</p>
                    <h3 class="mt-3 text-xl font-semibold text-slate-950">Aldi Pratama</h3>
                </div>
                <span class="rounded-2xl bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">Karier</span>
            </div>
            <p class="mt-4 text-sm text-slate-600">Berpengalaman dalam pengembangan karier digital selama 8 tahun.</p>
            <div class="mt-6 flex items-center justify-between">
                <span class="text-sm font-medium text-slate-900">Rating 4.9</span>
                <button class="rounded-2xl bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700">Pilih</button>
            </div>
        </article>
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Mentor</p>
                    <h3 class="mt-3 text-xl font-semibold text-slate-950">Sinta Rahma</h3>
                </div>
                <span class="rounded-2xl bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">CV</span>
            </div>
            <p class="mt-4 text-sm text-slate-600">Spesialis optimasi CV dan persiapan interview untuk startup.</p>
            <div class="mt-6 flex items-center justify-between">
                <span class="text-sm font-medium text-slate-900">Rating 4.8</span>
                <button class="rounded-2xl bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700">Pilih</button>
            </div>
        </article>
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Mentor</p>
                    <h3 class="mt-3 text-xl font-semibold text-slate-950">Nina Lestari</h3>
                </div>
                <span class="rounded-2xl bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">Strategi</span>
            </div>
            <p class="mt-4 text-sm text-slate-600">Ahli strategi pengembangan karier dan transition planning.</p>
            <div class="mt-6 flex items-center justify-between">
                <span class="text-sm font-medium text-slate-900">Rating 4.7</span>
                <button class="rounded-2xl bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700">Pilih</button>
            </div>
        </article>
    </div>
</div>
@endsection
