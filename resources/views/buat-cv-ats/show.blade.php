@extends('layouts.app')

@section('title', 'Preview CV - Hirify')

@section('content')
<div class="max-w-[860px] mx-auto">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('buat-cv-ats.index') }}" class="text-slate-400 hover:text-slate-700 transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-slate-900">Preview CV ATS</h1>
                <p class="text-slate-400 text-sm">{{ $cv->name }}</p>
            </div>
        </div>
        <div class="flex gap-2">
            <button onclick="window.print()"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white text-sm font-semibold rounded-xl hover:bg-slate-700 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print / Save PDF
            </button>
        </div>
    </div>

    {{-- CV Document Preview --}}
    <div id="cv-print-area" class="bg-white border border-slate-200 shadow-lg rounded-2xl overflow-hidden">
        <div class="max-w-[800px] mx-auto px-12 py-10 font-serif text-[13.5px] leading-relaxed text-slate-900 break-words">

            {{-- Name --}}
            <h1 class="text-3xl font-extrabold text-center uppercase tracking-wide mb-1">{{ $cv->name }}</h1>

            {{-- Contact --}}
            <p class="text-center text-slate-600 text-xs mb-0.5">
                @php $contacts = array_filter([$cv->email, $cv->phone, $cv->linkedin]); @endphp
                {{ implode(' | ', $contacts) }}
            </p>
            @if($cv->address)
                <p class="text-center text-slate-600 text-xs mb-4">{{ $cv->address }}</p>
            @else
                <div class="mb-4"></div>
            @endif

            <hr class="border-slate-900 border-t-2 mb-5">

            {{-- Professional Summary --}}
            @if($cv->summary)
                <section class="mb-5">
                    <h2 class="text-xs font-extrabold uppercase tracking-widest mb-2 border-b border-slate-200 pb-1">Professional Summary</h2>
                    <p class="text-slate-700 break-words">{{ $cv->summary }}</p>
                </section>
            @endif

            {{-- Education --}}
            @if($cv->educations->isNotEmpty())
                <section class="mb-5">
                    <h2 class="text-xs font-extrabold uppercase tracking-widest mb-3 border-b border-slate-200 pb-1">Education</h2>
                    @foreach($cv->educations as $edu)
                        <div class="flex justify-between items-start mb-2.5">
                            <div>
                                <p class="font-bold text-sm">{{ $edu->institution }}</p>
                                @if($edu->degree)
                                    <p class="text-slate-600 text-xs">{{ $edu->degree }}</p>
                                @endif
                            </div>
                            @if($edu->year)
                                <span class="text-xs text-slate-500 whitespace-nowrap ml-4 mt-0.5">{{ $edu->year }}</span>
                            @endif
                        </div>
                    @endforeach
                </section>
            @endif

            {{-- Experience --}}
            @if($cv->experiences->isNotEmpty())
                <section class="mb-5">
                    <h2 class="text-xs font-extrabold uppercase tracking-widest mb-3 border-b border-slate-200 pb-1">Experience</h2>
                    @foreach($cv->experiences as $exp)
                        <div class="mb-4">
                            <div class="flex justify-between items-start">
                                <p class="font-bold text-sm">{{ $exp->position }}</p>
                                @if($exp->period)
                                    <span class="text-xs text-slate-500 whitespace-nowrap ml-4 mt-0.5">{{ $exp->period }}</span>
                                @endif
                            </div>
                            @if($exp->company)
                                <p class="text-slate-600 text-xs italic mb-1">{{ $exp->company }}</p>
                            @endif
                            @if($exp->description)
                                <p class="text-slate-700 text-xs break-words leading-relaxed">{{ $exp->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </section>
            @endif

            {{-- Key Skills --}}
            @php
                $techSkills = $cv->skills->where('type', 'technical');
                $softSkills = $cv->skills->where('type', 'soft');
            @endphp
            @if($techSkills->isNotEmpty() || $softSkills->isNotEmpty())
                <section>
                    <h2 class="text-xs font-extrabold uppercase tracking-widest mb-3 border-b border-slate-200 pb-1">Key Skills</h2>
                    <div class="grid grid-cols-2 gap-6">
                        @if($techSkills->isNotEmpty())
                            <div>
                                <p class="font-bold text-xs mb-2">Technical Skills</p>
                                <ul class="space-y-1">
                                    @foreach($techSkills as $skill)
                                        <li class="text-xs text-slate-700 flex items-start gap-1.5">
                                            <span class="text-slate-400 leading-tight">•</span>
                                            {{ $skill->name }}
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
                                            {{ $skill->name }}
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
    #cv-print-area { position: fixed; left: 0; top: 0; width: 100%; border: none; box-shadow: none; }
}
</style>
@endsection