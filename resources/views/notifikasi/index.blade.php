@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">Pusat Informasi</p>
            <h1 class="mt-1 text-2xl font-bold text-slate-950 lg:text-3xl">Notifikasi</h1>
            <p class="mt-2 max-w-2xl text-sm text-slate-500">Pantau booking, jadwal, feedback, dan informasi penting lain dari Hirify.</p>
        </div>
        <form method="POST" action="{{ route('notifikasi.read-all') }}">
            @csrf
            <button class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4"></path><circle cx="12" cy="12" r="10"></circle></svg>
                Tandai Semua Dibaca
            </button>
        </form>
    </div>

    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('success') }}</div>
    @endif

    <div class="grid gap-3 sm:grid-cols-4">
        @php
            $summaryCards = [
                ['label' => 'Belum dibaca', 'value' => $unreadCount, 'class' => 'bg-slate-900 text-white'],
                ['label' => 'Booking', 'value' => (int) ($typeCounts['booking'] ?? 0), 'class' => 'bg-cyan-50 text-cyan-700 border border-cyan-100'],
                ['label' => 'Jadwal', 'value' => (int) ($typeCounts['jadwal'] ?? 0), 'class' => 'bg-violet-50 text-violet-700 border border-violet-100'],
                ['label' => 'Feedback', 'value' => (int) ($typeCounts['feedback'] ?? 0), 'class' => 'bg-amber-50 text-amber-700 border border-amber-100'],
            ];
        @endphp
        @foreach ($summaryCards as $card)
            <div class="rounded-2xl p-4 {{ $card['class'] }}">
                <p class="text-xs font-bold uppercase tracking-[0.16em] opacity-70">{{ $card['label'] }}</p>
                <p class="mt-2 text-2xl font-bold">{{ $card['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 p-5">
            <form method="GET" action="/notifikasi" class="grid gap-3 sm:grid-cols-[180px_180px_auto]">
                <select name="type" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
                    <option value="">Semua tipe</option>
                    @foreach (['booking' => 'Booking', 'jadwal' => 'Jadwal', 'feedback' => 'Feedback', 'system' => 'System'] as $value => $label)
                        <option value="{{ $value }}" @selected(($type ?? '') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="status" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
                    <option value="">Semua status</option>
                    <option value="unread" @selected(($status ?? '') === 'unread')>Belum dibaca</option>
                    <option value="read" @selected(($status ?? '') === 'read')>Sudah dibaca</option>
                </select>
                <button type="submit" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Filter</button>
            </form>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse ($notifications as $notification)
                @php
                    $isUnread = $notification->read_at === null;
                    $badgeClass = match($notification->type) {
                        'booking' => 'bg-cyan-50 text-cyan-700 border-cyan-200',
                        'jadwal' => 'bg-violet-50 text-violet-700 border-violet-200',
                        'feedback' => 'bg-amber-50 text-amber-700 border-amber-200',
                        default => 'bg-slate-50 text-slate-700 border-slate-200',
                    };
                @endphp
                <div class="flex flex-col gap-4 p-5 transition hover:bg-slate-50 sm:flex-row sm:items-start sm:justify-between {{ $isUnread ? 'bg-cyan-50/30' : '' }}">
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-lg border px-2.5 py-1 text-[11px] font-bold uppercase tracking-[0.12em] {{ $badgeClass }}">{{ $notification->type }}</span>
                            <span class="rounded-lg px-2.5 py-1 text-[11px] font-bold {{ $isUnread ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-500' }}">
                                {{ $isUnread ? 'Belum dibaca' : 'Sudah dibaca' }}
                            </span>
                            <span class="text-xs font-medium text-slate-400">{{ $notification->created_at?->diffForHumans() }}</span>
                        </div>
                        <h2 class="mt-3 text-base font-bold text-slate-900">{{ $notification->title }}</h2>
                        <p class="mt-1 text-sm leading-relaxed text-slate-600">{{ $notification->message }}</p>
                        @if ($notification->action_url)
                            <a href="{{ $notification->action_url }}" class="mt-3 inline-flex text-sm font-semibold text-cyan-700 hover:text-cyan-800">Buka detail</a>
                        @endif
                    </div>

                    @if ($isUnread)
                        <form method="POST" action="{{ route('notifikasi.read', $notification->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50">Tandai dibaca</button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-slate-100 text-slate-400">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                    </div>
                    <p class="mt-4 font-semibold text-slate-700">Belum ada notifikasi</p>
                    <p class="mt-1 text-sm text-slate-500">Informasi booking, jadwal, dan feedback akan muncul di sini.</p>
                </div>
            @endforelse
        </div>

        @if ($notifications->hasPages())
            <div class="border-t border-slate-200 p-5">{{ $notifications->links() }}</div>
        @endif
    </div>
</div>
@endsection
