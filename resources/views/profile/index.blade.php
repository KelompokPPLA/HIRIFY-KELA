@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="space-y-8">
    @if(session('success'))
    <div class="rounded-2xl bg-emerald-50 border border-emerald-200 px-5 py-3 text-sm font-medium text-emerald-700">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="rounded-2xl bg-red-50 border border-red-200 px-5 py-3 text-sm font-medium text-red-700">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf

        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between mb-8">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Profil</p>
                <h1 class="text-3xl font-semibold text-slate-950">Profil Saya</h1>
                <p class="mt-2 text-sm text-slate-600 max-w-2xl">Perbarui data pribadi, pendidikan, dan pengalaman Anda untuk memperkuat profil karier.</p>
            </div>
            <button type="submit" class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">Simpan Perubahan</button>
        </div>

        <div class="grid gap-6 xl:grid-cols-[0.72fr_0.28fr]">
            <div class="space-y-6">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Akun</p>
                            <h2 class="mt-2 text-xl font-semibold text-slate-950">Informasi Diri</h2>
                        </div>
                        <span class="rounded-2xl bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700">{{ ucfirst($user->role) }}</span>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <label class="space-y-2 text-sm">
                            <span class="text-slate-600">Nama Lengkap</span>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/10" required />
                        </label>
                        <label class="space-y-2 text-sm">
                            <span class="text-slate-600">Email</span>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/10" required />
                        </label>
                        <label class="space-y-2 text-sm">
                            <span class="text-slate-600">Telepon</span>
                            <input type="text" name="phone" value="{{ old('phone', $profile?->phone ?? '') }}"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/10" />
                        </label>
                        <label class="space-y-2 text-sm">
                            <span class="text-slate-600">Lokasi</span>
                            <input type="text" name="location" value="{{ old('location', $profile?->location ?? '') }}"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/10" />
                        </label>
                        <label class="space-y-2 text-sm sm:col-span-2">
                            <span class="text-slate-600">Bio</span>
                            <textarea name="bio" rows="3"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/10 resize-none">{{ old('bio', $profile?->bio ?? '') }}</textarea>
                        </label>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-slate-950">Pendidikan</h2>
                    <p class="mt-3 text-sm text-slate-500">Informasi pendidikan akan segera tersedia di versi berikutnya.</p>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-slate-950">Pengalaman Kerja</h2>
                    <p class="mt-3 text-sm text-slate-500">Informasi pengalaman kerja akan segera tersedia di versi berikutnya.</p>
                </div>
            </div>

            <aside class="space-y-6">
                <div class="rounded-3xl bg-gradient-to-br from-slate-950 to-slate-800 p-6 text-white shadow-lg">
                    <div class="flex items-center gap-4">
                        <div class="grid h-16 w-16 place-items-center rounded-3xl bg-white/10 text-2xl font-semibold">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div>
                            <p class="text-sm uppercase tracking-[0.24em] text-slate-300">Akun</p>
                            <h3 class="mt-2 text-xl font-semibold">{{ $user->name }}</h3>
                            <p class="mt-1 text-sm text-slate-300">{{ ucfirst($user->role) }}</p>
                        </div>
                    </div>
                    <div class="mt-6 space-y-3">
                        <div class="rounded-3xl bg-white/10 p-4">
                            <p class="text-xs text-slate-300">Email</p>
                            <p class="mt-1 font-medium">{{ $user->email }}</p>
                        </div>
                        <div class="rounded-3xl bg-white/10 p-4">
                            <p class="text-xs text-slate-300">Telepon</p>
                            <p class="mt-1 font-medium">{{ $profile?->phone ?? '-' }}</p>
                        </div>
                        <div class="rounded-3xl bg-white/10 p-4">
                            <p class="text-xs text-slate-300">Lokasi</p>
                            <p class="mt-1 font-medium">{{ $profile?->location ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-950">Status Akun</h3>
                    <div class="mt-4 space-y-3">
                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                            <span class="text-sm text-slate-600">Role</span>
                            <span class="text-sm font-semibold text-slate-900">{{ ucfirst($user->role) }}</span>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                            <span class="text-sm text-slate-600">Status</span>
                            <span class="text-sm font-semibold text-emerald-600">Aktif</span>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                            <span class="text-sm text-slate-600">Bergabung</span>
                            <span class="text-sm font-semibold text-slate-900">{{ $user->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </form>
</div>
@endsection
