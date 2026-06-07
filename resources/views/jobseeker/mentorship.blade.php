@extends('layouts.app')

@section('title', 'Mentorship')

@section('content')
<div class="mentorship-page max-w-6xl mx-auto px-4 py-6">
    <!-- PAGE HEADER -->
    <div class="mb-8">
        <p class="text-xs uppercase tracking-[0.25em] text-sky-600 font-bold mb-2">Mentorship</p>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Mentorship</h1>
        <p class="text-slate-500 mt-2">Telusuri mentor terbaik, booking sesi, dan pantau status pengembangan karier Anda.</p>
    </div>

    <!-- SESI MENDATANG -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm mb-8">
        <div class="flex items-center justify-between gap-4 mb-6">
            <h2 class="text-lg font-bold text-slate-900">Sesi Mendatang</h2>
            <button class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition" 
                    type="button" id="refreshUpcomingBtn">
                Refresh
            </button>
        </div>
        <div id="upcomingList" class="space-y-4">
            <!-- Rendered by JS -->
        </div>
    </div>

    <!-- SEARCH & FILTER -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm mb-8">
        <div class="flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <input id="searchInput" type="text" 
                       class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition text-sm text-slate-800"
                       placeholder="Cari mentor berdasarkan nama, keahlian, atau kata kunci...">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>
            </div>
            <div class="flex gap-2">
                <button id="searchBtn" class="bg-sky-600 text-white font-semibold rounded-xl px-5 py-3 text-sm hover:bg-sky-700 transition shadow-sm" type="button">
                    Cari Mentor
                </button>
                <button id="filterToggle" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition" type="button">
                    Filter
                </button>
            </div>
        </div>

        <!-- Advanced Filters Panel -->
        <div id="filterPanel" class="hidden grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mt-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
            <input id="expertiseInput" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm" placeholder="Keahlian (cth: UI/UX)">
            <select id="experienceInput" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm cursor-pointer">
                <option value="">Semua Pengalaman</option>
                <option value="1">1+ Tahun</option>
                <option value="3">3+ Tahun</option>
                <option value="5">5+ Tahun</option>
                <option value="10">10+ Tahun</option>
            </select>
            <select id="ratingInput" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm cursor-pointer">
                <option value="">Semua Rating</option>
                <option value="4.8">Rating 4.8+</option>
                <option value="4.5">Rating 4.5+</option>
                <option value="4.0">Rating 4.0+</option>
            </select>
            <button id="applyFilterBtn" class="w-full bg-slate-900 text-white font-semibold rounded-lg py-2.5 text-sm hover:bg-slate-800 transition" type="button">
                Terapkan Filter
            </button>
        </div>
    </div>

    <!-- MENTOR LIST -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-slate-900 mb-6">Daftar Mentor</h2>
        <div id="mentorGrid" class="grid gap-6 md:grid-cols-2">
            <!-- Rendered by JS -->
        </div>
    </div>

    <!-- BOOKINGS STATUS -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
        <div class="flex items-center justify-between gap-4 mb-6">
            <h2 class="text-lg font-bold text-slate-900">Status Booking Saya</h2>
            <button id="refreshBookingsBtn" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition" type="button">
                Refresh
            </button>
        </div>

        <!-- Tabs -->
        <div class="flex flex-wrap gap-2 mb-6 border-b border-slate-100 pb-4" id="bookingTabs">
            <button class="px-4 py-2 text-sm font-semibold rounded-xl transition bg-slate-900 text-white" data-status="all">Semua</button>
            <button class="px-4 py-2 text-sm font-semibold rounded-xl transition text-slate-600 hover:bg-slate-100" data-status="pending">Pending</button>
            <button class="px-4 py-2 text-sm font-semibold rounded-xl transition text-slate-600 hover:bg-slate-100" data-status="confirmed">Confirmed</button>
            <button class="px-4 py-2 text-sm font-semibold rounded-xl transition text-slate-600 hover:bg-slate-100" data-status="completed">Completed</button>
            <button class="px-4 py-2 text-sm font-semibold rounded-xl transition text-slate-600 hover:bg-slate-100" data-status="cancelled">Cancelled</button>
            <button class="px-4 py-2 text-sm font-semibold rounded-xl transition text-slate-600 hover:bg-slate-100" data-status="rejected">Rejected</button>
        </div>

        <div id="bookingList" class="space-y-4">
            <!-- Rendered by JS or Controller fallback -->
            @if(!empty($initialBookings) && count($initialBookings))
                @foreach($initialBookings as $booking)
                    @php
                        $canCancel = ($booking['status'] ?? '') === 'pending';
                        $canJoin = ($booking['status'] ?? '') === 'confirmed' && !empty($booking['meeting_url']);
                        $statusClassMap = [
                            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'confirmed' => 'bg-sky-50 text-sky-700 border-sky-200',
                            'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'cancelled' => 'bg-rose-50 text-rose-700 border-rose-200',
                            'rejected' => 'bg-rose-50 text-rose-700 border-rose-200'
                        ];
                        $statusCls = $statusClassMap[$booking['status'] ?? ''] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                    @endphp
                    <article class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5 border border-slate-100 rounded-2xl bg-slate-50/50 hover:bg-slate-50 transition">
                        <div>
                            <div class="mb-1">
                                <strong class="text-base font-bold text-slate-900">{{ $booking['mentor']['name'] ?? 'Mentor' }}</strong>
                                @if(!empty($booking['session_topic']))
                                    <div class="text-sm text-sky-600 font-semibold mt-0.5">{{ $booking['session_topic'] }}</div>
                                @endif
                            </div>
                            <p class="text-xs text-slate-500 mb-3">
                                {{ $booking['mentor']['expertise'] ?? '-' }} • {{ $booking['display_date'] ?? '-' }} • {{ $booking['display_time'] ?? '-' }}
                            </p>
                            <span class="px-3 py-1 border rounded-full text-xs font-bold uppercase tracking-wider {{ $statusCls }}">
                                {{ $booking['status_label'] ?? $booking['status'] }}
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-2 justify-end items-center">
                            <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-semibold rounded-xl text-xs hover:bg-slate-50 transition shadow-sm" type="button" data-detail-id="{{ $booking['id'] }}">Detail</button>
                            @if($canJoin)
                                <button class="px-4 py-2 bg-sky-600 text-white font-semibold rounded-xl text-xs hover:bg-sky-700 transition shadow-sm" type="button" data-join-booking="{{ $booking['meeting_url'] }}">Join</button>
                            @endif
                            @if($canCancel)
                                <button class="px-4 py-2 bg-rose-50 border border-rose-200 text-rose-700 font-semibold rounded-xl text-xs hover:bg-rose-100 transition shadow-sm" type="button" data-cancel-booking="{{ $booking['id'] }}">Batalkan</button>
                            @endif
                        </div>
                    </article>
                @endforeach
            @else
                <div class="p-8 text-center text-slate-500 border border-dashed border-slate-200 rounded-2xl">Belum ada data booking pada status ini.</div>
            @endif
        </div>
    </div>
