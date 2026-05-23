@extends('layouts.app')

@section('title', 'Self Assessment - Hirify')

@section('content')
<div class="max-w-3xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Self Assessment</h1>
        <p class="text-slate-500 mt-1">Jawab pertanyaan berikut secara jujur untuk mengetahui tingkat kesiapan kariermu.</p>
    </div>

    {{-- Last Result Banner --}}
    @if($lastResult)
        <div class="mb-6 bg-white border border-slate-200 rounded-2xl p-5 flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0
                {{ $lastResult->result === 'Siap' ? 'bg-emerald-100' : ($lastResult->result === 'Cukup' ? 'bg-amber-100' : 'bg-red-100') }}">
                {{ $lastResult->result === 'Siap' ? '🚀' : ($lastResult->result === 'Cukup' ? '📈' : '💪') }}
            </div>
            <div class="flex-1">
                <p class="text-sm text-slate-500">Hasil terakhir:</p>
                <p class="font-bold text-slate-900 text-lg">{{ $lastResult->result }}
                    <span class="text-sm font-normal text-slate-500">(Skor: {{ $lastResult->total_score }})</span>
                </p>
            </div>
            <a href="{{ route('assessment.result') }}" class="text-sm font-semibold text-slate-700 hover:text-slate-900 underline underline-offset-2">
                Lihat Detail →
            </a>
        </div>
    @endif

    {{-- Progress Bar (JS-driven) --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-5 mb-6">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-slate-600">Progress Pengisian</span>
            <span id="progress-text" class="text-sm font-bold text-slate-900">0 / {{ $questions->count() }}</span>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-2">
            <div id="progress-bar" class="bg-slate-900 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
        </div>
    </div>

    {{-- Assessment Form --}}
    <form method="POST" action="{{ route('assessment.store') }}" id="assessment-form">
        @csrf

        @php $categories = $questions->groupBy('category'); @endphp

        @foreach($categories as $category => $catQuestions)
            <div class="mb-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-px flex-1 bg-slate-200"></div>
                    <span class="text-xs font-bold uppercase tracking-widest text-slate-400">{{ $category }}</span>
                    <div class="h-px flex-1 bg-slate-200"></div>
                </div>

                <div class="space-y-4">
                    @foreach($catQuestions as $q)
                        @php $qIndex = $questions->search(fn($item) => $item->id === $q->id) + 1; @endphp
                        <div class="bg-white rounded-2xl border border-slate-200 p-5 question-card" data-question="{{ $q->id }}">
                            <p class="text-sm font-semibold text-slate-800 mb-4">
                                <span class="text-slate-400 font-normal mr-1">{{ $qIndex }}.</span>
                                {{ $q->question }}
                            </p>
                            <div class="flex flex-col sm:flex-row gap-2">
                                @foreach([1 => 'Sangat Kurang', 2 => 'Kurang', 3 => 'Cukup', 4 => 'Baik', 5 => 'Sangat Baik'] as $val => $label)
                                    <label class="radio-option flex-1 cursor-pointer">
                                        <input
                                            type="radio"
                                            name="answers[{{ $q->id }}]"
                                            value="{{ $val }}"
                                            class="sr-only"
                                            onchange="onAnswerChange({{ $q->id }}, this)"
                                            @if(isset($userAnswers[$q->id]) && $userAnswers[$q->id] == $val) checked @endif
                                        >
                                        <div class="radio-visual text-center px-2 py-2.5 rounded-xl border-2 transition
                                            {{ isset($userAnswers[$q->id]) && $userAnswers[$q->id] == $val
                                                ? 'border-slate-900 bg-slate-900 text-white'
                                                : 'border-slate-200 text-slate-600 hover:border-slate-400' }}">
                                            <p class="text-lg font-bold leading-none">{{ $val }}</p>
                                            <p class="text-[10px] mt-1 leading-tight">{{ $label }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{-- Submit --}}
        <div class="sticky bottom-0 bg-[#f8fafc] border-t border-slate-200 py-4 mt-4 -mx-6 px-6 lg:-mx-8 lg:px-8">
            <div class="max-w-3xl mx-auto flex items-center justify-between gap-4">
                <p class="text-sm text-slate-500">Pastikan semua pertanyaan sudah dijawab</p>
                <button
                    type="submit"
                    id="submit-btn"
                    class="inline-flex items-center gap-2 px-8 py-3 bg-slate-900 text-white text-sm font-bold rounded-xl hover:bg-slate-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Lihat Hasil
                </button>
            </div>
        </div>
    </form>
</div>

<script>
const totalQuestions = {{ $questions->count() }};
const answered = new Set();

// Isi answered set dari jawaban sebelumnya
@foreach($userAnswers as $qId => $score)
    answered.add({{ $qId }});
@endforeach

updateProgress();

function onAnswerChange(questionId, input) {
    answered.add(questionId);
    updateProgress();

    // Update visual
    const card = input.closest('.question-card');
    card.querySelectorAll('.radio-visual').forEach(el => {
        el.classList.remove('border-slate-900', 'bg-slate-900', 'text-white');
        el.classList.add('border-slate-200', 'text-slate-600');
    });
    const selected = input.closest('label').querySelector('.radio-visual');
    selected.classList.add('border-slate-900', 'bg-slate-900', 'text-white');
    selected.classList.remove('border-slate-200', 'text-slate-600');
}

function updateProgress() {
    const count   = answered.size;
    const pct     = Math.round((count / totalQuestions) * 100);
    document.getElementById('progress-bar').style.width  = pct + '%';
    document.getElementById('progress-text').textContent = count + ' / ' + totalQuestions;
}
</script>
@endsection
