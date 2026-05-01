@extends('layouts.app')

@section('title', 'Jadwal Sesi - Hirify!')
@section('page-title', 'Jadwal Sesi')
@section('page-subtitle', 'Kelola dan pantau sesi mentoring Anda')

@section('header-actions')
    <div class="flex items-center gap-3">
        <button class="px-4 py-2 rounded-full bg-sky-500 text-white font-semibold">Mendatang</button>
        <button class="px-4 py-2 rounded-full border border-slate-200 text-slate-600">Riwayat</button>
    </div>
@endsection

@section('content')
    @if(session('success'))
        <div class="mb-4 p-3 rounded-lg bg-emerald-50 text-emerald-700">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-700">{{ session('error') }}</div>
    @endif

    <div class="mb-6 flex justify-end">
        <a href="{{ route('mentor.sesi-jadwal.create') }}" class="px-4 py-2 rounded-lg bg-white border text-slate-700 hover:shadow">Buat Sesi Baru</a>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($sessions as $s)
            @include('components.session-card', ['session' => $s])
        @empty
            {{-- dummy preview cards when empty --}}
            @php
                $dummies = [
                    (object)['id'=>1,'topic'=>'Career Path Discussion','date'=>'2026-04-08','time'=>'14:00','duration'=>60,'platform'=>'Google Meet','status'=>'Confirmed'],
                    (object)['id'=>2,'topic'=>'CV Review & Improvement','date'=>'2026-04-10','time'=>'16:00','duration'=>45,'platform'=>'Zoom','status'=>'Pending'],
                    (object)['id'=>3,'topic'=>'Interview Preparation','date'=>'2026-04-12','time'=>'10:00','duration'=>90,'platform'=>'Cafe Coworking Space','status'=>'Completed'],
                ];
            @endphp
            @foreach($dummies as $s)
                @include('components.session-card', ['session' => $s])
            @endforeach
        @endforelse
    </div>

    <div class="mt-8">
        {{-- pagination (if provided by controller) --}}
        @if(method_exists($sessions, 'links'))
            <div class="mt-6">{{ $sessions->links() }}</div>
        @endif
    </div>
@endsection
