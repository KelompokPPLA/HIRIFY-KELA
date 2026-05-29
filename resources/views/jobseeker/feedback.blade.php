<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hirify | Riwayat Feedback</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f4f8fd;
            --card: #ffffff;
            --ink: #0d1b3d;
            --muted: #6c7a93;
            --line: #e5edf6;
            --brand: #06cbe5;
            --brand-dark: #06b0c6;
            --ok: #0b7f53;
            --warn: #b98007;
            --shadow: 0 20px 45px rgba(9, 20, 51, 0.08);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background: var(--bg);
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
            gap: 12px;
            height: 100vh;
            overflow: hidden;
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
            flex: 1;
            overflow-y: auto;
            padding-bottom: 4px;
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
            flex-shrink: 0;
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
        .logout-wrap { flex-shrink: 0; padding-top: 8px; border-top: 1px solid var(--line); }
        .logout-btn { width: 100%; background: transparent; border: 0; color: var(--muted); font: inherit; font-size: .9rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 12px; transition: color .15s; }
        .logout-btn:hover { color: #b42318; }
        .content {
            padding: 24px;
            display: grid;
            gap: 18px;
            align-content: start;
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
        .feedback-grid {
            display: grid;
            gap: 20px;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        }
        .feedback-card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 10px 30px -5px rgba(9, 20, 51, 0.05);
            display: flex;
            flex-direction: column;
            gap: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .feedback-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -10px rgba(9, 20, 51, 0.12);
            border-color: var(--brand);
        }
        .fc-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .fc-mentor {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .fc-avatar {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            background: linear-gradient(135deg, #06cbe5, #04a9bf);
            color: #fff;
            display: grid;
            place-items: center;
            font-weight: 800;
            font-size: 1.25rem;
            overflow: hidden;
            box-shadow: 0 8px 16px rgba(6, 203, 229, 0.2);
        }
        .fc-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .fc-mentor-info strong {
            display: block;
            font-size: 1.15rem;
            color: #0c2553;
            letter-spacing: -0.01em;
        }
        .fc-mentor-info small {
            color: var(--muted);
            font-size: 0.88rem;
            font-weight: 500;
            display: block;
            margin-top: 2px;
        }
        .fc-rating {
            background: #fffbeb;
            color: #b45309;
            padding: 6px 12px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 6px;
            border: 1px solid #fef3c7;
        }
        .fc-body {
            display: grid;
            gap: 12px;
        }
        .fc-section {
            border-radius: 16px;
            padding: 16px;
            border: 1px solid transparent;
            transition: all 0.2s;
        }
        .fc-section:hover {
            transform: scale(1.01);
        }
        .fc-section h4 {
            margin: 0 0 8px 0;
            font-size: 0.85rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .fc-section p {
            margin: 0;
            font-size: 1rem;
            color: #334155;
            line-height: 1.6;
        }
        
        .fc-strength { background: #f0f9ff; border-color: #e0f2fe; }
        .fc-strength h4 { color: #0369a1; }
        
        .fc-improvement { background: #fff5f5; border-color: #fee2e2; }
        .fc-improvement h4 { color: #b91c1c; }
        
        .fc-recommendation { background: #f0fdf4; border-color: #dcfce7; }
        .fc-recommendation h4 { color: #15803d; }

        .fc-date {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid var(--line);
            font-size: 0.82rem;
            color: var(--muted);
            font-weight: 500;
            display: flex;
            justify-content: flex-end;
        }
        .empty-state {
            background: var(--card);
            border: 1px dashed var(--line);
            border-radius: 18px;
            padding: 40px;
            text-align: center;
            color: var(--muted);
        }
        .filters {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
            background: var(--card);
            padding: 16px;
            border-radius: 16px;
            border: 1px solid var(--line);
            box-shadow: 0 5px 15px rgba(9, 20, 51, 0.03);
            flex-wrap: wrap;
        }
        .search-box {
            display: flex;
            flex: 1;
            min-width: 250px;
            position: relative;
        }
        .filter-input {
            width: 100%;
            padding: 12px 110px 12px 16px;
            border: 1px solid var(--line);
            border-radius: 10px;
            font-family: inherit;
            font-size: 0.95rem;
            color: var(--ink);
            outline: none;
            transition: all 0.2s;
        }
        .filter-input:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(6, 203, 229, 0.15);
        }
        .search-btn {
            position: absolute;
            right: 6px;
            top: 6px;
            bottom: 6px;
            background: linear-gradient(135deg, #06cbe5, #04a9bf);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0 16px;
            font-family: inherit;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            box-shadow: 0 4px 10px rgba(6, 203, 229, 0.2);
        }
        .search-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(6, 203, 229, 0.35);
        }
        .search-btn:active {
            transform: translateY(1px);
        }
        .filter-select {
            padding: 12px 16px;
            border: 1px solid var(--line);
            border-radius: 10px;
            font-family: inherit;
            font-size: 0.95rem;
            color: var(--ink);
            outline: none;
            background: #fff;
            cursor: pointer;
            min-width: 150px;
        }
        @media (max-width: 980px) {
            .layout { grid-template-columns: 1fr; }
            .sidebar { border-right: 0; border-bottom: 1px solid var(--line); }
            .feedback-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="brand">
                <span class="brand-mark">H</span>
                <span>Hirify!</span>
            </div>
            <div class="menu">
                <button type="button" onclick="location.href='/dashboard'">Dashboard</button>
                <button type="button" onclick="location.href='/profile'">Profil</button>
                <button type="button" onclick="location.href='/manajemen-cv'">Manajemen CV</button>
                <button type="button" onclick="location.href='/buat-cv-ats'">Buat CV ATS</button>
                <button type="button" onclick="location.href='/roadmap-karier'">Roadmap Karier</button>
                <button type="button" onclick="location.href='/self-assessment'">Self Assessment</button>
                <button type="button" onclick="location.href='/pelatihan'">Pelatihan</button>
                <button type="button" onclick="location.href='/forum'">Forum</button>
                <button type="button" onclick="location.href='/mentorship'">Mentorship</button>
                <button type="button" class="active">Riwayat Feedback</button>
                <button type="button" onclick="location.href='/notifikasi'">Notifikasi</button>
            </div>
            <div class="profile-mini">
                <div class="avatar-mini">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
                <div style="min-width:0">
                    <strong style="display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ auth()->user()->name ?? 'User' }}</strong>
                    <span style="display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ auth()->user()->email ?? '' }}</span>
                </div>
            </div>
            <div class="logout-wrap">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <main class="content">
            <section class="title-wrap">
                <h1>Riwayat Feedback</h1>
                <p>Lihat semua feedback dan penilaian yang diberikan oleh mentor Anda setelah sesi mentorship.</p>
            </section>

            <div class="filters">
                <div class="search-box">
                    <input type="text" id="searchInput" class="filter-input" placeholder="Cari nama mentor atau nama sesi...">
                    <button type="button" id="searchBtn" class="search-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        Cari
                    </button>
                </div>
                <select id="ratingFilter" class="filter-select">
                    <option value="all">Semua Rating</option>
                    <option value="5">5 Bintang</option>
                    <option value="4">4 Bintang</option>
                    <option value="3">3 Bintang</option>
                    <option value="2">2 Bintang</option>
                    <option value="1">1 Bintang</option>
                </select>
            </div>

            @if($feedbacks->isEmpty())
                <div class="empty-state">
                    <h3 style="font-size: 1.2rem; margin-bottom: 8px;">Belum Ada Feedback</h3>
                    <p>Anda belum menerima feedback apapun dari mentor. Selesaikan sesi mentorship terlebih dahulu.</p>
                </div>
            @else

                <div class="feedback-grid" id="feedbackGrid">
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
                        <div class="feedback-card" data-mentor="{{ strtolower($mentorName) }}" data-rating="{{ $fb->mentee_rating }}" data-content="{{ strtolower($mentorName . ' ' . $sessionTopic) }}">
                            <div class="fc-header">
                                <div class="fc-mentor">
                                    <div class="fc-avatar">
                                        @if($avatarUrl)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($avatarUrl) }}" alt="{{ $mentorName }}">
                                        @else
                                            {{ $mentorInitial }}
                                        @endif
                                    </div>
                                    <div class="fc-mentor-info">
                                        <strong>{{ $mentorName }}</strong>
                                        <small>Sesi: {{ $displaySession }}</small>
                                    </div>
                                </div>
                                <div class="fc-rating-wrap" style="display: flex; flex-direction: column; align-items: flex-end; gap: 4px;">
                                    <div class="fc-rating">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: #f59e0b;"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        {{ $fb->mentee_rating }}/5
                                    </div>
                                    @if($ratingText)
                                        <span style="font-size: 0.75rem; font-weight: 700; color: #b45309; text-transform: uppercase; letter-spacing: 0.02em;">{{ $ratingText }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="fc-body">
                                <div class="fc-section fc-strength">
                                    <h4>Kekuatan (Strength)</h4>
                                    <p>{{ $fb->strength }}</p>
                                </div>
                                
                                <div class="fc-section fc-improvement">
                                    <h4>Area Peningkatan (Improvement)</h4>
                                    <p>{{ $fb->improvement }}</p>
                                </div>

                                <div class="fc-section fc-recommendation">
                                    <h4>Rekomendasi</h4>
                                    <p>{{ $fb->recommendation }}</p>
                                </div>
                            </div>
                            
                            <div class="fc-date">
                                Diberikan pada {{ $fb->created_at->locale('id')->translatedFormat('d M Y') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const searchBtn = document.getElementById('searchBtn');
            const ratingFilter = document.getElementById('ratingFilter');
            const cards = document.querySelectorAll('.feedback-card');

            function filterCards() {
                if(!searchInput || !ratingFilter) return;

                const searchTerm = searchInput.value.toLowerCase();
                const selectedRating = ratingFilter.value;

                cards.forEach(card => {
                    const mentor = card.getAttribute('data-mentor');
                    const content = card.getAttribute('data-content');
                    const rating = card.getAttribute('data-rating');

                    const matchesSearch = mentor.includes(searchTerm) || content.includes(searchTerm);
                    const matchesRating = selectedRating === 'all' || rating === selectedRating;

                    if (matchesSearch && matchesRating) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            if(searchInput) {
                searchInput.addEventListener('keypress', (e) => {
                    if(e.key === 'Enter') filterCards();
                });
            }
            if(searchBtn) searchBtn.addEventListener('click', filterCards);
            if(ratingFilter) ratingFilter.addEventListener('change', filterCards);
        });
    </script>
</body>
</html>
