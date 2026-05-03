@extends('layouts.mentor')

@section('content')
<div class="max-w-7xl mx-auto">
    <header class="mb-6">
        <h1 class="text-3xl font-bold">Feedback & Evaluasi</h1>
        <p class="text-gray-500 mt-1">Berikan feedback dan evaluasi untuk mentee Anda</p>
    </header>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <form method="GET" action="{{ route('mentor.feedback.index') }}" class="flex items-center w-full md:w-1/2">
            <label for="search" class="sr-only">Cari feedback</label>
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"></path></svg>
                </div>
                <input id="search" name="search" value="{{ $search ?? '' }}" placeholder="Cari feedback..." class="pl-10 pr-4 py-3 w-full rounded-lg border border-gray-200 bg-white focus:outline-none focus:ring-2 focus:ring-amber-200" />
            </div>
        </form>

        <div class="flex items-center justify-end">
            <button id="openModalBtn" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 text-white rounded-lg shadow hover:scale-[1.01] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                Buat Feedback Baru
            </button>
        </div>
    </div>

    <section class="space-y-6">
        @forelse($feedbacks as $fb)
            @include('mentor.feedback._card', ['fb' => $fb])
        @empty
            <div class="text-center py-12 text-gray-500">Belum ada feedback untuk ditampilkan.</div>
        @endforelse
    </section>

    @include('mentor.feedback._modal')
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Modal open / close ───────────────────────────────────────
    const modal     = document.getElementById('feedbackModal');
    const openBtn   = document.getElementById('openModalBtn');
    const closeBtn  = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('modalCancelBtn');

    const openModal  = () => { modal.classList.remove('hidden'); document.body.classList.add('overflow-hidden'); };
    const closeModal = () => { modal.classList.add('hidden'); document.body.classList.remove('overflow-hidden'); };

    openBtn?.addEventListener('click', openModal);
    closeBtn?.addEventListener('click', closeModal);
    cancelBtn?.addEventListener('click', closeModal);
    modal?.addEventListener('click', e => { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    // ── Rating Performa Mentee (bintang amber) ───────────────────
    const menteeRatingLabels = {
        1: 'Perlu Banyak Perbaikan',
        2: 'Di Bawah Ekspektasi',
        3: 'Cukup Memuaskan',
        4: 'Berprestasi',
        5: 'Sangat Berprestasi',
    };

    const stars       = Array.from(document.querySelectorAll('#feedbackModal .star-mentee'));
    const hiddenInput = document.getElementById('mentee_rating_val');
    const labelEl     = document.getElementById('menteeRatingLabel');
    let selected      = 5;

    const paint = v => {
        stars.forEach(s => {
            const val = parseInt(s.dataset.value, 10);
            const svg = s.querySelector('svg');
            if (svg) {
                svg.classList.toggle('text-amber-400', val <= v);
                svg.classList.toggle('text-gray-200',  val >  v);
            }
        });
        if (labelEl) labelEl.textContent = `${v} — ${menteeRatingLabels[v] ?? ''}`;
    };

    paint(selected);

    stars.forEach(s => {
        s.addEventListener('mouseover', () => paint(parseInt(s.dataset.value, 10)));
        s.addEventListener('mouseleave', () => paint(selected));
        s.addEventListener('click', () => {
            selected = parseInt(s.dataset.value, 10);
            if (hiddenInput) hiddenInput.value = selected;
            paint(selected);
        });
    });

});
</script>
@endpush

@endsection
