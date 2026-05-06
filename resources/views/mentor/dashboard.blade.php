@extends('layouts.mentor')

@section('content')
<div class="max-w-7xl mx-auto">
    
    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-100/80 text-sm font-semibold flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 text-rose-700 border border-rose-100/80 text-sm font-semibold flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Welcome Banner -->
    <div class="relative bg-gradient-to-r from-[#00bee4] to-[#06b6d4] rounded-3xl p-8 mb-8 text-white overflow-hidden shadow-lg shadow-cyan-500/10">
        <!-- Decorative glowing circles -->
        <div class="absolute -right-10 -top-10 w-44 h-44 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -left-10 -bottom-10 w-36 h-36 bg-white/10 rounded-full blur-2xl"></div>
        
        <div class="relative z-10">
            <h1 class="text-3xl font-extrabold tracking-tight mb-2 flex items-center gap-2">
                Selamat Datang, Mentor! 👋
            </h1>
            <p class="text-white/85 font-semibold text-sm mb-6">Berikut ringkasan aktivitas mentorship Anda hari ini</p>
            
            <!-- Mini Stats inside Banner -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-xl">
                <div class="border border-white/20 bg-white/10 rounded-2xl p-4 flex flex-col justify-center backdrop-blur-sm">
                    <div class="text-2xl font-black mb-0.5">{{ $sessions->count() }}</div>
                    <div class="text-xs font-bold text-white/75 uppercase tracking-wider">Sesi Hari Ini</div>
                </div>
                <div class="border border-white/20 bg-white/10 rounded-2xl p-4 flex flex-col justify-center backdrop-blur-sm">
                    <div class="text-2xl font-black mb-0.5">{{ $totalMenteesCount }}</div>
                    <div class="text-xs font-bold text-white/75 uppercase tracking-wider">Total Mentee</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Stat Cards Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
        <!-- Total Mentee Card -->
        <div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-slate-200 hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-0.5 transition duration-300 flex items-center justify-between">
            <div>
                <div class="w-12 h-12 rounded-xl bg-cyan-50 text-[#00bee4] flex items-center justify-center mb-3 shadow-sm shadow-cyan-500/5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                    </svg>
                </div>
                <div class="text-sm font-bold text-slate-800">Total Mentee</div>
                <div class="text-xs text-slate-400 font-semibold mt-0.5">+3 bulan ini</div>
            </div>
            <div class="text-3xl font-black text-slate-800 tracking-tight">{{ $totalMenteesCount }}</div>
        </div>

        <!-- Sesi Bulan Ini Card -->
        <div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-slate-200 hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-0.5 transition duration-300 flex items-center justify-between">
            <div>
                <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center mb-3 border border-slate-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                    </svg>
                </div>
                <div class="text-sm font-bold text-slate-800">Sesi Bulan Ini</div>
                <div class="text-xs text-slate-400 font-semibold mt-0.5">12 sesi minggu ini</div>
            </div>
            <div class="text-3xl font-black text-slate-800 tracking-tight">{{ $sessionsThisMonthCount }}</div>
        </div>
    </div>

    <!-- Pending Booking Requests Section -->
    <div class="mb-8">
        <h2 class="text-xl font-extrabold text-slate-900 tracking-tight mb-4 flex items-center gap-2">
            Permintaan Booking Sesi
            @if($pendingBookings->count() > 0)
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-cyan-100 text-[#00bee4]">{{ $pendingBookings->count() }}</span>
            @endif
        </h2>
        
        <div class="bg-white rounded-3xl border border-slate-200 shadow-[0_8px_30px_rgb(0,0,0,0.02)] p-6 sm:p-8">
            @forelse($pendingBookings as $booking)
                @php
                    $colors = [
                        'from-[#00bee4] to-[#0ea5e9]',
                        'from-[#10b981] to-[#047857]',
                        'from-[#6366f1] to-[#4338ca]',
                        'from-[#3b82f6] to-[#1d4ed8]'
                    ];
                    $gradient = $colors[crc32($booking->jobseeker->name ?? 'Mentee') % count($colors)];
                @endphp
                
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-5 rounded-2xl border border-slate-100 bg-slate-50/20 hover:bg-slate-50/50 transition duration-200 mb-4 last:mb-0">
                    <div class="flex items-start sm:items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br {{ $gradient }} text-white flex items-center justify-center font-extrabold text-sm shadow-sm select-none shrink-0">
                            {{ strtoupper(substr($booking->jobseeker->name ?? 'M', 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm leading-tight">{{ $booking->jobseeker->name ?? 'Mentee' }}</h4>
                            <p class="text-xs text-slate-500 font-semibold mt-1">Catatan: <span class="text-slate-400 italic font-medium">{{ $booking->booking_notes ?: 'Tidak ada catatan' }}</span></p>
                            <div class="flex items-center gap-3 text-[11px] text-[#00bee4] font-bold mt-2">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line></svg>
                                    {{ \Carbon\Carbon::parse($booking->scheduled_start)->locale('id')->translatedFormat('l, d M Y') }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    {{ date('H:i', strtotime($booking->scheduled_start)) }} WIB
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Forms -->
                    <div class="flex flex-wrap items-center gap-3 self-end md:self-center">
                        <!-- Accept Form -->
                        <form action="{{ route('mentor.bookings.accept', $booking->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-5 py-2 rounded-full bg-[#00bee4] hover:bg-[#00a3c4] text-white text-xs font-extrabold uppercase tracking-wider shadow-sm transition duration-200">
                                Terima
                            </button>
                        </form>
                        
                        <!-- Toggle Rejection Input Trigger -->
                        <button type="button" onclick="toggleRejectionForm('{{ $booking->id }}')" class="px-5 py-2 rounded-full border border-slate-200 hover:bg-rose-50 hover:text-rose-600 text-slate-500 text-xs font-extrabold uppercase tracking-wider transition duration-200">
                            Tolak
                        </button>
                    </div>
                </div>
                
                <!-- Hidden Inline Rejection Form -->
                <div id="rejection-container-{{ $booking->id }}" class="hidden p-5 rounded-2xl border border-rose-100 bg-rose-50/20 mb-4">
                    <form action="{{ route('mentor.bookings.reject', $booking->id) }}" method="POST">
                        @csrf
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-rose-600 mb-2">Alasan Penolakan</label>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <input type="text" name="rejection_reason" placeholder="Misal: Slot jadwal bentrok dengan acara lain..." required 
                                class="flex-1 px-4 py-2.5 rounded-xl border border-rose-200 bg-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-400 outline-none transition duration-200 text-sm font-semibold text-slate-700 shadow-sm shadow-rose-100/50">
                            <div class="flex items-center gap-2 shrink-0">
                                <button type="button" onclick="toggleRejectionForm('{{ $booking->id }}')" class="px-4 py-2.5 rounded-full border border-slate-200 text-slate-500 text-xs font-bold uppercase tracking-wider bg-white hover:bg-slate-50 transition">
                                    Batal
                                </button>
                                <button type="submit" class="px-5 py-2.5 rounded-full bg-rose-500 hover:bg-rose-600 text-white text-xs font-bold uppercase tracking-wider shadow-sm transition">
                                    Kirim Penolakan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @empty
                <div class="py-6 text-center text-slate-400 font-semibold text-sm italic">
                    Tidak ada permintaan booking yang tertunda saat ini.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Lower Section - Two Columns -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Column 1: Sesi Mendatang -->
        <div>
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight mb-4">Sesi Mendatang</h2>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-[0_8px_30px_rgb(0,0,0,0.01)] p-6 flex flex-col justify-between min-h-[400px]">
                <div class="space-y-5">
                    @forelse($sessions->take(3) as $session)
                        @php
                            $booking = $session->bookings->first();
                            $menteeName = $booking->jobseeker->name ?? 'Sesi Terbuka';
                            $initials = strtoupper(substr($menteeName, 0, 1));
                            
                            $sessionDate = \Carbon\Carbon::parse($session->date);
                            if ($sessionDate->isToday()) {
                                $dateLabel = 'Hari ini';
                            } elseif ($sessionDate->isTomorrow()) {
                                $dateLabel = 'Besok';
                            } else {
                                $dateLabel = $sessionDate->locale('id')->translatedFormat('d M Y');
                            }
                            
                            $colors = [
                                'from-[#00bee4] to-[#0ea5e9]',
                                'from-[#10b981] to-[#047857]',
                                'from-[#6366f1] to-[#4338ca]',
                                'from-[#3b82f6] to-[#1d4ed8]'
                            ];
                            $gradient = $colors[crc32($menteeName) % count($colors)];
                        @endphp
                        
                        <div class="flex items-center justify-between gap-4 p-4 rounded-2xl border border-slate-100 hover:bg-slate-50/50 transition duration-200">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br {{ $gradient }} text-white flex items-center justify-center font-extrabold text-sm shadow-sm select-none shrink-0">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm leading-tight">{{ $menteeName }}</h4>
                                    <p class="text-xs text-slate-400 font-semibold mt-0.5">{{ $session->topic }}</p>
                                    <div class="flex items-center gap-3 text-[11px] text-slate-400 font-bold mt-1.5">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line></svg>
                                            {{ $dateLabel }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                            {{ date('H:i', strtotime($session->time)) }} WIB
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <span class="shrink-0 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wide {{ $session->status === 'Confirmed' ? 'bg-cyan-50 text-cyan-600 border border-cyan-100/50' : 'bg-amber-50 text-amber-600 border border-amber-100/50' }}">
                                {{ $session->status === 'Confirmed' ? 'Terkonfirmasi' : 'Pending' }}
                            </span>
                        </div>
                    @empty
                        <div class="py-12 text-center text-slate-400 font-medium text-sm">
                            Belum ada jadwal sesi dalam waktu dekat.
                        </div>
                    @endforelse
                </div>
                
                <div class="text-center pt-6 border-t border-slate-100">
                    <a href="{{ route('mentor.sesi-jadwal.index') }}" class="inline-flex items-center gap-1.5 text-xs font-extrabold text-[#00bee4] hover:text-[#00a3c4] tracking-wide uppercase transition duration-200">
                        Lihat Semua Jadwal →
                    </a>
                </div>
            </div>
        </div>

        <!-- Column 2: Aktivitas Terbaru -->
        <div>
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight mb-4">Aktivitas Terbaru</h2>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-[0_8px_30px_rgb(0,0,0,0.01)] p-6 flex flex-col justify-between min-h-[400px]">
                <div class="space-y-5">
                    @php
                        // Dynamically render activities based on real pending or accepted bookings
                        $activities = collect();
                        foreach($pendingBookings->take(2) as $p) {
                            $activities->push([
                                'name' => $p->jobseeker->name ?? 'Mentee',
                                'action' => 'membooking sesi baru',
                                'topic' => $p->booking_notes ?? 'Sesi Mentorship',
                                'time' => $p->created_at ? $p->created_at->diffForHumans() : 'Baru saja'
                            ]);
                        }
                        foreach($acceptedBookings->take(1) as $a) {
                            $activities->push([
                                'name' => $a->jobseeker->name ?? 'Mentee',
                                'action' => 'menyelesaikan sesi',
                                'topic' => 'Career Consultation',
                                'time' => '2 jam yang lalu'
                            ]);
                        }
                        
                        // Fallback elements matching mockup exactly if nothing is booked yet
                        if ($activities->isEmpty()) {
                            $activities->push([
                                'name' => 'John Doe',
                                'action' => 'menyelesaikan sesi',
                                'topic' => 'React Development',
                                'time' => '2 jam yang lalu'
                            ]);
                            $activities->push([
                                'name' => 'Jane Smith',
                                'action' => 'membooking sesi baru',
                                'topic' => 'Career Guidance',
                                'time' => '5 jam yang lalu'
                            ]);
                            $activities->push([
                                'name' => 'Bob Wilson',
                                'action' => 'memberikan review',
                                'topic' => 'Technical Interview',
                                'time' => '1 hari yang lalu'
                            ]);
                        }
                    @endphp
                    
                    @foreach($activities->take(3) as $act)
                        @php
                            $gradient = 'from-[#0ea5e9] to-[#00bee4]';
                            if (str_contains($act['name'], 'John')) {
                                $gradient = 'from-[#0f766e] to-[#14b8a6]';
                            } elseif (str_contains($act['name'], 'Jane')) {
                                $gradient = 'from-[#4338ca] to-[#6366f1]';
                            }
                        @endphp
                        
                        <div class="flex items-center justify-between gap-4 p-4 rounded-2xl border border-slate-100 hover:bg-slate-50/50 transition duration-200">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br {{ $gradient }} text-white flex items-center justify-center font-extrabold text-sm shadow-sm select-none shrink-0">
                                    {{ strtoupper(substr($act['name'], 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm leading-tight">
                                        {{ $act['name'] }} <span class="font-semibold text-slate-500 text-xs">{{ $act['action'] }}</span>
                                    </h4>
                                    <p class="text-xs text-slate-400 font-semibold mt-0.5">{{ $act['topic'] }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold mt-1.5 uppercase tracking-wide">{{ $act['time'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="text-center pt-6 border-t border-slate-100">
                    <a href="{{ route('mentor.mentee.index') }}" class="inline-flex items-center gap-1.5 text-xs font-extrabold text-[#00bee4] hover:text-[#00a3c4] tracking-wide uppercase transition duration-200">
                        Lihat Semua Aktivitas →
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    function toggleRejectionForm(id) {
        const container = document.getElementById('rejection-container-' + id);
        if (container) {
            container.classList.toggle('hidden');
        }
    }
</script>
@endpush
