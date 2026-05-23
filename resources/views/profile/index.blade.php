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

                {{-- Portofolio Section --}}
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-950">Portofolio</h2>
                        <a href="{{ route('portofolio.index') }}" class="text-xs font-bold text-navy hover:underline">Kelola Portofolio</a>
                    </div>
                    @if($user->portofolios && $user->portofolios->count())
                        <div class="mt-4 grid gap-4 sm:grid-cols-2">
                            @foreach($user->portofolios->sortByDesc('created_at')->take(4) as $portfolio)
                                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4 flex flex-col justify-between hover:border-slate-200 transition-all">
                                    <div>
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase {{ $portfolio->type === 'project' ? 'bg-blue-50 text-blue-600 border border-blue-100' : 'bg-purple-50 text-purple-600 border border-purple-100' }}">
                                                {{ $portfolio->type === 'project' ? 'Proyek' : 'Sertifikat' }}
                                            </span>
                                            <span class="text-[10px] text-slate-400 font-medium">
                                                @if($portfolio->start_date)
                                                    {{ $portfolio->start_date->translatedFormat('M Y') }}
                                                @endif
                                            </span>
                                        </div>
                                        <h3 class="font-bold text-slate-900 text-sm line-clamp-1" title="{{ $portfolio->title }}">{{ $portfolio->title }}</h3>
                                        @if($portfolio->description)
                                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $portfolio->description }}</p>
                                        @endif
                                        
                                        @if($portfolio->skills)
                                            <div class="flex flex-wrap gap-1 mt-2">
                                                @foreach(array_slice(array_filter(array_map('trim', explode(',', $portfolio->skills))), 0, 3) as $skill)
                                                    <span class="px-1.5 py-0.5 bg-white text-slate-600 rounded text-[9px] font-semibold border border-slate-200">
                                                        {{ $skill }}
                                                    </span>
                                                @endforeach
                                                @if(count(array_filter(array_map('trim', explode(',', $portfolio->skills)))) > 3)
                                                    <span class="px-1.5 py-0.5 bg-white text-slate-400 rounded text-[9px] font-semibold border border-slate-100">
                                                        +{{ count(array_filter(array_map('trim', explode(',', $portfolio->skills)))) - 3 }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex items-center justify-between border-t border-slate-100 pt-3 mt-3">
                                        @if($portfolio->link)
                                            <a href="{{ $portfolio->link }}" target="_blank" rel="noopener noreferrer" class="text-xs font-semibold text-navy hover:underline inline-flex items-center gap-1">
                                                Lihat Link
                                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                                    <polyline points="15 3 21 3 21 9"></polyline>
                                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                                </svg>
                                            </a>
                                        @else
                                            <span></span>
                                        @endif
                                        
                                        @if($portfolio->file_path)
                                            <a href="{{ asset('storage/' . $portfolio->file_path) }}" download class="text-[10px] text-slate-400 hover:text-navy transition-colors inline-flex items-center gap-1">
                                                📁 Unduh File
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="mt-4 p-6 border-2 border-dashed border-slate-100 rounded-2xl text-center">
                            <p class="text-sm text-slate-500">Anda belum mengunggah hasil proyek atau sertifikat apa pun.</p>
                            <a href="{{ route('portofolio.create') }}" class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-white bg-slate-900 px-3.5 py-2 rounded-xl hover:bg-slate-800 transition-colors">
                                + Tambah Portofolio
                            </a>
                        </div>
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-slate-950">Skill</h2>
                    @if($profile?->skills && count($profile->skills))
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach($profile->skills as $skill)
                                <span class="rounded-full bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900">{{ $skill }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-3 text-sm text-slate-500">Skill akan tampil di sini setelah ditambahkan.</p>
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
