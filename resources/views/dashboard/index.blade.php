@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    {{-- Welcome Banner --}}
    <section class="rounded-[1.5rem] p-7 lg:p-8 text-white shadow-[0_30px_70px_rgba(15,23,42,0.18)] relative overflow-hidden" style="background: linear-gradient(135deg, #0b1021 0%, #10182d 42%, #17253a 100%);">
        <div class="absolute inset-0 opacity-40 pointer-events-none" style="background-image: radial-gradient(rgba(255,255,255,0.07) 1px, transparent 1px); background-size: 22px 22px;"></div>
        <div class="relative z-10 grid gap-6 lg:grid-cols-[1.6fr_1fr] lg:items-center">
            <div class="space-y-5">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-cyan-200/80 font-semibold">Selamat Datang Kembali</p>
                    @php
        $hour = now()->hour;
        $greeting = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
    @endphp
    <h1 class="mt-2 text-2xl lg:text-3xl font-bold leading-tight text-white">{{ $greeting }}, {{ auth()->user()->name }}! 👋</h1>
                    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-slate-300">Temukan rekomendasi terbaru untuk CV, pelatihan, dan mentorship yang sesuai dengan tujuan kariermu.</p>
                </div>

                <div class="grid gap-3 sm:grid-cols-3">
                    <div class="rounded-2xl bg-white/[0.06] backdrop-blur-sm p-5 border border-white/10">
                        <p class="text-xs text-slate-400 font-medium">Kelengkapan Profil</p>
                        <p class="mt-2 text-2xl font-bold text-white">{{ $profileCompleteness }}%</p>
                    </div>
                    <div class="rounded-2xl bg-white/[0.06] backdrop-blur-sm p-5 border border-white/10">
                        <p class="text-xs text-slate-400 font-medium">Pelatihan Selesai</p>
                        <p class="mt-2 text-2xl font-bold text-white">{{ $trainingCompleted }}/{{ $trainingTotal }}</p>
                    </div>
                    <div class="rounded-2xl bg-white/[0.06] backdrop-blur-sm p-5 border border-white/10">
                        <p class="text-xs text-slate-400 font-medium">Sesi Mentorship</p>
                        <p class="mt-2 text-2xl font-bold text-white">{{ $mentorshipCompleted }}</p>
                        @if ($mentorshipPending > 0)
                            <p class="mt-1 text-xs text-yellow-300 font-semibold">{{ $mentorshipPending }} menunggu konfirmasi</p>
                        @elseif ($mentorshipUpcoming > 0)
                            <p class="mt-1 text-xs text-cyan-300 font-semibold">+{{ $mentorshipUpcoming }} sesi mendatang</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Progress Cards --}}
    <div class="grid gap-5 sm:grid-cols-3">
        @php
            $progressCards = [
                [
                    'label' => 'Kelengkapan Profil',
                    'value' => $profileCompleteness . '%',
                    'progress' => $profileCompleteness,
                    'desc' => $profileCompleteness >= 100 ? 'Profilmu lengkap.' : ($profileCompleteness >= 50 ? 'Hampir lengkap, tinggal sedikit lagi.' : 'Lengkapi profilmu untuk hasil maksimal.'),
                    'icon' => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>',
                ],
                [
                    'label' => 'Progress Pelatihan',
                    'value' => $trainingProgress . '%',
                    'progress' => $trainingProgress,
                    'desc' => $trainingTotal === 0
                        ? 'Belum ada pelatihan terdaftar. Mulai belajar!'
                        : ($trainingCompleted . ' dari ' . $trainingTotal . ' kursus selesai' . ($trainingProgress > 0 && $trainingCompleted < $trainingTotal ? ' · ' . $trainingProgress . '% progres keseluruhan' : '') . '.'),
                    'icon' => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>',
                ],
                [
                    'label' => 'Kesiapan Karier',
                    'value' => $careerReadiness . '%',
                    'progress' => $careerReadiness,
                    'desc' => !$hasAssessment ? 'Belum ada self assessment. Mulai sekarang!' : ($careerReadinessLabel . ' — ' . ($assessmentDate ?? 'baru saja')),
                    'icon' => '<path d="M9 12l2 2 4-4"></path><circle cx="12" cy="12" r="10"></circle>',
                ],
            ];
        @endphp

        @foreach ($progressCards as $card)
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold text-slate-600">{{ $card['label'] }}</p>
                        <p class="mt-2 text-2xl font-bold text-slate-950">{{ $card['value'] }}</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl" style="background: rgba(9, 201, 211, 0.12); color: #0399b7;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $card['icon'] !!}</svg>
                    </div>
                </div>
                <p class="mt-3 text-sm text-slate-500">{{ $card['desc'] }}</p>
                <div class="mt-4">
                    <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-2 rounded-full transition-all duration-700" style="background: linear-gradient(90deg, #0399b7, #06d8ee); width: {{ $card['progress'] }}%;"></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Quick Actions --}}
    <div>
        <h2 class="text-xl font-bold text-slate-950">Aksi Cepat</h2>
        <p class="mt-1 text-sm text-slate-500">Navigasi langsung ke fitur utama Hirify.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $quickActions = [
                ['href' => '/skill-training', 'title' => 'Pelatihan Skill', 'desc' => 'Akses katalog kursus dan tingkatkan skill kariermu.', 'icon' => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>'],
                ['href' => '/roadmap-karier', 'title' => 'Roadmap Karier', 'desc' => 'Ikuti panduan dan tahapan karier sesuai bidangmu.', 'icon' => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>'],
                ['href' => '/self-assessment', 'title' => 'Self Assessment', 'desc' => 'Evaluasi dan ukur kesiapan kariermu sekarang.', 'icon' => '<path d="M9 12l2 2 4-4"></path><circle cx="12" cy="12" r="10"></circle>'],
                ['href' => '/mentorship', 'title' => 'Cari Mentor', 'desc' => 'Temukan mentor berpengalaman untuk membimbingmu.', 'icon' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>'],
            ];
        @endphp

        @foreach ($quickActions as $action)
            <a href="{{ $action['href'] }}" class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-lg hover:border-cyan-200">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl text-white transition group-hover:scale-105" style="background: linear-gradient(135deg, #0399b7, #06d8ee); box-shadow: 0 6px 16px rgba(3, 153, 183, 0.25);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $action['icon'] !!}</svg>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-bold text-slate-950">{{ $action['title'] }}</p>
                    <p class="mt-1.5 text-sm text-slate-500">{{ $action['desc'] }}</p>
                </div>
            </a>
        @endforeach
    </div>

    {{-- Recent Activity --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-950">Aktivitas Terbaru</h2>
                <p class="mt-1 text-sm text-slate-500">Lihat pembaruan terbaru dari aktivitas akunmu.</p>
            </div>
        </div>

        <div class="mt-6 space-y-3">
            @forelse ($activities as $activity)
                @php
                    $colorMap = [
                        'cyan' => ['bg' => 'bg-cyan-50', 'text' => 'text-cyan-600', 'border' => 'border-cyan-100'],
                        'blue' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'border' => 'border-blue-100'],
                        'pink' => ['bg' => 'bg-pink-50', 'text' => 'text-pink-600', 'border' => 'border-pink-100'],
                    ];
                    $palette = $colorMap[$activity['color']] ?? $colorMap['cyan'];
                @endphp
                <div class="flex items-center gap-3 rounded-2xl bg-slate-50/70 border border-slate-100 p-4 hover:bg-slate-50 transition" title="{{ $activity['time_full'] ?? '' }}">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl {{ $palette['bg'] }} {{ $palette['text'] }} font-bold text-sm flex-shrink-0">{{ $activity['icon'] }}</div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-slate-900 text-sm truncate">{{ $activity['title'] }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $activity['time_label'] }}</p>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl bg-slate-50 border border-dashed border-slate-200 p-8 text-center">
                    <div class="text-3xl mb-3">🚀</div>
                    <p class="text-sm font-semibold text-slate-700 mb-1">Belum ada aktivitas tercatat</p>
                    <p class="text-xs text-slate-500">Mulai perjalanan kariermu dengan mengikuti pelatihan, sesi mentorship, atau self assessment sekarang.</p>
                    <a href="/skill-training" class="inline-block mt-4 px-4 py-2 rounded-xl text-xs font-bold text-white" style="background: linear-gradient(135deg, #0399b7, #06d8ee);">Mulai Pelatihan</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
