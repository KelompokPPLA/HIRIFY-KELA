@extends('layouts.mentor')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Mentee Saya</h1>
            <p class="text-slate-500 mt-1.5 font-medium">Pantau progres semua mentee yang mengambil sesi Anda</p>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <!-- Total Mentee Card -->
        <div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.05)] hover:-translate-y-0.5 transition duration-300 flex items-center gap-5 border border-slate-200">
            <div class="w-14 h-14 rounded-2xl bg-cyan-50 text-[#00bee4] flex items-center justify-center shrink-0 shadow-sm shadow-cyan-500/5">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M23 21v-2a4 4 0 00-3-3.87"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 3.13a4 4 0 010 7.75"/>
                </svg>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $stats['total'] }}</div>
                <div class="text-sm text-slate-400 font-bold mt-1">Total Mentee</div>
            </div>
        </div>

        <!-- Accepted Card -->
        <div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.05)] hover:-translate-y-0.5 transition duration-300 flex items-center gap-5 border border-slate-200">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0 shadow-sm shadow-emerald-500/5">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $stats['confirmed'] }}</div>
                <div class="text-sm text-slate-400 font-bold mt-1">Mentee Diterima</div>
            </div>
        </div>

        <!-- Rejected Card -->
        <div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.05)] hover:-translate-y-0.5 transition duration-300 flex items-center gap-5 border border-slate-200">
            <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center shrink-0 border border-rose-100/50">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                </svg>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $stats['rejected'] }}</div>
                <div class="text-sm text-slate-400 font-bold mt-1">Mentee Ditolak</div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Controls -->
    <form method="GET" action="{{ route('mentor.mentee.index') }}" class="flex flex-col lg:flex-row gap-4 mb-8">
        <!-- Search Input -->
        <div class="relative flex-1">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.35-4.35"/>
                </svg>
            </span>
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama mentee..." class="w-full pl-11 pr-5 py-3 rounded-2xl border border-slate-200/80 bg-white focus:ring-4 focus:ring-cyan-500/10 focus:border-[#00bee4] outline-none transition duration-200 text-sm font-semibold text-slate-700 shadow-sm shadow-slate-100">
        </div>

        <!-- Filter Selector Switcher -->
        <div class="flex items-center bg-white p-1 rounded-full border border-slate-200/80 shadow-sm gap-1 self-start lg:self-center">
            @foreach(['all' => 'Semua', 'confirmed' => 'Diterima', 'rejected' => 'Ditolak'] as $val => $label)
                <button type="submit" name="status" value="{{ $val }}"
                    class="px-6 py-2 rounded-full font-extrabold text-sm transition duration-200 {{ ($filterStatus ?? 'all') === $val ? 'bg-[#00bee4] text-white shadow-md shadow-cyan-500/15' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </form>

    <!-- Card Grid -->
    @if($mentees->isEmpty())
        <div class="py-20 text-center bg-white rounded-3xl border border-slate-200 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
            <div class="w-20 h-20 mx-auto mb-5 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                </svg>
            </div>
            <p class="text-xl font-extrabold text-slate-800 tracking-tight">Belum Ada Mentee</p>
            <p class="text-sm text-slate-400 font-semibold mt-2 max-w-sm mx-auto">Mentee akan secara otomatis muncul di sini setelah ada yang memesan sesi jadwal Anda.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($mentees as $mentee)
                @php
                    $initials = $mentee['avatar'];
                    $colors = [
                        'from-[#00bee4] to-[#0ea5e9]',
                        'from-[#06b6d4] to-[#0891b2]',
                        'from-[#14b8a6] to-[#0f766e]',
                        'from-[#6366f1] to-[#4338ca]',
                        'from-[#3b82f6] to-[#1d4ed8]'
                    ];
                    $gradient = $colors[crc32($mentee['name']) % count($colors)];
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200 shadow-[0_8px_30px_rgb(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:-translate-y-1 transition duration-300 flex flex-col relative overflow-hidden">
                    
                    <!-- Card Top Profile Header -->
                    <div class="p-6 pb-4 flex items-start justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <!-- Avatar with Gradient Background -->
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $gradient }} flex items-center justify-center text-white font-extrabold text-lg shrink-0 shadow-md shadow-cyan-500/10 select-none">
                                {{ $initials }}
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-extrabold text-slate-800 text-base tracking-tight truncate leading-tight">{{ $mentee['name'] }}</h3>
                                <p class="text-xs font-semibold text-slate-400 truncate mt-0.5">{{ $mentee['email'] }}</p>
                                <span class="mt-2 inline-block text-[10px] font-extrabold tracking-wide uppercase text-cyan-700 bg-cyan-50/50 border border-cyan-100/50 rounded-full px-3 py-1">
                                    {{ $mentee['bidang'] }}
                                </span>
                            </div>
                        </div>

                        <!-- Status Pill Badge -->
                        @if($mentee['latest_status'] === 'confirmed' || $mentee['latest_status'] === 'completed')
                            <span class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold bg-emerald-50 text-emerald-600 border border-emerald-100/30">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block animate-pulse"></span> Diterima
                            </span>
                        @elseif($mentee['latest_status'] === 'rejected')
                            <span class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold bg-rose-50 text-rose-600 border border-rose-100/30">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 inline-block"></span> Ditolak
                            </span>
                        @else
                            <span class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold bg-amber-50 text-amber-600 border border-amber-100/30">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block"></span> Pending
                            </span>
                        @endif
                    </div>

                    <!-- Inner Stats Block -->
                    <div class="px-6 pb-4 grid grid-cols-3 gap-3">
                        <div class="bg-slate-50/50 rounded-xl p-3 text-center border border-slate-100/30">
                            <div class="text-lg font-extrabold text-slate-800 tracking-tight">{{ $mentee['completed_sessions'] }}</div>
                            <div class="text-[10px] font-bold text-slate-400 mt-1">Selesai</div>
                        </div>
                        <div class="bg-slate-50/50 rounded-xl p-3 text-center border border-slate-100/30">
                            <div class="text-lg font-extrabold text-slate-800 tracking-tight">{{ $mentee['total_sessions'] }}</div>
                            <div class="text-[10px] font-bold text-slate-400 mt-1">Total Sesi</div>
                        </div>
                        <div class="bg-amber-50/50 rounded-xl p-3 text-center border border-amber-100/30">
                            @if($mentee['avg_mentee_rating'])
                                <div class="flex items-center justify-center gap-0.5">
                                    <svg class="w-3.5 h-3.5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.39 2.462a1 1 0 00-.364 1.118l1.287 3.97c.3.921-.755 1.688-1.54 1.118l-3.39-2.462a1 1 0 00-1.175 0L5.11 17.005c-.784.57-1.84-.197-1.54-1.118l1.287-3.97a1 1 0 00-.364-1.118L1.104 8.397c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.97z"/>
                                    </svg>
                                    <span class="text-base font-extrabold text-amber-600">{{ $mentee['avg_mentee_rating'] }}</span>
                                </div>
                            @else
                                <div class="text-base font-extrabold text-slate-300">—</div>
                            @endif
                            <div class="text-[10px] font-bold text-amber-600 mt-1">Avg Rating</div>
                        </div>
                    </div>

                    <!-- Progress Bar Section -->
                    <div class="px-6 pb-4">
                        <div class="flex justify-between text-[11px] text-slate-400 font-bold mb-1.5">
                            <span>Progress Sesi</span>
                            <span class="text-cyan-600 font-extrabold">{{ $mentee['progress'] }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-[#00bee4] h-2 rounded-full transition-all duration-300 shadow-sm shadow-cyan-500/10"
                                 style="width: {{ $mentee['progress'] }}%"></div>
                        </div>
                    </div>

                    <!-- Card Footer Actions -->
                    <div class="px-6 pb-5 pt-3 border-t border-slate-100 mt-auto flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-400">
                            @if($mentee['started_at'])
                                Sejak {{ \Carbon\Carbon::parse($mentee['started_at'])->locale('id')->translatedFormat('d M Y') }}
                            @else
                                —
                            @endif
                        </span>
                        
                        <a href="{{ route('mentor.mentee.show', $mentee['id']) }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-extrabold rounded-full bg-slate-900 hover:bg-slate-800 text-white transition duration-200 group">
                            Detail Mentee
                            <svg class="w-3.5 h-3.5 transform group-hover:translate-x-1 transition duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path d="m9 18 6-6-6-6"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
