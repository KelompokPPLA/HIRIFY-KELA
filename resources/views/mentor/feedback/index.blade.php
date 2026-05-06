@extends('layouts.mentor')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Feedback & Evaluasi</h1>
            <p class="text-slate-500 mt-1.5 font-medium">Berikan feedback dan evaluasi untuk mentee Anda</p>
        </div>
    </div>

    <!-- Controls Row (Search & Create Button) -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8 bg-white p-4 rounded-2xl border border-slate-100/80 shadow-[0_8px_30px_rgb(0,0,0,0.01)]">
        <form method="GET" action="{{ route('mentor.feedback.index') }}" class="flex-1 relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.35-4.35"/>
                </svg>
            </span>
            <input id="search" name="search" value="{{ $search ?? '' }}" placeholder="Cari feedback..." class="w-full pl-11 pr-5 py-3 rounded-xl border border-slate-200/60 bg-slate-50/50 focus:bg-white focus:ring-4 focus:ring-cyan-500/10 focus:border-[#00bee4] outline-none transition duration-200 text-sm font-semibold text-slate-700" />
        </form>

        <button id="openModalBtn" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl shadow-lg shadow-slate-900/10 hover:scale-[1.02] active:scale-[0.98] transition duration-200 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" /></svg>
            Buat Feedback Baru
        </button>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-100/80 text-sm font-semibold flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 text-rose-700 border border-rose-100/80 text-sm font-semibold flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Feedback List -->
    <section class="space-y-6">
        @forelse($feedbacks as $fb)
            @include('mentor.feedback._card', ['fb' => $fb])
        @empty
            <div class="py-20 text-center bg-white rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
                <div class="w-20 h-20 mx-auto mb-5 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <p class="text-xl font-extrabold text-slate-800 tracking-tight">Belum Ada Feedback</p>
                <p class="text-sm text-slate-400 font-semibold mt-2 max-w-sm mx-auto">Anda belum menulis umpan balik atau evaluasi apa pun untuk mentee Anda. Klik "+ Buat Feedback Baru" untuk memulai.</p>
            </div>
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
                svg.classList.toggle('text-[#00bee4]', val <= v);
                svg.classList.toggle('text-slate-200',  val >  v);
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

    // Make stars on form align with premium cyan theme
    const modalStars = document.querySelectorAll('#feedbackModal .star-mentee svg');
    modalStars.forEach(s => {
        s.classList.add('transition-colors', 'duration-150');
    });

});
</script>
@endpush

@endsection
