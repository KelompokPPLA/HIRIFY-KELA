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

<div class="rounded-2xl bg-white border border-slate-200 shadow-[0_8px_30px_rgb(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:-translate-y-1 transition duration-300 flex flex-col h-full relative overflow-hidden group">
    <!-- Cover/Thumbnail Container -->
    @php
        $hasMaterial = !empty($session->material_file);
        $isVideo = false;
        $isPdf = false;
        $fileUrl = '';
        if ($hasMaterial) {
            $fileUrl = asset('storage/' . $session->material_file);
            $extension = pathinfo($session->material_file, PATHINFO_EXTENSION);
            $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'avi']);
            $isPdf = strtolower($extension) === 'pdf';
        }
    @endphp

    @if($hasMaterial)
        @if($isVideo)
            <div class="relative w-full h-44 bg-slate-900 overflow-hidden shrink-0">
                <video class="w-full h-full object-cover" src="{{ $fileUrl }}" preload="metadata" muted playsinline></video>
                <!-- Play Overlay Icon -->
                <div class="absolute inset-0 bg-slate-950/20 flex items-center justify-center">
                    <div class="w-12 h-12 rounded-full bg-white/90 text-slate-800 flex items-center justify-center shadow-lg backdrop-blur-sm group-hover:scale-110 transition duration-300">
                        <svg class="w-5 h-5 fill-current ml-0.5 text-slate-800" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                </div>
                <div class="absolute bottom-3 left-3 bg-slate-900/75 backdrop-blur-sm text-white px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider border border-white/10">
                    Video
                </div>
            </div>
        @elseif($isPdf)
            <div class="relative w-full h-44 bg-white overflow-hidden shrink-0 border-b border-slate-100">
                <!-- Live PDF First Page Embed perfectly centered and cropped symmetrically to completely remove native browser PDF borders/scrollbars -->
                <iframe class="absolute border-0 select-none"
                        scrolling="no"
                        src="{{ $fileUrl }}#page=1&toolbar=0&navpanes=0&scrollbar=0&view=FitH"
                        style="left: 50%; top: 50%; width: calc(200% + 80px); height: 520px; transform: translate(-50%, -50%) scale(0.5); transform-origin: center center; pointer-events: none; overflow: hidden; background: white;">
                </iframe>
                <!-- Transparent Overlay to capture clicks and prevent scrolling/selection inside the card -->
                <div class="absolute inset-0 bg-transparent"></div>
                <div class="absolute bottom-3 left-3 bg-rose-600/95 backdrop-blur-sm text-white px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider border border-white/10 shadow-sm">
                    PDF
                </div>
            </div>
        @else
            <div class="relative w-full h-44 bg-gradient-to-br from-slate-700 to-slate-900 flex flex-col items-center justify-center p-4 text-white overflow-hidden shrink-0">
                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-white via-slate-900 to-slate-950"></div>
                <svg class="w-12 h-12 mb-2 filter drop-shadow-md text-white/95" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
                <span class="text-xs font-bold px-2.5 py-0.5 bg-white/20 backdrop-blur-md rounded-full border border-white/10 uppercase tracking-wider text-[9px]">
                    File
                </span>
                <span class="text-xs font-extrabold text-white/90 mt-2 truncate w-4/5 text-center px-2">
                    {{ basename($session->material_file) }}
                </span>
            </div>
        @endif
    @else
        @php
            $gradients = [
                'from-cyan-500 to-blue-600',
                'from-purple-500 to-indigo-600',
                'from-emerald-400 to-teal-600',
                'from-amber-400 to-orange-600',
                'from-pink-500 to-rose-600'
            ];
            $cardGradient = $gradients[crc32($session->topic) % count($gradients)];
        @endphp
        <div class="relative w-full h-44 bg-gradient-to-br {{ $cardGradient }} flex flex-col items-center justify-center p-4 text-white overflow-hidden shrink-0">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white to-transparent"></div>
            <span class="w-12 h-12 rounded-2xl bg-white/15 backdrop-blur-md border border-white/10 flex items-center justify-center mb-3 shadow-inner">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </span>
            <span class="text-xs font-bold px-2.5 py-0.5 bg-white/20 backdrop-blur-md rounded-full border border-white/10 uppercase tracking-wider text-[9px]">
                Sesi Mentoring
            </span>
        </div>
    @endif

    <!-- Content Block -->
    <div class="p-6 flex flex-col flex-1">
        <!-- Card Head -->
        <div class="flex justify-between items-start mb-4 gap-4">
            <div class="min-w-0 flex-1">
                <h3 class="font-extrabold text-slate-800 text-lg tracking-tight leading-tight truncate">{{ $session->topic }}</h3>
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

        @if($session->description)
            <p class="text-xs text-slate-400 font-semibold mb-4 line-clamp-2 leading-relaxed">
                {{ $session->description }}
            </p>
        @endif

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
</div>

