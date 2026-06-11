@extends('layouts.mentor')

@section('title', 'Detail Mentee')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header Section -->
    <header class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Detail Mentee</h1>
            <p class="text-slate-500 mt-1.5 font-medium">Informasi lengkap dan progres belajar mentee Anda</p>
        </div>
        <a href="{{ route('mentor.mentee.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-slate-200 bg-white text-xs font-extrabold uppercase tracking-wider text-slate-600 hover:bg-slate-50 hover:text-slate-900 shadow-sm transition duration-200 self-start sm:self-center">
            ← Kembali ke Mentee Saya
        </a>
    </header>

    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $mentee->name }}</h1>
            <p class="text-sm text-gray-500">{{ $mentee->email }} - {{ $mentee->profile?->posisi_kerja ?? 'Bidang belum diisi' }}</p>
        </div>
        <div class="rounded-2xl bg-slate-900 px-5 py-4 text-white">
            <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-300">Success Score</p>
            <p class="mt-1 text-4xl font-extrabold">{{ $successScore }}%</p>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
        @foreach ($components as $label => $value)
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400">{{ $label }}</p>
                <p class="mt-2 text-2xl font-bold text-slate-900">{{ $value }}%</p>
                <div class="mt-3 h-2 rounded-full bg-slate-100">
                    <div class="h-2 rounded-full bg-sky-500" style="width: {{ min(100, max(0, $value)) }}%"></div>
                </div>
            </div>
        @endforeach
    </div>


    <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5 flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Roadmap Karier</h2>
                    <p class="text-sm text-slate-500">{{ $roadmapCompleted }} dari {{ $roadmapTotal }} langkah selesai</p>
                </div>
                <span class="rounded-full bg-sky-100 px-3 py-1 text-sm font-bold text-sky-700">{{ $roadmapProgress }}%</span>
            </div>

            <div class="space-y-3">
                @forelse ($roadmap as $step)
                    <div class="rounded-2xl border {{ $step->is_completed ? 'border-emerald-200 bg-emerald-50' : 'border-slate-200 bg-slate-50' }} p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-bold text-slate-900">{{ $step->step_order }}. {{ $step->step_title }}</p>
                                <p class="mt-1 text-sm text-slate-600">{{ $step->description }}</p>
                            </div>
                            <span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $step->is_completed ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                                {{ $step->is_completed ? 'Selesai' : 'Berjalan' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="rounded-2xl bg-slate-50 p-5 text-center text-sm text-slate-500">Mentee belum membuat roadmap karier.</p>
                @endforelse
            </div>
        </section>

        <section class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-bold text-slate-900">Self Assessment</h2>
                @if ($latestAssessment)
                    <p class="mt-2 text-4xl font-extrabold text-slate-900">{{ $assessmentScore }}%</p>
                    <p class="text-sm text-slate-500">Terakhir diisi {{ $latestAssessment->created_at?->format('d M Y, H:i') }}</p>
                    <div class="mt-4 space-y-3">
                        @foreach ($assessmentScores as $category => $score)
                            <div>
                                <div class="mb-1 flex justify-between text-xs font-semibold text-slate-500">
                                    <span>{{ $category }}</span>
                                    <span>{{ $score }}%</span>
                                </div>
                                <div class="h-2 rounded-full bg-slate-100"><div class="h-2 rounded-full bg-violet-500" style="width: {{ $score }}%"></div></div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="mt-3 text-sm text-slate-500">Belum ada hasil assessment.</p>
                @endif
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-bold text-slate-900">Riwayat Feedback</h2>
                <div class="mt-4 space-y-3">
                    @forelse ($feedbacks as $feedback)
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-sm font-semibold text-slate-900">Rating mentee: {{ $feedback->mentee_rating ?? '-' }}/5</p>
                            <p class="mt-2 text-sm text-slate-600">{{ $feedback->recommendation }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada feedback untuk mentee ini.</p>
                    @endforelse
                </div>
            </div>
    </div>

    <!-- Curriculum Vitae (CV) Section -->
    <section class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-2">
                    <svg class="h-6 w-6 text-sky-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Curriculum Vitae (CV)
                </h2>
                <p class="text-sm text-slate-500 mt-1">Informasi lengkap CV ATS-friendly milik mentee.</p>
            </div>
            @if($cv)
                <a href="{{ route('cv.download', $cv->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-sky-500 hover:bg-sky-600 text-white font-bold text-sm shadow-md shadow-sky-100 hover:shadow-sky-200 transition duration-200 self-start sm:self-auto">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Unduh CV (PDF)
                </a>
            @endif
        </div>

        @if($cv)
            <div class="grid gap-8 lg:grid-cols-12">
                <!-- Left Side: Profile Info, Contact, Skills (4 cols) -->
                <div class="lg:col-span-4 space-y-6">
                    <!-- Basic Info & Contact -->
                    <div class="rounded-2xl bg-slate-50 p-6 border border-slate-100">
                        <h3 class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400 mb-4">Kontak & Informasi</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-slate-400 font-semibold uppercase">Nama Lengkap</p>
                                <p class="text-sm font-bold text-slate-800 mt-0.5">{{ $cv->nama_lengkap }}</p>
                            </div>
                            
                            <div>
                                <p class="text-xs text-slate-400 font-semibold uppercase">Email</p>
                                <p class="text-sm font-medium text-slate-800 mt-0.5">{{ $cv->email }}</p>
                            </div>

                            @if($cv->telepon)
                            <div>
                                <p class="text-xs text-slate-400 font-semibold uppercase">Telepon</p>
                                <p class="text-sm font-medium text-slate-800 mt-0.5">{{ $cv->telepon }}</p>
                            </div>
                            @endif

                            @if($cv->alamat)
                            <div>
                                <p class="text-xs text-slate-400 font-semibold uppercase">Alamat</p>
                                <p class="text-sm font-medium text-slate-800 mt-0.5">{{ $cv->alamat }}</p>
                            </div>
                            @endif

                            @if($cv->linkedin)
                            <div>
                                <p class="text-xs text-slate-400 font-semibold uppercase">LinkedIn</p>
                                <a href="{{ str_starts_with($cv->linkedin, 'http') ? $cv->linkedin : 'https://' . $cv->linkedin }}" target="_blank" class="text-sm font-bold text-sky-600 hover:text-sky-700 hover:underline inline-flex items-center gap-1 mt-0.5">
                                    {{ $cv->linkedin }}
                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Skills -->
                    @php
                        $techSkills = $cv->skills->where('tipe', 'technical');
                        $softSkills = $cv->skills->where('tipe', 'soft');
                    @endphp

                    @if($cv->skills->isNotEmpty())
                    <div class="rounded-2xl bg-slate-50 p-6 border border-slate-100 space-y-5">
                        <h3 class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400">Key Skills</h3>

                        @if($techSkills->isNotEmpty())
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Technical Skills</p>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($techSkills as $skill)
                                    <span class="rounded-lg bg-sky-50 px-2.5 py-1 text-xs font-semibold text-sky-700 border border-sky-100">
                                        {{ $skill->nama_skill }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($softSkills->isNotEmpty())
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Soft Skills</p>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($softSkills as $skill)
                                    <span class="rounded-lg bg-violet-50 px-2.5 py-1 text-xs font-semibold text-violet-700 border border-violet-100">
                                        {{ $skill->nama_skill }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Right Side: Summary, Experience, Education (8 cols) -->
                <div class="lg:col-span-8 space-y-6">
                    <!-- Professional Summary -->
                    @if($cv->ringkasan)
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400 mb-2">Professional Summary</h3>
                        <p class="text-slate-700 leading-relaxed text-sm bg-slate-50 p-5 rounded-2xl border border-slate-100">
                            {{ $cv->ringkasan }}
                        </p>
                    </div>
                    @endif

                    <!-- Experience -->
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400 mb-3">Work Experience</h3>
                        @if($cv->experiences->isNotEmpty())
                            <div class="relative border-l-2 border-slate-100 ml-3 pl-6 space-y-6">
                                @foreach($cv->experiences as $exp)
                                <div class="relative">
                                    <!-- Indicator dot -->
                                    <div class="absolute -left-[31px] top-1.5 h-3.5 w-3.5 rounded-full border-2 border-sky-500 bg-white shadow-sm"></div>
                                    
                                    <div>
                                        <div class="flex flex-wrap items-baseline justify-between gap-2">
                                            <h4 class="font-bold text-slate-900 text-base">{{ $exp->posisi }}</h4>
                                            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full">{{ $exp->periode }}</span>
                                        </div>
                                        <p class="text-sm font-semibold text-sky-600 mt-0.5">{{ $exp->perusahaan }}</p>
                                        
                                        @if($exp->deskripsi)
                                        <ul class="mt-2 space-y-1 text-sm text-slate-600 list-disc list-inside">
                                            @foreach(array_filter(array_map('trim', explode("\n", $exp->deskripsi))) as $line)
                                                <li>{{ $line }}</li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-slate-500 italic bg-slate-50 p-4 rounded-2xl border border-slate-100">Belum ada pengalaman kerja yang ditambahkan.</p>
                        @endif
                    </div>

                    <!-- Education -->
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400 mb-3">Education</h3>
                        @if($cv->educations->isNotEmpty())
                            <div class="relative border-l-2 border-slate-100 ml-3 pl-6 space-y-6">
                                @foreach($cv->educations as $edu)
                                <div class="relative">
                                    <!-- Indicator dot -->
                                    <div class="absolute -left-[31px] top-1.5 h-3.5 w-3.5 rounded-full border-2 border-violet-500 bg-white shadow-sm"></div>
                                    
                                    <div>
                                        <div class="flex flex-wrap items-baseline justify-between gap-2">
                                            <h4 class="font-bold text-slate-900 text-base">{{ $edu->institusi }}</h4>
                                            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full">{{ $edu->tahun }}</span>
                                        </div>
                                        <p class="text-sm font-medium text-violet-600 mt-0.5">{{ $edu->gelar }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-slate-500 italic bg-slate-50 p-4 rounded-2xl border border-slate-100">Belum ada riwayat pendidikan yang ditambahkan.</p>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State Placeholder -->
            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-3 text-sm font-bold text-slate-900">Belum Ada CV</h3>
                <p class="mt-1 text-sm text-slate-500">Mentee ini belum membuat CV ATS-friendly di Hirify.</p>
            </div>
        @endif
    </section>

    <div class="grid gap-6 lg:grid-cols-2">
        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-bold text-slate-900">Pelatihan Diikuti</h2>
            <div class="mt-4 space-y-3">
                @forelse ($enrollments as $enrollment)
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="flex justify-between gap-3">
                            <div>
                                <p class="font-semibold text-slate-900">{{ $enrollment['title'] }}</p>
                                <p class="text-xs text-slate-500">{{ $enrollment['category'] }} - {{ $enrollment['completed_lessons'] }}/{{ $enrollment['total_lessons'] }} materi</p>
                            </div>
                            <span class="text-sm font-bold text-sky-700">{{ $enrollment['progress'] }}%</span>
                        </div>
                        <div class="mt-3 h-2 rounded-full bg-white"><div class="h-2 rounded-full bg-sky-500" style="width: {{ $enrollment['progress'] }}%"></div></div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Mentee belum mengikuti pelatihan.</p>
                @endforelse
            </div>
        </section>

        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-bold text-slate-900">Riwayat Sesi</h2>
            <div class="mt-4 space-y-3">
                @forelse ($bookings as $booking)
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-semibold text-slate-900">{{ $booking->scheduled_start?->format('d M Y, H:i') }}</p>
                                <p class="text-xs text-slate-500">{{ $booking->duration_minutes }} menit</p>
                            </div>
                            <span class="rounded-full bg-slate-200 px-2.5 py-1 text-xs font-bold text-slate-700">{{ ucfirst($booking->status) }}</span>
                        </div>
                        @if ($booking->booking_notes)
                            <p class="mt-2 text-sm text-slate-600">{{ $booking->booking_notes }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Belum ada sesi mentorship.</p>
                @endforelse
            </div>
        </section>
    </div>
</div>
@endsection
