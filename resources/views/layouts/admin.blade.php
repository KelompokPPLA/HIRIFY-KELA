<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hirify | Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --color-primary: #0F172A;
            --color-primary-foreground: #ffffff;
            --color-accent: #06d8ee;
            --color-accent-dark: #0399b7;
        }
        body { font-family: 'Manrope', system-ui, sans-serif; }
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap');
    </style>
</head>
<body class="min-h-screen bg-[#f8fafc] text-slate-900 antialiased">
    <div class="flex min-h-screen">
        <aside class="w-[280px] min-h-screen bg-white border-r border-slate-200 flex flex-col">
            <div class="px-6 py-6 border-b border-slate-200">
                <a href="/admin/statistics" class="flex items-center gap-2.5">
                    <div class="w-[34px] h-[34px] rounded-[12px] flex items-center justify-center text-white text-[17px] font-extrabold flex-shrink-0" style="background: linear-gradient(145deg, #0399b7, #06d8ee);">H</div>
                    <div class="leading-tight">
                        <p class="text-[20px] font-extrabold tracking-tight text-[#0d1b3d]">Hirify</p>
                        <p class="text-[11px] text-slate-400">Admin Panel</p>
                    </div>
                </a>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="/admin/statistics" @class([
                    'group relative flex items-center gap-3 rounded-[12px] px-4 py-3 transition',
                    'text-white shadow-sm' => request()->is('admin/statistics'),
                    'text-slate-700 hover:bg-slate-100 hover:text-slate-900' => !request()->is('admin/statistics'),
                ]) @if(request()->is('admin/statistics')) style="background-color: #0F172A;" @endif>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 20V10"></path><path d="M12 20V4"></path><path d="M6 20v-6"></path>
                    </svg>
                    <span class="font-medium">Statistik Platform</span>
                </a>
                <a href="/admin/users" @class([
                    'group relative flex items-center gap-3 rounded-[12px] px-4 py-3 transition',
                    'text-white shadow-sm' => request()->is('admin/users*'),
                    'text-slate-700 hover:bg-slate-100 hover:text-slate-900' => !request()->is('admin/users*'),
                ]) @if(request()->is('admin/users*')) style="background-color: #0F172A;" @endif>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span class="font-medium">Manajemen Pengguna</span>
                </a>
                <a href="/admin/activity" @class([
                    'group relative flex items-center gap-3 rounded-[12px] px-4 py-3 transition',
                    'text-white shadow-sm' => request()->is('admin/activity'),
                    'text-slate-700 hover:bg-slate-100 hover:text-slate-900' => !request()->is('admin/activity'),
                ]) @if(request()->is('admin/activity')) style="background-color: #0F172A;" @endif>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                    </svg>
                    <span class="font-medium">Aktivitas Platform</span>
                </a>
            </nav>

            <div class="px-4 py-6 border-t border-slate-200">
                <div class="flex items-center gap-3 rounded-3xl bg-slate-50 p-4">
                    <div class="w-11 h-11 rounded-2xl bg-[#0F172A] text-white grid place-items-center font-semibold">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-slate-500 truncate">Administrator</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 text-sm font-medium text-slate-700 hover:text-[#0399b7]">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-6 lg:p-8">
            @yield('content')
        </main>
    </div>
</body>
</html>
