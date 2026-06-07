@extends('layouts.app')

@section('title', 'Riwayat Feedback')

@section('content')
<div class="feedback-history-page max-w-6xl mx-auto px-4 py-6">
    <!-- PAGE HEADER -->
    <div class="mb-8">
        <p class="text-xs uppercase tracking-[0.25em] text-sky-600 font-bold mb-2">Mentorship</p>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Feedback</h1>
        <p class="text-slate-500 mt-2">Lihat semua feedback dan penilaian yang diberikan oleh mentor Anda setelah sesi mentorship.</p>
    </div>

    <!-- FILTER SECTION -->
    <div class="mb-8 flex flex-col md:flex-row gap-4 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex-1 relative">
            <input type="text" id="searchInput" 
                   class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition text-sm text-slate-800"
                   placeholder="Cari nama mentor atau topik sesi...">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </span>
        </div>
        <div class="w-full md:w-56">
            <select id="ratingFilter" 
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition text-sm text-slate-800 cursor-pointer">
                <option value="all">Semua Rating</option>
                <option value="5">⭐⭐⭐⭐⭐ (5 Bintang)</option>
                <option value="4">⭐⭐⭐⭐ (4 Bintang)</option>
                <option value="3">⭐⭐⭐ (3 Bintang)</option>
                <option value="2">⭐⭐ (2 Bintang)</option>
                <option value="1">⭐ (1 Bintang)</option>
            </select>
        </div>
    </div>

    <!-- FEEDBACK CONTENT -->
    @if($feedbacks->isEmpty())
        <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-sm">
            <div class="mx-auto w-16 h-16 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Belum Ada Feedback</h3>
            <p class="text-slate-500 max-w-md mx-auto text-sm leading-relaxed">Anda belum menerima feedback apapun dari mentor. Selesaikan sesi mentorship terlebih dahulu.</p>
        </div>
    @else
        <!-- Grid layout for Feedback Cards -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-2" id="feedbackGrid">
            @foreach($feedbacks as $fb)
                @php
                    $mentorName = $fb->mentor->name ?? 'Mentor';
                    $mentorInitial = strtoupper(substr($mentorName, 0, 1));
                    $avatarUrl = $fb->mentor->mentorProfile->profile_picture ?? null;
                    $sessionTopic = $fb->session->topic ?? 'Jadwal Manual';
                    $sessionDate = $fb->session?->scheduled_start ? \Carbon\Carbon::parse($fb->session->scheduled_start)->locale('id')->translatedFormat('d M Y') : null;
                    $displaySession = $sessionDate ? $sessionTopic . ' (' . $sessionDate . ')' : $sessionTopic;
                    
                    $ratingLabels = [
                        1 => 'Perlu Banyak Perbaikan',
                        2 => 'Di Bawah Ekspektasi',
                        3 => 'Cukup Memuaskan',
                        4 => 'Berprestasi',
                        5 => 'Sangat Berprestasi',
                    ];
                    $ratingText = $ratingLabels[$fb->mentee_rating] ?? '';
                @endphp
                <div class="feedback-card bg-white border border-slate-200 rounded-3xl p-6 shadow-sm hover:shadow-md hover:border-sky-500 transition-all duration-300 flex flex-col gap-5"
                     data-mentor="{{ strtolower($mentorName) }}" 
                     data-rating="{{ $fb->mentee_rating }}" 
                     data-content="{{ strtolower($mentorName . ' ' . $sessionTopic) }}">
                    
                    <!-- Card Header -->
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-400 to-sky-600 text-white flex items-center justify-center font-bold text-lg shadow-sm overflow-hidden flex-shrink-0">
                                @if($avatarUrl)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($avatarUrl) }}" alt="{{ $mentorName }}" class="w-full h-full object-cover">
                                @else
                                    {{ $mentorInitial }}
                                @endif
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-bold text-slate-900 text-base truncate">{{ $mentorName }}</h3>
                                <p class="text-xs text-slate-500 mt-0.5 truncate">Sesi: {{ $displaySession }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-1 flex-shrink-0">
                            <div class="flex items-center gap-1.5 bg-amber-50 text-amber-700 px-3 py-1.5 rounded-xl border border-amber-200 text-xs font-bold">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                <span>{{ $fb->mentee_rating }}/5</span>
                            </div>
                            @if($ratingText)
                                <span class="text-[10px] font-bold text-amber-700 uppercase tracking-wider">{{ $ratingText }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Card Body -->
                    <div class="flex flex-col gap-3.5">
                        <div class="bg-sky-50 border border-sky-100 rounded-2xl p-4 transition-transform hover:scale-[1.01]">
                            <h4 class="text-xs font-bold text-sky-800 uppercase tracking-wider mb-2">Kekuatan (Strength)</h4>
                            <p class="text-sm text-slate-700 leading-relaxed">{{ $fb->strength }}</p>
                        </div>
                        
                        <div class="bg-rose-50 border border-rose-100 rounded-2xl p-4 transition-transform hover:scale-[1.01]">
                            <h4 class="text-xs font-bold text-rose-800 uppercase tracking-wider mb-2">Area Peningkatan (Improvement)</h4>
                            <p class="text-sm text-slate-700 leading-relaxed">{{ $fb->improvement }}</p>
                        </div>

                        <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 transition-transform hover:scale-[1.01]">
                            <h4 class="text-xs font-bold text-emerald-800 uppercase tracking-wider mb-2">Rekomendasi</h4>
                            <p class="text-sm text-slate-700 leading-relaxed">{{ $fb->recommendation }}</p>
                        </div>
                    </div>
                    
                    <!-- Card Footer -->
                    <div class="mt-auto pt-4 border-t border-slate-100 flex justify-between items-center text-xs text-slate-400">
                        <span>Feedback Mentoring</span>
                        <span>Diberikan pada {{ $fb->created_at->locale('id')->translatedFormat('d M Y') }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Empty search state -->
        <div id="noResultsState" class="hidden bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-sm">
            <div class="mx-auto w-16 h-16 bg-slate-50 text-slate-500 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Pencarian Tidak Ditemukan</h3>
            <p class="text-slate-500 max-w-md mx-auto text-sm leading-relaxed">Tidak ada feedback yang sesuai dengan kata kunci atau filter rating yang dipilih.</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const ratingFilter = document.getElementById('ratingFilter');
        const cards = document.querySelectorAll('.feedback-card');
        const noResultsState = document.getElementById('noResultsState');
        const feedbackGrid = document.getElementById('feedbackGrid');

        function filterCards() {
            if (!searchInput || !ratingFilter) return;

            const searchTerm = searchInput.value.toLowerCase().trim();
            const selectedRating = ratingFilter.value;
            let visibleCount = 0;

            cards.forEach(card => {
                const mentor = card.getAttribute('data-mentor');
                const content = card.getAttribute('data-content');
                const rating = card.getAttribute('data-rating');

                const matchesSearch = mentor.includes(searchTerm) || content.includes(searchTerm);
                const matchesRating = selectedRating === 'all' || rating === selectedRating;

                if (matchesSearch && matchesRating) {
                    card.classList.remove('hidden');
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                    card.style.display = 'none';
                }
            });

            if (feedbackGrid && noResultsState) {
                if (visibleCount === 0) {
                    feedbackGrid.classList.add('hidden');
                    noResultsState.classList.remove('hidden');
                } else {
                    feedbackGrid.classList.remove('hidden');
                    noResultsState.classList.add('hidden');
                }
            }
        }

        if (searchInput) {
            searchInput.addEventListener('input', filterCards);
        }
        if (ratingFilter) {
            ratingFilter.addEventListener('change', filterCards);
        }
    });
</script>
@endpush
