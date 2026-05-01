<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hirify | Mentor')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f8fafc] text-slate-900 antialiased">
    <div class="flex min-h-screen">
        <aside class="w-[280px] min-h-screen bg-white border-r border-slate-200 flex flex-col">
            <div class="px-6 py-6 border-b border-slate-200">
                <a href="/mentor/dashboard" class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-3xl bg-gradient-to-br from-[var(--color-primary)] to-[var(--color-secondary)] flex items-center justify-center text-[var(--color-primary-foreground)] text-xl font-bold">H</div>
                    <div>
                        <p class="text-sm font-medium">Hirify!</p>
                        <p class="text-xs text-slate-400">Mentor Panel</p>
                    </div>
                </a>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="/mentor/dashboard" @class([
                    'group relative flex items-center gap-3 rounded-[12px] px-4 py-3 transition',
                    'text-white shadow-sm' => request()->is('mentor/dashboard'),
                    'text-slate-700 hover:bg-slate-100 hover:text-slate-900' => !request()->is('mentor/dashboard'),
                ]) @if(request()->is('mentor/dashboard')) style="background-color: #0F172A;" @endif>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="/mentor/sesi-jadwal" @class([
                    'group relative flex items-center gap-3 rounded-[12px] px-4 py-3 transition',
                    'text-white shadow-sm' => request()->is('mentor/sesi-jadwal*'),
                    'text-slate-700 hover:bg-slate-100 hover:text-slate-900' => !request()->is('mentor/sesi-jadwal*'),
                ]) @if(request()->is('mentor/sesi-jadwal*')) style="background-color: #0F172A;" @endif>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <span class="font-medium">Sesi & Jadwal</span>
                </a>
                <a href="/mentor/feedback" @class([
                    'group relative flex items-center gap-3 rounded-[12px] px-4 py-3 transition',
                    'text-white shadow-sm' => request()->is('mentor/feedback*'),
                    'text-slate-700 hover:bg-slate-100 hover:text-slate-900' => !request()->is('mentor/feedback*'),
                ]) @if(request()->is('mentor/feedback*')) style="background-color: #0F172A;" @endif>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <span class="font-medium">Feedback</span>
                </a>
                <a href="/mentor/settings" @class([
                    'group relative flex items-center gap-3 rounded-[12px] px-4 py-3 transition',
                    'text-white shadow-sm' => request()->is('mentor/settings*'),
                    'text-slate-700 hover:bg-slate-100 hover:text-slate-900' => !request()->is('mentor/settings*'),
                ]) @if(request()->is('mentor/settings*')) style="background-color: #0F172A;" @endif>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                    <span class="font-medium">Pengaturan</span>
                </a>
            </nav>

            <div class="px-4 py-6 border-t border-slate-200">
                <div class="flex items-center gap-3 rounded-3xl bg-slate-50 p-4">
                    <div class="w-11 h-11 rounded-2xl bg-[var(--color-primary)] text-[var(--color-primary-foreground)] grid place-items-center font-semibold" id="sidebarAvatar">M</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900" id="sidebarName">Mentor</p>
                        <p class="text-xs text-slate-500 truncate" id="sidebarEmail">mentor@email.com</p>
                    </div>
                </div>
                <button id="logoutBtn" class="mt-4 inline-flex items-center gap-2 text-sm font-medium text-slate-700 hover:text-[var(--color-primary)] cursor-pointer border-0 bg-transparent">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Keluar
                </button>
            </div>
        </aside>

        <main class="flex-1 p-6 lg:p-8">
            @yield('content')
        </main>
    </div>

    <script>
        // Load user info from storage
        (function() {
            const token = localStorage.getItem('hirify_token') || sessionStorage.getItem('hirify_token');
            if (!token) {
                window.location.href = '/login';
                return;
            }

            const userStr = localStorage.getItem('hirify_user') || sessionStorage.getItem('hirify_user');
            if (userStr) {
                try {
                    const user = JSON.parse(userStr);
                    const nameEl = document.getElementById('sidebarName');
                    const emailEl = document.getElementById('sidebarEmail');
                    const avatarEl = document.getElementById('sidebarAvatar');
                    if (nameEl) nameEl.textContent = user.name || 'Mentor';
                    if (emailEl) emailEl.textContent = user.email || '';
                    if (avatarEl) avatarEl.textContent = (user.name || 'M').charAt(0).toUpperCase();
                } catch(e) {}
            }

            // Logout handler
            const logoutBtn = document.getElementById('logoutBtn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', async () => {
                    try {
                        await fetch('/api/auth/logout', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': 'Bearer ' + token,
                            },
                        });
                    } catch(e) {}
                    localStorage.removeItem('hirify_token');
                    localStorage.removeItem('hirify_user');
                    localStorage.removeItem('hirify_remember');
                    sessionStorage.removeItem('hirify_token');
                    sessionStorage.removeItem('hirify_user');
                    window.location.href = '/login';
                });
            }
        })();
    </script>
</body>
</html>
