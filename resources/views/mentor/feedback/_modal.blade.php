<div id="feedbackModal" class="fixed inset-0 bg-black bg-opacity-40 hidden z-50 overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center px-4">
        <div class="w-full max-w-3xl bg-white rounded-xl shadow-lg overflow-auto max-h-[90vh]">
            <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold">Buat Feedback Baru</h2>
                <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700">✕</button>
            </div>

            <form method="POST" action="{{ route('mentor.feedback.store') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pilih Mentee</label>
                        <select name="mentee_id" required class="mt-1 block w-full rounded-lg border border-gray-200 px-3 py-2">
                            <option value="">Pilih Mentee</option>
                            @foreach($mentees as $m)
                                <option value="{{ $m->id }}">{{ $m->name }} — {{ $m->email }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Topik Sesi</label>
                        <select name="session_id" required class="mt-1 block w-full rounded-lg border border-gray-200 px-3 py-2">
                            <option value="">Pilih Topik</option>
                            @foreach($sessions as $s)
                                <option value="{{ $s->id }}">{{ $s->topic }} — {{ $s->date }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Rating Sesi</label>
                    <div class="mt-2 flex items-center gap-2">
                        <input type="hidden" name="rating" value="5">
                        <div class="flex items-center">
                            @for($i=1;$i<=5;$i++)
                                <button type="button" class="star focus:outline-none" data-value="{{ $i }}">
                                    <svg class="h-8 w-8 text-teal-400" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.39 2.462a1 1 0 00-.364 1.118l1.287 3.97c.3.921-.755 1.688-1.54 1.118l-3.39-2.462a1 1 0 00-1.175 0L5.11 17.005c-.784.57-1.84-.197-1.54-1.118l1.287-3.97a1 1 0 00-.364-1.118L1.10 8.337c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.97z"/></svg>
                                </button>
                            @endfor
                        </div>
                        <div class="text-sm text-gray-500 ml-3" id="ratingLabel">5 dari 5 bintang</div>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Kekuatan (Strengths)</label>
                    <textarea name="strength" required rows="3" class="mt-1 block w-full rounded-lg border border-gray-200 px-3 py-2" placeholder="Tuliskan hal-hal positif yang ditunjukkan mentee..."></textarea>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Area Perbaikan (Improvements)</label>
                    <textarea name="improvement" required rows="3" class="mt-1 block w-full rounded-lg border border-gray-200 px-3 py-2" placeholder="Tuliskan area yang perlu ditingkatkan..."></textarea>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Rekomendasi</label>
                    <textarea name="recommendation" required rows="3" class="mt-1 block w-full rounded-lg border border-gray-200 px-3 py-2" placeholder="Berikan saran untuk pengembangan selanjutnya..."></textarea>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" id="modalCancelBtn" class="px-4 py-2 rounded-lg border">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-lg bg-slate-900 text-white">Kirim Feedback</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
