@props(['session'])
@php
    $booking = $session->bookings->whereIn('status', ['pending', 'confirmed'])->first();
    $menteeName = $booking ? ($booking->jobseeker->name ?? 'Mentee') : 'Sesi Terbuka';
    
    // Status
    $status = $session->status; // Pending, Confirmed, Completed, Cancelled

    $isOnline = false;
    $platformLower = strtolower($session->platform ?? '');
    if (str_contains($platformLower, 'zoom') || str_contains($platformLower, 'meet') || str_contains($platformLower, 'teams') || str_contains($platformLower, 'skype') || str_contains($platformLower, 'online')) {
        $isOnline = true;
    }
@endphp

<div class="rounded-2xl bg-white p-6 border border-slate-200 shadow-[0_8px_30px_rgb(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:-translate-y-1 transition duration-300 flex flex-col h-full relative overflow-hidden">
    <!-- Card Head -->
    <div class="flex justify-between items-start mb-4 gap-4">
        <div class="min-w-0 flex-1">
            <h3 class="font-extrabold text-slate-800 text-lg tracking-tight leading-tight mb-1 truncate">{{ $menteeName }}</h3>
            <p class="text-xs font-semibold text-slate-400 tracking-wide uppercase truncate">{{ $session->topic }}</p>
        </div>

        @if($status === 'Confirmed')
            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-blue-50 text-blue-600 border border-blue-100/50 shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                Scheduled
            </span>
        @elseif($status === 'Pending')
            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-amber-50 text-amber-600 border border-amber-100/50 shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                Pending
            </span>
        @elseif($status === 'Completed')
            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100/50 shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                Completed
            </span>
        @else
            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-rose-50 text-rose-600 border border-rose-100/50 shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
                Cancelled
            </span>
        @endif
    </div>

    <!-- Card Body Details -->
    <div class="space-y-3 mb-6 flex-1">
        <!-- Date -->
        <div class="flex items-center text-sm font-semibold text-slate-500 gap-3">
            <span class="w-8 h-8 rounded-xl bg-cyan-50 text-cyan-500 grid place-items-center shrink-0 shadow-sm shadow-cyan-500/5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </span>
            <span>{{ \Carbon\Carbon::parse($session->date)->locale('id')->translatedFormat('l, j F Y') }}</span>
        </div>

        <!-- Time -->
        <div class="flex items-center text-sm font-semibold text-slate-500 gap-3">
            <span class="w-8 h-8 rounded-xl bg-cyan-50 text-cyan-500 grid place-items-center shrink-0 shadow-sm shadow-cyan-500/5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </span>
            <span>{{ date('H:i', strtotime($session->time)) }} WIB ({{ $session->duration }} menit)</span>
        </div>

        <!-- Platform / Location -->
        <div class="flex items-center text-sm font-semibold text-slate-500 gap-3">
            <span class="w-8 h-8 rounded-xl bg-cyan-50 text-cyan-500 grid place-items-center shrink-0 shadow-sm shadow-cyan-500/5">
                @if($isOnline)
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M23 7l-7 5 7 5V7z"></path>
                        <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                    </svg>
                @else
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                @endif
            </span>
            <span class="truncate">{{ $session->platform ?: 'Belum ditentukan' }}</span>
        </div>
    </div>

    <!-- Card Footer -->
    <div class="pt-4 border-t border-slate-100 flex items-center justify-end mt-auto">
        <a href="{{ route('mentor.sesi-jadwal.show', $session->id) }}" class="text-sm font-extrabold text-cyan-600 hover:text-cyan-700 transition flex items-center gap-1.5 group">
            Detail Sesi
            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
</div>
