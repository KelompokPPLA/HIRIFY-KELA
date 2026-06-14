@extends('layouts.app')

@section('title', 'Hasil Self Assessment - Hirify')

@section('content')
<style>
    /* ── Result Page Custom Styles ── */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.85); }
        to   { opacity: 1; transform: scale(1); }
    }
    @keyframes progressFill {
        from { width: 0%; }
        to   { width: var(--target-width); }
    }

    .result-hero   { animation: scaleIn 0.5s cubic-bezier(0.34,1.56,0.64,1) both; }
    .result-detail { animation: fadeSlideUp 0.4s ease both; }
    .result-detail:nth-child(1) { animation-delay: 0.15s; }
    .result-detail:nth-child(2) { animation-delay: 0.25s; }
    .result-detail:nth-child(3) { animation-delay: 0.35s; }

    .cat-bar-fill {
        animation: progressFill 0.9s cubic-bezier(0.4, 0, 0.2, 1) both;
    }

    /* Streak notification */
    .streak-banner {
        background: linear-gradient(135deg, #0b1021 0%, #0f2042 100%);
        border: 1px solid rgba(3,153,183,0.3);
        border-radius: 16px;
    }

    /* Score ring */
    .score-ring {
        width: 120px; height: 120px;
        border-radius: 50%;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        background: rgba(255,255,255,0.15);
        border: 3px solid rgba(255,255,255,0.3);
        backdrop-filter: blur(10px);
    }

    /* Result card */
    .result-card {
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        background: white;
    }
</style>

<div class="max-w-3xl mx-auto space-y-6">

    {{-- ── STREAK NOTIFICATION (hanya muncul jika baru selesai) ──── --}}
    @if(session('streak_recorded'))
    <div class="streak-banner p-4 flex items-center gap-4" id="streak-notif">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl flex-shrink-0"
             style="background: rgba(3,153,183,0.2);">🔥</div>
        <div class="flex-1">
            <p class="text-sm font-bold text-white">Aktivitas tercatat ke Career Streak!</p>
            <p class="text-xs text-slate-400 mt-0.5">
                Self Assessment hari ini sudah tersimpan. Streak kamu diperbarui.
            </p>
        </div>
        <a href="{{ route('streak.index') }}"
           class="text-xs font-bold text-cyan-400 hover:text-cyan-300 transition whitespace-nowrap">
            Lihat Streak →
        </a>
    </div>
    @endif

    {{-- ── HEADER ─────────────────────────────────────────────── --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('self-assessment.index') }}"
           class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center
                  text-slate-400 hover:text-slate-700 hover:border-slate-300 transition shadow-sm flex-shrink-0">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-xl font-extrabold text-slate-900">Hasil Assessment</h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Dievaluasi pada {{ $assessment->created_at->format('d M Y, H:i') }}
            </p>
        </div>
    </div>

    {{-- ── RESULT HERO CARD ────────────────────────────────────── --}}
    @php
        $resultConfig = match($assessment->result) {
            'Siap'  => [
                'emoji'   => '🚀',
                'grad'    => 'from-emerald-500 via-teal-500 to-cyan-500',
                'glow'    => 'rgba(16,185,129,0.35)',
                'badge'   => 'bg-emerald-100 text-emerald-700',
                'desc'    => 'Selamat! Kamu sudah sangat siap untuk memasuki dunia kerja. Pertahankan dan terus tingkatkan kompetensimu!',
                'level'   => 3,
            ],
            'Cukup' => [
                'emoji'   => '📈',
                'grad'    => 'from-amber-500 via-orange-500 to-yellow-500',
                'glow'    => 'rgba(245,158,11,0.35)',
                'badge'   => 'bg-amber-100 text-amber-700',
                'desc'    => 'Kamu cukup siap! Masih ada beberapa area yang bisa ditingkatkan sebelum melamar pekerjaan impian.',
                'level'   => 2,
            ],
            default => [
                'emoji'   => '💪',
                'grad'    => 'from-rose-500 via-pink-500 to-red-500',
                'glow'    => 'rgba(244,63,94,0.3)',
                'badge'   => 'bg-rose-100 text-rose-700',
                'desc'    => 'Kamu masih perlu berlatih lebih banyak. Manfaatkan fitur Roadmap Karier dan Pelatihan di Hirify untuk berkembang!',
                'level'   => 1,
            ],
        };
        $percentage = $maxScore > 0 ? round(($assessment->total_score / $maxScore) * 100) : 0;
    @endphp

    <div class="result-hero bg-gradient-to-br {{ $resultConfig['grad'] }} rounded-[1.5rem] p-8 text-white relative overflow-hidden shadow-xl"
         style="box-shadow: 0 20px 60px {{ $resultConfig['glow'] }};">
        {{-- Dot grid --}}
        <div class="absolute inset-0 opacity-20 pointer-events-none"
             style="background-image: radial-gradient(rgba(255,255,255,0.15) 1px, transparent 1px); background-size: 20px 20px;"></div>

        <div class="relative z-10">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                {{-- Emoji + Ring --}}
                <div class="score-ring flex-shrink-0">
                    <span class="text-4xl leading-none">{{ $resultConfig['emoji'] }}</span>
                    <span class="text-xs font-bold text-white/70 mt-1">Level {{ $resultConfig['level'] }}/3</span>
                </div>

                {{-- Info --}}
                <div class="flex-1 text-center sm:text-left">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-white/60 mb-1">Tingkat Kesiapan Karier</p>
                    <h2 class="text-4xl font-extrabold text-white mb-2">{{ $assessment->result }}</h2>
                    <p class="text-sm text-white/80 max-w-sm leading-relaxed">{{ $resultConfig['desc'] }}</p>
                </div>
            </div>

            {{-- Score Stats --}}
            <div class="mt-6 grid grid-cols-3 gap-3">
                <div class="rounded-xl bg-white/15 backdrop-blur-sm p-4 text-center border border-white/20">
                    <p class="text-2xl font-extrabold">{{ $assessment->total_score }}</p>
                    <p class="text-[11px] text-white/70 mt-0.5">Skor Kamu</p>
                </div>
                <div class="rounded-xl bg-white/15 backdrop-blur-sm p-4 text-center border border-white/20">
                    <p class="text-2xl font-extrabold">{{ $maxScore }}</p>
                    <p class="text-[11px] text-white/70 mt-0.5">Skor Maks</p>
                </div>
                <div class="rounded-xl bg-white/15 backdrop-blur-sm p-4 text-center border border-white/20">
                    <p class="text-2xl font-extrabold">{{ $percentage }}%</p>
                    <p class="text-[11px] text-white/70 mt-0.5">Persentase</p>
                </div>
            </div>

            {{-- Overall progress bar --}}
            <div class="mt-4">
                <div class="w-full bg-white/20 rounded-full h-2.5 overflow-hidden">
                    <div class="cat-bar-fill h-2.5 rounded-full bg-white"
                         style="--target-width: {{ $percentage }}%; width: 0%;"
                         data-target="{{ $percentage }}"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── RINCIAN PER KATEGORI ─────────────────────────────── --}}
    @php $answersByCategory = $answers->groupBy(fn($a) => $a->question->category ?? 'Lainnya'); @endphp

    <div class="result-card p-6 result-detail">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-base">📊</div>
            <div>
                <h3 class="text-base font-bold text-slate-800">Rincian Per Kategori</h3>
                <p class="text-xs text-slate-500">Lihat area kekuatan dan yang perlu ditingkatkan</p>
            </div>
        </div>

        <div class="space-y-5">
            @foreach($answersByCategory as $cat => $catAnswers)
                @php
                    $catTotal = $catAnswers->sum('score');
                    $catMax   = $catAnswers->count() * 5;
                    $catPct   = round(($catTotal / $catMax) * 100);
                    $catColor = $catPct >= 70 ? ['bar' => '#10b981', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'badge' => 'Kuat']
                                : ($catPct >= 40 ? ['bar' => '#f59e0b', 'bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'badge' => 'Cukup']
                                                : ['bar' => '#ef4444', 'bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'badge' => 'Perlu Latihan']);
                @endphp
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-slate-800">{{ $cat }}</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $catColor['bg'] }} {{ $catColor['text'] }}">
                                {{ $catColor['badge'] }}
                            </span>
                        </div>
                        <span class="text-sm font-extrabold text-slate-900 tabular-nums">
                            {{ $catTotal }}/{{ $catMax }}
                            <span class="text-xs text-slate-400 font-normal">({{ $catPct }}%)</span>
                        </span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="cat-bar-fill h-2.5 rounded-full"
                             style="--target-width: {{ $catPct }}%; width: 0%; background: {{ $catColor['bar'] }};"
                             data-target="{{ $catPct }}">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ── KETERANGAN PENILAIAN ──────────────────────────────── --}}
    <div class="result-card p-5 result-detail">
        <h4 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
            <span>📋</span> Keterangan Penilaian
        </h4>
        <div class="grid grid-cols-3 gap-3">
            <div class="text-center p-4 bg-rose-50 rounded-xl border border-rose-100">
                <p class="text-2xl mb-1">💪</p>
                <p class="text-rose-600 font-extrabold text-sm">Kurang</p>
                <p class="text-xs text-slate-500 mt-1">Skor &lt; 30</p>
            </div>
            <div class="text-center p-4 bg-amber-50 rounded-xl border border-amber-100">
                <p class="text-2xl mb-1">📈</p>
                <p class="text-amber-600 font-extrabold text-sm">Cukup</p>
                <p class="text-xs text-slate-500 mt-1">Skor 30–55</p>
            </div>
            <div class="text-center p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                <p class="text-2xl mb-1">🚀</p>
                <p class="text-emerald-600 font-extrabold text-sm">Siap</p>
                <p class="text-xs text-slate-500 mt-1">Skor &gt; 55</p>
            </div>
        </div>
    </div>

    {{-- ── CTA BUTTONS ─────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row gap-3 result-detail">
        <a href="{{ route('self-assessment.index') }}"
           class="flex-1 text-center px-6 py-3.5 border-2 border-slate-200 text-slate-700 font-bold text-sm
                  rounded-xl hover:border-slate-400 hover:bg-white transition">
            🔄 Ulangi Assessment
        </a>
        <a href="{{ route('streak.index') }}"
           class="flex-1 text-center px-6 py-3.5 font-bold text-sm rounded-xl text-white transition
                  hover:opacity-90"
           style="background: linear-gradient(135deg, #0399b7, #06d8ee);">
            🔥 Lihat Career Streak
        </a>
        <a href="{{ route('roadmap-karier.index') }}"
           class="flex-1 text-center px-6 py-3.5 bg-slate-900 text-white font-bold text-sm
                  rounded-xl hover:bg-slate-700 transition">
            🗺️ Roadmap Karier →
        </a>
    </div>

</div>

@push('scripts')
<script>
    // Animasi progress bar saat halaman load
    document.addEventListener('DOMContentLoaded', function () {
        const bars = document.querySelectorAll('.cat-bar-fill');
        bars.forEach((bar, i) => {
            const target = bar.dataset.target || 0;
            bar.style.setProperty('--target-width', target + '%');
            // Trigger animation dengan delay
            setTimeout(() => {
                bar.style.width = target + '%';
                bar.style.transition = 'width 0.9s cubic-bezier(0.4, 0, 0.2, 1)';
            }, 200 + i * 80);
        });
    });
</script>
@endpush
@endsection