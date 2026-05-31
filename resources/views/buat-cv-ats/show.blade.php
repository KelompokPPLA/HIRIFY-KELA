@extends('layouts.app')

@section('title', 'Preview CV — Hirify')

@section('content')
<div class="max-w-[860px] mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('cv.index') }}" class="text-slate-400 hover:text-slate-700 transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-slate-900">Preview CV ATS</h1>
                <p class="text-slate-400 text-sm">{{ $cv->nama_lengkap }}</p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('cv.download', $cv->id) }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white text-sm font-semibold rounded-xl hover:bg-slate-700 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Download PDF
            </a>
            <button onclick="window.print()"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl hover:bg-slate-50 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    {{-- CV Document --}}
    <div id="cv-print-area" class="bg-white border border-slate-200 shadow-lg rounded-2xl overflow-hidden">
        <div class="max-w-[800px] mx-auto px-12 py-10 font-serif text-[13.5px] leading-relaxed text-slate-900 break-words">

            {{-- Name --}}
            <h2 class="text-3xl font-extrabold text-center uppercase tracking-wide mb-1">{{ $cv->nama_lengkap }}</h2>

            {{-- Contact --}}
            @php
                $contacts = array_filter([$cv->email, $cv->telepon, $cv->linkedin]);
            @endphp
            <p class="text-center text-slate-600 text-xs mb-0.5">{{ implode(' | ', $contacts) }}</p>
            @if($cv->alamat)
                <p class="text-center text-slate-600 text-xs mb-4">{{ $cv->alamat }}</p>
            @else
                <div class="mb-4"></div>
            @endif

            <hr class="border-slate-900 border-t-2 mb-5">

            {{-- Professional Summary --}}
            @if($cv->ringkasan)
                <section class="mb-5">
                    <h3 class="text-xs font-extrabold uppercase tracking-widest mb-2 border-b border-slate-200 pb-1">Professional Summary</h3>
                    <p class="text-slate-700 break-words">{{ $cv->ringkasan }}</p>
                </section>
            @endif

            {{-- Education --}}
            @if($cv->educations->isNotEmpty())
                <section class="mb-5">
                    <h3 class="text-xs font-extrabold uppercase tracking-widest mb-3 border-b border-slate-200 pb-1">Education</h3>
                    @foreach($cv->educations as $edu)
                        <div class="flex justify-between items-start mb-2.5">
                            <div>
                                <p class="font-bold text-sm">{{ $edu->institusi }}</p>
                                @if($edu->gelar)
                                    <p class="text-slate-600 text-xs">{{ $edu->gelar }}</p>
                                @endif
                            </div>
                            @if($edu->tahun)
                                <span class="text-xs text-slate-500 whitespace-nowrap ml-4 mt-0.5">{{ $edu->tahun }}</span>
                            @endif
                        </div>
                    @endforeach
                </section>
            @endif

            {{-- Experience --}}
            @if($cv->experiences->isNotEmpty())
                <section class="mb-5">
                    <h3 class="text-xs font-extrabold uppercase tracking-widest mb-3 border-b border-slate-200 pb-1">Experience</h3>
                    @foreach($cv->experiences as $exp)
                        <div class="mb-4">
                            <div class="flex justify-between items-start">
                                <p class="font-bold text-sm">{{ $exp->posisi }}</p>
                                @if($exp->periode)
                                    <span class="text-xs text-slate-500 whitespace-nowrap ml-4 mt-0.5">{{ $exp->periode }}</span>
                                @endif
                            </div>
                            @if($exp->perusahaan)
                                <p class="text-slate-600 text-xs italic mb-1">{{ $exp->perusahaan }}</p>
                            @endif
                            @if($exp->deskripsi)
                                <p class="text-slate-700 text-xs break-words leading-relaxed">{{ $exp->deskripsi }}</p>
                            @endif
                        </div>
                    @endforeach
                </section>
            @endif

            {{-- Key Skills --}}
            @php
                $techSkills = $cv->skills->where('tipe', 'technical');
                $softSkills = $cv->skills->where('tipe', 'soft');
            @endphp
            @if($techSkills->isNotEmpty() || $softSkills->isNotEmpty())
                <section>
                    <h3 class="text-xs font-extrabold uppercase tracking-widest mb-3 border-b border-slate-200 pb-1">Key Skills</h3>
                    <div class="grid grid-cols-2 gap-6">
                        @if($techSkills->isNotEmpty())
                            <div>
                                <p class="font-bold text-xs mb-2">Technical Skills</p>
                                <ul class="space-y-1">
                                    @foreach($techSkills as $skill)
                                        <li class="text-xs text-slate-700 flex items-start gap-1.5">
                                            <span class="text-slate-400 leading-tight">•</span>
                                            {{ $skill->nama_skill }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if($softSkills->isNotEmpty())
                            <div>
                                <p class="font-bold text-xs mb-2">Soft Skills</p>
                                <ul class="space-y-1">
                                    @foreach($softSkills as $skill)
                                        <li class="text-xs text-slate-700 flex items-start gap-1.5">
                                            <span class="text-slate-400 leading-tight">•</span>
                                            {{ $skill->nama_skill }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </section>
            @endif

        </div>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    #cv-print-area, #cv-print-area * { visibility: visible; }
    #cv-print-area {
        position: fixed; left: 0; top: 0; width: 100%;
        border: none; box-shadow: none; border-radius: 0;
    }
}
</style>
@endsection