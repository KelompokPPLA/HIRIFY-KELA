@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">Pusat Informasi</p>
            <h1 class="mt-1 text-2xl lg:text-3xl font-bold text-slate-950">Notifikasi</h1>
            <p class="mt-2 text-sm text-slate-500 max-w-2xl">Kelola semua pemberitahuan penting terkait aktivitas akun dan karier Anda.</p>
        </div>
        <button class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 active:scale-[0.97]">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"></path><circle cx="12" cy="12" r="10"></circle></svg>
            Tandai Semua Dibaca
        </button>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex flex-col gap-4">
            @php
                $notifications = [
                    [
                        'title' => 'Sesi mentorship baru tersedia',
                        'desc' => 'Mentor menemukan slot waktu baru minggu ini. Segera booking jadwalmu.',
                        'badge' => 'Baru',
                        'badgeColor' => 'bg-cyan-50 text-cyan-700 border-cyan-200',
                        'time' => '10 menit lalu',
                        'icon' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>',
                        'iconColor' => 'bg-cyan-50 text-cyan-600',
                        'unread' => true,
                    ],
                    [
                        'title' => 'CV Anda telah diperbarui',
                        'desc' => 'Versi terbaru CV ATS berhasil disimpan ke akun Anda.',
                        'badge' => 'Sukses',
                        'badgeColor' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'time' => '1 jam lalu',
                        'icon' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line>',
                        'iconColor' => 'bg-emerald-50 text-emerald-600',
                        'unread' => true,
                    ],
                    [
                        'title' => 'Disarankan: Ikuti modul pelatihan terbaru',
                        'desc' => 'Tingkatkan peluang karier Anda dengan pelatihan skill yang relevan.',
                        'badge' => 'Info',
                        'badgeColor' => 'bg-slate-50 text-slate-600 border-slate-200',
                        'time' => 'Kemarin',
                        'icon' => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>',
                        'iconColor' => 'bg-slate-100 text-slate-600',
                        'unread' => false,
                    ],
                    [
                        'title' => 'Self assessment selesai',
                        'desc' => 'Hasil assessment terakhir Anda sudah tersedia. Lihat rekomendasi yang diberikan.',
                        'badge' => 'Selesai',
                        'badgeColor' => 'bg-violet-50 text-violet-700 border-violet-200',
                        'time' => '2 hari lalu',
                        'icon' => '<path d="M9 12l2 2 4-4"></path><circle cx="12" cy="12" r="10"></circle>',
                        'iconColor' => 'bg-violet-50 text-violet-600',
                        'unread' => false,
                    ],
                ];
            @endphp

            @foreach ($notifications as $notif)
                <div class="group flex items-start gap-4 rounded-2xl border {{ $notif['unread'] ? 'border-cyan-100 bg-cyan-50/30' : 'border-slate-100 bg-slate-50/50' }} p-4 transition hover:shadow-sm">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl {{ $notif['iconColor'] }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $notif['icon'] !!}</svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-slate-900 {{ $notif['unread'] ? '' : 'text-slate-700' }}">{{ $notif['title'] }}</p>
                                <p class="mt-1 text-sm text-slate-500 leading-relaxed">{{ $notif['desc'] }}</p>
                            </div>
                            <span class="shrink-0 rounded-lg border px-2.5 py-1 text-[11px] font-bold {{ $notif['badgeColor'] }}">{{ $notif['badge'] }}</span>
                        </div>
                        <p class="mt-2 text-xs font-medium text-slate-400">{{ $notif['time'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Empty State Hint --}}
    <div class="text-center text-sm text-slate-400 py-2">
        Menampilkan 4 notifikasi terbaru
    </div>
</div>
@endsection
