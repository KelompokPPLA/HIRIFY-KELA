<div id="feedbackModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center px-4 py-8">
        <div class="w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-7 py-5 border-b border-gray-100 bg-gradient-to-r from-slate-900 to-slate-700">
                <div>
                    <h2 id="modalTitle" class="text-lg font-extrabold text-white tracking-tight">Buat Feedback Baru</h2>
                    <p id="modalSubtitle" class="text-xs text-slate-400 mt-0.5 font-medium">Evaluasi dan beri penilaian untuk mentee Anda</p>
                </div>
                <button id="closeModalBtn" class="w-8 h-8 flex items-center justify-center rounded-full text-slate-400 hover:text-white hover:bg-white/10 transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="feedbackForm" method="POST" action="{{ route('mentor.feedback.store') }}" class="px-7 py-6 space-y-5 overflow-y-auto max-h-[82vh]">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                {{-- Row: Pilih Mentee & Topik Sesi --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Pilih Mentee</label>
                        <select name="mentee_id" id="mentee_id" required
                            class="w-full rounded-xl border border-slate-200/80 px-3.5 py-3 text-sm font-semibold text-slate-700 outline-none focus:ring-4 focus:ring-cyan-500/10 focus:border-[#00bee4] transition bg-white shadow-sm">
                            <option value="">— Pilih Mentee —</option>
                            @foreach($mentees as $m)
                                <option value="{{ $m->id }}">{{ $m->name }} — {{ $m->email }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Topik Sesi</label>
                        <select name="session_id" id="session_id" required
                            class="w-full rounded-xl border border-slate-200/80 px-3.5 py-3 text-sm font-semibold text-slate-700 outline-none focus:ring-4 focus:ring-cyan-500/10 focus:border-[#00bee4] transition bg-white shadow-sm">
                            <option value="">— Pilih Sesi —</option>
                            @foreach($sessions as $s)
                                <option value="{{ $s->id }}" data-mentees="{{ json_encode($s->bookings->pluck('jobseeker_user_id')->toArray()) }}">
                                    {{ $s->topic }} — {{ \Carbon\Carbon::parse($s->date)->locale('id')->translatedFormat('d M Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Divider --}}
                <div class="border-t border-slate-100"></div>

                {{-- Rating Performa Mentee --}}
                <div class="p-5 rounded-2xl bg-cyan-50/50 border border-cyan-100/50">
                    <label class="block text-sm font-extrabold text-cyan-800 mb-1">
                        🏅 Rating Performa Mentee
                    </label>
                    <p class="text-xs text-cyan-600/80 font-medium mb-4">Berikan penilaian terhadap keterlibatan dan performa mentee selama sesi berlangsung.</p>

                    <input type="hidden" id="mentee_rating_val" name="mentee_rating" value="5">

                    <div class="flex items-center gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button"
                                class="star-mentee focus:outline-none transition-transform hover:scale-125 active:scale-110 cursor-pointer"
                                data-value="{{ $i }}"
                                title="{{ $i }} bintang">
                                <svg class="h-10 w-10 text-[#00bee4] drop-shadow-sm transition-colors duration-150" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.39 2.462a1 1 0 00-.364 1.118l1.287 3.97c.3.921-.755 1.688-1.54 1.118l-3.39-2.462a1 1 0 00-1.175 0L5.11 17.005c-.784.57-1.84-.197-1.54-1.118l1.287-3.97a1 1 0 00-.364-1.118L1.104 8.397c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.97z"/>
                                </svg>
                            </button>
                        @endfor

                        <span class="ml-3 text-xs font-extrabold text-cyan-700 bg-cyan-100 px-3 py-1 rounded-full uppercase tracking-wider" id="menteeRatingLabel">
                            5 — Sangat Berprestasi
                        </span>
                    </div>
                </div>

                {{-- Divider --}}
                <div class="border-t border-slate-100"></div>

                {{-- Performa --}}
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                        ✅ Performa
                    </label>
                    <textarea name="strength" id="strength" required rows="3"
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 outline-none focus:ring-4 focus:ring-cyan-500/10 focus:border-[#00bee4] transition resize-none placeholder-slate-400 bg-white"
                        placeholder="Tuliskan ulasan performa positif yang ditunjukkan mentee selama sesi..."></textarea>
                </div>

                {{-- Area Perbaikan --}}
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                        🔧 Area Perbaikan
                    </label>
                    <textarea name="improvement" id="improvement" required rows="3"
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 outline-none focus:ring-4 focus:ring-cyan-500/10 focus:border-[#00bee4] transition resize-none placeholder-slate-400 bg-white"
                        placeholder="Tuliskan area yang perlu ditingkatkan oleh mentee..."></textarea>
                </div>

                {{-- Rekomendasi --}}
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                        💡 Rekomendasi
                    </label>
                    <textarea name="recommendation" id="recommendation" required rows="3"
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 outline-none focus:ring-4 focus:ring-cyan-500/10 focus:border-[#00bee4] transition resize-none placeholder-slate-400 bg-white"
                        placeholder="Berikan saran konkret untuk pengembangan mentee selanjutnya..."></textarea>
                </div>

                {{-- Actions --}}
                <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                    <div>
                        <button type="button" id="deleteFeedbackBtn" class="hidden px-5 py-2.5 rounded-full border border-rose-200 text-sm font-extrabold text-rose-600 hover:bg-rose-50 hover:border-rose-300 transition duration-150 cursor-pointer">
                            Hapus Feedback
                        </button>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" id="modalCancelBtn"
                            class="px-5 py-2.5 rounded-full border border-slate-200 text-sm font-extrabold text-slate-500 hover:bg-slate-50 transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-[#00bee4] hover:bg-[#00a3c4] text-white text-sm font-extrabold hover:scale-[1.02] active:scale-[0.98] transition duration-200 shadow-md shadow-cyan-500/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Simpan Feedback
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Hidden form for DELETE --}}
<form id="deleteFeedbackForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal             = document.getElementById('feedbackModal');
    const openBtn           = document.getElementById('openModalBtn');
    const closeBtn          = document.getElementById('closeModalBtn');
    const cancelBtn         = document.getElementById('modalCancelBtn');
    const deleteBtn         = document.getElementById('deleteFeedbackBtn');
    const deleteForm        = document.getElementById('deleteFeedbackForm');

    const form              = document.getElementById('feedbackForm');
    const formMethod        = document.getElementById('formMethod');
    const modalTitle        = document.getElementById('modalTitle');
    const modalSubtitle     = document.getElementById('modalSubtitle');

    const menteeSelect      = document.getElementById('mentee_id');
    const sessionSelect     = document.getElementById('session_id');
    
    const strengthInput     = document.getElementById('strength');
    const improvementInput  = document.getElementById('improvement');
    const recommendationInput = document.getElementById('recommendation');

    // Star elements
    const stars             = Array.from(document.querySelectorAll('#feedbackModal .star-mentee'));
    const ratingInput       = document.getElementById('mentee_rating_val');
    const labelEl           = document.getElementById('menteeRatingLabel');
    let selectedRating      = 5;

    const menteeRatingLabels = {
        1: 'Perlu Banyak Perbaikan',
        2: 'Di Bawah Ekspektasi',
        3: 'Cukup Memuaskan',
        4: 'Berprestasi',
        5: 'Sangat Berprestasi',
    };

    // Session option filtering
    if (menteeSelect && sessionSelect) {
        const originalSessionOptions = Array.from(sessionSelect.options);
        
        const filterSessions = (selectedMenteeId) => {
            sessionSelect.innerHTML = '';
            originalSessionOptions.forEach(option => {
                if (option.value === '') {
                    sessionSelect.appendChild(option);
                    return;
                }
                
                try {
                    const mentees = JSON.parse(option.getAttribute('data-mentees') || '[]');
                    if (!selectedMenteeId || mentees.map(String).includes(String(selectedMenteeId))) {
                        sessionSelect.appendChild(option);
                    }
                } catch (e) {
                    sessionSelect.appendChild(option);
                }
            });
        };

        // Filter sessions on manual change
        menteeSelect.addEventListener('change', function () {
            filterSessions(menteeSelect.value);
            sessionSelect.value = '';
        });

        // ── Rating painting ──
        const paintStars = v => {
            stars.forEach(s => {
                const val = parseInt(s.dataset.value, 10);
                const svg = s.querySelector('svg');
                if (svg) {
                    svg.classList.toggle('text-[#00bee4]', val <= v);
                    svg.classList.toggle('text-slate-200',  val >  v);
                }
            });
            if (labelEl) labelEl.textContent = `${v} — ${menteeRatingLabels[v] ?? ''}`;
        };

        stars.forEach(s => {
            s.addEventListener('mouseover', () => paintStars(parseInt(s.dataset.value, 10)));
            s.addEventListener('mouseleave', () => paintStars(selectedRating));
            s.addEventListener('click', () => {
                selectedRating = parseInt(s.dataset.value, 10);
                if (ratingInput) ratingInput.value = selectedRating;
                paintStars(selectedRating);
            });
        });

        // ── Modal open / close helpers ──
        const closeModal = () => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        };

        const openCreateModal = () => {
            // Setup Create mode
            form.action = "{{ route('mentor.feedback.store') }}";
            formMethod.value = "POST";
            modalTitle.textContent = "Buat Feedback Baru";
            modalSubtitle.textContent = "Evaluasi dan beri penilaian untuk mentee Anda";
            
            // Reset inputs
            menteeSelect.value = "";
            filterSessions("");
            sessionSelect.value = "";
            
            strengthInput.value = "";
            improvementInput.value = "";
            recommendationInput.value = "";
            
            // Reset stars
            selectedRating = 5;
            ratingInput.value = 5;
            paintStars(5);
            
            // Hide delete button
            deleteBtn.classList.add('hidden');
            
            // Show modal
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        };

        const openEditModal = (data) => {
            // Setup Edit mode
            form.action = `/mentor/feedback/${data.id}`;
            formMethod.value = "PUT";
            modalTitle.textContent = "Edit Feedback";
            modalSubtitle.textContent = "Perbarui evaluasi dan penilaian untuk mentee Anda";
            
            // Set inputs
            menteeSelect.value = data.menteeId;
            filterSessions(data.menteeId);
            sessionSelect.value = data.sessionId;
            
            strengthInput.value = data.strength;
            improvementInput.value = data.improvement;
            recommendationInput.value = data.recommendation;
            
            // Set stars
            selectedRating = parseInt(data.rating, 10) || 5;
            ratingInput.value = selectedRating;
            paintStars(selectedRating);
            
            // Show delete button
            deleteBtn.classList.remove('hidden');
            deleteBtn.setAttribute('data-id', data.id);
            
            // Show modal
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        };

        // Attach listeners
        openBtn?.addEventListener('click', openCreateModal);
        closeBtn?.addEventListener('click', closeModal);
        cancelBtn?.addEventListener('click', closeModal);
        modal?.addEventListener('click', e => { if (e.target === modal) closeModal(); });
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

        // Event delegation for Edit buttons
        document.addEventListener('click', e => {
            const editBtn = e.target.closest('.editFeedbackBtn');
            if (editBtn) {
                const data = {
                    id: editBtn.getAttribute('data-id'),
                    menteeId: editBtn.getAttribute('data-mentee-id'),
                    sessionId: editBtn.getAttribute('data-session-id'),
                    rating: editBtn.getAttribute('data-rating'),
                    strength: editBtn.getAttribute('data-strength'),
                    improvement: editBtn.getAttribute('data-improvement'),
                    recommendation: editBtn.getAttribute('data-recommendation')
                };
                openEditModal(data);
            }
        });

        // Delete button listener
        deleteBtn?.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            if (!id) return;
            
            if (confirm('Apakah Anda yakin ingin menghapus feedback ini? Tindakan ini tidak dapat dibatalkan.')) {
                deleteForm.action = `/mentor/feedback/${id}`;
                deleteForm.submit();
            }
        });
    }
});
</script>
