@extends('layouts.app')

@section('title', 'Manajemen CV — Hirify')

@section('content')
<div class="space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Manajemen CV</p>
            <h1 class="text-3xl font-semibold text-slate-950">CV Saya</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Kelola semua CV ATS yang telah Anda buat.</p>
        </div>
        <a href="{{ route('buat-cv-ats.create') }}"
            class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Buat CV Baru
        </a>
    </div>

    {{-- Success / Error Flash --}}
    @if(session('success'))
        <div class="px-5 py-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- CV List --}}
    @if($cvs->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-800 mb-1">Belum ada CV</h3>
            <p class="text-sm text-slate-500 mb-5">Buat CV ATS pertama Anda untuk memulai.</p>
            <a href="{{ route('buat-cv-ats.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 transition">
                Buat CV Sekarang
            </a>
        </div>
    @else
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @foreach($cvs as $cv)
                <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm hover:shadow-md transition flex flex-col gap-4">

                    {{-- CV Header --}}
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-slate-900 text-white font-bold text-sm">
                            {{ strtoupper(substr($cv->nama_lengkap, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-slate-900 text-sm truncate">{{ $cv->nama_lengkap }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ $cv->email }}</p>
                        </div>
                    </div>

                    {{-- CV Meta --}}
                    <div class="flex flex-wrap gap-2 text-xs">
                        @if($cv->educations->isNotEmpty())
                            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-slate-600">
                                {{ $cv->educations->count() }} Pendidikan
                            </span>
                        @endif
                        @if($cv->experiences->isNotEmpty())
                            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-slate-600">
                                {{ $cv->experiences->count() }} Pengalaman
                            </span>
                        @endif
                        @if($cv->skills->isNotEmpty())
                            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-slate-600">
                                {{ $cv->skills->count() }} Skills
                            </span>
                        @endif
                    </div>

                    {{-- Tanggal --}}
                    <p class="text-xs text-slate-400">Dibuat: {{ $cv->created_at->format('d M Y, H:i') }}</p>

                    {{-- Actions --}}
                    <div class="flex gap-2 mt-auto">
                        <a href="{{ route('cv.show', $cv->id) }}"
                            class="flex-1 text-center rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                            Lihat
                        </a>
                        <a href="{{ route('cv.download', $cv->id) }}"
                            class="flex-1 text-center rounded-xl bg-slate-900 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-700 transition">
                            Download PDF
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
