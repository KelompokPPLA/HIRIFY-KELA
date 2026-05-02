@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <a href="{{ route('profile') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-[#09C9D3]">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
                <span>Kembali</span>
            </a>
            <h1 class="mt-4 text-3xl font-semibold text-slate-950">Edit Profil</h1>
            <p class="mt-2 max-w-2xl text-sm text-slate-600">Perbarui informasi profil Anda dengan mudah, mulai dari data diri, pendidikan, pengalaman kerja, hingga skill.</p>
        </div>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="rounded-3xl border border-red-200 bg-red-50 p-4">
                <p class="font-semibold text-red-800">Terjadi kesalahan:</p>
                <ul class="mt-2 list-inside list-disc text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid gap-6 xl:grid-cols-[0.72fr_0.28fr]">
            <div class="space-y-6">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-slate-950">Data Diri</h2>
                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        <label class="space-y-2 text-sm">
                            <span class="font-medium text-slate-600">Nama Lengkap</span>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $profile?->nama_lengkap ?? '') }}" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-[#09C9D3] focus:ring-2 focus:ring-[#09C9D3]/15" />
                        </label>
                        <label class="space-y-2 text-sm">
                            <span class="font-medium text-slate-600">Email</span>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-[#09C9D3] focus:ring-2 focus:ring-[#09C9D3]/15" />
                        </label>
                        <label class="space-y-2 text-sm">
                            <span class="font-medium text-slate-600">Nomor Telepon</span>
                            <input type="text" name="telepon" value="{{ old('telepon', $profile?->telepon ?? '') }}" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-[#09C9D3] focus:ring-2 focus:ring-[#09C9D3]/15" />
                        </label>
                        <label class="space-y-2 text-sm">
                            <span class="font-medium text-slate-600">Tanggal Lahir</span>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $profile?->tanggal_lahir ?? '') }}" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-[#09C9D3] focus:ring-2 focus:ring-[#09C9D3]/15" />
                        </label>
                        <label class="space-y-2 text-sm sm:col-span-2">
                            <span class="font-medium text-slate-600">Alamat</span>
                            <textarea name="alamat" rows="3" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-[#09C9D3] focus:ring-2 focus:ring-[#09C9D3]/15">{{ old('alamat', $profile?->alamat ?? '') }}</textarea>
                        </label>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-slate-950">Pendidikan</h2>
                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        <label class="space-y-2 text-sm">
                            <span class="font-medium text-slate-600">Institusi</span>
                            <input type="text" name="institusi" value="{{ old('institusi', $profile?->institusi ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-[#09C9D3] focus:ring-2 focus:ring-[#09C9D3]/15" />
                        </label>
                        <label class="space-y-2 text-sm">
                            <span class="font-medium text-slate-600">Jurusan</span>
                            <input type="text" name="jurusan" value="{{ old('jurusan', $profile?->jurusan ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-[#09C9D3] focus:ring-2 focus:ring-[#09C9D3]/15" />
                        </label>
                        <label class="space-y-2 text-sm">
                            <span class="font-medium text-slate-600">IPK</span>
                            <input type="number" step="0.01" name="ipk" value="{{ old('ipk', $profile?->ipk ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-[#09C9D3] focus:ring-2 focus:ring-[#09C9D3]/15" />
                        </label>
                        <div></div>
                        <label class="space-y-2 text-sm">
                            <span class="font-medium text-slate-600">Tahun Mulai</span>
                            <input type="number" name="tahun_mulai_pendidikan" value="{{ old('tahun_mulai_pendidikan', $profile?->tahun_mulai_pendidikan ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-[#09C9D3] focus:ring-2 focus:ring-[#09C9D3]/15" />
                        </label>
                        <label class="space-y-2 text-sm">
                            <span class="font-medium text-slate-600">Tahun Selesai</span>
                            <input type="number" name="tahun_selesai_pendidikan" value="{{ old('tahun_selesai_pendidikan', $profile?->tahun_selesai_pendidikan ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-[#09C9D3] focus:ring-2 focus:ring-[#09C9D3]/15" />
                        </label>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-slate-950">Pengalaman</h2>
                    <div class="mt-5 grid gap-4">
                        <label class="space-y-2 text-sm">
                            <span class="font-medium text-slate-600">Posisi</span>
                            <input type="text" name="posisi_kerja" value="{{ old('posisi_kerja', $profile?->posisi_kerja ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-[#09C9D3] focus:ring-2 focus:ring-[#09C9D3]/15" />
                        </label>
                        <label class="space-y-2 text-sm">
                            <span class="font-medium text-slate-600">Perusahaan</span>
                            <input type="text" name="perusahaan" value="{{ old('perusahaan', $profile?->perusahaan ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-[#09C9D3] focus:ring-2 focus:ring-[#09C9D3]/15" />
                        </label>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <label class="space-y-2 text-sm">
                                <span class="font-medium text-slate-600">Periode Mulai</span>
                                <input type="text" name="periode_mulai_kerja" value="{{ old('periode_mulai_kerja', $profile?->periode_mulai_kerja ?? '') }}" placeholder="Juni 2022" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-[#09C9D3] focus:ring-2 focus:ring-[#09C9D3]/15" />
                            </label>
                            <label class="space-y-2 text-sm">
                                <span class="font-medium text-slate-600">Periode Selesai</span>
                                <input type="text" name="periode_selesai_kerja" value="{{ old('periode_selesai_kerja', $profile?->periode_selesai_kerja ?? '') }}" placeholder="Desember 2022" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-[#09C9D3] focus:ring-2 focus:ring-[#09C9D3]/15" />
                            </label>
                        </div>
                        <label class="space-y-2 text-sm">
                            <span class="font-medium text-slate-600">Deskripsi</span>
                            <textarea name="deskripsi_kerja" rows="4" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-[#09C9D3] focus:ring-2 focus:ring-[#09C9D3]/15">{{ old('deskripsi_kerja', $profile?->deskripsi_kerja ?? '') }}</textarea>
                        </label>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-slate-950">Skills</h2>
                    <div class="mt-5 grid gap-4">
                        <label class="space-y-2 text-sm">
                            <span class="font-medium text-slate-600">Skills (pisahkan dengan koma)</span>
                            <textarea name="skills" rows="3" placeholder="React, TypeScript, Tailwind CSS, Node.js" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-[#09C9D3] focus:ring-2 focus:ring-[#09C9D3]/15">{{ old('skills', $profile?->skills ?? '') }}</textarea>
                        </label>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="rounded-full bg-[#09C9D3] px-6 py-2.5 text-sm font-semibold text-white shadow-sm shadow-[#09C9D3]/20 transition hover:bg-[#08b4c0]">Simpan Perubahan</button>
                    <a href="{{ route('profile') }}" class="rounded-full border border-slate-200 bg-white px-6 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Batal</a>
                </div>
            </div>

            <aside class="space-y-6">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-950">Preview Profil</h3>
                    <div class="mt-6 rounded-3xl bg-gradient-to-br from-slate-950 to-slate-800 p-6 text-white shadow-lg">
                        <div class="flex items-center gap-4">
                            <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-[#09C9D3] text-2xl font-semibold">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}{{ strtoupper(substr(explode(' ', $user->name ?? 'User')[1] ?? '', 0, 1)) }}</div>
                            <div>
                                <p class="text-sm uppercase tracking-[0.24em] text-slate-300">{{ $user->name ?? 'User Name' }}</p>
                                <h4 class="mt-2 text-xl font-semibold">{{ $profile?->posisi_kerja ?? 'Frontend Developer' }}</h4>
                            </div>
                        </div>
                        <div class="mt-6 space-y-3">
                            <div class="rounded-3xl bg-white/10 p-4">
                                <p class="text-xs uppercase tracking-[0.18em] text-slate-300">Email</p>
                                <p class="mt-1 font-semibold">{{ $user->email }}</p>
                            </div>
                            <div class="rounded-3xl bg-white/10 p-4">
                                <p class="text-xs uppercase tracking-[0.18em] text-slate-300">Telepon</p>
                                <p class="mt-1 font-semibold">{{ $profile?->telepon ?? '+62 812 3456 7890' }}</p>
                            </div>
                            <div class="rounded-3xl bg-white/10 p-4">
                                <p class="text-xs uppercase tracking-[0.18em] text-slate-300">Lokasi</p>
                                <p class="mt-1 font-semibold">{{ explode(',', $profile?->alamat ?? 'Jakarta')[0] ?? 'Jakarta' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h4 class="text-lg font-semibold text-slate-950">Ringkasan</h4>
                    <div class="mt-5 space-y-4 text-sm text-slate-600">
                        @if ($profile?->institusi)
                            <div>
                                <p class="font-medium text-slate-700">Pendidikan</p>
                                <p>{{ $profile->institusi }} • {{ $profile->jurusan ?? '-' }} • IPK {{ $profile->ipk ?? '-' }}</p>
                            </div>
                        @endif
                        @if ($profile?->perusahaan)
                            <div>
                                <p class="font-medium text-slate-700">Pengalaman Terakhir</p>
                                <p>{{ $profile->posisi_kerja ?? '-' }} • {{ $profile->perusahaan }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                @if ($profile?->skills)
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h4 class="text-lg font-semibold text-slate-950">Skills</h4>
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach (explode(',', $profile->skills) as $skill)
                                <span class="rounded-full bg-[#09C9D3]/10 px-3 py-1 text-sm font-semibold text-[#09C9D3]">{{ trim($skill) }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>
        </div>
    </form>
</div>
@endsection