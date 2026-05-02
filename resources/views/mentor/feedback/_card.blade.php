<article class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition transform hover:-translate-y-0.5">
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0">
            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-teal-400 to-sky-600 text-white flex items-center justify-center font-semibold text-lg">
                {{ strtoupper(substr($fb->mentee->name ?? 'U', 0, 1)) }}
            </div>
        </div>

        <div class="flex-1">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-lg font-semibold">{{ $fb->mentee->name ?? 'Unknown' }}</div>
                    <div class="text-sm text-gray-400">{{ $fb->session->topic ?? '-' }}</div>
                </div>

                <div class="text-right">
                    <div class="flex items-center gap-2">
                        <div class="text-teal-400 font-semibold">
                            @for($i=1;$i<=5;$i++)
                                @if($i <= $fb->rating)
                                    <!-- filled star -->
                                    <svg class="inline-block h-5 w-5" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.39 2.462a1 1 0 00-.364 1.118l1.287 3.97c.3.921-.755 1.688-1.54 1.118l-3.39-2.462a1 1 0 00-1.175 0L5.11 17.005c-.784.57-1.84-.197-1.54-1.118l1.287-3.97a1 1 0 00-.364-1.118L1.10 8.337c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.97z"/></svg>
                                @else
                                    <!-- outline star -->
                                    <svg class="inline-block h-5 w-5 text-gray-300" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.39 2.462a1 1 0 00-.364 1.118l1.287 3.97c.3.921-.755 1.688-1.54 1.118l-3.39-2.462a1 1 0 00-1.175 0L5.11 17.005c-.784.57-1.84-.197-1.54-1.118l1.287-3.97a1 1 0 00-.364-1.118L1.10 8.337c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.97z"/></svg>
                                @endif
                            @endfor
                        </div>
                    </div>
                    <div class="text-xs text-gray-300 mt-1">{{ $fb->created_at->format('Y-m-d') }}</div>
                </div>
            </div>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 bg-green-100 border border-green-200 rounded">
                    <div class="font-medium text-sm">✓ Kekuatan</div>
                    <div class="mt-2 text-sm text-green-800">{{ $fb->strength }}</div>
                </div>
                <div class="p-4 bg-yellow-100 border border-yellow-200 rounded">
                    <div class="font-medium text-sm">→ Area Perbaikan</div>
                    <div class="mt-2 text-sm text-yellow-800">{{ $fb->improvement }}</div>
                </div>
                <div class="p-4 bg-blue-100 border border-blue-200 rounded">
                    <div class="font-medium text-sm">💡 Rekomendasi</div>
                    <div class="mt-2 text-sm text-blue-800">{{ $fb->recommendation }}</div>
                </div>
            </div>
        </div>
    </div>
</article>
