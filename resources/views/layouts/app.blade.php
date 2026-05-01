<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hirify')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .welcome-pattern {
            background-image: radial-gradient(circle at top left, rgba(255, 255, 255, 0.18), transparent 35%),
                radial-gradient(circle at bottom right, rgba(255, 255, 255, 0.08), transparent 30%);
        }
    </style>
</head>
<body class="min-h-screen bg-[#f8fafc] text-slate-900 antialiased">
    <div class="flex min-h-screen">
        <aside class="w-[280px] min-h-screen bg-white border-r border-slate-200 flex flex-col">
            <div class="px-6 py-6 border-b border-slate-200">
                <a href="/dashboard" class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-3xl bg-gradient-to-br from-[var(--color-primary)] to-[var(--color-secondary)] flex items-center justify-center text-[var(--color-primary-foreground)] text-xl font-bold">H</div>
                    <div>
                        <p class="text-sm font-medium text--500">Hirify!</p>
                        <p class="text-xs text-slate-400">Career companion</p>
                    </div>
                </a>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="/dashboard" @class([
                    'group relative flex items-center gap-3 rounded-[12px] px-4 py-3 transition',
                    'text-white shadow-sm' => request()->is('dashboard'),
                    'text-slate-700 hover:bg-slate-100 hover:text-slate-900' => !request()->is('dashboard'),
                ]) @if(request()->is('dashboard')) style="background-color: #0F172A;" @endif>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="/profile" @class([
                    'group relative flex items-center gap-3 rounded-[12px] px-4 py-3 transition',
                    'text-white shadow-sm' => request()->is('profile'),
                    'text-slate-700 hover:bg-slate-100 hover:text-slate-900' => !request()->is('profile'),
                ]) @if(request()->is('profile')) style="background-color: #0F172A;" @endif>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span class="font-medium">Profil</span>
                </a>
                <a href="/manajemen-cv" @class([
                    'group relative flex items-center gap-3 rounded-[12px] px-4 py-3 transition',
                    'text-white shadow-sm' => request()->is('manajemen-cv'),
                    'text-slate-700 hover:bg-slate-100 hover:text-slate-900' => !request()->is('manajemen-cv'),
                ]) @if(request()->is('manajemen-cv')) style="background-color: #0F172A;" @endif>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="12" y1="19" x2="12" y2="5"></line>
                        <line x1="9" y1="16" x2="15" y2="16"></line>
                    </svg>
                    <span class="font-medium">Manajemen CV</span>
                </a>
                <a href="/buat-cv-ats" @class([
                    'group relative flex items-center gap-3 rounded-[12px] px-4 py-3 transition',
                    'text-white shadow-sm' => request()->is('buat-cv-ats'),
                    'text-slate-700 hover:bg-slate-100 hover:text-slate-900' => !request()->is('buat-cv-ats'),
                ]) @if(request()->is('buat-cv-ats')) style="background-color: #0F172A;" @endif>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="12" y1="19" x2="12" y2="5"></line>
                        <line x1="9" y1="16" x2="15" y2="16"></line>
                    </svg>
                    <span class="font-medium">Buat CV ATS</span>
                </a>
                <a href="/roadmap-karier" @class([
                    'group relative flex items-center gap-3 rounded-[12px] px-4 py-3 transition',
                    'text-white shadow-sm' => request()->is('roadmap-karier'),
                    'text-slate-700 hover:bg-slate-100 hover:text-slate-900' => !request()->is('roadmap-karier'),
                ]) @if(request()->is('roadmap-karier')) style="background-color: #0F172A;" @endif>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                    </svg>
                    <span class="font-medium">Roadmap Karier</span>
                </a>
                <a href="/self-assessment" @class([
                    'group relative flex items-center gap-3 rounded-[12px] px-4 py-3 transition',
                    'text-white shadow-sm' => request()->is('self-assessment'),
                    'text-slate-700 hover:bg-slate-100 hover:text-slate-900' => !request()->is('self-assessment'),
                ]) @if(request()->is('self-assessment')) style="background-color: #0F172A;" @endif>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"></path>
                    </svg>
                    <span class="font-medium">Self Assessment</span>
                </a>
                <a href="/pelatihan" @class([
                    'group relative flex items-center gap-3 rounded-[12px] px-4 py-3 transition',
                    'text-white shadow-sm' => request()->is('pelatihan'),
                    'text-slate-700 hover:bg-slate-100 hover:text-slate-900' => !request()->is('pelatihan'),
                ]) @if(request()->is('pelatihan')) style="background-color: #0F172A;" @endif>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="23 6 12 13 1 6"></polyline>
                    </svg>
                    <span class="font-medium">Pelatihan</span>
                </a>
                <a href="/mentorship" @class([
                    'group relative flex items-center gap-3 rounded-[12px] px-4 py-3 transition',
                    'text-white shadow-sm' => request()->is('mentorship'),
                    'text-slate-700 hover:bg-slate-100 hover:text-slate-900' => !request()->is('mentorship'),
                ]) @if(request()->is('mentorship')) style="background-color: #0F172A;" @endif>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span class="font-medium">Mentorship</span>
                </a>
                <a href="/notifikasi" @class([
                    'group relative flex items-center gap-3 rounded-[12px] px-4 py-3 transition',
                    'text-white shadow-sm' => request()->is('notifikasi'),
                    'text-slate-700 hover:bg-slate-100 hover:text-slate-900' => !request()->is('notifikasi'),
                ]) @if(request()->is('notifikasi')) style="background-color: #0F172A;" @endif>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="font-medium">Notifikasi</span>
                </a>
            </nav>

            <div class="px-4 py-6 border-t border-slate-200">
                @auth
                <div class="flex items-center gap-3 rounded-3xl bg-slate-50 p-4">
                    <div class="w-11 h-11 rounded-2xl bg-[var(--color-primary)] text-[var(--color-primary-foreground)] grid place-items-center font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <a href="/logout" class="mt-4 inline-flex items-center gap-2 text-sm font-medium text-slate-700 hover:text-[var(--color-primary)]" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Keluar
                </a>
                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                    @csrf
                </form>
                @else
                <a href="/login" class="inline-flex items-center gap-2 text-sm font-medium text-slate-700 hover:text-[var(--color-primary)]">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Login
                </a>
                @endauth
            </div>
        </aside>

        <main class="flex-1 p-6 lg:p-8">
            @yield('content')
        </main>
    </div>
</body>
</html>
