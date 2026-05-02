@extends('layouts.app')

@section('title', 'Daftar CV - Hirify')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">CV ATS Saya</h1>
            <p class="text-slate-500 mt-1 text-sm">Kelola dan buat CV yang ramah sistem rekrutmen (ATS).</p>
        </div>
        <a href="{{ route('buat-cv-ats.create') }}"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white text-sm font-semibold rounded-xl hover:bg-slate-700 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat CV Baru
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl px-5 py-4">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- CV List --}}
    @if($cvs->isNotEmpty())
        <div class="grid gap-4">
            @foreach($cvs as $cv)
                <div class="bg-white rounded-2xl border border-slate-200 p-6 flex items-center gap-5 hover:shadow-md transition">
                    <div class="w-14 h-14 bg-slate-900 text-white rounded-2xl flex items-center justify-center text-xl font-black shrink-0">
                        {{ strtoupper(substr($cv->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-slate-900 text-base">{{ $cv->name }}</h3>
                        <p class="text-sm text-slate-500 truncate">{{ $cv->email }} • {{ $cv->phone }}</p>
                        <p class="text-xs text-slate-400 mt-1">
                            {{ $cv->educations->count() }} Pendidikan •
                            {{ $cv->experiences->count() }} Pengalaman •
                            {{ $cv->skills->count() }} Skills •
                            Dibuat {{ $cv->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('buat-cv-ats.show', $cv->id) }}"
                            class="px-4 py-2 bg-slate-100 text-slate-700 text-sm font-semibold rounded-xl hover:bg-slate-200 transition">
                            Lihat CV
                        </a>
                        <form method="POST" action="{{ route('buat-cv-ats.destroy', $cv->id) }}"
                            onsubmit="return confirm('Hapus CV ini?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 bg-red-50 text-red-600 text-sm font-semibold rounded-xl hover:bg-red-100 transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-slate-200">
            <div class="text-5xl mb-5">📄</div>
            <h3 class="text-lg font-semibold text-slate-800 mb-2">Belum Ada CV</h3>
            <p class="text-slate-400 text-sm mb-6">Buat CV ATS pertamamu dan tingkatkan peluang diterima kerja!</p>
            <a href="{{ route('buat-cv-ats.create') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white text-sm font-bold rounded-xl hover:bg-slate-700 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat CV Pertama
            </a>
        </div>
    @endif
</div>
@endsection