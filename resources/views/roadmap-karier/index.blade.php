@extends('layouts.app')

@section('title', 'Roadmap Karier - Hirify')

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Roadmap Karier</h1>
        <p class="text-slate-500 mt-1">Pilih bidang karier impianmu dan dapatkan panduan step-by-step menuju karier yang sukses.</p>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl px-5 py-4">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Form Pilih Karier --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 mb-8">
        <h2 class="text-lg font-semibold text-slate-800 mb-4">Pilih Bidang Karier</h2>
        <form method="POST" action="{{ route('roadmap-karier.store') }}" class="flex flex-col sm:flex-row gap-4">
            @csrf
            <select
                name="career_field"
                id="career_field"
                class="flex-1 rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition"
            >
                <option value="">-- Pilih bidang karier --</option>
                @foreach($careerFields as $field)
                    <option value="{{ $field }}" @selected($selectedCareer === $field)>{{ $field }}</option>
                @endforeach
            </select>
            <button
                type="submit"
                class="shrink-0 inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white text-sm font-semibold rounded-xl hover:bg-slate-700 transition"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Generate Roadmap
            </button>
        </form>
        @error('career_field')
            <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
        @enderror
    </div>

    {{-- Progress Overview --}}
    @if($roadmap->isNotEmpty())
        <div class="bg-gradient-to-r from-slate-900 to-slate-700 rounded-3xl p-6 mb-8 text-white">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-slate-300 text-sm font-medium uppercase tracking-wide">Progress Roadmap</p>
                    <h3 class="text-xl font-bold mt-1">{{ $selectedCareer }}</h3>
                </div>
                <div class="text-right">
                    <p class="text-4xl font-bold">{{ $progressPercent }}<span class="text-xl">%</span></p>
                    <p class="text-slate-300 text-sm">{{ $completedCount }}/{{ $totalCount }} step selesai</p>
                </div>
            </div>
            <div class="w-full bg-white/20 rounded-full h-2.5">
                <div
                    class="bg-emerald-400 h-2.5 rounded-full transition-all duration-500"
                    style="width: {{ $progressPercent }}%"
                ></div>
            </div>
        </div>

        {{-- Roadmap Steps --}}
        <div class="space-y-4">
            @foreach($roadmap as $index => $step)
                <div class="bg-white rounded-3xl border {{ $step->is_completed ? 'border-emerald-200 bg-emerald-50/30' : 'border-slate-200' }} shadow-sm overflow-hidden transition-all">
                    {{-- Step Header --}}
                    <div class="flex items-center gap-4 p-6 cursor-pointer" onclick="toggleStep('step-{{ $step->id }}', this)">
                        {{-- Step Number / Check --}}
                        <div class="shrink-0 w-12 h-12 rounded-2xl flex items-center justify-center text-lg font-bold
                            {{ $step->is_completed ? 'bg-emerald-500 text-white' : 'bg-slate-100 text-slate-600' }}">
                            @if($step->is_completed)
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            @else
                                {{ $index + 1 }}
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-xs font-semibold uppercase tracking-widest text-slate-400">Step {{ $index + 1 }}</span>
                                @if($step->is_completed)
                                    <span class="text-xs font-semibold text-emerald-600 bg-emerald-100 px-2 py-0.5 rounded-full">✓ Selesai</span>
                                @endif
                            </div>
                            <h3 class="text-base font-bold text-slate-900 mt-0.5">{{ $step->step_title }}</h3>
                            <p class="text-sm text-slate-500 mt-0.5 line-clamp-1">{{ $step->description }}</p>
                        </div>
                        <svg class="step-arrow w-5 h-5 text-slate-400 transition-transform shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>

                    {{-- Step Body --}}
                    <div id="step-{{ $step->id }}" class="hidden px-6 pb-6">
                        <p class="text-slate-600 text-sm mb-5">{{ $step->description }}</p>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
                            {{-- Skills --}}
                            <div class="bg-blue-50 rounded-2xl p-4">
                                <p class="text-xs font-bold text-blue-600 uppercase tracking-wide mb-3">Skills</p>
                                <ul class="space-y-1.5">
                                    @foreach($step->skills ?? [] as $skill)
                                        <li class="text-sm text-slate-700 flex items-start gap-1.5">
                                            <span class="text-blue-400 mt-0.5">•</span> {{ $skill }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            {{-- Tools --}}
                            <div class="bg-violet-50 rounded-2xl p-4">
                                <p class="text-xs font-bold text-violet-600 uppercase tracking-wide mb-3">Tools</p>
                                <ul class="space-y-1.5">
                                    @foreach($step->tools ?? [] as $tool)
                                        <li class="text-sm text-slate-700 flex items-start gap-1.5">
                                            <span class="text-violet-400 mt-0.5">•</span> {{ $tool }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            {{-- Aktivitas --}}
                            <div class="bg-amber-50 rounded-2xl p-4">
                                <p class="text-xs font-bold text-amber-600 uppercase tracking-wide mb-3">Aktivitas</p>
                                <ul class="space-y-1.5">
                                    @foreach($step->activities ?? [] as $activity)
                                        <li class="text-sm text-slate-700 flex items-start gap-1.5">
                                            <span class="text-amber-400 mt-0.5">•</span> {{ $activity }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        {{-- Button Selesai --}}
                        <form method="POST" action="{{ route('roadmap-karier.update', $step->id) }}">
                            @csrf
                            @method('PATCH')
                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-xl transition
                                    {{ $step->is_completed
                                        ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200'
                                        : 'bg-slate-900 text-white hover:bg-slate-700' }}"
                            >
                                @if($step->is_completed)
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                    Tandai Belum Selesai
                                @else
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Tandai Selesai
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        {{-- Empty State --}}
        <div class="text-center py-20 bg-white rounded-3xl border border-slate-200 border-dashed">
            <div class="w-20 h-20 bg-slate-100 rounded-3xl mx-auto flex items-center justify-center text-4xl mb-5">🗺️</div>
            <h3 class="text-lg font-semibold text-slate-800 mb-2">Belum Ada Roadmap</h3>
            <p class="text-slate-400 text-sm max-w-sm mx-auto">Pilih bidang karier di atas dan klik <strong>Generate Roadmap</strong> untuk memulai perjalanan kariermu!</p>
        </div>
    @endif
</div>

<script>
function toggleStep(id, header) {
    const body  = document.getElementById(id);
    const arrow = header.querySelector('.step-arrow');
    const isHidden = body.classList.contains('hidden');
    body.classList.toggle('hidden', !isHidden);
    arrow.style.transform = isHidden ? 'rotate(180deg)' : '';
}
</script>
@endsection
