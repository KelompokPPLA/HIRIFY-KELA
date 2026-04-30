<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hirify | Mentorship</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap');

        :root {
            --bg: #f4f8fd;
            --card: #ffffff;
            --ink: #0d1b3d;
            --muted: #6c7a93;
            --line: #e5edf6;
            --brand: #06cbe5;
            --brand-dark: #06b0c6;
            --deep: #08152f;
            --ok: #0b7f53;
            --warn: #b98007;
            --danger: #b42318;
            --shadow: 0 20px 45px rgba(9, 20, 51, 0.08);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 5% 15%, rgba(6, 203, 229, 0.16), transparent 24%),
                radial-gradient(circle at 95% 5%, rgba(6, 203, 229, 0.12), transparent 20%),
                var(--bg);
        }

        .layout {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 250px 1fr;
        }

        .sidebar {
            background: #ffffff;
            border-right: 1px solid var(--line);
            padding: 22px 16px;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 30px;
            letter-spacing: -0.02em;
        }

        .brand-mark {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            background: linear-gradient(145deg, #0399b7, #06d8ee);
            display: grid;
            place-items: center;
            color: #fff;
            font-size: 17px;
            font-weight: 800;
        }

        .menu {
            display: grid;
            gap: 8px;
        }

        .menu button {
            border: 0;
            background: transparent;
            color: #1a2a4c;
            font: inherit;
            text-align: left;
            border-radius: 12px;
            padding: 11px 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-weight: 600;
        }

        .menu button:hover {
            background: #f2f8ff;
        }

        .menu button.active {
            background: linear-gradient(145deg, #0a1632, #111f45);
            color: #f2fbff;
            box-shadow: 0 10px 20px rgba(11, 24, 54, 0.22);
        }

        .profile-mini {
            margin-top: auto;
            background: #f8fbff;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar-mini {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(140deg, #0499b3, #05d5ef);
            color: #fff;
            display: grid;
            place-items: center;
            font-weight: 800;
        }

        .profile-mini strong {
            display: block;
            font-size: .92rem;
        }

        .profile-mini span {
            color: var(--muted);
            font-size: .82rem;
        }

        .content {
            padding: 24px;
            display: grid;
            gap: 18px;
        }

        .title-wrap h1 {
            margin: 0;
            font-size: clamp(28px, 4vw, 40px);
            letter-spacing: -0.03em;
        }

        .title-wrap p {
            margin: 6px 0 0;
            color: var(--muted);
            font-weight: 500;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: var(--shadow);
        }

        .upcoming {
            padding: 14px;
            border: 1px solid rgba(6, 203, 229, 0.4);
            background: linear-gradient(180deg, #f0fdff, #f8feff);
        }

        .section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 10px;
        }

        .section-head h2 {
            margin: 0;
            font-size: 1.15rem;
        }

        .upcoming-list {
            display: grid;
            gap: 10px;
        }

        .upcoming-item {
            background: #fff;
            border: 1px solid #dbedf5;
            border-radius: 14px;
            padding: 12px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;
            align-items: center;
        }

        .upcoming-meta strong {
            display: block;
            margin-bottom: 2px;
        }

        .upcoming-meta small {
            color: var(--muted);
        }

        .join-btn {
            border: 0;
            border-radius: 10px;
            background: linear-gradient(140deg, #07c9e2, #00b7d0);
            color: #fff;
            font: inherit;
            font-weight: 700;
            padding: 10px 16px;
            cursor: pointer;
        }

        .join-btn:disabled {
            opacity: .55;
            cursor: not-allowed;
        }

        .search-card {
            padding: 14px;
        }

        .search-row {
            display: grid;
            grid-template-columns: 1fr auto auto;
            gap: 10px;
            align-items: center;
        }

        .input, .select, .textarea {
            width: 100%;
            border-radius: 12px;
            border: 1px solid #d5e3f1;
            background: #fff;
            padding: 11px 13px;
            font: inherit;
            color: var(--ink);
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .input:focus, .select:focus, .textarea:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(6, 203, 229, 0.16);
        }

        .btn {
            border: 0;
            border-radius: 12px;
            padding: 11px 14px;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
            transition: transform .15s ease, box-shadow .2s ease, opacity .2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-brand {
            background: linear-gradient(140deg, #08cde6, #00b2cb);
            color: #fff;
        }

        .btn-ghost {
            background: #f3f8fe;
            color: #17315f;
            border: 1px solid #dbe8f6;
        }

        .btn-danger {
            background: rgba(180, 35, 24, 0.08);
            color: var(--danger);
            border: 1px solid rgba(180, 35, 24, 0.24);
        }

        .filter-panel {
            margin-top: 10px;
            display: none;
            grid-template-columns: 1fr 1fr 1fr 1fr auto;
            gap: 10px;
        }

        .filter-panel.show {
            display: grid;
        }

        .section-title {
            margin: 8px 0 0;
            font-size: 1.6rem;
            letter-spacing: -0.02em;
        }

        .mentor-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .mentor-card {
            padding: 16px;
            display: grid;
            gap: 12px;
        }

        .mentor-head {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mentor-avatar {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: linear-gradient(140deg, #046e93, #07cde7);
            color: #fff;
            font-weight: 800;
            font-size: 1.45rem;
            display: grid;
            place-items: center;
            overflow: hidden;
        }

        .mentor-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .mentor-head h3 {
            margin: 0;
            font-size: 1.8rem;
            letter-spacing: -0.02em;
        }

        .mentor-head p {
            margin: 2px 0;
            color: #294572;
            font-weight: 600;
        }

        .mentor-sub {
            color: var(--muted);
            font-size: .9rem;
        }

        .tag-list {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        .tag {
            padding: 4px 9px;
            border-radius: 999px;
            font-size: .78rem;
            background: #edfcff;
            color: #0494ab;
            font-weight: 700;
        }

        .mentor-bio {
            color: #40567f;
            line-height: 1.55;
            min-height: 50px;
        }

        .mentor-foot {
            border-top: 1px solid var(--line);
            padding-top: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .stats {
            display: flex;
            gap: 12px;
            color: #365179;
            font-size: .92rem;
            font-weight: 600;
        }

        .price {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: #0c2553;
        }

        .empty {
            padding: 26px;
            text-align: center;
            color: var(--muted);
            background: #fff;
            border-radius: 16px;
            border: 1px dashed #cfdded;
        }

        .booking-panel {
            padding: 16px;
            display: grid;
            gap: 12px;
        }

        .booking-tabs {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .booking-tabs button {
            border: 1px solid #d7e5f3;
            border-radius: 999px;
            background: #fff;
            padding: 7px 12px;
            font: inherit;
            font-weight: 700;
            color: #274472;
            cursor: pointer;
        }

        .booking-tabs button.active {
            background: #0f2147;
            color: #fff;
            border-color: #0f2147;
        }

        .booking-list {
            display: grid;
            gap: 10px;
        }

        .booking-item {
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 12px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;
            align-items: center;
        }

        .booking-item strong {
            display: block;
            margin-bottom: 2px;
        }

        .booking-item small {
            color: var(--muted);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: .76rem;
            border-radius: 999px;
            padding: 5px 10px;
            font-weight: 700;
            margin-top: 7px;
        }

        .badge.pending { background: #fff8e1; color: var(--warn); }
        .badge.confirmed { background: #e7f6ff; color: #0d6db1; }
        .badge.completed { background: #eafaf2; color: var(--ok); }
        .badge.cancelled, .badge.rejected { background: #fdeceb; color: var(--danger); }

        .booking-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 8px;
        }

        .modal {
            position: fixed;
            inset: 0;
            background: rgba(6, 16, 38, 0.52);
            display: none;
            place-items: center;
            z-index: 30;
            padding: 20px;
        }

        .modal.show {
            display: grid;
            animation: fadeIn .2s ease;
        }

        .modal-card {
            width: min(820px, 100%);
            max-height: calc(100vh - 40px);
            overflow: auto;
            background: #fff;
            border-radius: 20px;
            border: 1px solid #dce9f6;
            box-shadow: 0 26px 70px rgba(7, 18, 40, .22);
            padding: 18px;
            display: grid;
            gap: 14px;
        }

        .booking-modal {
            width: min(660px, 100%);
            max-height: calc(100vh - 60px);
            padding: 0;
            display: block;
            overflow: hidden;
        }

        .booking-scroll {
            max-height: calc(100vh - 60px);
            overflow: auto;
        }

        .booking-head {
            padding: 20px 22px 14px;
            border-bottom: 1px solid var(--line);
        }

        .booking-head h3 {
            margin: 0;
            font-size: 2rem;
            letter-spacing: -0.02em;
        }

        .booking-head p {
            margin: 4px 0 0;
            color: var(--muted);
            font-weight: 600;
        }

        .booking-body {
            padding: 16px 22px 18px;
            display: grid;
            gap: 14px;
        }

        .booking-label {
            margin: 0 0 8px;
            font-size: .98rem;
            font-weight: 800;
            color: #172c52;
        }

        .topic-input {
            min-height: 110px;
            resize: vertical;
            background: #f8fbff;
        }

        .slot {
            border: 1px solid #d5e5f4;
            border-radius: 12px;
            padding: 12px;
            cursor: pointer;
            transition: border-color .2s ease, background .2s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            min-height: 74px;
        }

        .slot-icon {
            width: 30px;
            height: 30px;
            border-radius: 9px;
            background: #ecfbff;
            color: #0ab9d1;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            font-size: 16px;
        }

        .slot-time {
            color: #476186;
            font-size: .88rem;
        }

        .summary-box {
            border: 1px solid #e0eaf5;
            border-radius: 14px;
            background: #f7fbff;
            padding: 12px;
            display: grid;
            gap: 9px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            color: #28446d;
            font-weight: 600;
        }

        .summary-total {
            border-top: 1px solid #d7e4f2;
            padding-top: 10px;
            color: #112a54;
            font-size: 1.05rem;
            font-weight: 800;
        }

        .booking-footer {
            border-top: 1px solid var(--line);
            padding: 12px 22px 18px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            background: #fff;
        }

        .btn-solid {
            background: #07193d;
            color: #fff;
        }

        .modal-head {
            display: flex;
            justify-content: space-between;
            align-items: start;
            gap: 10px;
        }

        .slot-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .slot input {
            display: none;
        }

        .slot.active {
            border-color: #06c8e1;
            background: #f0fdff;
            box-shadow: 0 0 0 4px rgba(6, 203, 229, 0.13);
        }

        .slot strong {
            display: block;
            font-size: .9rem;
        }

        .slot span {
            color: #416187;
            font-size: .83rem;
        }

        .modal-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .meta-row {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .meta-box {
            background: #f7fbff;
            border: 1px solid #deebf8;
            border-radius: 12px;
            padding: 10px;
        }

        .meta-box small {
            color: var(--muted);
            display: block;
            margin-bottom: 4px;
        }

        .meta-box strong {
            font-size: .98rem;
        }

        .muted {
            color: var(--muted);
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 1220px) {
            .mentor-grid {
                grid-template-columns: 1fr;
            }

            .slot-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 980px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                border-right: 0;
                border-bottom: 1px solid var(--line);
            }

            .filter-panel {
                grid-template-columns: 1fr 1fr;
            }

            .search-row {
                grid-template-columns: 1fr;
            }

            .modal-grid, .meta-row {
                grid-template-columns: 1fr;
            }

            .booking-footer {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .content {
                padding: 14px;
            }

            .slot-grid {
                grid-template-columns: 1fr;
            }

            .upcoming-item, .booking-item {
                grid-template-columns: 1fr;
            }

            .booking-actions {
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body>
    @include('components.auth.toast')

    <div class="layout">
        <aside class="sidebar">
            <div class="brand">
                <span class="brand-mark">H</span>
                <span>Hirify!</span>
            </div>

            <div class="menu">
                <button type="button" data-nav="dashboard">Dashboard</button>
                <button type="button" data-nav="profile">Profil</button>
                <button type="button">Manajemen CV</button>
                <button type="button">Roadmap Karier</button>
                <button type="button" class="active">Mentorship</button>
                <button type="button" data-nav="skill-training">Pelatihan Skill</button>
                <button type="button" data-nav="forum">Forum Diskusi</button>
                <button type="button">Notifikasi</button>
            </div>

            <div class="profile-mini">
                <div class="avatar-mini" id="miniAvatar">U</div>
                <div>
                    <strong id="miniName">User Name</strong>
                    <span id="miniEmail">user@email.com</span>
                </div>
            </div>
        </aside>

        <main class="content">
            <section class="title-wrap">
                <h1>Mentorship</h1>
                <p>Telusuri mentor terbaik, booking sesi, dan pantau status pengembangan karier Anda.</p>
            </section>

            <section class="card upcoming">
                <div class="section-head">
                    <h2>Sesi Mendatang</h2>
                    <button class="btn btn-ghost" type="button" id="refreshUpcomingBtn">Refresh</button>
                </div>
                <div id="upcomingList" class="upcoming-list"></div>
            </section>

            <section class="card search-card">
                <div class="search-row">
                    <input id="searchInput" class="input" placeholder="Cari mentor berdasarkan nama, keahlian, atau kata kunci...">
                    <button id="searchBtn" class="btn btn-brand" type="button">Cari Mentor</button>
                    <button id="filterToggle" class="btn btn-ghost" type="button">Filter</button>
                </div>

                <div id="filterPanel" class="filter-panel">
                    <input id="expertiseInput" class="input" placeholder="Bidang keahlian, contoh: UI/UX">
                    <select id="sortInput" class="select">
                        <option value="recommended">Urutkan: Rekomendasi</option>
                        <option value="experience">Pengalaman tertinggi</option>
                        <option value="price_low">Harga terendah</option>
                        <option value="price_high">Harga tertinggi</option>
                    </select>
                    <input id="priceMinInput" class="input" type="number" min="0" step="10000" placeholder="Harga min">
                    <input id="priceMaxInput" class="input" type="number" min="0" step="10000" placeholder="Harga max">
                    <button id="applyFilterBtn" class="btn btn-brand" type="button">Terapkan</button>
                </div>
            </section>

            <section>
                <h2 class="section-title">Daftar Mentor</h2>
                <div id="mentorGrid" class="mentor-grid" style="margin-top:10px;"></div>
            </section>

            <section class="card booking-panel">
                <div class="section-head">
                    <h2>Status Booking Saya</h2>
                    <button id="refreshBookingsBtn" class="btn btn-ghost" type="button">Refresh</button>
                </div>

                <div class="booking-tabs" id="bookingTabs">
                    <button class="active" data-status="all">Semua</button>
                    <button data-status="pending">Pending</button>
                    <button data-status="confirmed">Confirmed</button>
                    <button data-status="completed">Completed</button>
                    <button data-status="cancelled">Cancelled</button>
                </div>

                <div id="bookingList" class="booking-list"></div>
            </section>
        </main>
    </div>

    <section id="mentorModal" class="modal">
        <div class="modal-card booking-modal">
            <div class="booking-scroll">
                <div class="booking-head">
                    <h3>Booking Sesi Mentorship</h3>
                    <p id="modalSubtitle">dengan Mentor</p>
                </div>

                <div class="booking-body">
                    <div>
                        <p class="booking-label">Pilih Jadwal</p>
                        <div id="slotGrid" class="slot-grid"></div>
                    </div>

                    <div class="modal-grid">
                        <div>
                            <label class="muted" for="manualDate">Atur manual (opsional)</label>
                            <input id="manualDate" class="input" type="datetime-local">
                        </div>
                        <div>
                            <label class="muted" for="durationInput">Durasi (menit)</label>
                            <select id="durationInput" class="select">
                                <option value="60">60 menit</option>
                                <option value="90">90 menit</option>
                                <option value="120">120 menit</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <p class="booking-label">Topik yang Ingin Dibahas</p>
                        <textarea id="bookingNotes" class="textarea topic-input" placeholder="Jelaskan topik yang ingin Anda diskusikan dengan mentor..."></textarea>
                    </div>

                    <div class="summary-box">
                        <div class="summary-row">
                            <span>Harga sesi</span>
                            <strong id="summaryPrice">Rp 0/sesi</strong>
                        </div>
                        <div class="summary-row">
                            <span>Platform fee</span>
                            <strong>Gratis</strong>
                        </div>
                        <div class="summary-row summary-total">
                            <span>Total</span>
                            <strong id="summaryTotal">Rp 0/sesi</strong>
                        </div>
                    </div>
                </div>

                <div class="booking-footer">
                    <button id="closeModalBtn" class="btn btn-ghost" type="button">Batal</button>
                    <button id="bookBtn" class="btn btn-solid" type="button">Konfirmasi Booking</button>
                </div>
            </div>
        </div>
    </section>

    <script>
        const showToast = window.hirifyShowToast;

        let token = localStorage.getItem('hirify_token') || sessionStorage.getItem('hirify_token');
        let selectedBookingStatus = 'all';
        let selectedSlotId = null;
        let activeMentor = null;

        const state = {
            me: null,
            mentors: [],
            bookings: [],
            upcoming: [],
            filters: {
                search: '',
                expertise: '',
                sort: 'recommended',
                price_min: '',
                price_max: '',
            },
        };

        const searchInput = document.getElementById('searchInput');
        const expertiseInput = document.getElementById('expertiseInput');
        const sortInput = document.getElementById('sortInput');
        const priceMinInput = document.getElementById('priceMinInput');
        const priceMaxInput = document.getElementById('priceMaxInput');
        const filterPanel = document.getElementById('filterPanel');
        const mentorGrid = document.getElementById('mentorGrid');
        const bookingList = document.getElementById('bookingList');
        const upcomingList = document.getElementById('upcomingList');

        const mentorModal = document.getElementById('mentorModal');
        const modalSubtitle = document.getElementById('modalSubtitle');
        const summaryPrice = document.getElementById('summaryPrice');
        const summaryTotal = document.getElementById('summaryTotal');
        const slotGrid = document.getElementById('slotGrid');

        const manualDate = document.getElementById('manualDate');
        const durationInput = document.getElementById('durationInput');
        const bookingNotes = document.getElementById('bookingNotes');

        if (!token) {
            window.location.href = '/login';
        }

        function clearAuthStorage() {
            localStorage.removeItem('hirify_token');
            localStorage.removeItem('hirify_user');
            localStorage.removeItem('hirify_remember');
            sessionStorage.removeItem('hirify_token');
            sessionStorage.removeItem('hirify_user');
        }

        function activeStorage() {
            return localStorage.getItem('hirify_token') ? localStorage : sessionStorage;
        }

        async function refreshToken() {
            if (!token) {
                return false;
            }

            try {
                const response = await fetch('/api/auth/refresh', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`,
                    },
                });

                const result = await response.json();

                if (!response.ok || result.success === false || !result?.data?.token) {
                    return false;
                }

                token = result.data.token;
                activeStorage().setItem('hirify_token', token);

                if (result.data.user) {
                    activeStorage().setItem('hirify_user', JSON.stringify(result.data.user));
                }

                return true;
            } catch (_) {
                return false;
            }
        }

        async function api(path, options = {}, canRetry = true) {
            const response = await fetch(path, {
                ...options,
                headers: {
                    'Accept': 'application/json',
                    ...(options.body instanceof FormData ? {} : { 'Content-Type': 'application/json' }),
                    'Authorization': `Bearer ${token}`,
                    ...(options.headers || {}),
                },
            });

            let data = {};
            try {
                data = await response.json();
            } catch (_) {
                data = {};
            }

            if (response.status === 401 && canRetry) {
                const refreshed = await refreshToken();
                if (refreshed) {
                    return api(path, options, false);
                }
            }

            if (!response.ok || data.success === false) {
                throw new Error(data.message || 'Terjadi kesalahan request.');
            }

            return data;
        }

        function escapeHtml(text) {
            return String(text || '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#39;');
        }

        function formatRupiah(value) {
            return new Intl.NumberFormat('id-ID').format(Number(value || 0));
        }

        function getInitial(name) {
            return (name?.trim()?.[0] || 'M').toUpperCase();
        }

        function statusClass(status) {
            const value = String(status || '').toLowerCase();
            if (['pending', 'confirmed', 'completed', 'cancelled', 'rejected'].includes(value)) {
                return value;
            }
            return 'pending';
        }

        function renderUpcoming() {
            if (!state.upcoming.length) {
                upcomingList.innerHTML = '<div class="empty">Belum ada sesi mendatang. Pilih mentor dan lakukan booking sesi pertama Anda.</div>';
                return;
            }

            upcomingList.innerHTML = state.upcoming.map((item) => {
                const canJoin = item.status === 'confirmed' && item.meeting_url;
                return `
                    <article class="upcoming-item">
                        <div class="upcoming-meta">
                            <strong>${escapeHtml(item.mentor?.name || 'Mentor')}</strong>
                            <small>${escapeHtml(item.mentor?.expertise || '-')} • ${escapeHtml(item.display_date || '')} • ${escapeHtml(item.display_time || '')}</small>
                        </div>
                        <button class="join-btn" ${canJoin ? '' : 'disabled'} data-join-url="${escapeHtml(item.meeting_url || '')}">
                            ${canJoin ? 'Join' : 'Menunggu'}
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
                mentorGrid.innerHTML = '<div class="empty">Mentor tidak ditemukan. Ubah kata kunci atau filter pencarian Anda.</div>';
                return;
            }

            mentorGrid.innerHTML = state.mentors.map((mentor) => {
                const skills = (mentor.skills || []).slice(0, 4)
                    .map((skill) => `<span class="tag">${escapeHtml(skill)}</span>`)
                    .join('');

                const avatar = mentor.avatar_url
                    ? `<img src="${escapeHtml(mentor.avatar_url)}" alt="Avatar mentor">`
                    : escapeHtml(getInitial(mentor.name));

                return `
                    <article class="card mentor-card">
                        <div class="mentor-head">
                            <div class="mentor-avatar">${avatar}</div>
                            <div>
                                <h3>${escapeHtml(mentor.name || 'Mentor')}</h3>
                                <p>${escapeHtml(mentor.expertise || '-')}</p>
                                <div class="mentor-sub">${escapeHtml(mentor.experience_years)} tahun pengalaman • ${escapeHtml(mentor.open_slots_count)} slot tersedia</div>
                            </div>
                        </div>

                        <div class="tag-list">${skills || '<span class="tag">Professional Mentor</span>'}</div>

                        <div class="mentor-bio">${escapeHtml((mentor.bio || 'Mentor profesional dengan pengalaman industri.').slice(0, 160))}</div>

                        <div class="mentor-foot">
                            <div class="stats">
                                <span>⭐ ${escapeHtml(mentor.rating)}</span>
                                <span>📚 ${escapeHtml(mentor.session_count)} sesi</span>
                            </div>
                            <div class="price">Rp ${formatRupiah(mentor.price_per_session)}/sesi</div>
                        </div>

                        <button class="btn btn-brand" data-open-mentor="${escapeHtml(mentor.id)}" type="button">Lihat Profil & Booking</button>
                    </article>
                `;
            }).join('');

            mentorGrid.querySelectorAll('[data-open-mentor]').forEach((button) => {
                button.addEventListener('click', () => openMentorDetail(button.getAttribute('data-open-mentor')));
            });
        }

        function renderBookings() {
            if (!state.bookings.length) {
                bookingList.innerHTML = '<div class="empty">Belum ada data booking pada status ini.</div>';
                return;
            }

            bookingList.innerHTML = state.bookings.map((booking) => {
                const canCancel = ['pending', 'confirmed'].includes(booking.status);
                const canJoin = booking.status === 'confirmed' && booking.meeting_url;

                return `
                    <article class="booking-item">
                        <div>
                            <strong>${escapeHtml(booking.mentor?.name || 'Mentor')}</strong>
                            <small>${escapeHtml(booking.mentor?.expertise || '-')}</small><br>
                            <small>${escapeHtml(booking.display_date || '-')} • ${escapeHtml(booking.display_time || '-')}</small>
                            <div class="badge ${statusClass(booking.status)}">${escapeHtml(booking.status_label || booking.status)}</div>
                        </div>
                        <div class="booking-actions">
                            <button class="btn btn-ghost" type="button" data-detail-id="${escapeHtml(booking.id)}">Detail</button>
                            <button class="btn btn-brand" type="button" ${canJoin ? '' : 'disabled'} data-join-booking="${escapeHtml(booking.meeting_url || '')}">Join</button>
                            <button class="btn btn-danger" type="button" ${canCancel ? '' : 'disabled'} data-cancel-booking="${escapeHtml(booking.id)}">Batalkan</button>
                        </div>
                    </article>
                `;
            }).join('');

            bookingList.querySelectorAll('[data-detail-id]').forEach((button) => {
                button.addEventListener('click', () => {
                    const booking = state.bookings.find((item) => item.id === button.getAttribute('data-detail-id'));
                    if (!booking) {
                        return;
                    }
                    showToast(`${booking.status_label}. ${booking.display_date} ${booking.display_time}.`, 'info');
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

            document.getElementById('miniName').textContent = user.name || 'User';
            document.getElementById('miniEmail').textContent = user.email || '-';
            document.getElementById('miniAvatar').textContent = getInitial(user.name);

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
                button.classList.toggle('active', button.getAttribute('data-status') === status);
            });
        }

        async function cancelBooking(bookingId) {
            if (!bookingId) {
                return;
            }

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
            if (!mentorId) {
                return;
            }

            try {
                const response = await api(`/api/mentorship/mentors/${mentorId}`);
                activeMentor = response.data?.mentor || null;
                const slots = response.data?.availability_slots || [];
                selectedSlotId = null;

                if (!activeMentor) {
                    showToast('Detail mentor tidak ditemukan.', 'error');
                    return;
                }

                modalSubtitle.textContent = `dengan ${activeMentor.name || 'Mentor'}`;
                summaryPrice.textContent = `Rp ${formatRupiah(activeMentor.price_per_session || 0)}/sesi`;
                summaryTotal.textContent = `Rp ${formatRupiah(activeMentor.price_per_session || 0)}/sesi`;
                bookingNotes.value = '';

                if (!slots.length) {
                    slotGrid.innerHTML = '<div class="empty" style="grid-column:1/-1;">Belum ada slot yang dibuka mentor. Anda tetap bisa mengajukan jadwal manual.</div>';
                } else {
                    slotGrid.innerHTML = slots.map((slot) => `
                        <label class="slot" data-slot-id="${escapeHtml(slot.id)}">
                            <input type="radio" name="slotChoice" value="${escapeHtml(slot.id)}">
                            <span class="slot-icon">🗓</span>
                            <div>
                                <strong>${escapeHtml(slot.display_date || '-')}</strong>
                                <span class="slot-time">${escapeHtml(slot.display_time || '-')}</span>
                            </div>
                        </label>
                    `).join('');

                    slotGrid.querySelectorAll('.slot').forEach((slotEl) => {
                        slotEl.addEventListener('click', () => {
                            selectedSlotId = slotEl.getAttribute('data-slot-id');
                            slotGrid.querySelectorAll('.slot').forEach((item) => item.classList.remove('active'));
                            slotEl.classList.add('active');
                            manualDate.value = '';
                        });
                    });
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

            const payload = {
                mentor_id: activeMentor.id,
                booking_notes: bookingNotes.value.trim(),
                duration_minutes: Number(durationInput.value || 60),
            };

            if (selectedSlotId) {
                payload.mentor_availability_id = selectedSlotId;
            } else if (manualDate.value) {
                payload.scheduled_start = new Date(manualDate.value).toISOString();
            } else {
                showToast('Pilih salah satu jadwal atau isi jadwal manual terlebih dahulu.', 'error');
                return;
            }

            try {
                await api('/api/mentorship/bookings', {
                    method: 'POST',
                    body: JSON.stringify(payload),
                });

                showToast('Booking sesi berhasil dibuat.', 'success');
                mentorModal.classList.remove('show');
                bookingNotes.value = '';
                manualDate.value = '';
                selectedSlotId = null;

                await Promise.all([loadMentors(), loadBookings(), loadUpcoming()]);
            } catch (error) {
                showToast(error.message || 'Booking sesi gagal diproses.', 'error');
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
                filterPanel.classList.toggle('show');
            });

            document.getElementById('applyFilterBtn').addEventListener('click', async () => {
                state.filters.expertise = expertiseInput.value.trim();
                state.filters.sort = sortInput.value;
                state.filters.price_min = priceMinInput.value.trim();
                state.filters.price_max = priceMaxInput.value.trim();
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
                mentorModal.classList.remove('show');
            });

            mentorModal.addEventListener('click', (event) => {
                if (event.target === mentorModal) {
                    mentorModal.classList.remove('show');
                }
            });

            document.getElementById('bookBtn').addEventListener('click', submitBooking);

            document.querySelector('[data-nav="dashboard"]').addEventListener('click', () => {
                window.location.href = '/dashboard';
            });

            document.querySelector('[data-nav="profile"]').addEventListener('click', () => {
                window.location.href = '/dashboard';
            });

            document.querySelector('[data-nav="forum"]').addEventListener('click', () => {
                window.location.href = '/forum';
            });

            document.querySelector('[data-nav="skill-training"]').addEventListener('click', () => {
                window.location.href = '/skill-training';
            });
        }

        async function boot() {
            try {
                const roleOk = await loadMe();
                if (!roleOk) {
                    return;
                }

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
</body>
</html>
