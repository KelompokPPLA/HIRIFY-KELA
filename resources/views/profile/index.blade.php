@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="space-y-8">
    @if (session('success'))
        <div class="rounded-3xl border border-[#09C9D3]/30 bg-[#09C9D3]/5 p-4 text-[#09C9D3]">
            <p class="font-semibold">✓ {{ session('success') }}</p>
        </div>
    @endif

    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Profil</p>
            <h1 class="text-3xl font-semibold text-slate-950">Profil Saya</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Lihat dan kelola data pribadi, pendidikan, dan pengalaman kerja Anda dalam satu halaman profil yang rapi.</p>
        </div>
        <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 whitespace-nowrap rounded-full bg-[#09C9D3] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#08b4c0]">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5Z"></path>
            </svg>
            Edit Profil
        </a>
    </div>

    <div class="grid gap-6 xl:grid-cols-[0.72fr_0.28fr]">
        <div class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Informasi Akun</p>
                        <h2 class="mt-2 text-2xl font-semibold text-slate-950">Detail Profil</h2>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-[#e5f9fb] px-4 py-2 text-sm font-semibold text-[#09C9D3]">Profil {{ $profile ? 'Lengkap' : 'Tidak Lengkap' }}</span>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <p class="text-sm font-medium text-slate-600">Nama Lengkap</p>
                        <p class="mt-2 text-base font-semibold text-slate-950">{{ $profile?->nama_lengkap ?? $user->name ?? 'Belum diisi' }}</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <p class="text-sm font-medium text-slate-600">Email</p>
                        <p class="mt-2 text-base font-semibold text-slate-950">{{ $user->email }}</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <p class="text-sm font-medium text-slate-600">Telepon</p>
                        <p class="mt-2 text-base font-semibold text-slate-950">{{ $profile?->telepon ?? 'Belum diisi' }}</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <p class="text-sm font-medium text-slate-600">Alamat</p>
                        <p class="mt-2 text-base font-semibold text-slate-950">{{ $profile?->alamat ?? 'Belum diisi' }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Informasi Pribadi</p>
                        <h3 class="mt-2 text-xl font-semibold text-slate-950">Data Diri</h3>
                    </div>
                </div>
                <div class="mt-6 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <p class="text-sm font-medium text-slate-600">Tanggal Lahir</p>
                        <p class="mt-2 text-base font-semibold text-slate-950">{{ $profile?->tanggal_lahir?->format('d F Y') ?? 'Belum diisi' }}</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <p class="text-sm font-medium text-slate-600">Usia</p>
                        <p class="mt-2 text-base font-semibold text-slate-950">{{ $profile && $profile->tanggal_lahir ? \Carbon\Carbon::parse($profile->tanggal_lahir)->age : '-' }} Tahun</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <p class="text-sm font-medium text-slate-600">Jenis Kelamin</p>
                        <p class="mt-2 text-base font-semibold text-slate-950">-</p>
                    </div>
                </div>
            </div>

            @if ($profile?->institusi)
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h3 class="text-xl font-semibold text-slate-950">Pendidikan</h3>
                    <div class="mt-6 space-y-4">
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-sm font-medium text-slate-600">Universitas</p>
                            <p class="mt-2 text-base font-semibold text-slate-950">{{ $profile->institusi }}</p>
                            <p class="mt-1 text-sm text-slate-600">{{ $profile->jurusan }} • {{ $profile->tahun_mulai_pendidikan }} - {{ $profile->tahun_selesai_pendidikan }}</p>
                            @if ($profile->ipk)
                                <p class="mt-3 inline-flex items-center gap-2 rounded-full bg-[#e5f9fb] px-3 py-1 text-sm font-semibold text-[#09C9D3]">IPK {{ $profile->ipk }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h3 class="text-xl font-semibold text-slate-950">Pendidikan</h3>
                    <p class="mt-4 text-slate-600">Belum diisi. <a href="{{ route('profile.edit') }}" class="font-semibold text-[#09C9D3] hover:underline">Tambahkan sekarang</a></p>
                </div>
            @endif

            @if ($profile?->perusahaan)
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h3 class="text-xl font-semibold text-slate-950">Pengalaman Kerja</h3>
                    <div class="mt-6 rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <p class="text-sm font-medium text-slate-600">{{ $profile->posisi_kerja }}</p>
                        <p class="mt-2 text-base font-semibold text-slate-950">{{ $profile->perusahaan }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ $profile->periode_mulai_kerja }} - {{ $profile->periode_selesai_kerja }}</p>
                        @if ($profile->deskripsi_kerja)
                            <p class="mt-3 text-sm leading-6 text-slate-700">{{ $profile->deskripsi_kerja }}</p>
                        @endif
                    </div>
                </div>
            @else
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h3 class="text-xl font-semibold text-slate-950">Pengalaman Kerja</h3>
                    <p class="mt-4 text-slate-600">Belum diisi. <a href="{{ route('profile.edit') }}" class="font-semibold text-[#09C9D3] hover:underline">Tambahkan sekarang</a></p>
                </div>
            @endif
        </div>

        <aside class="space-y-6">
            <div class="rounded-3xl bg-slate-950 p-6 text-white shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-[#09C9D3] text-xl font-semibold">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}{{ strtoupper(substr(explode(' ', $user->name ?? 'User')[1] ?? '', 0, 1)) }}</div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Nama Pengguna</p>
                        <h3 class="mt-2 text-xl font-semibold text-slate-950">{{ $user->name ?? 'User Name' }}</h3>
                        <p class="mt-1 text-sm text-slate-950">{{ $profile?->posisi_kerja ?? 'Belum diisi' }}</p>
                    </div>
                </div>
                <div class="mt-6 space-y-3">
                    <div class="rounded-3xl bg-white/10 p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Email</p>
                        <p class="mt-1 font-semibold text-slate-950">{{ $user->email }}</p>
                    </div>
                    <div class="rounded-3xl bg-white/10 p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Telepon</p>
                        <p class="mt-1 font-semibold text-slate-950">{{ $profile?->telepon ?? 'Belum diisi' }}</p>
                    </div>
                    <div class="rounded-3xl bg-white/10 p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Lokasi</p>
                        <p class="mt-1 font-semibold text-slate-950">{{ explode(',', $profile?->alamat ?? 'Belum diisi')[0] ?? 'Belum diisi' }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Skills</p>
                        <h3 class="mt-2 text-lg font-semibold text-slate-950">Keahlian</h3>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="rounded-2xl border border-[#09C9D3] bg-[#09C9D3]/10 px-3 py-2 text-xs font-semibold text-[#09C9D3] transition hover:bg-[#09C9D3]/20">Edit</a>
                </div>
                @if ($profile?->skills)
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach (explode(',', $profile->skills) as $skill)
                            <span class="rounded-2xl bg-[#09C9D3]/10 px-3 py-1 text-sm font-semibold text-[#09C9D3]">{{ trim($skill) }}</span>
                        @endforeach
                    </div>
                @else
                    <p class="mt-4 text-sm text-slate-600">Belum ada skills. <a href="{{ route('profile.edit') }}" class="font-semibold text-[#09C9D3] hover:underline">Tambahkan sekarang</a></p>
                @endif
            </div>
        </aside>
    </div>
</div>
@endsection
