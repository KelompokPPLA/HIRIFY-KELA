@extends('layouts.mentor')

@section('content')
<div class="max-w-7xl mx-auto">
    <header class="mb-6">
        <h1 class="text-3xl font-bold">Jadwal Sesi</h1>
        <p class="text-gray-500 mt-1">Kelola dan pantau sesi mentoring Anda</p>
    </header>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div class="flex items-center gap-3 w-full md:w-1/2">
            <a href="{{ route('mentor.sesi-jadwal.index', ['tab' => 'mendatang']) }}" class="px-4 py-2 rounded-lg font-semibold transition {{ $tab === 'mendatang' ? 'bg-sky-500 text-white' : 'border border-slate-200 text-slate-600 hover:bg-slate-50' }}">Mendatang</a>
            <a href="{{ route('mentor.sesi-jadwal.index', ['tab' => 'riwayat']) }}" class="px-4 py-2 rounded-lg font-semibold transition {{ $tab === 'riwayat' ? 'bg-sky-500 text-white' : 'border border-slate-200 text-slate-600 hover:bg-slate-50' }}">Riwayat</a>
        </div>

        <div class="flex items-center justify-end">
            <a href="{{ route('mentor.sesi-jadwal.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 text-white rounded-lg shadow hover:scale-[1.01] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                Buat Sesi Baru
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-3 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-3 rounded-lg bg-red-50 text-red-700 border border-red-100">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($sessions as $s)
            @include('components.session-card', ['session' => $s])
        @empty
            <div class="col-span-full py-12 text-center text-slate-500 bg-white rounded-xl border border-slate-200 shadow-sm">
                <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-lg font-medium text-slate-700">Belum Ada Sesi Jadwal</p>
                <p class="mt-1 text-sm text-slate-500">Anda belum membuat sesi jadwal apapun. Silakan buat sesi baru untuk memulainya.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{-- pagination (if provided by controller) --}}
        @if(method_exists($sessions, 'links'))
            <div class="mt-6">{{ $sessions->links() }}</div>
        @endif
    </div>
</div>
@endsection
