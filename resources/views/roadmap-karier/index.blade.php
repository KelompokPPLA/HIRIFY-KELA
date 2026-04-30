@extends('layouts.app')

@section('title', 'Roadmap Karier')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Roadmap</p>
            <h1 class="text-3xl font-semibold text-slate-950">Roadmap Karier</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Rencanakan langkah karier Anda dengan panduan yang disusun untuk setiap fase perkembangan profesional.</p>
        </div>
        <button class="inline-flex items-center rounded-2xl bg-[var(--color-primary)] px-4 py-2 text-sm font-semibold text-[var(--color-primary-foreground)] transition hover:bg-[var(--color-primary)]/90">Lihat Rencana Saya</button>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.35fr_0.65fr]">
        <section class="rounded-3xl bg-gradient-to-br from-[var(--color-primary)] to-[var(--color-secondary)] p-8 text-[var(--color-primary-foreground)] shadow-lg">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.24em] text-cyan-100/80">Perencanaan</p>
                    <h2 class="mt-3 text-3xl font-semibold">Langkah Karier Anda</h2>
                </div>
                <div class="rounded-3xl bg-white/10 px-4 py-3 text-sm font-semibold text-white">Fase 3 dari 5</div>
            </div>
            <div class="mt-8 space-y-4">
                <div class="rounded-3xl bg-white/10 p-5">
                    <p class="text-sm text-cyan-100/80">Analisis Keterampilan</p>
                    <p class="mt-2 text-2xl font-semibold">Kemampuan komunikasi, desain, dan pemrograman.</p>
                </div>
                <div class="rounded-3xl bg-white/10 p-5">
                    <p class="text-sm text-cyan-100/80">Target Pekerjaan</p>
                    <p class="mt-2 text-2xl font-semibold">UI/UX Designer, Frontend Developer.</p>
                </div>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-950">Progress Anda</h3>
                <div class="mt-6 space-y-4">
                    <div>
                        <div class="mb-2 flex items-center justify-between text-sm text-slate-500">
                            <span>Meningkatkan skill</span>
                            <span>70%</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-100">
                            <div class="h-2 w-7/10 rounded-full bg-[var(--color-primary)]"></div>
                        </div>
                    </div>
                    <div>
                        <div class="mb-2 flex items-center justify-between text-sm text-slate-500">
                            <span>Menyusun portfolio</span>
                            <span>45%</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-100">
                            <div class="h-2 w-1/2 rounded-full bg-[var(--color-primary)]"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-950">Rekomendasi</h3>
                <p class="mt-4 text-sm text-slate-600">Pelatihan desain dan sesi mentorship akan membantu Anda mencapai target karier lebih cepat.</p>
            </div>
        </aside>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold text-slate-950">Milestone Karier</h2>
        <div class="mt-6 space-y-5">
            <div class="flex items-start gap-4">
                <div class="mt-1 h-3 w-3 rounded-full bg-[var(--color-primary)]"></div>
                <div>
                    <p class="font-semibold text-slate-950">Bangun portofolio profesional</p>
                    <p class="mt-2 text-sm text-slate-600">Selesaikan 3 proyek portofolio dengan deskripsi hasil kerja yang jelas.</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="mt-1 h-3 w-3 rounded-full bg-slate-300"></div>
                <div>
                    <p class="font-semibold text-slate-950">Pelajari teknik wawancara</p>
                    <p class="mt-2 text-sm text-slate-600">Ikuti latihan wawancara dan siapkan jawaban untuk studi kasus nyata.</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="mt-1 h-3 w-3 rounded-full bg-slate-300"></div>
                <div>
                    <p class="font-semibold text-slate-950">Optimalkan LinkedIn</p>
                    <p class="mt-2 text-sm text-slate-600">Perbarui profil Anda dengan kata kunci yang tepat dan pengalaman terbaru.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
