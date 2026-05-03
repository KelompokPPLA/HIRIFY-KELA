<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mentor Panel') — Hirify</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Manrope', 'system-ui', 'sans-serif'] },
                    colors: {
                        hirify: { 500: '#1dbfe6', 600: '#0399b7', 700: '#0a7b94' },
                        navy: { DEFAULT: '#0F172A' },
                    },
                },
            },
        }
    </script>
    <style>
        :root {
            --color-primary: #0F172A;
            --color-primary-foreground: #ffffff;
        }
        * { box-sizing: border-box; }
        body { font-family: 'Manrope', system-ui, sans-serif; }

        .sidebar-link {
            display: flex; align-items: center; gap: 12px;
            border-radius: 12px; padding: 11px 16px;
            font-weight: 500; font-size: 0.92rem;
            transition: all 0.2s ease; color: #475569;
        }
        .sidebar-link:hover { background: #f1f5f9; color: #0f172a; }
        .sidebar-link.active { background: #0F172A; color: #ffffff; box-shadow: 0 4px 14px rgba(15, 23, 42, 0.18); }
        .sidebar-link svg { flex-shrink: 0; }

        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px); z-index: 40; }
        .sidebar-overlay.open { display: block; }
        @media (max-width: 1024px) {
            .sidebar { position: fixed; left: -300px; top: 0; z-index: 50; transition: left 0.3s ease; }
            .sidebar.open { left: 0; box-shadow: 8px 0 30px rgba(15, 23, 42, 0.15); }
        }
        .page-enter { animation: pageEnter 0.35s ease; }
        @keyframes pageEnter { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <div class="flex min-h-screen">
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

        <aside class="sidebar w-[280px] min-h-screen bg-white border-r border-slate-200 flex flex-col" id="sidebar">
            <div class="px-6 py-5 border-b border-slate-100">
                <a href="/mentor/dashboard" class="flex items-center gap-3">
                    <div class="w-[36px] h-[36px] rounded-xl flex items-center justify-center text-white text-[17px] font-extrabold flex-shrink-0" style="background: linear-gradient(145deg, #0399b7, #06d8ee); box-shadow: 0 6px 18px rgba(3, 153, 183, 0.25);">H</div>
                    <div class="leading-tight">
                        <p class="text-[20px] font-extrabold tracking-tight text-[#0d1b3d]">Hirify</p>
                        <p class="text-[11px] text-slate-400 font-medium">Mentor Panel</p>
                    </div>
                </a>
            </div>

            <nav class="flex-1 px-3 py-5 space-y-1">
                <p class="px-3 mb-3 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">Menu Mentor</p>

                @php
                    $mentorItems = [
                        ['url' => '/mentor/dashboard', 'label' => 'Dashboard', 'pattern' => 'mentor/dashboard', 'icon' => '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline>'],
                        ['url' => '/mentor/sesi-jadwal', 'label' => 'Sesi & Jadwal', 'pattern' => 'mentor/sesi-jadwal', 'icon' => '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line>'],
                        ['url' => '/mentor/feedback', 'label' => 'Feedback', 'pattern' => 'mentor/feedback', 'icon' => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>'],
                        ['url' => '/mentor/settings', 'label' => 'Pengaturan', 'pattern' => 'mentor/settings', 'icon' => '<circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>'],
                    ];
                @endphp

                @foreach ($mentorItems as $item)
                    @php $isActive = request()->is($item['pattern'] . '*'); @endphp
                    <a href="{{ $item['url'] }}" class="sidebar-link {{ $isActive ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $item['icon'] !!}</svg>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="px-4 py-5 border-t border-slate-100">
                <div class="flex items-center gap-3 rounded-2xl bg-slate-50 p-3.5">
                    <div class="w-10 h-10 rounded-xl bg-[#0F172A] text-white grid place-items-center font-semibold text-sm flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name ?? 'M', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 truncate">{{ auth()->user()->name ?? 'Mentor' }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email ?? 'mentor@email.com' }}</p>
                    </div>
                </div>
                <button id="logoutBtn" class="mt-3 inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-red-600 transition-colors cursor-pointer border-0 bg-transparent">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    Keluar
                </button>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-h-screen">
            <header class="lg:hidden flex items-center justify-between px-4 py-3 bg-white border-b border-slate-200 sticky top-0 z-30">
                <button type="button" onclick="openSidebar()" class="p-2 rounded-lg hover:bg-slate-100 transition">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <span class="font-extrabold text-[#0d1b3d] tracking-tight">Hirify Mentor</span>
                <div class="w-8"></div>
            </header>

            <main class="flex-1 p-5 lg:p-8 page-enter">
                @yield('content')
            </main>
        </div>
    </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <script src="/js/hirify-api.js"></script>
        <script>
            // Init JWT token for any API calls
            hirifyInitToken('{{ session("jwt_token") }}');

            function openSidebar() { document.getElementById('sidebar').classList.add('open'); document.getElementById('sidebarOverlay').classList.add('open'); }
            function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sidebarOverlay').classList.remove('open'); }

            // Handle logout
            const logoutBtn = document.getElementById('logoutBtn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    hirifyClearAuth();
                    document.getElementById('logout-form').submit();
                });
            }
        </script>
    @stack('scripts')
</body>
</html>