</div>

<!-- MODALS -->

<!-- BOOKING MODAL -->
<section id="mentorModal" class="modal">
    <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[90vh] overflow-y-auto border border-slate-200 shadow-2xl flex flex-col p-6 m-4">
        <div class="flex justify-between items-start border-b border-slate-100 pb-4 mb-5">
            <div>
                <h3 class="text-xl font-bold text-slate-900">Booking Sesi Mentorship</h3>
                <p id="modalSubtitle" class="text-slate-500 text-sm mt-1">dengan Mentor</p>
            </div>
            <button id="modalFollowBtn" class="px-4 py-2 text-xs font-bold rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 transition shadow-sm" type="button">Follow</button>
        </div>

        <div class="space-y-6 flex-1">
            <!-- Sesi Grid -->
            <div>
                <p class="text-sm font-bold text-slate-900 mb-3">Daftar Sesi</p>
                <div id="slotGrid" class="grid gap-3 sm:grid-cols-2 md:grid-cols-3">
                    <!-- Loaded dynamically -->
                </div>
                
                <div id="slotDetailPanel" class="bg-sky-50 border border-sky-100 rounded-2xl p-4 mt-4 hidden">
                    <strong class="text-sm font-bold text-sky-800 block mb-2">Detail Sesi Terpilih</strong>
                    <div class="text-xs font-semibold text-slate-700 flex items-center gap-2 mb-2">
                        <span id="slotDetailDate"></span> <span class="text-slate-300">|</span> <span id="slotDetailTime"></span>
                    </div>
                    <p id="slotDetailLabel" class="text-sm text-slate-800 font-bold"></p>
                    <p id="slotDetailDescription" class="text-xs text-slate-500 mt-2 leading-relaxed whitespace-pre-wrap"></p>
                </div>
            </div>

            <!-- Ulasan Pengguna -->
            <div class="border-t border-slate-100 pt-5">
                <p class="text-sm font-bold text-slate-900 mb-3">Ulasan Pengguna</p>
                <div id="mentorReviewsList" class="space-y-3 max-h-60 overflow-y-auto pr-2">
                    <!-- Reviews will be loaded here -->
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 border-t border-slate-100 pt-5 mt-6">
            <button id="closeModalBtn" class="px-5 py-2.5 bg-slate-100 text-slate-800 font-semibold rounded-xl text-sm hover:bg-slate-200 transition" type="button">Batal</button>
            <button id="bookBtn" class="px-5 py-2.5 bg-slate-900 text-white font-semibold rounded-xl text-sm hover:bg-slate-800 transition" type="button">Konfirmasi Booking</button>
        </div>
    </div>
</section>

<!-- DETAIL MODAL -->
<section id="detailModal" class="modal">
    <div class="bg-white rounded-3xl max-w-lg w-full max-h-[90vh] overflow-y-auto border border-slate-200 shadow-2xl flex flex-col p-6 m-4">
        <div class="flex justify-between items-start border-b border-slate-100 pb-4 mb-4">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Detail Booking</h3>
                <p id="detailModalSubtitle" class="text-xs text-slate-500 mt-1">Status: <span id="detailModalStatus"></span></p>
            </div>
            <button id="closeDetailBtn" class="text-slate-400 hover:text-slate-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="space-y-4 flex-1">
            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4">
                <span class="text-xs text-slate-400 uppercase tracking-wider block mb-1">Informasi Mentor</span>
                <p class="font-bold text-slate-900 text-sm" id="detailMentorName"></p>
                <p class="text-xs text-slate-500 mt-0.5" id="detailMentorExp"></p>
            </div>

            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4">
                <span class="text-xs text-slate-400 uppercase tracking-wider block mb-1">Jadwal Sesi</span>
                <p class="font-bold text-slate-900 text-sm" id="detailDate"></p>
                <p class="text-xs text-slate-500 mt-0.5" id="detailTime"></p>
            </div>

            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4">
                <span class="text-xs text-slate-400 uppercase tracking-wider block mb-1">Topik Sesi</span>
                <p class="text-slate-800 text-sm font-semibold" id="detailLabel"></p>
            </div>

            <div id="detailDescriptionBox" class="bg-slate-50 border border-slate-100 rounded-2xl p-4 hidden">
                <span class="text-xs text-slate-400 uppercase tracking-wider block mb-1">Deskripsi / Keterangan Sesi</span>
                <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-wrap" id="detailDescription"></p>
            </div>

            <div id="detailPlatformBox" class="bg-slate-50 border border-slate-100 rounded-2xl p-4 hidden">
                <span class="text-xs text-slate-400 uppercase tracking-wider block mb-1">Tautan / Platform</span>
                <p class="text-slate-800 text-sm font-semibold" id="detailPlatform"></p>
            </div>

            <div id="detailMeetingBox" class="bg-sky-50 border border-sky-100 rounded-2xl p-4 hidden">
                <span class="text-xs text-sky-700 uppercase tracking-wider block mb-1">Link Meeting</span>
                <a href="#" target="_blank" class="text-sky-600 hover:text-sky-700 text-sm font-bold underline" id="detailMeetingUrl">Buka Link Sesi Mentorship</a>
            </div>

            <div id="detailRejectionBox" class="bg-rose-50 border border-rose-100 rounded-2xl p-4 hidden">
                <span class="text-xs text-rose-700 uppercase tracking-wider block mb-1 font-bold">Alasan Penolakan</span>
                <p class="text-rose-800 text-sm leading-relaxed" id="detailRejectionReason"></p>
            </div>

            <div id="detailMaterialBox" class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 hidden">
                <span class="text-xs text-emerald-700 uppercase tracking-wider block mb-1">Materi Sesi</span>
                <a href="#" target="_blank" class="text-emerald-600 hover:text-emerald-700 text-sm font-bold underline" id="detailMaterialUrl">Unduh Materi Mentoring</a>
            </div>

            <div id="detailNotesBox" class="bg-sky-50 border border-sky-100 rounded-2xl p-4 hidden">
                <span class="text-xs text-sky-700 uppercase tracking-wider block mb-1 font-bold">Catatan Mentor</span>
                <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-wrap" id="detailNotes"></p>
            </div>

            <div id="detailReviewBox" class="bg-amber-50 border border-amber-100 rounded-2xl p-4 hidden">
                <span class="text-xs text-amber-700 uppercase tracking-wider block mb-1 font-bold">Ulasan Anda</span>
                <div class="flex items-center gap-1 text-amber-500 my-1 font-bold" id="detailReviewStars"></div>
                <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-wrap" id="detailReviewComment"></p>
            </div>
        </div>
    </div>
</section>

