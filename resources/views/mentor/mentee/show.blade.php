@extends('layouts.mentor')

@section('title', 'Detail Mentee')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <a href="{{ route('mentor.mentee.index') }}" class="text-sm font-semibold text-sky-600 hover:text-sky-700">Kembali ke Mentee Saya</a>
            <h1 class="mt-2 text-3xl font-bold text-gray-900">{{ $mentee->name }}</h1>
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

    <div class="rounded-3xl border border-sky-100 bg-sky-50 p-5">
        <p class="text-xs font-bold uppercase tracking-[0.18em] text-sky-700">Rekomendasi Mentor</p>
        <p class="mt-2 text-sm font-medium leading-relaxed text-slate-700">{{ $recommendation }}</p>
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
        </section>
    </div>

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
