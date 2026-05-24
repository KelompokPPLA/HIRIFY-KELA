@extends('layouts.app')

@section('title', 'Career Streak')

@section('content')
<div class="space-y-8">

    {{-- ═══════════════════════════════════════════════════════
         HERO: Streak Counter Utama
    ═══════════════════════════════════════════════════════ --}}
    <section class="relative overflow-hidden rounded-[1.5rem] p-7 lg:p-10 text-white shadow-[0_30px_70px_rgba(15,23,42,0.20)]"
             style="background: linear-gradient(135deg, #0b1021 0%, #10182d 42%, #1a0f2e 100%);">

        {{-- Dot-grid background --}}
        <div class="absolute inset-0 opacity-30 pointer-events-none"
             style="background-image: radial-gradient(rgba(255,255,255,0.08) 1px, transparent 1px); background-size: 22px 22px;"></div>

        {{-- Glow orb --}}
        <div class="absolute -top-20 -right-20 w-72 h-72 rounded-full pointer-events-none"
             style="background: radial-gradient(circle, rgba(251,146,60,0.25) 0%, transparent 70%);"></div>

        <div class="relative z-10 grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
            {{-- Left: Streak info --}}
            <div class="space-y-6">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-orange-300/80 font-semibold">Career Streak Harian</p>
                    <h1 class="mt-2 text-2xl lg:text-3xl font-bold text-white">
                        @if($isActiveToday)
                            Streak Aktif Hari Ini!
                        @elseif($isStreakAlive)
                            Jangan Putus Hari Ini!
                        @else
                            Mulai Streak Barumu!
                        @endif
                    </h1>
                    <p class="mt-2 text-sm text-slate-300 max-w-lg">
                        Konsistensi adalah kunci. Lakukan minimal 1 aktivitas setiap hari untuk menjaga streakmu tetap menyala.
                    </p>
                </div>

                {{-- Stats row --}}
                <div class="grid grid-cols-3 gap-4">
                    <div class="rounded-2xl bg-white/[0.07] backdrop-blur-sm p-4 border border-white/10">
                        <p class="text-xs text-slate-400 font-medium">Streak Saat Ini</p>
                        <p class="mt-1.5 text-3xl font-extrabold text-orange-400 leading-none">
                            {{ $streak->current_streak }}
                        </p>
                        <p class="mt-1 text-[11px] text-slate-500">hari</p>
                    </div>
                    <div class="rounded-2xl bg-white/[0.07] backdrop-blur-sm p-4 border border-white/10">
                        <p class="text-xs text-slate-400 font-medium">Streak Terpanjang</p>
                        <p class="mt-1.5 text-3xl font-extrabold text-cyan-400 leading-none">
                            {{ $streak->longest_streak }}
                        </p>
                        <p class="mt-1 text-[11px] text-slate-500">hari</p>
                    </div>
                    <div class="rounded-2xl bg-white/[0.07] backdrop-blur-sm p-4 border border-white/10">
                        <p class="text-xs text-slate-400 font-medium">Total Hari Aktif</p>
                        <p class="mt-1.5 text-3xl font-extrabold text-purple-400 leading-none">
                            {{ $streak->total_activity_days }}
                        </p>
                        <p class="mt-1 text-[11px] text-slate-500">hari</p>
                    </div>
                </div>

                {{-- Progress menuju badge berikutnya --}}
                @if($nextBadge)
                <div class="rounded-2xl bg-white/[0.06] border border-white/10 p-4">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">{{ $nextBadge->icon }}</span>
                            <div>
                                <p class="text-xs font-semibold text-white">Menuju: {{ $nextBadge->name }}</p>
                                <p class="text-[11px] text-slate-400">{{ $streak->current_streak }}/{{ $nextBadge->milestone_days }} hari</p>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-orange-400">{{ $nextBadgeProgress }}%</span>
                    </div>
                    <div class="h-2 rounded-full bg-white/10 overflow-hidden">
                        <div class="h-2 rounded-full transition-all duration-700"
                             style="background: linear-gradient(90deg, #f97316, #fbbf24); width: {{ $nextBadgeProgress }}%;"></div>
                    </div>
                </div>
                @else
                <div class="rounded-2xl bg-white/[0.06] border border-white/10 p-4">
                    <p class="text-sm font-semibold text-yellow-400">Semua badge telah diperoleh! Kamu luar biasa!</p>
                </div>
                @endif
            </div>

            {{-- Right: Flame visual --}}
            <div class="hidden lg:flex flex-col items-center gap-3">
                <div class="relative flex items-center justify-center">
                    <div class="w-36 h-36 rounded-full flex items-center justify-center text-7xl"
                         style="background: radial-gradient(circle, rgba(251,146,60,0.25) 0%, rgba(249,115,22,0.08) 60%, transparent 100%);
                                box-shadow: 0 0 60px rgba(251,146,60,0.3), 0 0 30px rgba(249,115,22,0.2);">
                        @if($streak->current_streak > 0)
                            🔥
                        @else
                            💤
                        @endif
                    </div>
                    @if($isActiveToday)
                    <span class="absolute -top-2 -right-2 bg-green-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-lg">
                        AKTIF
                    </span>
                    @endif
                </div>
                <p class="text-xs text-slate-400 text-center">
                    {{ $streak->last_activity_date ? 'Terakhir aktif: ' . $streak->last_activity_date->translatedFormat('d M Y') : 'Belum pernah aktif' }}
                </p>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════
         KALENDER HEATMAP 30 HARI TERAKHIR
    ═══════════════════════════════════════════════════════ --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Kalender Aktivitas</h2>
                <p class="mt-0.5 text-sm text-slate-500">30 hari terakhir aktivitasmu</p>
            </div>
            <div class="flex items-center gap-2 text-xs text-slate-500">
                <span>Tidak aktif</span>
                <div class="flex gap-1">
                    @foreach([0, 1, 2, 3] as $level)
                    <div class="w-4 h-4 rounded-sm"
                         style="background-color: {{ ['#f1f5f9','#bbf7d0','#4ade80','#16a34a'][$level] }};"></div>
                    @endforeach
                </div>
                <span>Sangat aktif</span>
            </div>
        </div>

        <div class="grid gap-1.5" style="grid-template-columns: repeat(30, minmax(0, 1fr));">
            @foreach($heatmapData as $date => $count)
            @php
                $bg = match(true) {
                    $count >= 5 => '#16a34a',
                    $count >= 3 => '#4ade80',
                    $count >= 1 => '#bbf7d0',
                    default     => '#f1f5f9',
                };
                $textColor = $count >= 3 ? '#ffffff' : '#64748b';
                $isToday   = $date === now()->toDateString();
            @endphp
            <div class="aspect-square rounded-sm flex items-center justify-center text-[9px] font-bold relative group cursor-default
                        {{ $isToday ? 'ring-2 ring-orange-400 ring-offset-1' : '' }}"
                 style="background-color: {{ $bg }}; color: {{ $textColor }};"
                 title="{{ \Carbon\Carbon::parse($date)->translatedFormat('D, d M') }}: {{ $count }} aktivitas">
                {{-- Tooltip --}}
                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-slate-900 text-white text-[10px] rounded-lg
                            opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-10 shadow-lg">
                    {{ \Carbon\Carbon::parse($date)->translatedFormat('D, d M') }}: {{ $count }} aktivitas
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-3 flex gap-4 text-xs text-slate-400">
            <span>← {{ now()->subDays(29)->translatedFormat('d M') }}</span>
            <span class="flex-1 text-center">{{ now()->translatedFormat('MMMM Y') }}</span>
            <span>{{ now()->translatedFormat('d M') }} →</span>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         STATISTIK AKTIVITAS PER JENIS
    ═══════════════════════════════════════════════════════ --}}
    <div class="grid gap-4 sm:grid-cols-3">
        @php
            $activityTypes = [
                ['key' => 'training',   'label' => 'Pelatihan',      'icon' => '📚', 'color' => 'cyan'],
                ['key' => 'assessment', 'label' => 'Self Assessment', 'icon' => '✅', 'color' => 'pink'],
                ['key' => 'mentorship', 'label' => 'Mentorship',      'icon' => '🤝', 'color' => 'purple'],
            ];
            $colorMap = [
                'cyan'   => 'bg-cyan-50 text-cyan-700 border-cyan-100',
                'pink'   => 'bg-pink-50 text-pink-700 border-pink-100',
                'purple' => 'bg-purple-50 text-purple-700 border-purple-100',
            ];
        @endphp

        @foreach($activityTypes as $atype)
        @php
            $stat = $activityStats->get($atype['key']);
            $colors = $colorMap[$atype['color']];
        @endphp
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl {{ $colors }} border">
                    {{ $atype['icon'] }}
                </div>
                <p class="font-semibold text-slate-700 text-sm">{{ $atype['label'] }}</p>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <p class="text-2xl font-extrabold text-slate-900">{{ $stat?->active_days ?? 0 }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">hari aktif</p>
                </div>
                <div>
                    <p class="text-2xl font-extrabold text-slate-900">{{ $stat?->total_count ?? 0 }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">total aktivitas</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ═══════════════════════════════════════════════════════
         BADGE / PENCAPAIAN
    ═══════════════════════════════════════════════════════ --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Badge Pencapaian</h2>
                <p class="mt-0.5 text-sm text-slate-500">
                    {{ count($earnedBadgeIds) }}/{{ $allBadges->count() }} badge diperoleh
                </p>
            </div>
            @if(count($earnedBadgeIds) > 0)
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700">
                🏅 {{ count($earnedBadgeIds) }} Badge
            </span>
            @endif
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($allBadges as $badge)
            @php
                $isEarned = in_array($badge->id, $earnedBadgeIds);
                $earnedAt = null;
                if ($isEarned) {
                    $earned = $earnedBadges->firstWhere('streak_badge_id', $badge->id);
                    $earnedAt = $earned?->earned_at;
                }
                $colorStyles = match($badge->color) {
                    'green'  => ['bg' => '#dcfce7', 'border' => '#86efac', 'text' => '#15803d'],
                    'orange' => ['bg' => '#ffedd5', 'border' => '#fdba74', 'text' => '#c2410c'],
                    'yellow' => ['bg' => '#fef9c3', 'border' => '#fde047', 'text' => '#a16207'],
                    'amber'  => ['bg' => '#fef3c7', 'border' => '#fcd34d', 'text' => '#b45309'],
                    'blue'   => ['bg' => '#dbeafe', 'border' => '#93c5fd', 'text' => '#1d4ed8'],
                    'purple' => ['bg' => '#f3e8ff', 'border' => '#c084fc', 'text' => '#7e22ce'],
                    default  => ['bg' => '#f1f5f9', 'border' => '#e2e8f0', 'text' => '#64748b'],
                };
            @endphp

            <div class="group relative flex flex-col items-center gap-2 rounded-2xl border-2 p-4 text-center transition-all duration-200
                        {{ $isEarned ? 'shadow-sm hover:shadow-md hover:-translate-y-0.5' : 'opacity-50 grayscale' }}"
                 style="border-color: {{ $isEarned ? $colorStyles['border'] : '#e2e8f0' }};
                        background-color: {{ $isEarned ? $colorStyles['bg'] : '#f8fafc' }};">

                {{-- Icon --}}
                <div class="text-4xl leading-none">{{ $badge->icon }}</div>

                {{-- Info --}}
                <div>
                    <p class="text-xs font-bold leading-tight" style="color: {{ $isEarned ? $colorStyles['text'] : '#94a3b8' }};">
                        {{ $badge->name }}
                    </p>
                    <p class="mt-1 text-[10px] text-slate-500">{{ $badge->milestone_days }} hari</p>
                </div>

                {{-- Status badge --}}
                @if($isEarned)
                <span class="absolute -top-2 -right-2 w-5 h-5 rounded-full bg-green-500 flex items-center justify-center text-white text-[9px] font-bold shadow">✓</span>
                @else
                <span class="absolute -top-2 -right-2 w-5 h-5 rounded-full bg-slate-300 flex items-center justify-center text-white text-[9px] shadow">🔒</span>
                @endif

                {{-- Tooltip earned date --}}
                @if($isEarned && $earnedAt)
                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1.5 bg-slate-900 text-white text-[10px] rounded-lg
                            opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-10 shadow-lg text-left">
                    <p class="font-semibold">{{ $badge->description }}</p>
                    <p class="text-slate-400 mt-0.5">Diperoleh: {{ $earnedAt->translatedFormat('d M Y') }}</p>
                </div>
                @else
                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1.5 bg-slate-900 text-white text-[10px] rounded-lg
                            opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-10 shadow-lg">
                    <p>Perlu {{ $badge->milestone_days }} hari streak</p>
                    <p class="text-slate-400">Masih {{ max(0, $badge->milestone_days - $streak->current_streak) }} hari lagi</p>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         AKTIVITAS TERBARU
    ═══════════════════════════════════════════════════════ --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Aktivitas Terbaru</h2>
                <p class="mt-0.5 text-sm text-slate-500">10 aktivitas terakhir yang tercatat</p>
            </div>
            <a href="{{ route('streak.history') }}"
               class="inline-flex items-center gap-1.5 text-sm font-semibold text-cyan-600 hover:text-cyan-700 transition">
                Lihat semua
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>

        <div class="space-y-2">
            @forelse($recentActivities as $activity)
            @php
                $typeColors = [
                    'training'   => ['bg' => 'bg-cyan-50',   'text' => 'text-cyan-600',   'border' => 'border-cyan-100'],
                    'assessment' => ['bg' => 'bg-pink-50',   'text' => 'text-pink-600',   'border' => 'border-pink-100'],
                    'mentorship' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'border' => 'border-purple-100'],
                ];
                $palette  = $typeColors[$activity->activity_type] ?? $typeColors['training'];
                $typeIcon = ['training' => '📚', 'assessment' => '✅', 'mentorship' => '🤝'][$activity->activity_type] ?? '⚡';
                $typeLabel = ['training' => 'Pelatihan', 'assessment' => 'Self Assessment', 'mentorship' => 'Mentorship'][$activity->activity_type] ?? '-';
            @endphp
            <div class="flex items-center gap-3 rounded-xl border p-3.5 hover:bg-slate-50/70 transition {{ $palette['border'] }}">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-lg {{ $palette['bg'] }} flex-shrink-0">
                    {{ $typeIcon }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate">{{ $activity->description ?? $typeLabel }}</p>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="text-[10px] font-medium px-1.5 py-0.5 rounded {{ $palette['bg'] }} {{ $palette['text'] }}">{{ $typeLabel }}</span>
                        <span class="text-xs text-slate-400">{{ $activity->activity_date->translatedFormat('D, d M Y') }}</span>
                    </div>
                </div>
                <div class="flex-shrink-0 text-xs text-slate-400">
                    {{ $activity->created_at->diffForHumans() }}
                </div>
            </div>
            @empty
            <div class="rounded-2xl bg-slate-50 border border-dashed border-slate-200 p-10 text-center">
                <div class="text-4xl mb-3">🚀</div>
                <p class="text-sm font-semibold text-slate-700 mb-1">Belum ada aktivitas tercatat</p>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">Selesaikan pelatihan, self assessment, atau booking mentorship untuk memulai streak pertamamu!</p>
                <a href="/skill-training"
                   class="inline-block mt-4 px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-md hover:shadow-lg transition"
                   style="background: linear-gradient(135deg, #0399b7, #06d8ee);">
                    Mulai Pelatihan
                </a>
            </div>
            @endforelse
        </div>
    </div>

</div>

@push('scripts')
<script>
    // Animasi counter streak masuk
    document.addEventListener('DOMContentLoaded', function () {
        const counters = document.querySelectorAll('[data-count]');
        counters.forEach(counter => {
            const target = parseInt(counter.dataset.count, 10);
            let current  = 0;
            const step   = Math.max(1, Math.ceil(target / 30));
            const timer  = setInterval(() => {
                current = Math.min(current + step, target);
                counter.textContent = current;
                if (current >= target) clearInterval(timer);
            }, 40);
        });
    });
</script>
@endpush
@endsection
