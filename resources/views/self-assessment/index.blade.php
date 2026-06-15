@extends('layouts.app')

@section('title', 'Self Assessment - Hirify')

@section('content')
{{-- ═══════════════════════════════════════════════════════════
     SELF ASSESSMENT — Premium Redesign
     Menggunakan wizard multi-step dengan animasi modern
═══════════════════════════════════════════════════════════ --}}

<style>
    /* ── Assessment Custom Styles ── */
    .sa-hero {
        background: linear-gradient(135deg, #0b1021 0%, #10182d 50%, #0f2042 100%);
    }
    .sa-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        transition: box-shadow 0.2s ease;
    }
    .sa-card:hover { box-shadow: 0 4px 20px rgba(15,23,42,0.08); }

    /* Pilihan jawaban */
    .answer-option {
        position: relative;
        cursor: pointer;
    }
    .answer-option input[type="radio"] { display: none; }
    .answer-visual {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        padding: 12px 8px;
        border-radius: 14px;
        border: 2px solid #e2e8f0;
        background: #f8fafc;
        transition: all 0.18s ease;
        cursor: pointer;
        user-select: none;
    }
    .answer-option:hover .answer-visual {
        border-color: #94a3b8;
        background: #f1f5f9;
        transform: translateY(-2px);
    }
    .answer-visual.selected {
        border-color: #0f172a;
        background: #0f172a;
        color: white;
        box-shadow: 0 6px 20px rgba(15,23,42,0.25);
        transform: translateY(-2px);
    }
    .answer-val {
        font-size: 1.25rem;
        font-weight: 800;
        line-height: 1;
        color: #334155;
    }
    .answer-visual.selected .answer-val { color: white; }
    .answer-lbl {
        font-size: 0.65rem;
        font-weight: 600;
        text-align: center;
        line-height: 1.2;
        color: #64748b;
    }
    .answer-visual.selected .answer-lbl { color: rgba(255,255,255,0.8); }

    /* Scale color dots */
    .scale-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* Progress bar */
    #sa-progress-fill {
        transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: linear-gradient(90deg, #0399b7, #06d8ee);
    }

    /* Question card animation */
    @keyframes fadeSlideIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .question-card { animation: fadeSlideIn 0.3s ease both; }
    .question-card:nth-child(1)  { animation-delay: 0.03s; }
    .question-card:nth-child(2)  { animation-delay: 0.06s; }
    .question-card:nth-child(3)  { animation-delay: 0.09s; }
    .question-card:nth-child(4)  { animation-delay: 0.12s; }
    .question-card:nth-child(5)  { animation-delay: 0.15s; }
    .question-card:nth-child(6)  { animation-delay: 0.18s; }
    .question-card:nth-child(7)  { animation-delay: 0.21s; }
    .question-card:nth-child(8)  { animation-delay: 0.24s; }
    .question-card:nth-child(9)  { animation-delay: 0.27s; }
    .question-card:nth-child(10) { animation-delay: 0.30s; }

    /* Sticky footer */
    .sa-footer {
        position: sticky;
        bottom: 0;
        z-index: 20;
        background: rgba(248,250,252,0.95);
        backdrop-filter: blur(12px);
        border-top: 1px solid #e2e8f0;
        padding: 16px 0;
        margin-top: 32px;
    }

    /* Submit button states */
    #sa-submit-btn {
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }
    #sa-submit-btn:not(:disabled):hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 24px rgba(15,23,42,0.3);
    }
    #sa-submit-btn:disabled {
        opacity: 0.55;
        cursor: not-allowed;
    }
    #sa-submit-btn.ready {
        background: linear-gradient(135deg, #0399b7, #06d8ee);
    }

    /* Category divider */
    .cat-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }
    .cat-divider::before,
    .cat-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }

    /* Unanswered highlight */
    .question-card.unanswered-highlight {
        border-color: #f59e0b !important;
        box-shadow: 0 0 0 3px rgba(245,158,11,0.15);
    }
</style>

