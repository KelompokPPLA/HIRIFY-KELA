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

    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between mb-8">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Profil</p>
                <h1 class="text-3xl font-semibold text-slate-950">Profil Saya</h1>
                <p class="mt-2 text-sm text-slate-600 max-w-2xl">Lihat data pribadi Anda. Klik Edit Profile untuk memperbarui informasi.</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">Edit Profile</a>
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
                        <div class="space-y-2 text-sm">
                            <span class="text-slate-600">Nama Lengkap</span>
                            <div class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900">{{ $user->name }}</div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <span class="text-slate-600">Email</span>
                            <div class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900">{{ $user->email }}</div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <span class="text-slate-600">Telepon</span>
                            <div class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900">{{ $profile?->phone ?? '-' }}</div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <span class="text-slate-600">Lokasi</span>
                            <div class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900">{{ $profile?->location ?? '-' }}</div>
                        </div>
                        <div class="space-y-2 text-sm sm:col-span-2">
                            <span class="text-slate-600">Bio</span>
                            <div class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 min-h-[80px]">{{ $profile?->bio ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-slate-950">Pendidikan</h2>
                    @if($profile?->education && count($profile->education))
                        <div class="mt-4 space-y-3 text-sm text-slate-700">
                            @foreach($profile->education as $edu)
                                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                                    <div class="font-semibold text-slate-900">{{ $edu['gelar'] ?? '-' }} — {{ $edu['institusi'] ?? '-' }}</div>
                                    <div class="text-slate-500">{{ $edu['tahun'] ?? '-' }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-3 text-sm text-slate-500">Informasi pendidikan akan segera tersedia di versi berikutnya.</p>
                    @endif
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-slate-950">Pengalaman Kerja</h2>
                    @if($profile?->experience && count($profile->experience))
                        <div class="mt-4 space-y-3 text-sm text-slate-700">
                            @foreach($profile->experience as $exp)
                                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                                    <div class="font-semibold text-slate-900">{{ $exp['posisi'] ?? '-' }} — {{ $exp['perusahaan'] ?? '-' }}</div>
                                    <div class="text-slate-500">{{ $exp['periode'] ?? '-' }}</div>
                                    @if(!empty($exp['deskripsi']))
                                        <p class="mt-2 text-slate-600">{{ $exp['deskripsi'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-3 text-sm text-slate-500">Informasi pengalaman kerja akan segera tersedia di versi berikutnya.</p>
                    @endif
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
    </div>
</div>
@endsection