<!-- REVIEW MODAL -->
<section id="reviewModal" class="modal">
    <div class="bg-white rounded-3xl max-w-md w-full border border-slate-200 shadow-2xl flex flex-col p-6 m-4">
        <div class="border-b border-slate-100 pb-4 mb-4">
            <h3 class="text-lg font-bold text-slate-900">Berikan Ulasan Mentor</h3>
            <p id="reviewModalSubtitle" class="text-xs text-slate-500 mt-1">Bagikan pengalaman mentoring Anda bersama mentor ini</p>
        </div>

        <div class="space-y-5 flex-1">
            <input type="hidden" id="reviewBookingId">

            <div class="text-center">
                <p class="text-sm font-bold text-slate-800 mb-2">Rating Mentor</p>
                <div class="star-rating">
                    <input type="radio" id="star5" name="reviewRating" value="5" />
                    <label for="star5">★</label>
                    <input type="radio" id="star4" name="reviewRating" value="4" />
                    <label for="star4">★</label>
                    <input type="radio" id="star3" name="reviewRating" value="3" />
                    <label for="star3">★</label>
                    <input type="radio" id="star2" name="reviewRating" value="2" />
                    <label for="star2">★</label>
                    <input type="radio" id="star1" name="reviewRating" value="1" />
                    <label for="star1">★</label>
                </div>
                <p id="ratingErrorMessage" class="text-rose-600 text-xs mt-1 hidden">Pilih rating bintang terlebih dahulu.</p>
            </div>

            <div>
                <label class="text-sm font-bold text-slate-850 block mb-2">Tulis Ulasan</label>
                <textarea id="reviewComment" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 text-sm text-slate-800 min-h-[100px] resize-vertical" placeholder="Tulis masukan konstruktif untuk mentor Anda (opsional)..."></textarea>
            </div>
        </div>

        <div class="flex justify-end gap-3 border-t border-slate-100 pt-4 mt-5">
            <button id="closeReviewModalBtn" class="px-4 py-2 bg-slate-100 text-slate-800 font-semibold rounded-xl text-xs hover:bg-slate-200 transition" type="button">Batal</button>
            <button id="submitReviewBtn" class="px-4 py-2 bg-slate-900 text-white font-semibold rounded-xl text-xs hover:bg-slate-800 transition" type="button">Kirim Ulasan</button>
        </div>
    </div>
</section>

@include('components.auth.toast')

