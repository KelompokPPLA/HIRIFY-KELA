@extends('layouts.mentor')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <header class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Profil Mentee</h1>
            <p class="text-slate-500 mt-1.5 font-medium">Informasi biodata lengkap dan histori sesi mentee Anda</p>
        </div>
        <a href="{{ route('mentor.mentee.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-slate-200 bg-white text-xs font-extrabold uppercase tracking-wider text-slate-600 hover:bg-slate-50 hover:text-slate-900 shadow-sm transition duration-200 self-start sm:self-center">
            ← Kembali ke Mentee Saya
        </a>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Profile Card -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-[0_8px_30px_rgb(0,0,0,0.02)] text-center relative overflow-hidden">
                <!-- Decorative Circle -->
                <div class="absolute -right-10 -top-10 w-24 h-24 bg-cyan-50 rounded-full blur-2xl"></div>
                
                <div class="relative">
                    @php
                        $initials = strtoupper(substr($mentee->name, 0, 2));
                        $colors = [
                            'from-[#00bee4] to-[#0ea5e9]',
                            'from-[#06b6d4] to-[#0891b2]',
                            'from-[#14b8a6] to-[#0f766e]',
                            'from-[#6366f1] to-[#4338ca]'
                        ];
                        $gradient = $colors[crc32($mentee->name) % count($colors)];
                    @endphp
                    <!-- Avatar -->
                    <div class="w-24 h-24 mx-auto rounded-3xl bg-gradient-to-br {{ $gradient }} text-white flex items-center justify-center font-black text-3xl shadow-lg shadow-cyan-500/10 mb-5 select-none">
                        {{ $initials }}
                    </div>

                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight leading-tight mb-1">{{ $mentee->name }}</h2>
                    <p class="text-sm font-semibold text-slate-400 mb-4">{{ $mentee->email }}</p>
                    
                    <span class="inline-block text-xs font-extrabold tracking-wider uppercase text-cyan-700 bg-cyan-50/60 border border-cyan-100/50 rounded-full px-4 py-1.5 mb-6">
                        {{ $mentee->profile->posisi_kerja ?? 'Jobseeker' }}
                    </span>
                    
                    <!-- Bio Block -->
                    <div class="border-t border-slate-100 pt-6 text-left">
                        <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 mb-3">Tentang Mentee</h3>
                        <p class="text-sm font-medium text-slate-500 leading-relaxed whitespace-pre-line">
                            {{ $mentee->profile->bio ?? 'Mentee belum mengisi kolom biografi profil mereka saat ini.' }}
                        </p>
                    </div>

                    <!-- Contact Details -->
                    <div class="border-t border-slate-100 pt-6 mt-6 space-y-3.5 text-left text-sm font-bold text-slate-500">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-slate-50 border border-slate-100 text-slate-400 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.387a12.035 12.035 0 01-7.108-7.108c-.145-.44.02-.927.396-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                                </svg>
                            </span>
                            <span>{{ $mentee->profile->phone ?? '—' }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-slate-50 border border-slate-100 text-slate-400 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                </svg>
                            </span>
                            <span>{{ $mentee->profile->location ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Timeline & Professional Details -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Professional Credentials (Education & Experience) -->
            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
                <h3 class="text-lg font-extrabold text-slate-900 tracking-tight mb-6">Latar Belakang Profesional</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Education -->
                    <div>
                        <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#00bee4]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                            Pendidikan
                        </h4>
                        @if(!empty($mentee->profile->education) && is_array($mentee->profile->education))
                            <div class="space-y-4">
                                @foreach($mentee->profile->education as $edu)
                                    <div class="border-l-2 border-slate-100 pl-4 py-1">
                                        <h5 class="font-bold text-slate-800 text-sm leading-snug">{{ $edu['school'] ?? ($edu['institution'] ?? 'Institusi Pendidikan') }}</h5>
                                        <p class="text-xs font-semibold text-slate-500 mt-0.5">{{ $edu['degree'] ?? ($edu['major'] ?? 'Gelar / Jurusan') }}</p>
                                        <p class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider mt-1">{{ $edu['year'] ?? ($edu['period'] ?? '') }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm font-semibold text-slate-400 italic">Belum ada data pendidikan.</p>
                        @endif
                    </div>

                    <!-- Experience -->
                    <div>
                        <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#00bee4]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Pengalaman Kerja
                        </h4>
                        @if(!empty($mentee->profile->experience) && is_array($mentee->profile->experience))
                            <div class="space-y-4">
                                @foreach($mentee->profile->experience as $exp)
                                    <div class="border-l-2 border-slate-100 pl-4 py-1">
                                        <h5 class="font-bold text-slate-800 text-sm leading-snug">{{ $exp['role'] ?? ($exp['position'] ?? 'Posisi Pekerjaan') }}</h5>
                                        <p class="text-xs font-semibold text-slate-500 mt-0.5">{{ $exp['company'] ?? 'Perusahaan' }}</p>
                                        <p class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider mt-1">{{ $exp['year'] ?? ($exp['period'] ?? '') }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm font-semibold text-slate-400 italic">Belum ada data pengalaman kerja.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Booking History Timeline -->
            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
                <h3 class="text-lg font-extrabold text-slate-900 tracking-tight mb-6">Histori Sesi dengan Anda</h3>
                
                @if($bookings->count() > 0)
                    <div class="space-y-4">
                        @foreach($bookings as $booking)
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-amber-50 text-amber-600 border border-amber-100/50',
                                    'confirmed' => 'bg-cyan-50 text-cyan-600 border border-cyan-100/50',
                                    'completed' => 'bg-emerald-50 text-emerald-600 border border-emerald-100/50',
                                    'rejected' => 'bg-rose-50 text-rose-600 border border-rose-100/50'
                                ];
                                $colorClass = $statusClasses[strtolower($booking->status)] ?? 'bg-slate-50 text-slate-600 border border-slate-100';
                            @endphp
                            
                            <div class="flex items-center justify-between gap-4 p-4 bg-white border border-slate-200 rounded-2xl hover:bg-slate-50/50 transition duration-200 shadow-sm shadow-slate-100/50">
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm leading-tight">Sesi Mentorship</h4>
                                    <p class="text-xs text-slate-500 font-semibold mt-1">Catatan: <span class="text-slate-400 italic font-medium">{{ $booking->booking_notes ?: 'Tidak ada catatan' }}</span></p>
                                    <div class="flex items-center gap-3 text-[11px] text-slate-400 font-bold mt-2">
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
                                <span class="shrink-0 px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wide {{ $colorClass }}">
                                    {{ $booking->status }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm font-semibold text-slate-400 italic text-center py-6">Belum ada histori sesi bimbingan.</p>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection
