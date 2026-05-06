<article class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.03)] p-6 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:-translate-y-0.5 transition duration-300 border border-slate-200">
    <div class="flex items-start gap-4">
        {{-- Avatar --}}
        <div class="flex-shrink-0">
            @php
                $colors = [
                    'from-[#00bee4] to-[#0ea5e9]',
                    'from-[#06b6d4] to-[#0891b2]',
                    'from-[#14b8a6] to-[#0f766e]',
                    'from-[#10b981] to-[#047857]',
                    'from-[#6366f1] to-[#4338ca]'
                ];
                $gradient = $colors[crc32($fb->mentee->name ?? 'User') % count($colors)];
            @endphp
            <div class="w-11 h-11 rounded-full bg-gradient-to-br {{ $gradient }} text-white flex items-center justify-center font-extrabold text-base shadow-sm select-none">
                {{ strtoupper(substr($fb->mentee->name ?? 'U', 0, 1)) }}
            </div>
        </div>

        <div class="flex-1 min-w-0">
            {{-- Header row --}}
            <div class="flex items-start justify-between gap-4 flex-wrap mb-4">
                <div>
                    <h3 class="text-base font-extrabold text-slate-800 tracking-tight leading-tight mb-0.5">{{ $fb->mentee->name ?? 'Unknown' }}</h3>
                    <p class="text-xs font-semibold text-slate-400 truncate">{{ $fb->session->topic ?? '-' }}</p>
                </div>

                {{-- Rating Mentee --}}
                <div class="flex flex-col items-end gap-1 shrink-0">
                    <div class="flex items-center gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="h-4 w-4 {{ $i <= ($fb->mentee_rating ?? 0) ? 'text-[#00bee4]' : 'text-slate-200' }}"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.39 2.462a1 1 0 00-.364 1.118l1.287 3.97c.3.921-.755 1.688-1.54 1.118l-3.39-2.462a1 1 0 00-1.175 0L5.11 17.005c-.784.57-1.84-.197-1.54-1.118l1.287-3.97a1 1 0 00-.364-1.118L1.104 8.397c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.97z"/>
                            </svg>
                        @endfor
                    </div>
                    <div class="text-[11px] font-bold text-slate-400">{{ $fb->created_at->format('Y-m-d') }}</div>
                </div>
            </div>

            {{-- Mentee rating badge --}}
            @if($fb->mentee_rating)
            @php
                $menteeRatingLabels = [
                    1 => 'Perlu Banyak Perbaikan',
                    2 => 'Di Bawah Ekspektasi',
                    3 => 'Cukup Memuaskan',
                    4 => 'Berprestasi',
                    5 => 'Sangat Berprestasi',
                ];
                $badgeColors = [
                    1 => 'bg-rose-50 text-rose-600 border-rose-100/50',
                    2 => 'bg-orange-50 text-orange-600 border-orange-100/50',
                    3 => 'bg-amber-50 text-amber-600 border-amber-100/50',
                    4 => 'bg-emerald-50 text-emerald-600 border-emerald-100/50',
                    5 => 'bg-cyan-50 text-cyan-600 border-cyan-100/50',
                ];
            @endphp
            <div class="mb-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold border uppercase tracking-wide {{ $badgeColors[$fb->mentee_rating] ?? 'bg-slate-50 text-slate-600 border-slate-100' }}">
                    🏅 Performa: {{ $menteeRatingLabels[$fb->mentee_rating] ?? '-' }}
                    <span class="font-black">({{ $fb->mentee_rating }}/5)</span>
                </span>
            </div>
            @endif

            {{-- Content blocks (stacked vertically with left-border differentiation) --}}
            <div class="space-y-4">
                <!-- Performa Section -->
                <div>
                    <div class="text-xs font-extrabold text-emerald-600 flex items-center gap-1.5 mb-1.5 uppercase tracking-wider">
                        <span class="text-emerald-500">✓</span> Performa
                    </div>
                    <div class="p-4 bg-emerald-50/30 border border-emerald-100/50 border-l-4 border-l-emerald-500 rounded-xl rounded-l-none text-sm font-semibold text-emerald-800 leading-relaxed shadow-sm shadow-emerald-500/5">
                        {{ $fb->strength }}
                    </div>
                </div>

                <!-- Area Perbaikan Section -->
                <div>
                    <div class="text-xs font-extrabold text-amber-600 flex items-center gap-1.5 mb-1.5 uppercase tracking-wider">
                        <span class="text-amber-500">—</span> Area Perbaikan
                    </div>
                    <div class="p-4 bg-amber-50/30 border border-amber-100/50 border-l-4 border-l-amber-500 rounded-xl rounded-l-none text-sm font-semibold text-amber-800 leading-relaxed shadow-sm shadow-amber-500/5">
                        {{ $fb->improvement }}
                    </div>
                </div>

                <!-- Rekomendasi Section -->
                <div>
                    <div class="text-xs font-extrabold text-sky-600 flex items-center gap-1.5 mb-1.5 uppercase tracking-wider">
                        <span class="text-sky-500">💡</span> Rekomendasi
                    </div>
                    <div class="p-4 bg-sky-50/30 border border-sky-100/50 border-l-4 border-l-sky-500 rounded-xl rounded-l-none text-sm font-semibold text-sky-800 leading-relaxed shadow-sm shadow-sky-500/5">
                        {{ $fb->recommendation }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>
