@extends('layouts.mentor')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <header class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Mentee Saya</h1>
        <p class="text-gray-500 mt-1">Pantau progres semua mentee yang aktif dalam sesi Anda</p>
    </header>

    {{-- Stats Row --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-sky-100 flex items-center justify-center text-sky-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
                <div class="text-sm text-gray-500">Total Mentee</div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">{{ $stats['active'] }}</div>
                <div class="text-sm text-gray-500">Aktif</div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">{{ $stats['inactive'] }}</div>
                <div class="text-sm text-gray-500">Tidak Aktif</div>
            </div>
        </div>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('mentor.mentee.index') }}" class="flex flex-col md:flex-row gap-3 mb-6">
        <div class="relative flex-1">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama mentee..." class="w-full pl-9 pr-4 py-2.5 rounded-lg border border-gray-200 focus:ring-sky-200 focus:border-sky-500 transition text-sm">
        </div>
        <div class="flex items-center gap-2">
            @foreach(['all' => 'Semua', 'active' => 'Active', 'inactive' => 'Inactive'] as $val => $label)
                <button type="submit" name="status" value="{{ $val }}"
                    class="px-4 py-2.5 rounded-lg text-sm font-semibold transition {{ ($filterStatus ?? 'all') === $val ? 'bg-sky-500 text-white' : 'border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </form>

    {{-- Card Grid --}}
    @if($mentees->isEmpty())
        <div class="py-16 text-center bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <p class="text-lg font-semibold text-gray-700">Belum Ada Mentee</p>
            <p class="text-sm text-gray-400 mt-1">Mentee akan muncul setelah ada booking sesi dari mereka.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($mentees as $mentee)
                @php
                    $initials = $mentee['avatar'];
                    $colors = ['bg-sky-500', 'bg-teal-500', 'bg-violet-500', 'bg-amber-500', 'bg-rose-500'];
                    $color = $colors[crc32($mentee['name']) % count($colors)];
                @endphp
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex flex-col">
                    {{-- Card Header --}}
                    <div class="p-6 pb-4 flex items-start justify-between gap-3">
                        <div class="flex items-center gap-4">
                            {{-- Avatar --}}
                            <div class="w-14 h-14 rounded-full {{ $color }} flex items-center justify-center text-white font-bold text-xl shrink-0 select-none">
                                {{ $initials }}
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-bold text-gray-900 text-base truncate">{{ $mentee['name'] }}</h3>
                                <p class="text-xs text-gray-400 truncate">{{ $mentee['email'] }}</p>
                                <span class="mt-1 inline-block text-xs font-medium text-sky-700 bg-sky-50 border border-sky-100 rounded px-2 py-0.5">
                                    {{ $mentee['bidang'] }}
                                </span>
                            </div>
                        </div>
                        {{-- Status Badge --}}
                        @if($mentee['is_active'])
                            <span class="shrink-0 inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span> Active
                            </span>
                        @else
                            <span class="shrink-0 inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400 inline-block"></span> Inactive
                            </span>
                        @endif
                    </div>

                    {{-- Stats --}}
                    <div class="px-6 pb-4 grid grid-cols-3 gap-3">
                        <div class="bg-gray-50 rounded-lg p-3 text-center">
                            <div class="text-xl font-bold text-gray-900">{{ $mentee['completed_sessions'] }}</div>
                            <div class="text-xs text-gray-400 mt-0.5">Sesi Selesai</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3 text-center">
                            <div class="text-xl font-bold text-gray-900">{{ $mentee['total_sessions'] }}</div>
                            <div class="text-xs text-gray-400 mt-0.5">Total Sesi</div>
                        </div>
                        <div class="bg-amber-50 rounded-lg p-3 text-center border border-amber-100">
                            @if($mentee['avg_mentee_rating'])
                                <div class="flex items-center justify-center gap-1">
                                    <svg class="w-4 h-4 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.39 2.462a1 1 0 00-.364 1.118l1.287 3.97c.3.921-.755 1.688-1.54 1.118l-3.39-2.462a1 1 0 00-1.175 0L5.11 17.005c-.784.57-1.84-.197-1.54-1.118l1.287-3.97a1 1 0 00-.364-1.118L1.104 8.397c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.97z"/>
                                    </svg>
                                    <span class="text-xl font-bold text-amber-600">{{ $mentee['avg_mentee_rating'] }}</span>
                                </div>
                            @else
                                <div class="text-xl font-bold text-gray-300">—</div>
                            @endif
                            <div class="text-xs text-amber-600 mt-0.5">Rata-rata Rating</div>
                        </div>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="px-6 pb-4">
                        <div class="flex justify-between text-xs text-gray-500 mb-1.5">
                            <span>Progress</span>
                            <span class="font-semibold text-sky-600">{{ $mentee['progress'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-sky-500 h-2 rounded-full transition-all"
                                 style="width: {{ $mentee['progress'] }}%"></div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="px-6 pb-5 pt-2 border-t border-gray-100 mt-auto flex items-center justify-between">
                        <span class="text-xs text-gray-400">
                            @if($mentee['started_at'])
                                Sejak {{ \Carbon\Carbon::parse($mentee['started_at'])->format('d M Y') }}
                            @else
                                —
                            @endif
                        </span>
                        <a href="{{ route('mentor.mentee.show', $mentee['id']) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-slate-900 text-white hover:bg-slate-700 transition">
                            Lihat Detail
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
