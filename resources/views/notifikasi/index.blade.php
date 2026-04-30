@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Notifikasi</p>
            <h1 class="text-3xl font-semibold text-slate-950">Notifikasi</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Kelola semua pemberitahuan penting terkait akun Anda dalam satu tempat.</p>
        </div>
        <button class="inline-flex items-center rounded-2xl bg-[var(--color-primary)] px-4 py-2 text-sm font-semibold text-[var(--color-primary-foreground)] transition hover:bg-[var(--color-primary)]/90">Tandai Semua Dibaca</button>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-5">
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold text-slate-950">Sesi mentorship baru tersedia</p>
                        <p class="mt-2 text-sm text-slate-600">Mentor menemukan slot waktu baru minggu ini.</p>
                    </div>
                    <span class="rounded-2xl bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">Baru</span>
                </div>
                <p class="mt-3 text-xs text-slate-500">10 menit lalu</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold text-slate-950">CV Anda telah diperbarui</p>
                        <p class="mt-2 text-sm text-slate-600">Versi terbaru CV berhasil disimpan.</p>
                    </div>
                    <span class="rounded-2xl bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Sukses</span>
                </div>
                <p class="mt-3 text-xs text-slate-500">1 jam lalu</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold text-slate-950">Disarankan: Ikuti modul karier</p>
                        <p class="mt-2 text-sm text-slate-600">Tingkatkan peluang Anda dengan pelatihan terbaru.</p>
                    </div>
                    <span class="rounded-2xl bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">Info</span>
                </div>
                <p class="mt-3 text-xs text-slate-500">Kemarin</p>
            </div>
        </div>
    </div>
</div>
@endsection
