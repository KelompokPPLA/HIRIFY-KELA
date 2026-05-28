@extends('layouts.app')

@section('title', 'Hasil Self Assessment - Hirify')

@section('content')
<div class="max-w-3xl mx-auto">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('self-assessment') }}" class="text-slate-400 hover:text-slate-700 transition">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Hasil Assessment</h1>
            <p class="text-slate-500 text-sm mt-0.5">Dievaluasi pada {{ $assessment->created_at->format('d M Y, H:i') }}</p>
        </div>
    </div>

    {{-- Result Card --}}
    @php
        $resultConfig = match($assessment->result) {
            'Siap'  => ['emoji' => '🚀', 'bg' => 'from-emerald-500 to-teal-500', 'badge' => 'bg-emerald-100 text-emerald-700', 'desc' => 'Selamat! Kamu sudah sangat siap untuk memasuki dunia kerja. Terus tingkatkan kompetensimu!'],
            'Cukup' => ['emoji' => '📈', 'bg' => 'from-amber-500 to-orange-500', 'badge' => 'bg-amber-100 text-amber-700', 'desc' => 'Kamu cukup siap! Masih ada beberapa area yang perlu ditingkatkan sebelum melamar pekerjaan.'],
            default => ['emoji' => '💪', 'bg' => 'from-rose-500 to-pink-500', 'badge' => 'bg-rose-100 text-rose-700', 'desc' => 'Kamu masih perlu banyak berlatih. Manfaatkan fitur Roadmap Karier dan Pelatihan di Hirify!'],
        };
        $percentage = $maxScore > 0 ? round(($assessment->total_score / $maxScore) * 100) : 0;
    @endphp

    <div class="bg-gradient-to-br {{ $resultConfig['bg'] }} rounded-3xl p-8 text-white text-center mb-8 shadow-lg">
        <div class="text-6xl mb-4">{{ $resultConfig['emoji'] }}</div>
        <p class="text-white/70 text-sm font-semibold uppercase tracking-widest mb-2">Tingkat Kesiapan Karier</p>
        <h2 class="text-5xl font-extrabold mb-2">{{ $assessment->result }}</h2>
        <p class="text-white/80 text-sm max-w-sm mx-auto leading-relaxed">{{ $resultConfig['desc'] }}</p>

        {{-- Score --}}
        <div class="mt-6 bg-white/20 rounded-2xl p-5 backdrop-blur-sm">
            <div class="flex justify-center gap-8">
                <div>
                    <p class="text-3xl font-extrabold">{{ $assessment->total_score }}</p>
                    <p class="text-white/70 text-xs mt-1">Skor Kamu</p>
                </div>
                <div class="w-px bg-white/30"></div>
                <div>
                    <p class="text-3xl font-extrabold">{{ $maxScore }}</p>
                    <p class="text-white/70 text-xs mt-1">Skor Maks</p>
                </div>
                <div class="w-px bg-white/30"></div>
                <div>
                    <p class="text-3xl font-extrabold">{{ $percentage }}%</p>
                    <p class="text-white/70 text-xs mt-1">Persentase</p>
                </div>
            </div>
            <div class="mt-4 w-full bg-white/20 rounded-full h-2">
                <div class="bg-white h-2 rounded-full" style="width: {{ $percentage }}%"></div>
            </div>
        </div>
    </div>

    {{-- Category Breakdown --}}
    @php $answersByCategory = $answers->groupBy(fn($a) => $a->question->category ?? 'Lainnya'); @endphp
    <div class="bg-white rounded-3xl border border-slate-200 p-6 mb-6">
        <h3 class="text-base font-bold text-slate-800 mb-5">Rincian Per Kategori</h3>
        <div class="space-y-4">
            @foreach($answersByCategory as $cat => $catAnswers)
                @php
                    $catTotal = $catAnswers->sum('score');
                    $catMax   = $catAnswers->count() * 5;
                    $catPct   = round(($catTotal / $catMax) * 100);
                @endphp
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-sm font-semibold text-slate-700">{{ $cat }}</span>
                        <span class="text-sm font-bold text-slate-900">{{ $catTotal }}/{{ $catMax }}
                            <span class="text-slate-400 font-normal">({{ $catPct }}%)</span>
                        </span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="h-2 rounded-full transition-all duration-500
                            {{ $catPct >= 70 ? 'bg-emerald-500' : ($catPct >= 40 ? 'bg-amber-500' : 'bg-rose-500') }}"
                            style="width: {{ $catPct }}%">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Scoring Legend --}}
    <div class="bg-slate-50 rounded-2xl border border-slate-200 p-5 mb-6">
        <h4 class="text-sm font-bold text-slate-700 mb-3">Keterangan Penilaian</h4>
        <div class="grid grid-cols-3 gap-3">
            <div class="text-center p-3 bg-rose-50 rounded-xl border border-rose-100">
                <p class="text-rose-600 font-bold text-sm">Kurang</p>
                <p class="text-xs text-slate-500 mt-1">Skor &lt; 30</p>
            </div>
            <div class="text-center p-3 bg-amber-50 rounded-xl border border-amber-100">
                <p class="text-amber-600 font-bold text-sm">Cukup</p>
                <p class="text-xs text-slate-500 mt-1">Skor 30–55</p>
            </div>
            <div class="text-center p-3 bg-emerald-50 rounded-xl border border-emerald-100">
                <p class="text-emerald-600 font-bold text-sm">Siap</p>
                <p class="text-xs text-slate-500 mt-1">Skor &gt; 55</p>
            </div>
        </div>
    </div>

    {{-- CTA Buttons --}}
    <div class="flex flex-col sm:flex-row gap-3">
        <a href="{{ route('self-assessment') }}"
            class="flex-1 text-center px-6 py-3 border-2 border-slate-200 text-slate-700 font-semibold text-sm rounded-xl hover:border-slate-400 transition">
            Ulangi Assessment
        </a>
        <a href="{{ route('roadmap-karier') }}"
            class="flex-1 text-center px-6 py-3 bg-slate-900 text-white font-semibold text-sm rounded-xl hover:bg-slate-700 transition">
            Lihat Roadmap Karier →
        </a>
    </div>
</div>
@endsection