<style>
    /* Star Rating Selector styles */
    .star-rating {
        display: inline-flex;
        flex-direction: row-reverse;
        justify-content: center;
        gap: 6px;
    }

    .star-rating label {
        font-size: 2.5rem;
        color: #cbd5e1;
        cursor: pointer;
        transition: color 0.15s ease, transform 0.1s ease;
    }

    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input:checked ~ label {
        color: #fbbf24;
    }

    .star-rating label:active {
        transform: scale(0.9);
    }
    
    .star-rating input {
        display: none;
    }

    /* Modal Backdrop & Toggles */
    .modal {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: none;
        place-items: center;
        z-index: 50;
        padding: 20px;
    }
    .modal.show {
        display: grid;
        animation: modalFadeIn 0.25s ease-out;
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    /* Interactive Calendar Slots */
    .slot {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 16px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 12px;
        background: #ffffff;
    }
    .slot:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
    }
    .slot.active {
        border-color: #0ea5e9;
        background: #f0f9ff;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.15);
    }
    .slot input {
        display: none;
    }

    /* Spinner animation */
    .small-spinner {
        display: inline-block;
        width: 14px;
        height: 14px;
        border: 2px solid rgba(0,0,0,0.12);
        border-top-color: #0ea5e9;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        vertical-align: middle;
        margin-right: 6px;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>
@endsection

@push('scripts')
<script src="/js/hirify-api.js"></script>
<script>
    const showToast = window.hirifyShowToast;

    hirifyInitToken('{{ session("jwt_token") }}');
    const api = window.hirifyApi;
    const escapeHtml = window.hirifyEsc;
    
    window.bookingsByMentor = @json($bookingsByMentor ?? []);
    let selectedBookingStatus = 'all';
    let selectedSlotId = null;
    let selectedSlotIsManual = false;
    let activeMentor = null;

    const state = {
        me: null,
        mentors: [],
        bookings: [],
        upcoming: [],
        followedMentorIds: [],
        followLoadingIds: [],
        currentSlots: [],
        filters: {
            search: '',
            expertise: '',
            min_experience: '',
            min_rating: '',
        },
    };

    const searchInput = document.getElementById('searchInput');
    const expertiseInput = document.getElementById('expertiseInput');
    const experienceInput = document.getElementById('experienceInput');
    const ratingInput = document.getElementById('ratingInput');
    const filterPanel = document.getElementById('filterPanel');
    const mentorGrid = document.getElementById('mentorGrid');
    const bookingList = document.getElementById('bookingList');
    const upcomingList = document.getElementById('upcomingList');
    const mentorModal = document.getElementById('mentorModal');
    const modalSubtitle = document.getElementById('modalSubtitle');
    const slotGrid = document.getElementById('slotGrid');

    function formatRupiah(value) {
        return new Intl.NumberFormat('id-ID').format(Number(value || 0));
    }

    function getInitial(name) {
        return (name?.trim()?.[0] || 'M').toUpperCase();
    }

    function statusClass(status) {
        const value = String(status || '').toLowerCase();
        const map = {
            'pending': 'bg-amber-50 text-amber-700 border-amber-200',
            'confirmed': 'bg-sky-50 text-sky-700 border-sky-200',
            'completed': 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'cancelled': 'bg-rose-50 text-rose-700 border-rose-200',
            'rejected': 'bg-rose-50 text-rose-700 border-rose-200'
        };
        return map[value] || 'bg-slate-50 text-slate-700 border-slate-200';
    }

    function renderUpcoming() {
        if (!state.upcoming.length) {
            upcomingList.innerHTML = `
                <div class="p-8 text-center text-slate-500 border border-dashed border-slate-200 rounded-2xl text-sm">
                    Belum ada sesi mendatang. Pilih mentor dan lakukan booking sesi pertama Anda.
                </div>`;
            return;
        }

        upcomingList.innerHTML = state.upcoming.map((item) => {
            const joinUrl = item.meeting_url || item.platform;
            const canJoin = item.status === 'confirmed' && joinUrl;

            return `
                <article class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5 border border-slate-100 rounded-2xl bg-sky-50/30 hover:bg-sky-50/50 transition">
                    <div>
                        <strong class="text-base font-bold text-slate-900">${escapeHtml(item.mentor?.name || 'Mentor')}</strong>
                        <p class="text-xs text-slate-500 mt-1">
                            ${escapeHtml(item.mentor?.expertise || '-')} • ${escapeHtml(item.display_date || '')} • ${escapeHtml(item.display_time || '')}
                        </p>
                    </div>
                    <button class="px-5 py-2.5 text-xs font-bold rounded-xl shadow-sm transition ${canJoin ? 'bg-sky-600 hover:bg-sky-700 text-white' : 'bg-slate-100 text-slate-400 cursor-not-allowed'}" 
                            ${canJoin ? '' : 'disabled'} data-join-url="${escapeHtml(joinUrl || '')}">
                        ${canJoin ? 'Join Sesi' : 'Menunggu Sesi'}
                    </button>
                </article>
            `;
        }).join('');

        upcomingList.querySelectorAll('[data-join-url]').forEach((button) => {
            button.addEventListener('click', () => {
                const url = button.getAttribute('data-join-url');
                if (url) {
                    window.open(url, '_blank', 'noopener,noreferrer');
                }
            });
        });
    }

    function renderMentors() {
        if (!state.mentors.length) {
            mentorGrid.innerHTML = `
                <div class="col-span-2 p-8 text-center text-slate-500 border border-dashed border-slate-200 rounded-2xl text-sm">
                    Mentor tidak ditemukan. Ubah kata kunci atau filter pencarian Anda.
                </div>`;
            return;
        }

        mentorGrid.innerHTML = state.mentors.map((mentor) => {
            const skills = (mentor.skills || []).slice(0, 4)
                .map((skill) => `<span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-sky-50 text-sky-700">${escapeHtml(skill)}</span>`)
                .join('');

            const avatar = mentor.avatar_url
                ? `<img src="${escapeHtml(mentor.avatar_url)}" alt="Avatar mentor" class="w-full h-full object-cover">`
                : escapeHtml(getInitial(mentor.name));

            const isFollowed = state.followedMentorIds.includes(mentor.id);
            const isLoading = state.followLoadingIds.includes(mentor.id);
            const followText = isLoading ? '' : (isFollowed ? 'Following' : 'Follow');
            const followClass = isFollowed ? 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50' : 'bg-slate-900 text-white hover:bg-slate-800';

            let booked = null;
            const bMap = (window.bookingsByMentor && typeof window.bookingsByMentor === 'object') ? window.bookingsByMentor : {};
            if (bMap[mentor.id]) {
                booked = bMap[mentor.id];
            } else if (bMap[String(mentor.id)]) {
                booked = bMap[String(mentor.id)];
            } else if (Array.isArray(state.bookings) && state.bookings.length) {
                booked = state.bookings.find(b => Number(b.mentor?.id) === Number(mentor.id)) || null;
            }

            const bookedBadge = booked 
                ? `<div class="absolute right-4 top-4 bg-white border border-slate-200 rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-sky-600 shadow-sm z-10">
                       Booked: ${escapeHtml(booked.status_label || booked.status)}
                   </div>` 
                : '';

            return `
                <article class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm hover:shadow-md hover:border-sky-500 transition-all duration-300 relative overflow-hidden flex flex-col justify-between">
                    ${bookedBadge}
                    
                    <div>
                        <!-- Head -->
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-sky-400 to-sky-600 text-white font-extrabold text-2xl flex items-center justify-center overflow-hidden shadow-sm flex-shrink-0">
                                ${avatar}
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-lg font-bold text-slate-900 truncate">${escapeHtml(mentor.name || 'Mentor')}</h3>
                                <p class="text-sm text-sky-600 font-semibold truncate">${escapeHtml(mentor.expertise || '-')}</p>
                                <span class="text-xs text-slate-400 font-medium">${escapeHtml(mentor.experience_years)} tahun pengalaman</span>
                            </div>
                        </div>

                        <!-- Skills -->
                        <div class="flex flex-wrap gap-1.5 mb-4">${skills || '<span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-slate-100 text-slate-500">Professional Mentor</span>'}</div>

                        <!-- Bio -->
                        <p class="text-sm text-slate-600 leading-relaxed mb-6 font-medium line-clamp-3">
                            ${escapeHtml(mentor.bio || 'Mentor profesional dengan pengalaman industri.')}
                        </p>
                    </div>

                    <!-- Foot & Actions -->
                    <div class="border-t border-slate-100 pt-4 mt-auto">
                        <div class="flex justify-between items-center text-xs text-slate-500 mb-4">
                            <span class="font-bold flex items-center gap-1 text-slate-700">🗓️ ${escapeHtml(mentor.open_slots_count)} Sesi</span>
                            <span class="flex items-center gap-1 font-bold text-slate-700">
                                <span class="text-amber-500 text-sm">★</span>
                                <span>${Number(mentor.rating).toFixed(1)}</span>
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-2">
                            <button class="px-4 py-2.5 text-xs font-bold rounded-xl shadow-sm transition flex items-center justify-center ${followClass}" data-follow-mentor="${escapeHtml(mentor.id)}" type="button" ${isLoading ? 'disabled' : ''}>
                                ${isLoading ? '<span class="small-spinner !mr-0"></span>' : followText}
                            </button>
                            <button class="px-4 py-2.5 bg-sky-600 text-white font-bold rounded-xl text-xs hover:bg-sky-700 transition shadow-sm" data-open-mentor="${escapeHtml(mentor.id)}" type="button">Booking</button>
                        </div>
                    </div>
                </article>
            `;
        }).join('');

        mentorGrid.querySelectorAll('[data-open-mentor]').forEach((button) => {
            button.addEventListener('click', () => openMentorDetail(button.getAttribute('data-open-mentor')));
        });

        mentorGrid.querySelectorAll('[data-follow-mentor]').forEach((button) => {
            button.addEventListener('click', async () => {
                const mentorId = button.getAttribute('data-follow-mentor');
                if (!mentorId) return;

                const isNowFollowed = state.followedMentorIds.includes(mentorId);
                try {
                    state.followLoadingIds.push(mentorId);
                    renderMentors();
                    if (isNowFollowed) {
                        await api(`/api/mentorship/mentors/${mentorId}/follow`, { method: 'DELETE' });
                        state.followedMentorIds = state.followedMentorIds.filter(id => id !== mentorId);
                        showToast('Berhasil berhenti mengikuti mentor', 'success');
                    } else {
                        await api(`/api/mentorship/mentors/${mentorId}/follow`, { method: 'POST' });
                        state.followedMentorIds.push(mentorId);
                        showToast('Berhasil mengikuti mentor', 'success');
                    }
                    state.followLoadingIds = state.followLoadingIds.filter(id => id !== mentorId);
                    renderMentors();
                } catch (err) {
                    state.followLoadingIds = state.followLoadingIds.filter(id => id !== mentorId);
                    renderMentors();
                    showToast(err.message || 'Gagal melakukan aksi follow', 'error');
                }
            });
        });
    }

    function renderBookings() {
        if (!state.bookings.length) {
            bookingList.innerHTML = '<div class="p-8 text-center text-slate-500 border border-dashed border-slate-200 rounded-2xl text-sm">Belum ada data booking pada status ini.</div>';
            return;
        }

        bookingList.innerHTML = state.bookings.map((booking) => {
            const canCancel = booking.status === 'pending';
            const canJoin = booking.status === 'confirmed' && booking.meeting_url;

            let buttonsHtml = `<button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-semibold rounded-xl text-xs hover:bg-slate-50 transition shadow-sm" type="button" data-detail-id="${escapeHtml(booking.id)}">Detail</button>`;

            if (canJoin) {
                buttonsHtml += `<button class="px-4 py-2 bg-sky-600 text-white font-semibold rounded-xl text-xs hover:bg-sky-700 transition shadow-sm" type="button" data-join-booking="${escapeHtml(booking.meeting_url || '')}">Join</button>`;
            }

            if (canCancel) {
                buttonsHtml += `<button class="px-4 py-2 bg-rose-50 border border-rose-200 text-rose-700 font-semibold rounded-xl text-xs hover:bg-rose-100 transition shadow-sm" type="button" data-cancel-booking="${escapeHtml(booking.id)}">Batalkan</button>`;
            }

            if (booking.status === 'completed' && !booking.review) {
                buttonsHtml += `<button class="px-4 py-2 bg-amber-500 text-white font-semibold rounded-xl text-xs hover:bg-amber-600 transition shadow-sm" type="button" data-review-booking="${escapeHtml(booking.id)}">Beri Ulasan</button>`;
            }

            return `
                <article class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5 border border-slate-100 rounded-2xl bg-slate-50/50 hover:bg-slate-50 transition">
                    <div>
                        <div class="mb-1">
                            <strong class="text-base font-bold text-slate-900">${escapeHtml(booking.mentor?.name || 'Mentor')}</strong>
                            ${booking.session_topic ? `<div class="text-sm text-sky-600 font-semibold mt-0.5">${escapeHtml(booking.session_topic)}</div>` : ''}
                        </div>
                        <p class="text-xs text-slate-500 mb-3">
                            ${escapeHtml(booking.mentor?.expertise || '-')} • ${escapeHtml(booking.display_date || '-')} • ${escapeHtml(booking.display_time || '-')}
                        </p>
                        <span class="px-3 py-1 border rounded-full text-[10px] font-bold uppercase tracking-wider ${statusClass(booking.status)}">
                            ${escapeHtml(booking.status_label || booking.status)}
                        </span>
                    </div>
                    <div class="flex flex-wrap gap-2 justify-end items-center">
                        ${buttonsHtml}
                    </div>
                </article>
            `;
        }).join('');

        bookingList.querySelectorAll('[data-detail-id]').forEach((button) => {
            button.addEventListener('click', () => {
                const booking = state.bookings.find((item) => item.id === button.getAttribute('data-detail-id'));
                if (!booking) return;

                const statusBadge = document.getElementById('detailModalStatus');
                statusBadge.textContent = booking.status_label || booking.status;
                statusBadge.className = `px-3 py-1 border rounded-full text-[10px] font-bold uppercase tracking-wider ${statusClass(booking.status)}`;
                statusBadge.style.display = 'inline-block';

                document.getElementById('detailMentorName').textContent = booking.mentor?.name || '-';
                document.getElementById('detailMentorExp').textContent = booking.mentor?.expertise || '-';
                document.getElementById('detailDate').textContent = booking.display_date || '-';
                document.getElementById('detailTime').textContent = booking.display_time || '-';

                const topic = booking.session_topic || booking.booking_notes || 'Sesi mentoring reguler.';
                document.getElementById('detailLabel').textContent = topic;

                // Description
                const descBox = document.getElementById('detailDescriptionBox');
                const descEl = document.getElementById('detailDescription');
                if (booking.session_description) {
                    descBox.classList.remove('hidden');
                    descEl.textContent = booking.session_description;
                } else {
                    descBox.classList.add('hidden');
                }

                // Platform
                const platformBox = document.getElementById('detailPlatformBox');
                const platformEl = document.getElementById('detailPlatform');
                const showPlatform = booking.platform && (booking.status === 'confirmed' || booking.status === 'completed');
                if (showPlatform) {
                    platformBox.classList.remove('hidden');
                    platformEl.textContent = booking.platform;
                } else {
                    platformBox.classList.add('hidden');
                }

                // Meeting URL
                const meetingBox = document.getElementById('detailMeetingBox');
                const meetingUrlEl = document.getElementById('detailMeetingUrl');
                if (booking.status === 'confirmed' && booking.meeting_url) {
                    meetingBox.classList.remove('hidden');
                    meetingUrlEl.href = booking.meeting_url;
                } else {
                    meetingBox.classList.add('hidden');
                }

                // Rejection Reason
                const rejectionBox = document.getElementById('detailRejectionBox');
                const rejectionReasonEl = document.getElementById('detailRejectionReason');
                if (booking.status === 'rejected' && booking.rejection_reason) {
                    rejectionBox.classList.remove('hidden');
                    rejectionReasonEl.textContent = booking.rejection_reason;
                } else {
                    rejectionBox.classList.add('hidden');
                }

                // Material
                const materialBox = document.getElementById('detailMaterialBox');
                const materialUrlEl = document.getElementById('detailMaterialUrl');
                const showMaterial = booking.material_url && (booking.status === 'confirmed' || booking.status === 'completed');
                if (showMaterial) {
                    materialBox.classList.remove('hidden');
                    materialUrlEl.href = booking.material_url;
                } else {
                    materialBox.classList.add('hidden');
                }

                // Mentor Notes
                const notesBox = document.getElementById('detailNotesBox');
                const notesEl = document.getElementById('detailNotes');
                if (booking.session_notes && booking.status === 'completed') {
                    notesBox.classList.remove('hidden');
                    notesEl.textContent = booking.session_notes;
                } else {
                    notesBox.classList.add('hidden');
                }

                // Review details
                const reviewBox = document.getElementById('detailReviewBox');
                const reviewStarsEl = document.getElementById('detailReviewStars');
                const reviewCommentEl = document.getElementById('detailReviewComment');

                if (booking.review) {
                    reviewBox.classList.remove('hidden');
                    reviewStarsEl.innerHTML = `
                        <span class="text-amber-500">${'★'.repeat(booking.review.rating) + '☆'.repeat(5 - booking.review.rating)}</span>
                        <span class="text-xs text-slate-500 font-bold">(${booking.review.rating}/5)</span>`;
                    reviewCommentEl.textContent = booking.review.comment || 'Tidak ada ulasan tertulis.';
                } else {
                    reviewBox.classList.add('hidden');
                }

                document.getElementById('detailModal').classList.add('show');
            });
        });

        bookingList.querySelectorAll('[data-join-booking]').forEach((button) => {
            button.addEventListener('click', () => {
                const url = button.getAttribute('data-join-booking');
                if (url) {
                    window.open(url, '_blank', 'noopener,noreferrer');
                }
            });
        });

        bookingList.querySelectorAll('[data-cancel-booking]').forEach((button) => {
            button.addEventListener('click', () => cancelBooking(button.getAttribute('data-cancel-booking')));
        });

        bookingList.querySelectorAll('[data-review-booking]').forEach((button) => {
            button.addEventListener('click', () => openReviewModal(button.getAttribute('data-review-booking')));
        });
    }

    async function loadMe() {
        const me = await api('/api/auth/me');
        const user = me.data;
        state.me = user;

        if (!user || user.role !== 'jobseeker') {
            showToast('Halaman mentorship ini khusus role jobseeker.', 'error');
            setTimeout(() => {
                window.location.href = '/dashboard';
            }, 900);
            return false;
        }

        try {
            const followed = await api('/api/mentorship/my-followed-mentors');
            state.followedMentorIds = (followed.data?.data || []).map(m => m.id);
        } catch (e) {
            state.followedMentorIds = [];
        }

        return true;
    }

    async function loadMentors() {
        const params = new URLSearchParams();
        Object.entries(state.filters).forEach(([key, value]) => {
            if (String(value || '').trim() !== '') {
                params.set(key, value);
            }
        });

        const endpoint = `/api/mentorship/mentors?${params.toString()}`;
        const response = await api(endpoint);
        state.mentors = response.data?.items || [];
        renderMentors();
    }

    async function loadUpcoming() {
        const response = await api('/api/mentorship/bookings/my?status=pending,confirmed&per_page=5');
        state.upcoming = response.data?.items || [];
        renderUpcoming();
    }

    async function loadBookings() {
        const query = selectedBookingStatus === 'all'
            ? '/api/mentorship/bookings/my?per_page=12'
            : `/api/mentorship/bookings/my?status=${encodeURIComponent(selectedBookingStatus)}&per_page=12`;
        const response = await api(query);
        state.bookings = response.data?.items || [];
        renderBookings();
    }

    function activateTab(status) {
        selectedBookingStatus = status;
        document.querySelectorAll('#bookingTabs button').forEach((button) => {
            const isTarget = button.getAttribute('data-status') === status;
            button.className = isTarget 
                ? 'px-4 py-2 text-sm font-semibold rounded-xl transition bg-slate-900 text-white shadow-sm'
                : 'px-4 py-2 text-sm font-semibold rounded-xl transition text-slate-600 hover:bg-slate-100';
        });
    }

    async function cancelBooking(bookingId) {
        if (!bookingId) return;

        try {
            await api(`/api/mentorship/bookings/${bookingId}/cancel`, {
                method: 'PATCH',
                body: JSON.stringify({}),
            });
            showToast('Booking berhasil dibatalkan.', 'success');
            await Promise.all([loadBookings(), loadUpcoming()]);
        } catch (error) {
            showToast(error.message || 'Gagal membatalkan booking.', 'error');
        }
    }

    async function openMentorDetail(mentorId) {
        if (!mentorId) return;

        try {
            const response = await api(`/api/mentorship/mentors/${mentorId}`);
            activeMentor = response.data?.mentor || null;
            const slots = response.data?.availability_slots || [];
            const reviews = response.data?.reviews || [];
            state.currentSlots = slots;
            selectedSlotId = null;

            if (!activeMentor) {
                showToast('Detail mentor tidak ditemukan.', 'error');
                return;
            }

            modalSubtitle.textContent = `dengan ${activeMentor.name || 'Mentor'}`;
            document.getElementById('slotDetailPanel').classList.add('hidden');

            // Setup follow button in modal
            const modalFollowBtn = document.getElementById('modalFollowBtn');
            if (modalFollowBtn) {
                const isFollowed = state.followedMentorIds.includes(activeMentor.id);
                modalFollowBtn.textContent = isFollowed ? 'Following' : 'Follow';
                modalFollowBtn.className = isFollowed 
                    ? 'px-4 py-2 text-xs font-bold rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 transition shadow-sm' 
                    : 'px-4 py-2 text-xs font-bold rounded-xl bg-slate-900 text-white hover:bg-slate-800 transition shadow-sm';
                modalFollowBtn.disabled = false;
                modalFollowBtn.onclick = async () => {
                    modalFollowBtn.disabled = true;
                    const prevText = modalFollowBtn.textContent;
                    modalFollowBtn.innerHTML = '<span class="small-spinner !mr-0"></span>';
                    try {
                        if (state.followedMentorIds.includes(activeMentor.id)) {
                            await api(`/api/mentorship/mentors/${activeMentor.id}/follow`, { method: 'DELETE' });
                            state.followedMentorIds = state.followedMentorIds.filter(id => id !== activeMentor.id);
                            showToast('Berhasil berhenti mengikuti mentor', 'success');
                        } else {
                            await api(`/api/mentorship/mentors/${activeMentor.id}/follow`, { method: 'POST' });
                            state.followedMentorIds.push(activeMentor.id);
                            showToast('Berhasil mengikuti mentor', 'success');
                        }
                        renderMentors();
                        const nowFollowed = state.followedMentorIds.includes(activeMentor.id);
                        modalFollowBtn.textContent = nowFollowed ? 'Following' : 'Follow';
                        modalFollowBtn.className = nowFollowed 
                            ? 'px-4 py-2 text-xs font-bold rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 transition shadow-sm' 
                            : 'px-4 py-2 text-xs font-bold rounded-xl bg-slate-900 text-white hover:bg-slate-800 transition shadow-sm';
                    } catch (err) {
                        showToast(err.message || 'Gagal melakukan aksi follow', 'error');
                        modalFollowBtn.textContent = prevText;
                    } finally {
                        modalFollowBtn.disabled = false;
                    }
                };
            }

            if (!slots.length) {
                slotGrid.innerHTML = `
                    <div class="col-span-full bg-slate-50 rounded-2xl p-6 border border-slate-100">
                        <div class="text-center text-slate-500 text-sm mb-4">Belum ada slot yang dibuka mentor.</div>
                        <div class="border-t border-slate-200 pt-4 mt-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Minta Jadwal ke Mentor</label>
                            <div class="grid gap-3 sm:grid-cols-3 items-end mb-3">
                                <div>
                                    <label class="block text-[10px] text-slate-400 font-bold uppercase mb-1">Tanggal</label>
                                    <input id="requestDate" type="date" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs" />
                                </div>
                                <div>
                                    <label class="block text-[10px] text-slate-400 font-bold uppercase mb-1">Mulai</label>
                                    <input id="requestStartTime" type="time" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs" />
                                </div>
                                <div>
                                    <label class="block text-[10px] text-slate-400 font-bold uppercase mb-1">Selesai</label>
                                    <input id="requestEndTime" type="time" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs" />
                                </div>
                            </div>
                            <textarea id="requestMessage" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs resize-none mb-3" placeholder="Tulis pesan singkat (opsional), mis. 'Saya ingin diskusi tentang roadmap karier'."></textarea>
                            <div class="flex gap-2">
                                <button id="requestScheduleBtn" class="px-4 py-2 bg-sky-600 text-white font-bold rounded-lg text-xs hover:bg-sky-700 transition" type="button">Minta Jadwal</button>
                                <button id="requestCancelBtn" class="px-4 py-2 bg-slate-100 text-slate-700 font-bold rounded-lg text-xs hover:bg-slate-200 transition" type="button">Batal</button>
                            </div>
                        </div>
                    </div>
                `;
                document.getElementById('slotDetailPanel').classList.add('hidden');
                const bookBtnEl = document.getElementById('bookBtn');
                if (bookBtnEl) bookBtnEl.disabled = true;

                setTimeout(() => {
                    const reqBtn = document.getElementById('requestScheduleBtn');
                    const cancelReqBtn = document.getElementById('requestCancelBtn');
                    const dateInput = document.getElementById('requestDate');
                    const startInput = document.getElementById('requestStartTime');
                    const endInput = document.getElementById('requestEndTime');
                    const bookBtnEl = document.getElementById('bookBtn');

                    // Prefill date/times
                    const dt = new Date();
                    const next = new Date(dt.getTime() + 24*60*60*1000);
                    const yyyy = next.getFullYear();
                    const mm = String(next.getMonth()+1).padStart(2,'0');
                    const dd = String(next.getDate()).padStart(2,'0');
                    if (dateInput && !dateInput.value) dateInput.value = `${yyyy}-${mm}-${dd}`;
                    if (startInput && !startInput.value) startInput.value = '10:00';
                    if (endInput && !endInput.value) endInput.value = '11:00';

                    function updateBookButtonState() {
                        if (!bookBtnEl) return;
                        const hasSelectedSlot = !!selectedSlotId;
                        const hasPreferred = (dateInput && dateInput.value) && (startInput && startInput.value) && (endInput && endInput.value);
                        let validRange = false;
                        if (hasPreferred) {
                            validRange = startInput.value < endInput.value;
                        }
                        bookBtnEl.disabled = !(hasSelectedSlot || (hasPreferred && validRange));
                    }

                    if (dateInput) dateInput.addEventListener('change', updateBookButtonState);
                    if (startInput) startInput.addEventListener('change', updateBookButtonState);
                    if (endInput) endInput.addEventListener('change', updateBookButtonState);

                    if (reqBtn) {
                        reqBtn.addEventListener('click', async () => {
                            await requestSchedule();
                            updateBookButtonState();
                        });
                    }
                    if (cancelReqBtn) {
                        cancelReqBtn.addEventListener('click', () => {
                            if (dateInput) dateInput.value = '';
                            if (startInput) startInput.value = '';
                            if (endInput) endInput.value = '';
                            if (document.getElementById('requestMessage')) document.getElementById('requestMessage').value = '';
                            updateBookButtonState();
                        });
                    }
                    updateBookButtonState();
                }, 40);
            } else {
                slotGrid.innerHTML = slots.map((slot) => `
                    <label class="slot" data-slot-id="${escapeHtml(slot.id)}" data-is-manual="${!!slot.is_manual}">
                        <input type="radio" name="slotChoice" value="${escapeHtml(slot.id)}">
                        <span class="text-xl">🗓</span>
                        <div class="min-w-0">
                            <strong class="text-xs font-bold text-slate-900 block truncate">${escapeHtml(slot.display_date || '-')}</strong>
                            <span class="text-[10px] text-slate-400 font-semibold block truncate">${escapeHtml(slot.display_time || '')}</span>
                        </div>
                    </label>
                `).join('');

                const bookBtnEl = document.getElementById('bookBtn');
                if (bookBtnEl) bookBtnEl.disabled = true;

                slotGrid.querySelectorAll('.slot').forEach((slotEl) => {
                    slotEl.addEventListener('click', () => {
                        const id = slotEl.getAttribute('data-slot-id');
                        const isManual = slotEl.getAttribute('data-is-manual') === 'true';
                        const selectedSlot = slots.find(s => s.id == id && (!!s.is_manual) === isManual);

                        selectedSlotId = id;
                        selectedSlotIsManual = isManual;

                        slotGrid.querySelectorAll('.slot').forEach((item) => item.classList.remove('active'));
                        slotEl.classList.add('active');

                        if (selectedSlot) {
                            const panel = document.getElementById('slotDetailPanel');
                            panel.classList.remove('hidden');
                            document.getElementById('slotDetailDate').textContent = selectedSlot.display_date || '-';
                            document.getElementById('slotDetailTime').textContent = selectedSlot.display_time || '';
                            document.getElementById('slotDetailLabel').textContent = selectedSlot.label || 'Sesi mentoring reguler.';
                            
                            const slotDescEl = document.getElementById('slotDetailDescription');
                            if (selectedSlot.description) {
                                slotDescEl.classList.remove('hidden');
                                slotDescEl.textContent = selectedSlot.description;
                            } else {
                                slotDescEl.classList.add('hidden');
                            }
                            if (bookBtnEl) bookBtnEl.disabled = false;
                        }
                    });
                });
            }

            const reviewsListEl = document.getElementById('mentorReviewsList');
            if (!reviews.length) {
                reviewsListEl.innerHTML = '<div class="p-4 text-center text-slate-400 text-xs border border-slate-100 rounded-xl bg-slate-50/50">Belum ada ulasan untuk mentor ini.</div>';
            } else {
                reviewsListEl.innerHTML = reviews.map((rev) => `
                    <div class="p-4 bg-slate-55 border border-slate-100 rounded-2xl bg-slate-50/50">
                        <div class="flex justify-between items-center mb-2">
                            <strong class="text-xs font-bold text-slate-900">${escapeHtml(rev.jobseeker_name)}</strong>
                            <span class="text-[10px] text-slate-400 font-semibold">${escapeHtml(rev.created_at)}</span>
                        </div>
                        <div class="flex items-center gap-1 mb-2">
                            <span class="text-amber-500 text-xs">${'★'.repeat(rev.rating) + '☆'.repeat(5 - rev.rating)}</span>
                            <span class="text-[10px] font-bold text-slate-500">(${rev.rating}/5)</span>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">${escapeHtml(rev.comment || 'Mentee tidak menulis ulasan tertulis.')}</p>
                    </div>
                `).join('');
            }

            mentorModal.classList.add('show');
        } catch (error) {
            showToast(error.message || 'Gagal membuka profil mentor.', 'error');
        }
    }

    async function submitBooking() {
        if (!activeMentor?.id) {
            showToast('Mentor belum dipilih.', 'error');
            return;
        }

        if (!selectedSlotId) {
            const dateEl = document.getElementById('requestDate');
            const startEl = document.getElementById('requestStartTime');
            const endEl = document.getElementById('requestEndTime');
            const hasPreferred = dateEl && dateEl.value && startEl && startEl.value && endEl && endEl.value && (startEl.value < endEl.value);
            if (!state.currentSlots || !state.currentSlots.length) {
                if (hasPreferred) {
                    await requestSchedule();
                    return;
                }
                showToast('Mentor belum membuka slot. Silakan hubungi mentor.', 'error');
                return;
            }
        }

        const payload = { mentor_id: activeMentor.id };
        if (selectedSlotId) {
            if (selectedSlotIsManual) {
                payload.sesi_jadwal_id = selectedSlotId;
            } else {
                payload.mentor_availability_id = selectedSlotId;
            }
        } else {
            showToast('Pilih salah satu jadwal terlebih dahulu.', 'error');
            return;
        }

        try {
            await api('/api/mentorship/bookings', {
                method: 'POST',
                body: JSON.stringify(payload),
            });

            showToast('Booking sesi berhasil dibuat.', 'success');
            mentorModal.classList.remove('show');
            selectedSlotId = null;
            state.currentSlots = [];
            const bookBtnEl = document.getElementById('bookBtn');
            if (bookBtnEl) bookBtnEl.disabled = false;

            await Promise.all([loadMentors(), loadBookings(), loadUpcoming()]);
        } catch (error) {
            showToast(error.message || 'Booking sesi gagal diproses.', 'error');
        }
    }

    function openReviewModal(bookingId) {
        document.getElementById('reviewBookingId').value = bookingId;
        const ratingInputs = document.getElementsByName('reviewRating');
        ratingInputs.forEach(input => input.checked = false);
        document.getElementById('reviewComment').value = '';
        document.getElementById('ratingErrorMessage').classList.add('hidden');
        document.getElementById('reviewModal').classList.add('show');
    }

    async function submitReview() {
        const bookingId = document.getElementById('reviewBookingId').value;
        const ratingInputs = document.getElementsByName('reviewRating');
        let rating = null;
        for (const input of ratingInputs) {
            if (input.checked) {
                rating = input.value;
                break;
            }
        }

        if (!rating) {
            document.getElementById('ratingErrorMessage').classList.remove('hidden');
            return;
        }

        document.getElementById('ratingErrorMessage').classList.add('hidden');
        const comment = document.getElementById('reviewComment').value.trim();
        const submitBtn = document.getElementById('submitReviewBtn');
        const originalText = submitBtn.textContent;

        submitBtn.disabled = true;
        submitBtn.textContent = 'Mengirim...';

        try {
            await api(`/api/mentorship/bookings/${bookingId}/reviews`, {
                method: 'POST',
                body: JSON.stringify({
                    rating: parseInt(rating),
                    comment: comment || null
                })
            });

            showToast('Ulasan Anda berhasil dikirim!', 'success');
            document.getElementById('reviewModal').classList.remove('show');
            await Promise.all([loadBookings(), loadMentors()]);
        } catch (error) {
            showToast(error.message || 'Gagal mengirimkan ulasan.', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    }

    async function requestSchedule() {
        if (!activeMentor?.id) {
            showToast('Mentor belum dipilih.', 'error');
            return;
        }

        const msgEl = document.getElementById('requestMessage');
        const reqBtn = document.getElementById('requestScheduleBtn');
        if (reqBtn) reqBtn.disabled = true;
        const message = msgEl ? msgEl.value.trim() : '';
        const dateEl = document.getElementById('requestDate');
        const startEl = document.getElementById('requestStartTime');
        const endEl = document.getElementById('requestEndTime');
        const preferred_date = dateEl ? dateEl.value : null;
        const preferred_start = startEl ? startEl.value : null;
        const preferred_end = endEl ? endEl.value : null;

        try {
            if (reqBtn) reqBtn.innerHTML = '<span class="small-spinner !mr-0"></span>';
            await api('/api/mentorship/mentor-requests', {
                method: 'POST',
                body: JSON.stringify({ mentor_id: activeMentor.id, message, preferred_date, preferred_start, preferred_end }),
            });

            showToast('Permintaan jadwal berhasil dikirim ke mentor.', 'success');
            if (msgEl) msgEl.value = '';
        } catch (err) {
            showToast(err.message || 'Gagal mengirim permintaan jadwal.', 'error');
        } finally {
            if (reqBtn) {
                reqBtn.disabled = false;
                reqBtn.textContent = 'Minta Jadwal';
            }
        }
    }

    function bindEvents() {
        document.getElementById('searchBtn').addEventListener('click', async () => {
            state.filters.search = searchInput.value.trim();
            await loadMentors();
        });

        searchInput.addEventListener('keydown', async (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                state.filters.search = searchInput.value.trim();
                await loadMentors();
            }
        });

        document.getElementById('filterToggle').addEventListener('click', () => {
            filterPanel.classList.toggle('hidden');
            filterPanel.classList.toggle('grid');
        });

        document.getElementById('applyFilterBtn').addEventListener('click', async () => {
            state.filters.expertise = expertiseInput.value.trim();
            state.filters.min_experience = experienceInput.value;
            state.filters.min_rating = ratingInput.value;
            await loadMentors();
        });

        document.getElementById('refreshUpcomingBtn').addEventListener('click', loadUpcoming);
        document.getElementById('refreshBookingsBtn').addEventListener('click', loadBookings);

        document.querySelectorAll('#bookingTabs button').forEach((button) => {
            button.addEventListener('click', async () => {
                activateTab(button.getAttribute('data-status') || 'all');
                await loadBookings();
            });
        });

        document.getElementById('closeModalBtn').addEventListener('click', () => {
            state.currentSlots = [];
            selectedSlotId = null;
            const bookBtnEl = document.getElementById('bookBtn');
            if (bookBtnEl) bookBtnEl.disabled = false;
            mentorModal.classList.remove('show');
        });

        document.getElementById('closeDetailBtn').addEventListener('click', () => {
            document.getElementById('detailModal').classList.remove('show');
        });

        mentorModal.addEventListener('click', (event) => {
            if (event.target === mentorModal) {
                state.currentSlots = [];
                selectedSlotId = null;
                const bookBtnEl = document.getElementById('bookBtn');
                if (bookBtnEl) bookBtnEl.disabled = false;
                mentorModal.classList.remove('show');
            }
        });

        document.getElementById('bookBtn').addEventListener('click', submitBooking);

        document.getElementById('closeReviewModalBtn').addEventListener('click', () => {
            document.getElementById('reviewModal').classList.remove('show');
        });

        document.getElementById('submitReviewBtn').addEventListener('click', submitReview);

        const reviewModal = document.getElementById('reviewModal');
        reviewModal.addEventListener('click', (event) => {
            if (event.target === reviewModal) {
                reviewModal.classList.remove('show');
            }
        });
    }

    function clearAuthStorage() {
        if (typeof window.hirifyClearAuth === 'function') {
            window.hirifyClearAuth();
        }
    }

    async function boot() {
        try {
            const roleOk = await loadMe();
            if (!roleOk) return;

            bindEvents();
            await Promise.all([loadMentors(), loadBookings(), loadUpcoming()]);
        } catch (error) {
            if (error.message.toLowerCase().includes('unauthenticated')) {
                clearAuthStorage();
                window.location.href = '/login';
                return;
            }
            showToast(error.message || 'Gagal memuat halaman mentorship.', 'error');
        }
    }

    boot();
</script>
@endpush
