@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="rounded-[2rem] bg-[#0F172A] p-8 text-white shadow-[0_30px_70px_rgba(15,23,42,0.2)]" style="background-color: #0F172A;">
        <div class="grid gap-8 lg:grid-cols-[1.6fr_1fr] lg:items-center">
            <div class="space-y-6">
                <div>
                    <p class="text-sm uppercase tracking-[0.24em] text-cyan-200/80">Selamat Datang Kembali</p>
                    <h2 class="mt-2 text-3xl font-semibold leading-tight text-white">Halo, {{ auth()->user()->name }}! 👋</h2>
                    <p class="mt-4 max-w-2xl text-sm leading-6 text-slate-300">Temukan rekomendasi terbaru untuk CV, pelatihan, dan mentorship yang sesuai dengan tujuan kariermu.</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-3xl bg-[#111827] p-6 shadow-[0_10px_30px_rgba(0,0,0,0.12)] border border-slate-700">
                        <p class="text-sm text-slate-400">Kelengkapan Profil</p>
                        <p class="mt-3 text-2xl font-semibold text-white">{{ $profileCompleteness }}%</p>
                    </div>
                    <div class="rounded-3xl bg-[#111827] p-5 shadow-[0_10px_30px_rgba(0,0,0,0.12)] border border-slate-700">
                        <p class="text-sm text-slate-400">Pelatihan Selesai</p>
                        <p class="mt-3 text-2xl font-semibold text-white">{{ $trainingCompleted }}/{{ $trainingTotal }}</p>
                    </div>
                    <div class="rounded-3xl bg-[#111827] p-5 shadow-[0_10px_30px_rgba(0,0,0,0.12)] border border-slate-700">
                        <p class="text-sm text-slate-400">Sesi Mentorship</p>
                        <p class="mt-3 text-2xl font-semibold text-white">{{ $mentorshipCompleted }}</p>
                        @if ($mentorshipUpcoming > 0)
                            <p class="mt-1 text-xs text-cyan-300">+{{ $mentorshipUpcoming }} mendatang</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="space-y-8">
        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-bold-500">Kelengkapan Profil</p>
                        <p class="mt-2 text-2xl font-semibold text-slate-950">{{ $profileCompleteness }}%</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-3xl text-[#09C9D3]" style="background-color: rgba(9, 201, 211, 0.15); color: #09C9D3;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12h6"></path>
                            <path d="M9 16h6"></path>
                            <path d="M9 8h6"></path>
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-sm text-slate-500">
                    @if ($profileCompleteness >= 100)
                        Profilmu lengkap.
                    @elseif ($profileCompleteness >= 50)
                        Hampir lengkap, tinggal sedikit lagi.
                    @else
                        Lengkapi profilmu untuk hasil maksimal.
                    @endif
                </p>
                <div class="mt-5">
                    <div class="h-2 rounded-full bg-slate-200">
                        <div class="h-2 rounded-full" style="background-color: #09C9D3; width: {{ $profileCompleteness }}%;"></div>
                    </div>
                </div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-bold-500">Progress Pelatihan</p>
                        <p class="mt-2 text-2xl font-semibold text-slate-950">{{ $trainingProgress }}%</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-3xl text-[#09C9D3]" style="background-color: rgba(9, 201, 211, 0.15); color: #09C9D3;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14"></path>
                            <path d="M5 12h14"></path>
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-sm text-slate-500">
                    @if ($trainingTotal === 0)
                        Belum ada pelatihan terdaftar. Daftar sekarang!
                    @else
                        {{ $trainingCompleted }} dari {{ $trainingTotal }} pelatihan telah diselesaikan.
                    @endif
                </p>
                <div class="mt-5">
                    <div class="h-2 rounded-full bg-slate-200">
                        <div class="h-2 rounded-full" style="background-color: #09C9D3; width: {{ $trainingProgress }}%;"></div>
                    </div>
                </div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-bold-500">Kesiapan Karier</p>
                        <p class="mt-2 text-2xl font-semibold text-slate-950">{{ $careerReadiness }}%</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-3xl text-[#09C9D3]" style="background-color: rgba(9, 201, 211, 0.15); color: #09C9D3;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4"></path>
                            <path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-sm text-slate-500">
                    @if (!$hasAssessment)
                        Belum ada self assessment. Mulai sekarang!
                    @else
                        Berdasarkan self assessment terakhir.
                    @endif
                </p>
                <div class="mt-5">
                    <div class="h-2 rounded-full bg-slate-200">
                        <div class="h-2 rounded-full" style="background-color: #09C9D3; width: {{ $careerReadiness }}%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-xl font-semibold text-slate-950">Aksi Cepat</h2>
            <p class="mt-2 text-sm text-slate-600">Navigasi langsung ke fitur utama Hirify.</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <a href="/skill-training" class="group rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#09C9D3] text-white transition group-hover:bg-[#09C9D3]/90" style="background-color: #09C9D3;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="stroke-current">
                        <path d="M9 12h6"></path><path d="M9 16h6"></path><path d="M9 8h6"></path>
                    </svg>
                </div>
                <div class="mt-5">
                    <p class="text-sm font-semibold text-slate-950">Pelatihan Skill</p>
                    <p class="mt-2 text-sm text-slate-500">Akses katalog kursus dan tingkatkan skill.</p>
                </div>
            </a>
            <a href="/roadmap-karier" class="group rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#09C9D3] text-white transition group-hover:bg-[#09C9D3]/90" style="background-color: #09C9D3;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="stroke-current">
                        <path d="M4 19h16"></path>
                        <path d="M6 15l6-6 6 6"></path>
                    </svg>
                </div>
                <div class="mt-5">
                    <p class="text-sm font-semibold text-slate-950">Lihat Roadmap</p>
                    <p class="mt-2 text-sm text-slate-500">Ikuti panduan karier sesuai bidangmu.</p>
                </div>
            </a>
            <a href="/self-assessment" class="group rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#09C9D3] text-white transition group-hover:bg-[#09C9D3]/90" style="background-color: #09C9D3;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="stroke-current">
                        <path d="M12 5v14"></path>
                        <path d="M5 12h14"></path>
                    </svg>
                </div>
                <div class="mt-5">
                    <p class="text-sm font-semibold text-slate-950">Mulai Assessment</p>
                    <p class="mt-2 text-sm text-slate-500">Evaluasi kesiapan kariermu sekarang.</p>
                </div>
            </a>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-950">Aktivitas Terbaru</h2>
                <p class="mt-2 text-sm text-slate-500">Lihat pembaruan terbaru dari aktivitas akunmu.</p>
            </div>
        </div>

        <div class="mt-6 space-y-4">
            @forelse ($activities as $activity)
                @php
                    $colorMap = [
                        'cyan' => ['bg' => 'bg-cyan-100', 'text' => 'text-cyan-600'],
                        'blue' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600'],
                        'pink' => ['bg' => 'bg-pink-100', 'text' => 'text-pink-600'],
                    ];
                    $palette = $colorMap[$activity['color']] ?? $colorMap['cyan'];
                @endphp
                <div class="flex items-center gap-3 rounded-3xl bg-slate-50 p-4">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl {{ $palette['bg'] }} {{ $palette['text'] }} font-bold">{{ $activity['icon'] }}</div>
                    <div>
                        <p class="font-semibold text-slate-950">{{ $activity['title'] }}</p>
                        <p class="text-sm text-slate-500">{{ $activity['time_label'] }}</p>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl bg-slate-50 p-6 text-center text-sm text-slate-500">
                    Belum ada aktivitas. Mulai dengan mengikuti pelatihan, mentorship, atau self assessment.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