<div class="max-w-3xl mx-auto">

    {{-- ── HERO HEADER ─────────────────────────────────────── --}}
    <div class="sa-hero rounded-[1.5rem] p-7 text-white mb-6 relative overflow-hidden">
        {{-- Dot grid --}}
        <div class="absolute inset-0 opacity-20 pointer-events-none"
             style="background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 20px 20px;"></div>
        {{-- Glow --}}
        <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full pointer-events-none"
             style="background: radial-gradient(circle, rgba(3,153,183,0.3) 0%, transparent 70%);"></div>

        <div class="relative z-10 flex items-start gap-4">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0"
                 style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2);">
                ✅
            </div>
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-cyan-300/80 font-semibold mb-1">Career Assessment</p>
                <h1 class="text-2xl font-extrabold text-white leading-tight">Self Assessment</h1>
                <p class="mt-2 text-sm text-slate-300 max-w-md leading-relaxed">
                    Evaluasi kesiapan karier Anda dengan menjawab pertanyaan berikut secara jujur.
                    Setiap jawaban membantu kami memahami potensi Anda.
                </p>
            </div>
        </div>

        {{-- Hasil terakhir mini --}}
        @if($lastResult)
        <div class="relative z-10 mt-5 flex items-center gap-3 rounded-xl p-3.5"
             style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15);">
            <span class="text-lg">
                {{ $lastResult->result === 'Siap' ? '🚀' : ($lastResult->result === 'Cukup' ? '📈' : '💪') }}
            </span>
            <div class="flex-1 min-w-0">
                <p class="text-xs text-slate-400">Hasil terakhir Anda</p>
                <p class="text-sm font-bold text-white">{{ $lastResult->result }}
                    <span class="text-slate-400 font-normal">— Skor {{ $lastResult->total_score }}</span>
                </p>
            </div>
            <a href="{{ route('assessment.result') }}"
               class="text-xs font-semibold text-cyan-300 hover:text-cyan-100 transition whitespace-nowrap">
                Lihat →
            </a>
        </div>
        @endif
    </div>

    {{-- ── PROGRESS BAR ─────────────────────────────────────── --}}
    <div class="sa-card p-5 mb-6">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-slate-100 flex items-center justify-center text-base">📊</div>
                <span class="text-sm font-semibold text-slate-700">Progress Pengisian</span>
            </div>
            <div class="flex items-center gap-2">
                <span id="sa-progress-text"
                      class="text-sm font-extrabold text-slate-900 tabular-nums">0 / {{ $questions->count() }}</span>
                <span class="text-xs text-slate-400">pertanyaan</span>
            </div>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
            <div id="sa-progress-fill" class="h-3 rounded-full" style="width: 0%"></div>
        </div>

        {{-- Skala legend --}}
        <div class="mt-3 flex items-center justify-between text-[10px] text-slate-400 font-medium">
            @php $scaleColors = ['#ef4444','#f97316','#eab308','#22c55e','#16a34a']; @endphp
            <div class="flex items-center gap-1.5">
                @foreach(['Sangat Kurang','Kurang','Cukup','Baik','Sangat Baik'] as $i => $lbl)
                    <div class="flex items-center gap-1">
                        <div class="w-2 h-2 rounded-full" style="background:{{ $scaleColors[$i] }};"></div>
                        <span>{{ $lbl }}</span>
                    </div>
                    @if($i < 4)<span class="text-slate-200">|</span>@endif
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── FORM ASSESSMENT ──────────────────────────────────── --}}
    <form method="POST" action="{{ route('assessment.store') }}" id="sa-form">
        @csrf

        @php $categories = $questions->groupBy('category'); $qGlobalIdx = 0; @endphp

        @foreach($categories as $category => $catQuestions)
            {{-- Category Divider --}}
            <div class="cat-divider mt-2 mb-4">
                @php
                    $catIcons = [
                        'Technical Skills' => '⚙️',
                        'Teknikal'         => '⚙️',
                        'Soft Skills'      => '🧠',
                        'Career Readiness' => '🎯',
                        'Karier'           => '🎯',
                    ];
                @endphp
                <span class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-xs font-bold uppercase tracking-widest text-slate-500">
                    {{ $catIcons[$category] ?? '📋' }} {{ $category }}
                </span>
            </div>

            <div class="space-y-4 mb-6">
                @foreach($catQuestions as $q)
                    @php $qGlobalIdx++; @endphp
                    <div class="sa-card p-5 question-card border-2 border-transparent"
                         id="qcard-{{ $q->id }}"
                         data-qid="{{ $q->id }}">

                        {{-- Nomor + Teks Pertanyaan --}}
                        <div class="flex items-start gap-3 mb-4">
                            <span class="w-7 h-7 rounded-lg bg-slate-100 text-slate-500 text-xs font-extrabold
                                         flex items-center justify-center flex-shrink-0 mt-0.5">
                                {{ $qGlobalIdx }}
                            </span>
                            <p class="text-sm font-semibold text-slate-800 leading-relaxed">
                                {{ $q->question }}
                            </p>
                        </div>

                        {{-- Pilihan Jawaban (skala 1–5) --}}
                        <div class="grid grid-cols-5 gap-2">
                            @php
                                $scaleOptions = [
                                    1 => ['label' => 'Sangat Kurang', 'color' => '#ef4444', 'emoji' => '😞'],
                                    2 => ['label' => 'Kurang',        'color' => '#f97316', 'emoji' => '😕'],
                                    3 => ['label' => 'Cukup',         'color' => '#eab308', 'emoji' => '😐'],
                                    4 => ['label' => 'Baik',          'color' => '#22c55e', 'emoji' => '😊'],
                                    5 => ['label' => 'Sangat Baik',   'color' => '#16a34a', 'emoji' => '🌟'],
                                ];
                            @endphp

                            @foreach($scaleOptions as $val => $opt)
                                <label class="answer-option" id="opt-{{ $q->id }}-{{ $val }}">
                                    <input
                                        type="radio"
                                        name="answers[{{ $q->id }}]"
                                        value="{{ $val }}"
                                        onchange="onAnswerChange('{{ $q->id }}', {{ $val }}, this)"
                                        @if(isset($userAnswers[$q->id]) && $userAnswers[$q->id] == $val) checked @endif
                                    >
                                    <div class="answer-visual {{ isset($userAnswers[$q->id]) && $userAnswers[$q->id] == $val ? 'selected' : '' }}"
                                         id="vis-{{ $q->id }}-{{ $val }}">
                                        <span class="answer-val">{{ $val }}</span>
                                        <span class="answer-lbl">{{ $opt['label'] }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        {{-- Indikator terjawab --}}
                        <div class="mt-3 flex items-center gap-2"
                             id="answered-indicator-{{ $q->id }}"
                             style="display: {{ isset($userAnswers[$q->id]) ? 'flex' : 'none' }} !important">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-xs text-emerald-600 font-semibold">Terjawab</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

        {{-- ── STICKY FOOTER ─────────────────────────────────── --}}
        <div class="sa-footer">
            <div class="max-w-3xl mx-auto flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div id="sa-unanswered-badge"
                         class="hidden items-center gap-1.5 px-3 py-1.5 bg-amber-50 border border-amber-200 rounded-xl">
                        <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01M12 4a8 8 0 100 16A8 8 0 0012 4z"/>
                        </svg>
                        <span id="sa-unanswered-count" class="text-xs font-bold text-amber-700"></span>
                    </div>
                    <p class="text-sm text-slate-500" id="sa-footer-msg">
                        Pastikan semua pertanyaan dijawab
                    </p>
                </div>

                <button type="submit"
                        id="sa-submit-btn"
                        disabled
                        class="inline-flex items-center gap-2 px-7 py-3 bg-slate-900 text-white text-sm font-bold rounded-xl">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span id="sa-submit-label">Lihat Hasil</span>
                </button>
            </div>
        </div>
    </form>

</div>

@push('scripts')
<script>
const TOTAL = {{ $questions->count() }};
const answered = new Map(); // qId → score

// ── Init dari jawaban yang sudah ada ─────────────────────────────
@foreach($userAnswers as $qId => $score)
    answered.set('{{ $qId }}', {{ $score }});
@endforeach

// ── Render initial state ─────────────────────────────────────────
updateAll();

// ── Handler pilihan jawaban ──────────────────────────────────────
function onAnswerChange(qId, val, input) {
    answered.set(qId, val);

    // Update semua visual dalam card ini
    for (let v = 1; v <= 5; v++) {
        const vis = document.getElementById('vis-' + qId + '-' + v);
        if (!vis) continue;
        if (v === val) {
            vis.classList.add('selected');
        } else {
            vis.classList.remove('selected');
        }
    }

    // Tampilkan indikator terjawab
    const indicator = document.getElementById('answered-indicator-' + qId);
    if (indicator) indicator.style.display = 'flex';

    // Hilangkan highlight unanswered jika ada
    const card = document.getElementById('qcard-' + qId);
    if (card) card.classList.remove('unanswered-highlight');

    updateAll();
}

// ── Update progress bar + tombol submit ─────────────────────────
function updateAll() {
    const count  = answered.size;
    const pct    = Math.round((count / TOTAL) * 100);
    const isAll  = count === TOTAL;

    // Progress bar
    document.getElementById('sa-progress-fill').style.width = pct + '%';
    document.getElementById('sa-progress-text').textContent = count + ' / ' + TOTAL;

    // Submit button state
    const btn   = document.getElementById('sa-submit-btn');
    const label = document.getElementById('sa-submit-label');
    const msg   = document.getElementById('sa-footer-msg');
    const badge = document.getElementById('sa-unanswered-badge');
    const badgeTxt = document.getElementById('sa-unanswered-count');

    btn.disabled = !isAll;

    if (isAll) {
        btn.classList.add('ready');
        btn.classList.remove('bg-slate-900');
        label.textContent = 'Lihat Hasil Assessment →';
        msg.textContent   = 'Semua pertanyaan sudah dijawab! Klik tombol untuk melihat hasil.';
        badge.classList.add('hidden');
        badge.classList.remove('inline-flex');
    } else {
        btn.classList.remove('ready');
        btn.classList.add('bg-slate-900');
        label.textContent = 'Lihat Hasil Assessment';
        const remaining   = TOTAL - count;
        msg.textContent   = 'Silakan jawab seluruh pertanyaan terlebih dahulu.';
        badgeTxt.textContent = remaining + ' pertanyaan belum dijawab';
        badge.classList.remove('hidden');
        badge.classList.add('inline-flex');
    }
}

// ── Validate & highlight unanswered on submit attempt ───────────
document.getElementById('sa-form').addEventListener('submit', function(e) {
    if (answered.size < TOTAL) {
        e.preventDefault();
        // Scroll ke pertanyaan pertama yang belum dijawab
        const allCards = document.querySelectorAll('.question-card');
        let firstUnanswered = null;
        allCards.forEach(card => {
            const qid = card.dataset.qid;
            if (!answered.has(qid)) {
                card.classList.add('unanswered-highlight');
                if (!firstUnanswered) firstUnanswered = card;
            }
        });
        if (firstUnanswered) {
            firstUnanswered.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
});
</script>
@endpush
@endsection
