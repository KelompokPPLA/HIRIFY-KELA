@extends('layouts.app')

@section('title', $job->title . ' - ' . $job->company_name)

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">

    <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-cyan-600 mb-6 transition">
        ← Kembali ke daftar lowongan
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Header --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center text-2xl font-bold text-gray-600">
                        {{ strtoupper(substr($job->company_name, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-extrabold text-gray-900">{{ $job->title }}</h1>
                        <p class="text-gray-500 font-medium">{{ $job->company_name }}</p>
                    </div>
                </div>

                {{-- Match Score --}}
                @if($matchScore > 0)
                <div class="bg-green-50 border border-green-200 rounded-xl px-4 py-3 mb-4">
                    <p class="text-sm font-semibold text-green-700">
                        ✅ {{ $matchScore }}% skill Anda cocok dengan lowongan ini
                    </p>
                </div>
                @endif

                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="bg-cyan-50 text-cyan-700 text-sm font-medium px-3 py-1 rounded-full border border-cyan-100">{{ $job->job_type_label }}</span>
                    <span class="bg-blue-50 text-blue-700 text-sm font-medium px-3 py-1 rounded-full border border-blue-100">{{ $job->level_label }}</span>
                    <span class="bg-gray-50 text-gray-600 text-sm font-medium px-3 py-1 rounded-full border border-gray-100">📍 {{ $job->location }}</span>
                    <span class="bg-purple-50 text-purple-700 text-sm font-medium px-3 py-1 rounded-full border border-purple-100">{{ $job->category }}</span>
                </div>

                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <span class="text-green-600 font-semibold">💰 {{ $job->salary_label }}</span>
                    @if($job->deadline)
                        <span>⏰ Deadline: {{ $job->deadline->format('d M Y') }}</span>
                    @endif
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900 mb-3">Deskripsi Pekerjaan</h2>
                <div class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">{{ $job->description }}</div>
            </div>

            {{-- Requirements --}}
            @if($job->requirements)
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900 mb-3">Kualifikasi & Persyaratan</h2>
                <div class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">{{ $job->requirements }}</div>
            </div>
            @endif

            {{-- Skills --}}
            @if($job->skills->isNotEmpty())
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900 mb-3">Skill yang Dibutuhkan</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($job->skills as $skill)
                        <span class="bg-cyan-50 text-cyan-700 text-sm px-3 py-1.5 rounded-full border border-cyan-100 font-medium">
                            {{ $skill->skill_name }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-5">
            {{-- Apply --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm sticky top-6">
                <h3 class="font-bold text-gray-900 mb-3">Lamar Sekarang</h3>
                @if($job->apply_url)
                    <a href="{{ $job->apply_url }}" target="_blank" rel="noopener noreferrer"
                       class="block w-full text-center bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-3 rounded-xl transition">
                        Lamar Sekarang →
                    </a>
                @else
                    <p class="text-sm text-gray-500 text-center">Silakan hubungi perusahaan langsung.</p>
                @endif
                @if($job->deadline)
                    <p class="text-xs text-center text-gray-400 mt-3">Batas lamaran: {{ $job->deadline->format('d M Y') }}</p>
                @endif
            </div>

            {{-- Lowongan Serupa --}}
            @if($similar->isNotEmpty())
            <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
                <h3 class="font-bold text-gray-900 mb-3">Lowongan Serupa</h3>
                <div class="space-y-3">
                    @foreach($similar as $s)
                    <a href="{{ route('jobs.show', $s->id) }}" class="block hover:bg-gray-50 rounded-xl p-2 transition">
                        <p class="font-semibold text-sm text-gray-800">{{ $s->title }}</p>
                        <p class="text-xs text-gray-500">{{ $s->company_name }} · {{ $s->location }}</p>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
