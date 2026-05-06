<article class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition transform hover:-translate-y-0.5">
    <div class="flex items-start gap-4">
        {{-- Avatar --}}
        <div class="flex-shrink-0">
            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 text-white flex items-center justify-center font-semibold text-lg">
                {{ strtoupper(substr($fb->mentee->name ?? 'U', 0, 1)) }}
            </div>
        </div>

        <div class="flex-1 min-w-0">
            {{-- Header row --}}
            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div>
                    <div class="text-lg font-semibold text-gray-900">{{ $fb->mentee->name ?? 'Unknown' }}</div>
                    <div class="text-sm text-gray-400">{{ $fb->session->topic ?? '-' }}</div>
                </div>

                {{-- Rating Mentee --}}
                <div class="flex flex-col items-end gap-1 shrink-0">
                    <div class="flex items-center gap-1">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="h-5 w-5 {{ $i <= ($fb->mentee_rating ?? 0) ? 'text-amber-400' : 'text-gray-200' }}"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.39 2.462a1 1 0 00-.364 1.118l1.287 3.97c.3.921-.755 1.688-1.54 1.118l-3.39-2.462a1 1 0 00-1.175 0L5.11 17.005c-.784.57-1.84-.197-1.54-1.118l1.287-3.97a1 1 0 00-.364-1.118L1.104 8.397c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.97z"/>
                            </svg>
                        @endfor
                    </div>
                    <div class="text-xs text-gray-400">{{ $fb->created_at->format('d M Y') }}</div>
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
                    1 => 'bg-red-100 text-red-700 border-red-200',
                    2 => 'bg-orange-100 text-orange-700 border-orange-200',
                    3 => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                    4 => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                    5 => 'bg-amber-100 text-amber-700 border-amber-200',
                ];
            @endphp
            <div class="mt-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $badgeColors[$fb->mentee_rating] ?? 'bg-gray-100 text-gray-600 border-gray-200' }}">
                    🏅 Performa Mentee: {{ $menteeRatingLabels[$fb->mentee_rating] ?? '-' }}
                    <span class="font-bold">({{ $fb->mentee_rating }}/5)</span>
                </span>
            </div>
            @endif

            {{-- Content blocks --}}
            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="font-semibold text-xs text-green-700 flex items-center gap-1 mb-2">
                        <span>✅</span> Kekuatan
                    </div>
                    <div class="text-sm text-green-800 leading-relaxed">{{ $fb->strength }}</div>
                </div>
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="font-semibold text-xs text-yellow-700 flex items-center gap-1 mb-2">
                        <span>🔧</span> Area Perbaikan
                    </div>
                    <div class="text-sm text-yellow-800 leading-relaxed">{{ $fb->improvement }}</div>
                </div>
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="font-semibold text-xs text-blue-700 flex items-center gap-1 mb-2">
                        <span>💡</span> Rekomendasi
                    </div>
                    <div class="text-sm text-blue-800 leading-relaxed">{{ $fb->recommendation }}</div>
                </div>
            </div>
        </div>
    </div>
</article>
