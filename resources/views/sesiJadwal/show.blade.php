@extends('layouts.mentor')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <header class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Detail Sesi</h1>
            <p class="text-slate-500 mt-1.5 font-medium">Rincian dan catatan sesi mentoring Anda</p>
        </div>
        <a href="{{ route('mentor.sesi-jadwal.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-slate-200 bg-white text-xs font-extrabold uppercase tracking-wider text-slate-600 hover:bg-slate-50 hover:text-slate-900 shadow-sm transition duration-200 self-start sm:self-center">
            ← Kembali ke Jadwal
        </a>
    </header>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-100/80 text-sm font-semibold flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 text-rose-700 border border-rose-100/80 text-sm font-semibold flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Main Detail Card -->
    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
        
        <!-- Header Info Block -->
        <div class="p-8 sm:p-10 border-b border-slate-100 bg-gradient-to-b from-slate-50/50 to-white">
            <div class="flex flex-col sm:flex-row justify-between items-start gap-6">
                <div class="space-y-4 flex-1">
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight leading-snug">{{ $session->topic }}</h2>
                    
                    <div class="flex flex-wrap items-center gap-y-2 gap-x-5 text-sm font-bold text-slate-400">
                        <span class="flex items-center gap-2 text-slate-500">
                            <span class="w-8 h-8 rounded-xl bg-cyan-50 text-cyan-500 grid place-items-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            </span>
                            {{ \Carbon\Carbon::parse($session->date)->locale('id')->translatedFormat('l, j F Y') }}
                        </span>
                        <span class="hidden sm:inline">•</span>
                        <span class="flex items-center gap-2 text-slate-500">
                            <span class="w-8 h-8 rounded-xl bg-cyan-50 text-cyan-500 grid place-items-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            </span>
                            {{ date('H:i', strtotime($session->time)) }} WIB
                        </span>
                        <span class="hidden sm:inline">•</span>
                        <span class="flex items-center gap-2 text-slate-500">
                            <span class="w-8 h-8 rounded-xl bg-cyan-50 text-cyan-500 grid place-items-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            </span>
                            Durasi: {{ $session->duration }} Menit
                        </span>
                    </div>

                    <!-- Platform Details -->
                    <div class="pt-2 text-sm font-bold text-slate-500 flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-xl bg-cyan-50 text-cyan-500 grid place-items-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </span>
                        <div>
                            <span class="text-slate-400 mr-1.5 font-semibold">Platform:</span>
                            @if($session->platform)
                                <a href="{{ $session->platform }}" target="_blank" class="text-cyan-600 hover:text-cyan-700 hover:underline transition font-extrabold leading-tight">{{ $session->platform }}</a>
                            @else
                                <span class="text-slate-400 italic">Belum ditentukan</span>
                            @endif
                        </div>
                    </div>

                    <!-- Material details if any -->
                    @if($session->material_file)
                        <div class="pt-2 text-sm font-bold text-slate-500 flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-xl bg-cyan-50 text-cyan-500 grid place-items-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002 2h12a2 2 0 002-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                            </span>
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400 mr-1 font-semibold">Materi:</span>
                                <a href="{{ Storage::url($session->material_file) }}" target="_blank" 
                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-cyan-50 text-cyan-600 rounded-full text-xs font-extrabold uppercase tracking-wider border border-cyan-100/50 hover:bg-cyan-100/80 transition duration-200 shadow-sm shadow-cyan-500/5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                                    Lihat/Unduh Materi
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                @php
                    $statusClasses = [
                        'Pending' => 'bg-amber-50 text-amber-600 border border-amber-100/50',
                        'Confirmed' => 'bg-cyan-50 text-cyan-600 border border-cyan-100/50',
                        'Completed' => 'bg-emerald-50 text-emerald-600 border border-emerald-100/50',
                        'Cancelled' => 'bg-rose-50 text-rose-600 border border-rose-100/50'
                    ];
                    $colorClass = $statusClasses[$session->status] ?? 'bg-slate-50 text-slate-600 border border-slate-100';
                @endphp
                <span class="shrink-0 px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-wide {{ $colorClass }}">
                    {{ $session->status }}
                </span>
            </div>

            <!-- Edit Button Row -->
            <div class="mt-8 flex gap-3">
                <a href="{{ route('mentor.sesi-jadwal.edit', $session->id) }}" 
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-slate-200 text-xs font-extrabold uppercase tracking-wider text-slate-700 bg-white hover:bg-slate-50 transition duration-200 shadow-sm shadow-slate-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path>
                    </svg>
                    Edit Sesi
                </a>
            </div>
        </div>

        <!-- Participants Block -->
        <div class="p-8 sm:p-10 border-b border-slate-100">
            <h3 class="text-lg font-extrabold text-slate-900 tracking-tight mb-5 flex items-center gap-2">
                Peserta Mentee (Jobseeker)
            </h3>
            
            @if($session->bookings->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($session->bookings as $booking)
                        @php
                            $colors = [
                                'from-[#00bee4] to-[#0ea5e9]',
                                'from-[#10b981] to-[#047857]',
                                'from-[#6366f1] to-[#4338ca]',
                                'from-[#3b82f6] to-[#1d4ed8]'
                            ];
                            $gradient = $colors[crc32($booking->jobseeker->name) % count($colors)];
                        @endphp
                        
                        <div class="flex items-center justify-between gap-4 p-4 bg-white border border-slate-200 rounded-2xl hover:bg-slate-50/50 transition duration-200 shadow-sm shadow-slate-100/50">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br {{ $gradient }} text-white flex items-center justify-center font-extrabold text-sm shadow-sm select-none shrink-0">
                                    {{ strtoupper(substr($booking->jobseeker->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-bold text-slate-800 text-sm leading-tight truncate">{{ $booking->jobseeker->name }}</h4>
                                    <p class="text-[10px] text-slate-400 font-bold mt-1.5 uppercase tracking-wide leading-none">Jobseeker</p>
                                </div>
                            </div>
                            
                            <span class="shrink-0 px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wide bg-cyan-50 text-cyan-600 border border-cyan-100/50">
                                {{ $booking->status }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-6 text-center text-slate-400 font-semibold text-sm italic bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
                    Belum ada peserta yang mengambil sesi ini.
                </div>
            @endif
        </div>

        <!-- Notes Block -->
        <div class="p-8 sm:p-10 bg-slate-50/50">
            <h3 class="text-lg font-extrabold text-slate-900 tracking-tight mb-5">Catatan Hasil Sesi</h3>
            
            @if($session->notes)
                <div class="p-6 bg-white rounded-2xl border border-slate-200 text-sm font-semibold text-slate-600 shadow-sm shadow-slate-100/50 leading-relaxed whitespace-pre-wrap">{{ $session->notes }}</div>
            @else
                <div class="py-6 text-center text-slate-400 font-semibold text-sm italic bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
                    Belum ada catatan untuk sesi ini.
                </div>
            @endif

            @if($session->status === 'Completed' && !$session->notes)
                <div class="mt-6 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
                    <form action="{{ route('mentor.sesi-jadwal.notes', $session->id) }}" method="POST">
                        @csrf
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-3">Tambahkan Catatan Sesi</label>
                        <textarea name="notes" rows="4" required 
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white focus:ring-4 focus:ring-cyan-500/10 focus:border-[#00bee4] outline-none transition duration-200 text-sm font-semibold text-slate-700 shadow-sm shadow-slate-100/50" 
                            placeholder="Tuliskan kesimpulan hasil sesi, rekomendasi karier, atau area perbaikan penting bagi mentee Anda..."></textarea>
                        
                        <div class="mt-5 flex justify-end">
                            <button type="submit" 
                                class="px-6 py-2.5 rounded-full bg-slate-900 text-white text-xs font-extrabold uppercase tracking-wider hover:bg-slate-800 transition duration-200 shadow-md">
                                Simpan Catatan
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
