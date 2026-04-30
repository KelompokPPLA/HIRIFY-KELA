@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Profil</p>
            <h1 class="text-3xl font-semibold text-slate-950">Profil Saya</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Perbarui data pribadi, pendidikan, dan pengalaman Anda untuk memperkuat profil karier.</p>
        </div>
        <button class="inline-flex items-center rounded-2xl bg-[var(--color-primary)] px-4 py-2 text-sm font-semibold text-[var(--color-primary-foreground)] transition hover:bg-[var(--color-primary)]/90">Simpan Perubahan</button>
    </div>

    <div class="grid gap-6 xl:grid-cols-[0.72fr_0.28fr]">
        <div class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Akun</p>
                        <h2 class="mt-2 text-xl font-semibold text-slate-950">Informasi Diri</h2>
                    </div>
                    <span class="rounded-2xl bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700">Profil Lengkap 75%</span>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <label class="space-y-2 text-sm">
                        <span class="text-slate-600">Nama Lengkap</span>
                        <input type="text" value="John Doe" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-[var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]/10" />
                    </label>
                    <label class="space-y-2 text-sm">
                        <span class="text-slate-600">Email</span>
                        <input type="email" value="john@mail.com" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-[var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]/10" />
                    </label>
                    <label class="space-y-2 text-sm">
                        <span class="text-slate-600">Telepon</span>
                        <input type="text" value="+62 812 0000" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-[var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]/10" />
                    </label>
                    <label class="space-y-2 text-sm">
                        <span class="text-slate-600">Lokasi</span>
                        <input type="text" value="Jakarta, Indonesia" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-[var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]/10" />
                    </label>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-950">Pendidikan</h2>
                <div class="mt-5 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-sm font-medium text-slate-600">Institusi</p>
                        <p class="mt-2 text-base font-semibold text-slate-950">Universitas Indonesia</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-sm font-medium text-slate-600">Program Studi</p>
                        <p class="mt-2 text-base font-semibold text-slate-950">Informatika</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-sm font-medium text-slate-600">IPK</p>
                        <p class="mt-2 text-base font-semibold text-slate-950">3.8</p>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-950">Pengalaman Kerja</h2>
                <div class="mt-5 space-y-4">
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-sm text-slate-500">Frontend Developer</p>
                        <p class="mt-2 text-sm text-slate-600">Startup XYZ • 2023 - Sekarang</p>
                    </div>
                </div>
            </div>
        </div>

        <aside class="space-y-6">
            <div class="rounded-3xl bg-gradient-to-br from-slate-950 to-slate-800 p-6 text-white shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="grid h-16 w-16 place-items-center rounded-3xl bg-white/10 text-2xl font-semibold">JD</div>
                    <div>
                        <p class="text-sm uppercase tracking-[0.24em] text-slate-300">Akun</p>
                        <h3 class="mt-2 text-xl font-semibold">John Doe</h3>
                        <p class="mt-1 text-sm text-slate-300">Frontend Developer</p>
                    </div>
                </div>
                <div class="mt-6 space-y-3">
                    <div class="rounded-3xl bg-white/10 p-4">
                        <p class="text-xs text-slate-300">Email</p>
                        <p class="mt-1 font-medium">john@mail.com</p>
                    </div>
                    <div class="rounded-3xl bg-white/10 p-4">
                        <p class="text-xs text-slate-300">Status</p>
                        <p class="mt-1 font-medium">Aktif</p>
                    </div>
                </div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-950">Skill Populer</h3>
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="rounded-2xl bg-slate-100 px-3 py-1 text-sm font-medium text-slate-700">Vue</span>
                    <span class="rounded-2xl bg-slate-100 px-3 py-1 text-sm font-medium text-slate-700">Laravel</span>
                    <span class="rounded-2xl bg-slate-100 px-3 py-1 text-sm font-medium text-slate-700">MySQL</span>
                    <span class="rounded-2xl bg-slate-100 px-3 py-1 text-sm font-medium text-slate-700">Figma</span>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection