@extends('layouts.app')

@section('title', 'Lowongan Kerja')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Lowongan Kerja</h1>
        <p class="text-gray-500 mt-1">Temukan lowongan yang sesuai dengan profil dan skill Anda.</p>
    </div>

    {{-- Rekomendasi --}}
    @if($recommended->isNotEmpty())
    <div class="mb-10">
        <h2 class="text-lg font-bold text-gray-800 mb-4">⭐ Direkomendasikan untuk Anda</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($recommended as $job)
                <a href="{{ route('jobs.show', $job->id) }}" class="block bg-cyan-50 border border-cyan-200 rounded-2xl p-5 hover:shadow-md transition">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-xl bg-cyan-100 flex items-center justify-center text-lg font-bold text-cyan-700">
                            {{ strtoupper(substr($job->company_name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 text-sm">{{ $job->title }}</p>
                            <p class="text-xs text-gray-500">{{ $job->company_name }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-1 mt-2">
                        <span class="text-xs bg-white border border-cyan-200 text-cyan-700 px-2 py-0.5 rounded-full">{{ $job->job_type_label }}</span>
                        <span class="text-xs bg-white border border-gray-200 text-gray-600 px-2 py-0.5 rounded-full">{{ $job->location }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Filter & Search --}}
    <form method="GET" action="{{ route('jobs.index') }}" class="bg-white border border-gray-200 rounded-2xl p-5 mb-8 shadow-sm">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div class="lg:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari posisi, perusahaan..." class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
            </div>
            <select name="category" class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                <option value="">Semua Bidang</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" @selected(request('category') === $cat)>{{ $cat }}</option>
                @endforeach
            </select>
            <select name="level" class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                <option value="">Semua Level</option>
                <option value="entry" @selected(request('level') === 'entry')>Fresh Graduate</option>
                <option value="mid" @selected(request('level') === 'mid')>Mid-level</option>
                <option value="senior" @selected(request('level') === 'senior')>Senior</option>
                <option value="lead" @selected(request('level') === 'lead')>Lead / Manager</option>
            </select>
            <select name="job_type" class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                <option value="">Semua Tipe</option>
                <option value="full-time" @selected(request('job_type') === 'full-time')>Full-time</option>
                <option value="part-time" @selected(request('job_type') === 'part-time')>Part-time</option>
                <option value="internship" @selected(request('job_type') === 'internship')>Magang</option>
                <option value="remote" @selected(request('job_type') === 'remote')>Remote</option>
                <option value="contract" @selected(request('job_type') === 'contract')>Kontrak</option>
            </select>
        </div>
        <div class="flex gap-2 mt-3">
            <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 text-white text-sm font-semibold px-5 py-2 rounded-xl transition">Cari</button>
            @if(request()->hasAny(['search','category','level','job_type','location']))
                <a href="{{ route('jobs.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-5 py-2 rounded-xl transition">Reset</a>
            @endif
        </div>
    </form>

    {{-- Hasil --}}
    <div class="flex items-center justify-between mb-4">
        <p class="text-sm text-gray-500">
            {{ $jobs->total() }} lowongan ditemukan
            @if(request()->hasAny(['search','category','level','job_type','location']))
                <span class="text-gray-400">dari {{ $totalJobs }} total</span>
            @endif
        </p>
        <p class="text-xs text-gray-400">Hanya menampilkan lowongan aktif & belum expired</p>
    </div>

    @if($jobs->isEmpty())
        <div class="text-center py-20 text-gray-400">
            <div class="text-5xl mb-4">🔍</div>
            <p class="font-semibold text-lg">Tidak ada lowongan yang ditemukan.</p>
            <p class="text-sm mt-1">Coba ubah filter atau kata kunci pencarian.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach($jobs as $job)
                <a href="{{ route('jobs.show', $job->id) }}" class="block bg-white border border-gray-200 rounded-2xl p-5 hover:shadow-lg hover:border-cyan-300 transition group">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center text-xl font-bold text-gray-600 group-hover:bg-cyan-50 transition">
                            {{ strtoupper(substr($job->company_name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-900 truncate">{{ $job->title }}</p>
                            <p class="text-sm text-gray-500 truncate">{{ $job->company_name }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-1.5 mb-3">
                        <span class="text-xs font-medium bg-cyan-50 text-cyan-700 px-2.5 py-1 rounded-full border border-cyan-100">{{ $job->job_type_label }}</span>
                        <span class="text-xs font-medium bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full border border-blue-100">{{ $job->level_label }}</span>
                        <span class="text-xs font-medium bg-gray-50 text-gray-600 px-2.5 py-1 rounded-full border border-gray-100">📍 {{ $job->location }}</span>
                    </div>
                    <p class="text-xs text-gray-400 line-clamp-2">{{ $job->description }}</p>
                    <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs text-green-600 font-semibold">{{ $job->salary_label }}</span>
                        @if($job->deadline)
                            <span class="text-xs text-gray-400">Deadline: {{ $job->deadline->format('d M Y') }}</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $jobs->links() }}
        </div>
    @endif
</div>
@endsection
