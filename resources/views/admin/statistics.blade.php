@extends('layouts.admin')

@section('title', 'Hirify | Statistik Platform')

@section('content')
<div class="space-y-8">
    {{-- Header --}}
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Admin Dashboard</p>
        <h1 class="text-3xl font-semibold text-slate-950">Statistik Platform</h1>
        <p class="mt-2 text-sm text-slate-600 max-w-2xl">Pantau jumlah pengguna aktif, sesi mentorship, pelatihan, dan aktivitas platform per periode untuk mengambil keputusan berbasis data.</p>
    </div>

    {{-- Summary cards --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 rounded-full opacity-5 -translate-y-4 translate-x-4" style="background:#06d8ee;"></div>
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm text-slate-500">Total Pengguna</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-950">{{ number_format($summary['total_users']) }}</p>
                </div>
                <div class="w-10 h-10 rounded-2xl grid place-items-center flex-shrink-0" style="background:rgba(6,216,238,.12);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#06d8ee" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
            </div>
            <p class="mt-3 text-xs text-slate-500">
                Jobseeker: <span class="font-semibold text-slate-700">{{ $summary['users_by_role']['jobseeker'] }}</span> ·
                Mentor: <span class="font-semibold text-slate-700">{{ $summary['users_by_role']['mentor'] }}</span> ·
                Admin: <span class="font-semibold text-slate-700">{{ $summary['users_by_role']['admin'] }}</span>
            </p>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 rounded-full opacity-5 -translate-y-4 translate-x-4" style="background:#7c3aed;"></div>
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm text-slate-500">Sesi Mentorship</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-950">{{ number_format($summary['total_bookings']) }}</p>
                </div>
                <div class="w-10 h-10 rounded-2xl grid place-items-center flex-shrink-0" style="background:rgba(124,58,237,.12);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
            </div>
            <p class="mt-3 text-xs text-slate-500">
                Selesai: <span class="font-semibold text-slate-700">{{ $summary['bookings_by_status']['completed'] }}</span> ·
                Aktif: <span class="font-semibold text-slate-700">{{ $summary['bookings_by_status']['confirmed'] + $summary['bookings_by_status']['pending'] }}</span>
            </p>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 rounded-full opacity-5 -translate-y-4 translate-x-4" style="background:#10b981;"></div>
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm text-slate-500">Pendaftaran Pelatihan</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-950">{{ number_format($summary['total_enrollments']) }}</p>
                </div>
                <div class="w-10 h-10 rounded-2xl grid place-items-center flex-shrink-0" style="background:rgba(16,185,129,.12);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>
            </div>
            <p class="mt-3 text-xs text-slate-500">
                Selesai: <span class="font-semibold text-slate-700">{{ $summary['completed_enrollments'] }}</span> dari
                <span class="font-semibold text-slate-700">{{ $summary['total_courses'] }}</span> kursus
            </p>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 rounded-full opacity-5 -translate-y-4 translate-x-4" style="background:#f59e0b;"></div>
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm text-slate-500">Thread Forum</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-950">{{ number_format($summary['total_forum_threads']) }}</p>
                </div>
                <div class="w-10 h-10 rounded-2xl grid place-items-center flex-shrink-0" style="background:rgba(245,158,11,.12);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
            </div>
            <p class="mt-3 text-xs text-slate-500">Total diskusi aktif pengguna</p>
        </div>
    </div>

    {{-- Activity chart --}}
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between flex-wrap gap-3 mb-6">
            <div>
                <h2 class="text-xl font-semibold text-slate-950">Aktivitas Per Periode (6 Bulan Terakhir)</h2>
                <p class="mt-1 text-sm text-slate-500">Perkembangan pengguna baru, sesi mentorship, dan pendaftaran pelatihan per bulan.</p>
            </div>
            <div class="flex items-center gap-4 text-xs">
                <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm" style="background:#06d8ee"></span> Pengguna Baru</span>
                <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm" style="background:#0F172A"></span> Sesi Mentorship</span>
                <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm" style="background:#94a3b8"></span> Pendaftaran Pelatihan</span>
            </div>
        </div>

        @php
            $maxValue = 1;
            foreach ($monthly as $m) {
                $maxValue = max($maxValue, $m['users'], $m['bookings'], $m['enrollments']);
            }
            $totalActivity = array_sum(array_column($monthly, 'users'))
                + array_sum(array_column($monthly, 'bookings'))
                + array_sum(array_column($monthly, 'enrollments'));
        @endphp

        <div class="grid grid-cols-6 gap-4 items-end" style="height: 220px;">
            @foreach ($monthly as $m)
                @php
                    $usersHeight = $m['users'] > 0 ? max(4, ($m['users'] / $maxValue) * 180) : 2;
                    $bookingsHeight = $m['bookings'] > 0 ? max(4, ($m['bookings'] / $maxValue) * 180) : 2;
                    $enrollHeight = $m['enrollments'] > 0 ? max(4, ($m['enrollments'] / $maxValue) * 180) : 2;
                    $monthTotal = $m['users'] + $m['bookings'] + $m['enrollments'];
                @endphp
                <div class="flex flex-col items-center gap-1 group">
                    <div class="flex items-end gap-1 w-full justify-center relative" style="height: 180px;">
                        {{-- Tooltip on hover --}}
                        <div class="absolute -top-12 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-xs rounded-xl px-2.5 py-1.5 whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none z-10 shadow-lg">
                            Total: {{ $monthTotal }}
                        </div>
                        <div class="rounded-t flex-1 transition-all duration-300 hover:opacity-80" style="background:#06d8ee; height: {{ $usersHeight }}px;" title="Pengguna baru: {{ $m['users'] }}"></div>
                        <div class="rounded-t flex-1 transition-all duration-300 hover:opacity-80" style="background:#0F172A; height: {{ $bookingsHeight }}px;" title="Sesi mentorship: {{ $m['bookings'] }}"></div>
                        <div class="rounded-t flex-1 transition-all duration-300 hover:opacity-80" style="background:#94a3b8; height: {{ $enrollHeight }}px;" title="Pelatihan: {{ $m['enrollments'] }}"></div>
                    </div>
                    <p class="text-xs font-medium text-slate-600 mt-2">{{ $m['label'] }}</p>
                </div>
            @endforeach
        </div>

        @if ($totalActivity === 0)
            <div class="mt-4 rounded-2xl bg-slate-50 border border-dashed border-slate-300 p-5 text-center text-sm text-slate-500">
                Belum ada aktivitas tercatat dalam 6 bulan terakhir.
            </div>
        @endif
    </div>

    {{-- Activity table + breakdown side by side --}}
    <div class="grid gap-6 lg:grid-cols-2">
        {{-- Tabel aktivitas --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-slate-950 mb-1">Tabel Aktivitas Per Periode</h2>
            <p class="text-sm text-slate-500 mb-5">Rincian numerik dari grafik di atas.</p>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 border-b border-slate-200">
                            <th class="py-3 pr-4">Periode</th>
                            <th class="py-3 pr-4 text-center">Pengguna</th>
                            <th class="py-3 pr-4 text-center">Mentorship</th>
                            <th class="py-3 pr-4 text-center">Pelatihan</th>
                            <th class="py-3 pr-4 text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($monthly as $m)
                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                                <td class="py-3 pr-4 font-medium text-slate-900">{{ $m['label'] }}</td>
                                <td class="py-3 pr-4 text-center text-slate-700">{{ $m['users'] }}</td>
                                <td class="py-3 pr-4 text-center text-slate-700">{{ $m['bookings'] }}</td>
                                <td class="py-3 pr-4 text-center text-slate-700">{{ $m['enrollments'] }}</td>
                                <td class="py-3 pr-4 text-center font-semibold text-slate-900">{{ $m['users'] + $m['bookings'] + $m['enrollments'] }}</td>
                            </tr>
                        @endforeach
                        <tr class="bg-slate-50">
                            <td class="py-3 pr-4 font-semibold text-slate-700">Total</td>
                            <td class="py-3 pr-4 text-center font-semibold text-slate-900">{{ array_sum(array_column($monthly, 'users')) }}</td>
                            <td class="py-3 pr-4 text-center font-semibold text-slate-900">{{ array_sum(array_column($monthly, 'bookings')) }}</td>
                            <td class="py-3 pr-4 text-center font-semibold text-slate-900">{{ array_sum(array_column($monthly, 'enrollments')) }}</td>
                            <td class="py-3 pr-4 text-center font-semibold text-cyan-600">{{ $totalActivity }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Distributions --}}
        <div class="space-y-6">
            {{-- Mentorship breakdown --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-950 mb-4">Status Sesi Mentorship</h3>
                @php
                    $statusLabels = [
                        'pending'   => ['Menunggu',      '#fbbf24'],
                        'confirmed' => ['Dikonfirmasi',  '#06d8ee'],
                        'completed' => ['Selesai',       '#10b981'],
                        'cancelled' => ['Dibatalkan',    '#ef4444'],
                    ];
                    $totalBooking = max(1, $summary['total_bookings']);
                @endphp
                <div class="space-y-3">
                    @foreach ($statusLabels as $status => $info)
                        @php $count = $summary['bookings_by_status'][$status]; $pct = ($count / $totalBooking) * 100; @endphp
                        <div>
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="font-medium text-slate-700">{{ $info[0] }}</span>
                                <span class="text-slate-500">{{ $count }} ({{ round($pct, 1) }}%)</span>
                            </div>
                            <div class="h-2 rounded-full bg-slate-100">
                                <div class="h-2 rounded-full transition-all" style="background: {{ $info[1] }}; width: {{ $pct }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- User roles --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-950 mb-4">Distribusi Role Pengguna</h3>
                @php
                    $roleLabels = [
                        'jobseeker' => ['Pencari Kerja', '#06d8ee'],
                        'mentor'    => ['Mentor',        '#7c3aed'],
                        'admin'     => ['Admin',         '#0F172A'],
                    ];
                    $totalUsersDisplay = max(1, $summary['total_users']);
                @endphp
                <div class="space-y-3">
                    @foreach ($roleLabels as $role => $info)
                        @php $count = $summary['users_by_role'][$role]; $pct = ($count / $totalUsersDisplay) * 100; @endphp
                        <div>
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="font-medium text-slate-700">{{ $info[0] }}</span>
                                <span class="text-slate-500">{{ $count }} ({{ round($pct, 1) }}%)</span>
                            </div>
                            <div class="h-2 rounded-full bg-slate-100">
                                <div class="h-2 rounded-full transition-all" style="background: {{ $info[1] }}; width: {{ $pct }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Recent users table --}}
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between flex-wrap gap-3 mb-5">
            <div>
                <h2 class="text-xl font-semibold text-slate-950">Pengguna Terbaru</h2>
                <p class="mt-1 text-sm text-slate-500">10 pengguna yang baru-baru ini bergabung di platform.</p>
            </div>
            <a href="/admin/users" class="inline-flex items-center gap-1.5 rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                Lihat semua pengguna →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 border-b border-slate-200">
                        <th class="py-3 pr-4">Nama</th>
                        <th class="py-3 pr-4">Email</th>
                        <th class="py-3 pr-4">Role</th>
                        <th class="py-3 pr-4">Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentUsers as $u)
                        @php
                            $roleColor = match($u->role) {
                                'mentor' => 'bg-purple-100 text-purple-700',
                                'admin'  => 'bg-slate-900 text-white',
                                default  => 'bg-cyan-100 text-cyan-700',
                            };
                            $initial = strtoupper(substr($u->name ?? 'U', 0, 1));
                        @endphp
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                            <td class="py-3 pr-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-2xl bg-[#0F172A] text-white grid place-items-center text-sm font-semibold flex-shrink-0">{{ $initial }}</div>
                                    <span class="font-medium text-slate-900">{{ $u->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 pr-4 text-slate-600">{{ $u->email }}</td>
                            <td class="py-3 pr-4">
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $roleColor }}">
                                    {{ ucfirst($u->role) }}
                                </span>
                            </td>
                            <td class="py-3 pr-4 text-slate-600">{{ $u->created_at?->format('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-sm text-slate-500">Belum ada pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
