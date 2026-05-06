@extends('layouts.admin')

@section('title', 'Hirify | Aktivitas Platform')

@section('content')
<div class="space-y-8">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Admin Panel</p>
        <h1 class="text-3xl font-semibold text-slate-950">Aktivitas Platform</h1>
        <p class="mt-2 text-sm text-slate-600 max-w-2xl">Log aktivitas terbaru pengguna: booking mentorship, pendaftaran pelatihan, dan diskusi forum.</p>
    </div>

    {{-- Monthly trend --}}
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold text-slate-950">Tren Aktivitas 6 Bulan Terakhir</h2>
        <p class="mt-1 text-sm text-slate-500">Jumlah pengguna baru, sesi mentorship, dan pendaftaran pelatihan per bulan.</p>

        @php
            $maxValue = 1;
            foreach ($monthly as $m) {
                $maxValue = max($maxValue, $m['users'], $m['bookings'], $m['enrollments']);
            }
        @endphp

        <div class="mt-6 grid grid-cols-6 gap-4 items-end" style="height: 200px;">
            @foreach ($monthly as $m)
                @php
                    $usersHeight = $m['users'] > 0 ? max(4, ($m['users'] / $maxValue) * 160) : 2;
                    $bookingsHeight = $m['bookings'] > 0 ? max(4, ($m['bookings'] / $maxValue) * 160) : 2;
                    $enrollHeight = $m['enrollments'] > 0 ? max(4, ($m['enrollments'] / $maxValue) * 160) : 2;
                @endphp
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-end gap-1 w-full justify-center" style="height: 160px;">
                        <div class="rounded-t flex-1 transition" style="background:#06d8ee; height: {{ $usersHeight }}px;" title="Pengguna: {{ $m['users'] }}"></div>
                        <div class="rounded-t flex-1 transition" style="background:#0F172A; height: {{ $bookingsHeight }}px;" title="Mentorship: {{ $m['bookings'] }}"></div>
                        <div class="rounded-t flex-1 transition" style="background:#94a3b8; height: {{ $enrollHeight }}px;" title="Pelatihan: {{ $m['enrollments'] }}"></div>
                    </div>
                    <p class="text-xs font-medium text-slate-600 mt-1">{{ $m['label'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-4 flex items-center gap-5 text-xs text-slate-500">
            <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm" style="background:#06d8ee"></span> Pengguna Baru</span>
            <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm" style="background:#0F172A"></span> Sesi Mentorship</span>
            <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm" style="background:#94a3b8"></span> Pendaftaran Pelatihan</span>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        {{-- Recent bookings --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-lg font-semibold text-slate-950">Booking Mentorship Terbaru</h3>
                    <p class="mt-1 text-sm text-slate-500">15 booking terbaru di platform.</p>
                </div>
            </div>
            <div class="space-y-3">
                @forelse ($recentBookings as $booking)
                    @php
                        $statusColor = match($booking->status) {
                            'pending'   => 'bg-yellow-100 text-yellow-700',
                            'confirmed' => 'bg-cyan-100 text-cyan-700',
                            'completed' => 'bg-green-100 text-green-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                            default     => 'bg-slate-100 text-slate-600',
                        };
                        $statusLabel = match($booking->status) {
                            'pending'   => 'Menunggu',
                            'confirmed' => 'Dikonfirmasi',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                            default     => ucfirst($booking->status),
                        };
                    @endphp
                    <div class="flex items-center justify-between gap-3 rounded-2xl bg-slate-50 px-4 py-3">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-900 truncate">
                                {{ $booking->jobseeker?->name ?? 'Pengguna' }}
                                <span class="font-normal text-slate-500">→ {{ $booking->mentor?->user?->name ?? 'Mentor' }}</span>
                            </p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $booking->created_at?->format('d M Y, H:i') }}</p>
                        </div>
                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold flex-shrink-0 {{ $statusColor }}">{{ $statusLabel }}</span>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 py-4 text-center">Belum ada booking mentorship.</p>
                @endforelse
            </div>
        </div>

        {{-- Recent enrollments --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5">
                <h3 class="text-lg font-semibold text-slate-950">Pendaftaran Pelatihan Terbaru</h3>
                <p class="mt-1 text-sm text-slate-500">15 pendaftaran kursus terbaru.</p>
            </div>
            <div class="space-y-3">
                @forelse ($recentEnrollments as $enrollment)
                    <div class="flex items-center justify-between gap-3 rounded-2xl bg-slate-50 px-4 py-3">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-900 truncate">
                                {{ $enrollment->user?->name ?? 'Pengguna' }}
                            </p>
                            <p class="text-xs text-slate-500 mt-0.5 truncate">{{ $enrollment->course?->title ?? 'Kursus' }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            @if ($enrollment->completed_at)
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Selesai</span>
                            @else
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-cyan-100 text-cyan-700">Aktif</span>
                            @endif
                            <p class="text-xs text-slate-500 mt-1">{{ $enrollment->created_at?->format('d M Y') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 py-4 text-center">Belum ada pendaftaran pelatihan.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Recent forum threads --}}
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-5">
            <h3 class="text-lg font-semibold text-slate-950">Thread Forum Terbaru</h3>
            <p class="mt-1 text-sm text-slate-500">15 diskusi terbaru yang dibuat pengguna.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 border-b border-slate-200">
                        <th class="py-3 pr-4">Judul</th>
                        <th class="py-3 pr-4">Dibuat oleh</th>
                        <th class="py-3 pr-4">Views</th>
                        <th class="py-3 pr-4">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentThreads as $thread)
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                            <td class="py-3 pr-4 font-medium text-slate-900 max-w-xs truncate">{{ $thread->title }}</td>
                            <td class="py-3 pr-4 text-slate-600">{{ $thread->user?->name ?? 'Pengguna' }}</td>
                            <td class="py-3 pr-4 text-slate-600">{{ $thread->views_count }}</td>
                            <td class="py-3 pr-4 text-slate-600">{{ $thread->created_at?->format('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-sm text-slate-500">Belum ada thread forum.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
