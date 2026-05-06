@extends('layouts.mentor')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Jadwal Sesi</h1>
            <p class="text-slate-500 mt-1.5 font-medium">Kelola dan pantau sesi mentoring Anda</p>
        </div>

        <div class="flex flex-wrap items-center gap-4">
            <!-- Switcher Pills -->
            <div class="flex items-center bg-white p-1 rounded-full border border-slate-200/80 shadow-sm gap-1">
                <a href="{{ route('mentor.sesi-jadwal.index', ['tab' => 'mendatang']) }}" class="px-6 py-2 rounded-full font-extrabold text-sm transition duration-200 {{ $tab === 'mendatang' ? 'bg-[#00bee4] text-white shadow-md shadow-cyan-500/15' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">Mendatang</a>
                <a href="{{ route('mentor.sesi-jadwal.index', ['tab' => 'riwayat']) }}" class="px-6 py-2 rounded-full font-extrabold text-sm transition duration-200 {{ $tab === 'riwayat' ? 'bg-[#00bee4] text-white shadow-md shadow-cyan-500/15' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">Riwayat</a>
            </div>

            <!-- Create Button -->
            <a href="{{ route('mentor.sesi-jadwal.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-full shadow-lg shadow-slate-900/10 hover:scale-[1.02] active:scale-[0.98] transition duration-200 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                Buat Sesi Baru
            </a>
        </div>
    </div>

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

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($sessions as $s)
            @include('components.session-card', ['session' => $s])
        @empty
            <div class="col-span-full py-16 text-center text-slate-500 bg-white rounded-2xl border border-slate-200 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
                <svg class="mx-auto h-14 w-14 text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-xl font-extrabold text-slate-800 tracking-tight">Belum Ada Sesi Jadwal</p>
                <p class="mt-2 text-sm text-slate-400 font-semibold max-w-md mx-auto">Anda belum memiliki sesi jadwal aktif di bagian ini. Silakan buat sesi baru untuk memulainya.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(method_exists($sessions, 'links'))
        <div class="mt-10">{{ $sessions->links() }}</div>
    @endif
</div>
@endsection
