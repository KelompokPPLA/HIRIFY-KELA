<div id="feedbackModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center px-4 py-8">
        <div class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-7 py-5 border-b border-gray-100 bg-gradient-to-r from-slate-900 to-slate-700">
                <div>
                    <h2 class="text-lg font-bold text-white">Buat Feedback Baru</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Evaluasi dan beri penilaian untuk mentee Anda</p>
                </div>
                <button id="closeModalBtn" class="w-8 h-8 flex items-center justify-center rounded-full text-slate-400 hover:text-white hover:bg-white/10 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('mentor.feedback.store') }}" class="px-7 py-6 space-y-5 overflow-y-auto max-h-[82vh]">
                @csrf

                {{-- Row: Pilih Mentee & Topik Sesi --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Pilih Mentee</label>
                        <select name="mentee_id" id="mentee_id" required
                            class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-200 focus:border-amber-400 transition">
                            <option value="">— Pilih Mentee —</option>
                            @foreach($mentees as $m)
                                <option value="{{ $m->id }}">{{ $m->name }} — {{ $m->email }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Topik Sesi</label>
                        <select name="session_id" id="session_id" required
                            class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-200 focus:border-amber-400 transition">
                            <option value="">— Pilih Sesi —</option>
                            @foreach($sessions as $s)
                                <option value="{{ $s->id }}">{{ $s->topic }} — {{ \Carbon\Carbon::parse($s->date)->format('d M Y') }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Divider --}}
                <div class="border-t border-gray-100"></div>

                {{-- Rating Performa Mentee --}}
                <div class="p-5 rounded-xl bg-amber-50 border border-amber-200">
                    <label class="block text-sm font-bold text-amber-800 mb-1">
                        🏅 Rating Performa Mentee
                    </label>
                    <p class="text-xs text-amber-600 mb-4">Berikan penilaian terhadap keterlibatan dan performa mentee selama sesi berlangsung.</p>

                    <input type="hidden" id="mentee_rating_val" name="mentee_rating" value="5">

                    <div class="flex items-center gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button"
                                class="star-mentee focus:outline-none transition-transform hover:scale-125 active:scale-110"
                                data-value="{{ $i }}"
                                title="{{ $i }} bintang">
                                <svg class="h-10 w-10 text-amber-400 drop-shadow-sm" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.39 2.462a1 1 0 00-.364 1.118l1.287 3.97c.3.921-.755 1.688-1.54 1.118l-3.39-2.462a1 1 0 00-1.175 0L5.11 17.005c-.784.57-1.84-.197-1.54-1.118l1.287-3.97a1 1 0 00-.364-1.118L1.104 8.397c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.97z"/>
                                </svg>
                            </button>
                        @endfor

                        <span class="ml-3 text-sm font-semibold text-amber-700 bg-amber-100 px-3 py-1 rounded-full" id="menteeRatingLabel">
                            5 — Sangat Berprestasi
                        </span>
                    </div>
                </div>

                {{-- Divider --}}
                <div class="border-t border-gray-100"></div>

                {{-- Kekuatan --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                        ✅ Kekuatan (Strengths)
                    </label>
                    <textarea name="strength" required rows="3"
                        class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-200 focus:border-amber-400 transition resize-none"
                        placeholder="Tuliskan hal-hal positif yang ditunjukkan mentee selama sesi..."></textarea>
                </div>

                {{-- Area Perbaikan --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                        🔧 Area Perbaikan (Improvements)
                    </label>
                    <textarea name="improvement" required rows="3"
                        class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-200 focus:border-amber-400 transition resize-none"
                        placeholder="Tuliskan area yang perlu ditingkatkan oleh mentee..."></textarea>
                </div>

                {{-- Rekomendasi --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                        💡 Rekomendasi
                    </label>
                    <textarea name="recommendation" required rows="3"
                        class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-200 focus:border-amber-400 transition resize-none"
                        placeholder="Berikan saran konkret untuk pengembangan mentee selanjutnya..."></textarea>
                </div>

                {{-- Actions --}}
                <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                    <button type="button" id="modalCancelBtn"
                        class="px-5 py-2.5 rounded-lg border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg bg-amber-500 text-white text-sm font-semibold hover:bg-amber-600 active:scale-95 transition shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Simpan Feedback
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
