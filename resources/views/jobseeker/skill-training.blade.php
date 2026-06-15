@extends('layouts.app')

@section('title', 'Pelatihan Skill')

@section('content')
<div class="skill-training-page max-w-6xl mx-auto px-4 py-6">
    <!-- LIST VIEW -->
    <div id="listView" class="space-y-6">
        <!-- Page Header -->
        <div>
            <p class="text-xs uppercase tracking-[0.25em] text-sky-600 font-bold mb-2">Pelatihan Skill</p>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pelatihan Skill</h1>
            <p class="text-slate-500 mt-2">Tingkatkan kompetensimu dengan kursus terstruktur dari para praktisi industri.</p>
        </div>

        <!-- Tab Bar -->
        <div class="flex gap-2 bg-slate-100 p-1.5 rounded-2xl w-fit">
            <button class="tab-btn px-5 py-2.5 text-sm font-semibold rounded-xl bg-white text-slate-900 shadow-sm transition" data-tab="catalog" type="button">🔍 Katalog Kursus</button>
            <button class="tab-btn px-5 py-2.5 text-sm font-semibold rounded-xl text-slate-500 hover:bg-slate-100/60 transition" data-tab="my-courses" type="button">📖 Kursus Saya</button>
        </div>

        <!-- CATALOG TAB -->
        <div id="catalogTab" class="space-y-6">
            <!-- Filter Bar -->
            <div class="bg-white rounded-3xl border border-slate-200 p-4 shadow-sm flex flex-col md:flex-row gap-3">
                <div class="flex-1 relative">
                    <input id="searchInput" type="text" 
                           class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition text-sm text-slate-800"
                           placeholder="Cari kursus, topik, atau instruktur…">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </span>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <select id="categoryFilter" class="px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition text-sm text-slate-800 cursor-pointer min-w-[160px]">
                        <option value="">Semua Kategori</option>
                    </select>
                    <select id="levelFilter" class="px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition text-sm text-slate-800 cursor-pointer min-w-[160px]">
                        <option value="">Semua Level</option>
                        <option value="beginner">Pemula</option>
                        <option value="intermediate">Menengah</option>
                        <option value="advanced">Lanjutan</option>
                    </select>
                    <button id="searchBtn" class="bg-sky-600 text-white font-semibold rounded-xl px-6 py-3 text-sm hover:bg-sky-700 transition shadow-sm" type="button">Cari</button>
                </div>
            </div>

            <!-- Course Grid -->
            <div>
                <h2 class="text-xl font-bold text-slate-900 mb-6" id="catalogLabel">Semua Kursus</h2>
                <div id="courseGrid" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Loaded dynamically -->
                </div>
            </div>
        </div>

        <!-- MY COURSES TAB -->
        <div id="myCoursesTab" class="space-y-6 hidden">
            <div>
                <h2 class="text-xl font-bold text-slate-900 mb-6">Kursus Saya</h2>
                <div id="myCourseGrid" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Loaded dynamically -->
                </div>
            </div>
        </div>
    </div>

    <!-- DETAIL VIEW -->
    <div id="detailView" class="hidden space-y-6">
        <div class="flex items-center justify-between gap-4 flex-wrap">
            <button class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm" type="button" id="backBtn">
                ← Kembali ke Katalog
            </button>
            <button class="bg-sky-600 text-white font-bold rounded-xl px-5 py-2.5 text-xs hover:bg-sky-700 transition shadow-sm hidden" type="button" id="enrollBtn">
                ✅ Daftar Kursus Ini
            </button>
        </div>

        <!-- Hero Header -->
        <div class="bg-slate-900 text-slate-100 rounded-3xl p-6 md:p-8 shadow-sm flex flex-col gap-6" id="detailHero">
            <div class="flex items-start gap-4 md:gap-6">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-slate-800 text-4xl md:text-5xl flex items-center justify-center flex-shrink-0" id="detailEmoji">📚</div>
                <div class="min-w-0">
                    <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight" id="detailTitle">Memuat…</h2>
                    <div class="flex flex-wrap gap-2 items-center text-xs text-slate-400 mt-2 font-medium" id="detailMeta">
                        <!-- Meta info -->
                    </div>
                </div>
            </div>
            
            <div class="bg-slate-800/80 rounded-2xl p-4 md:p-5 flex flex-col gap-3 hidden" id="detailProgressRow">
                <div class="flex justify-between items-center text-sm font-bold">
                    <span>Progress Pembelajaran</span>
                    <span id="progressPct" class="text-sky-400">0%</span>
                </div>
                <div class="w-full bg-slate-700 h-2.5 rounded-full overflow-hidden">
                    <div class="bg-gradient-to-r from-sky-400 to-sky-600 h-full rounded-full transition-all duration-300" id="progressFill" style="width:0%"></div>
                </div>
                <div class="text-xs text-slate-400" id="progressDetail"></div>
                <a href="{{ route('certificates.index') }}" id="certBtn" class="hidden mt-1 inline-flex items-center gap-2 bg-sky-500 hover:bg-sky-600 text-white text-xs font-bold px-4 py-2 rounded-xl transition w-fit">
                    🏆 Unduh Sertifikat
                </a>
            </div>
        </div>

        <!-- Lessons List -->
        <div>
            <h2 class="text-xl font-bold text-slate-900 mb-6" id="lessonsHeading">Materi Kursus</h2>
            <div id="lessonList" class="grid gap-3">
                <!-- Loaded dynamically -->
            </div>
        </div>
    </div>
</div>

<!-- LESSON READER MODAL -->
<section id="lessonModal" class="modal">
    <div class="bg-white rounded-3xl max-w-3xl w-full max-h-[90vh] overflow-y-auto border border-slate-200 shadow-2xl flex flex-col p-6 m-4">
        <div class="flex justify-between items-start border-b border-slate-100 pb-4 mb-4">
            <div>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1" id="modalCourseTitle"></p>
                <h3 class="text-lg font-bold text-slate-900" id="modalLessonTitle">Materi</h3>
            </div>
            <button class="text-slate-400 hover:text-slate-600 transition" type="button" id="closeModalBtn">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body overflow-y-auto pr-2 flex-1 min-h-[200px] max-h-[50vh]">
            <div class="lesson-content text-slate-700 text-sm leading-relaxed whitespace-pre-wrap" id="lessonContent"></div>
        </div>
        <div class="flex justify-between items-center border-t border-slate-100 pt-4 mt-5">
            <span class="text-xs text-slate-400 font-semibold" id="modalDuration"></span>
            <div class="flex gap-2">
                <button class="px-4 py-2 bg-slate-100 text-slate-800 font-semibold rounded-xl text-xs hover:bg-slate-200 transition shadow-sm" type="button" id="prevLessonBtn" disabled>← Sebelumnya</button>
                <button class="px-4 py-2 bg-sky-600 text-white font-bold rounded-xl text-xs hover:bg-sky-700 transition shadow-sm" type="button" id="completeLessonBtn">✓ Tandai Selesai</button>
                <button class="px-4 py-2 bg-slate-900 text-white font-semibold rounded-xl text-xs hover:bg-slate-800 transition shadow-sm" type="button" id="nextLessonBtn" disabled>Berikutnya →</button>
            </div>
        </div>
    </div>
</section>

@include('components.auth.toast')

<style>
    /* Modal Backdrop & Toggles */
    .modal {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: none;
        place-items: center;
        z-index: 50;
        padding: 20px;
    }
    .modal.show {
        display: grid;
        animation: modalFadeIn 0.22s ease-out;
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    /* Course detail view overrides */
    #detailView.show {
        display: block;
    }

    /* Loading Spinner */
    .spinner {
        display: inline-block;
        width: 24px;
        height: 24px;
        border: 3px solid rgba(14, 165, 233, 0.15);
        border-top-color: #0ea5e9;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>
@endsection

@push('scripts')
<script src="/js/hirify-api.js"></script>
<script>
const showToast = window.hirifyShowToast;

hirifyInitToken('{{ session("jwt_token") }}');
const api = window.hirifyApi;
const esc = window.hirifyEsc;
let currentUser = null;
let activeCourse = null;
let activeLessons = [];
let activeLesson  = null;
let activeLessonIdx = 0;
let activeTab = 'catalog';

function initial(name) { return (String(name||'U').trim()[0]||'U').toUpperCase(); }

/* ── Load me ── */
async function loadMe() {
    const res = await api('/api/auth/me');
    currentUser = res.data;
    if (currentUser.role !== 'jobseeker') {
        showToast('Halaman ini khusus untuk pencari kerja.', 'error');
        setTimeout(() => { window.location.href = '/dashboard'; }, 1000);
        return;
    }
}

/* ── Catalog ── */
async function loadCatalog() {
    document.getElementById('courseGrid').innerHTML = '<div class="col-span-full py-12 flex justify-center"><span class="spinner"></span></div>';

    const search   = document.getElementById('searchInput').value.trim();
    const category = document.getElementById('categoryFilter').value;
    const level    = document.getElementById('levelFilter').value;
    const params   = new URLSearchParams({ per_page: 24 });
    if (search)   params.set('search', search);
    if (category) params.set('category', category);
    if (level)    params.set('level', level);

    const res  = await api(`/api/skill-training/courses?${params}`);
    const data = res.data;

    const catSel = document.getElementById('categoryFilter');
    if (catSel.options.length <= 1 && data.categories?.length) {
        data.categories.forEach(c => {
            const o = document.createElement('option');
            o.value = c; o.textContent = c;
            catSel.appendChild(o);
        });
    }

    document.getElementById('catalogLabel').textContent =
        `${data.total} Kursus Tersedia${search ? ` untuk "${search}"` : ''}`;

    renderCourseGrid(document.getElementById('courseGrid'), data.items || [], false);
}

/* ── My courses ── */
async function loadMyCourses() {
    document.getElementById('myCourseGrid').innerHTML = '<div class="col-span-full py-12 flex justify-center"><span class="spinner"></span></div>';
    const res  = await api('/api/skill-training/my-courses');
    renderCourseGrid(document.getElementById('myCourseGrid'), res.data.items || [], true);
}

function renderCourseGrid(container, items, isMy) {
    if (!items.length) {
        container.innerHTML = `
            <div class="col-span-full bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-sm">
                <div class="mx-auto w-16 h-16 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center mb-6">
                    <span class="text-3xl">${isMy ? '📖' : '🔍'}</span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">${isMy ? 'Belum Ada Kursus Terdaftar' : 'Kursus Tidak Ditemukan'}</h3>
                <p class="text-slate-500 max-w-md mx-auto text-sm leading-relaxed">${isMy ? 'Kamu belum mendaftar ke kursus apapun. Jelajahi katalog dan mulai belajar!' : 'Tidak ada kursus yang sesuai dengan kata kunci atau filter pencarian Anda.'}</p>
            </div>`;
        return;
    }

    container.innerHTML = items.map(c => {
        const levelClsMap = {
            'beginner': 'bg-emerald-50 text-emerald-700 border-emerald-100',
            'intermediate': 'bg-amber-50 text-amber-700 border-amber-100',
            'advanced': 'bg-rose-50 text-rose-700 border-rose-100'
        };
        const levelCls  = levelClsMap[c.level] || 'bg-slate-50 text-slate-700 border-slate-100';
        const levelLbl  = esc(c.level_label || 'Pemula');
        const enrolled  = c.is_enrolled ?? true;
        const pct       = c.progress_pct ?? 0;
        const done      = c.course_completed;
        const total     = c.total_lessons ?? c.lessons_count ?? 0;
        const completed = c.completed_count ?? 0;

        return `
        <article class="course-card bg-white border border-slate-200 rounded-3xl p-6 shadow-sm hover:shadow-md hover:border-sky-500 transition-all duration-300 flex flex-col justify-between cursor-pointer" data-course-id="${esc(c.course_id||c.id)}">
            <div>
                <div class="text-4xl mb-4">${esc(c.thumbnail_emoji)}</div>
                
                <div class="flex flex-wrap gap-1.5 mb-3">
                    <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-sky-50 text-sky-700">${esc(c.category)}</span>
                    <span class="px-2.5 py-1 text-xs font-bold rounded-lg border ${levelCls}">${levelLbl}</span>
                    ${c.is_free===false ? '<span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-orange-50 text-orange-700 border border-orange-100">Berbayar</span>' : '<span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100">Gratis</span>'}
                </div>
                
                <h3 class="text-base font-bold text-slate-900 tracking-tight leading-snug mb-2 line-clamp-2">${esc(c.title)}</h3>
                <p class="text-sm text-slate-500 leading-relaxed mb-4 line-clamp-3">${esc(c.description)}</p>
                
                <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-slate-400 mb-6 font-medium">
                    <span>👨‍🏫 ${esc(c.instructor_name)}</span>
                    <span class="text-slate-200">•</span>
                    <span>⏱ ${esc(String(c.estimated_hours))} jam</span>
                    <span class="text-slate-200">•</span>
                    <span>📝 ${esc(String(total))} materi</span>
                </div>
            </div>

            <div class="mt-auto pt-4 border-t border-slate-100">
                ${enrolled ? `
                <div class="flex flex-col gap-2 mb-4">
                    <div class="flex justify-between items-center text-xs font-bold">
                        <span class="text-slate-500">Progress</span>
                        <span class="text-sky-600">${pct}%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-gradient-to-r from-sky-400 to-sky-600 h-full rounded-full" style="width:${pct}%"></div>
                    </div>
                    <div class="text-[10px] text-slate-400 font-bold tracking-wide uppercase">${done ? '✅ Selesai' : `${completed}/${total} materi selesai`}</div>
                </div>` : ''}

                <div class="flex items-center justify-between gap-2">
                    ${enrolled ? `<span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold border border-emerald-100">✓ Terdaftar</span>` : `<span class="text-xs text-slate-400 font-bold">Belum terdaftar</span>`}
                    <button class="px-4 py-2 text-xs font-bold rounded-xl shadow-sm transition ${enrolled ? 'bg-slate-100 text-slate-700 hover:bg-slate-200' : 'bg-sky-600 text-white hover:bg-sky-700'}">
                        ${enrolled ? 'Belajar →' : 'Lihat Detail'}
                    </button>
                </div>
            </div>
        </article>`;
    }).join('');

    container.querySelectorAll('.course-card').forEach(el => {
        el.addEventListener('click', () => openCourseDetail(el.dataset.courseId));
    });
}

/* ── Course detail ── */
async function openCourseDetail(id) {
    if (!id) return;
    showDetail();

    document.getElementById('detailTitle').textContent = 'Memuat…';
    document.getElementById('lessonList').innerHTML = '<div class="col-span-full py-12 flex justify-center"><span class="spinner"></span></div>';
    document.getElementById('detailProgressRow').classList.add('hidden');
    document.getElementById('enrollBtn').classList.add('hidden');

    try {
        const res = await api(`/api/skill-training/courses/${id}`);
        activeCourse  = res.data;
        activeLessons = activeCourse.lessons || [];

        document.getElementById('detailEmoji').textContent  = activeCourse.thumbnail_emoji;
        document.getElementById('detailTitle').textContent  = activeCourse.title;
        
        const levelClsMap = {
            'beginner': 'bg-emerald-50/20 text-emerald-400 border-emerald-800/40',
            'intermediate': 'bg-amber-50/20 text-amber-400 border-amber-800/40',
            'advanced': 'bg-rose-50/20 text-rose-400 border-rose-800/40'
        };
        const levelCls = levelClsMap[activeCourse.level] || 'bg-slate-800 text-slate-400 border-slate-700';

        document.getElementById('detailMeta').innerHTML = `
            <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg border ${levelCls}">${esc(activeCourse.level_label)}</span>
            <span>${esc(activeCourse.category)}</span>
            <span class="text-slate-600">•</span>
            <span>👨‍🏫 ${esc(activeCourse.instructor_name)}</span>
            <span class="text-slate-600">•</span>
            <span>⏱ ${esc(String(activeCourse.estimated_hours))} jam</span>
            <span class="text-slate-600">•</span>
            <span>📝 ${esc(String(activeCourse.total_lessons))} materi</span>
        `;

        document.getElementById('lessonsHeading').textContent =
            `Materi Kursus (${activeCourse.total_lessons} pelajaran)`;

        if (activeCourse.is_enrolled) {
            const pct = activeCourse.progress_pct;
            const row = document.getElementById('detailProgressRow');
            row.classList.remove('hidden');
            document.getElementById('progressPct').textContent  = `${pct}%`;
            document.getElementById('progressFill').style.width = `${pct}%`;
            document.getElementById('progressDetail').textContent =
                activeCourse.course_completed
                    ? '🎉 Kamu telah menyelesaikan seluruh materi kursus ini!'
                    : `${activeCourse.completed_count} dari ${activeCourse.total_lessons} materi selesai`;
            document.getElementById('certBtn').classList.toggle('hidden', !activeCourse.course_completed);
        } else {
            document.getElementById('enrollBtn').classList.remove('hidden');
        }

        renderLessons();
    } catch (err) {
        showToast(err.message || 'Gagal memuat kursus.', 'error');
        showList();
    }
}

function renderLessons() {
    const container = document.getElementById('lessonList');
    if (!activeLessons.length) {
        container.innerHTML = ' <div class="bg-white rounded-3xl border border-slate-200 p-8 text-center text-slate-500">Belum ada materi dalam kursus ini.</div>';
        return;
    }

    container.innerHTML = activeLessons.map((l, idx) => {
        const isCompleted = l.is_completed;
        const numBg = isCompleted ? 'bg-emerald-50 text-emerald-700' : 'bg-sky-50 text-sky-700';
        
        return `
        <div class="lesson-card bg-white border border-slate-200 rounded-2xl p-4 flex items-center justify-between gap-4 cursor-pointer hover:border-sky-500 hover:bg-sky-50/10 transition duration-200 ${isCompleted ? 'border-emerald-200 bg-emerald-50/5' : ''}" data-lesson-idx="${idx}">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold text-sm flex-shrink-0 ${numBg}">
                    ${isCompleted ? '✓' : esc(String(l.order_number))}
                </div>
                <div class="min-w-0">
                    <h4 class="text-sm font-bold text-slate-900">${esc(l.title)}</h4>
                    <p class="text-xs text-slate-400 mt-1 font-semibold">⏱ ${esc(String(l.duration_minutes))} menit</p>
                </div>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                ${isCompleted ? '<span class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold border border-emerald-100">✓ Selesai</span>' : ''}
                ${activeCourse.is_enrolled && !isCompleted ? '<span class="text-xs font-bold text-sky-600 hover:text-sky-700">Mulai →</span>' : ''}
                ${!activeCourse.is_enrolled ? '<span class="text-xs text-slate-400 font-semibold">🔒 Daftar dulu</span>' : ''}
            </div>
        </div>
    `}).join('');

    container.querySelectorAll('.lesson-card').forEach(el => {
        el.addEventListener('click', () => {
            if (!activeCourse.is_enrolled) {
                showToast('Daftar ke kursus ini terlebih dahulu untuk mengakses materi.', 'info');
                return;
            }
            openLessonReader(parseInt(el.dataset.lessonIdx));
        });
    });
}

/* ── Lesson reader ── */
function openLessonReader(idx) {
    activeLessonIdx = idx;
    activeLesson    = activeLessons[idx];
    if (!activeLesson) return;

    document.getElementById('modalCourseTitle').textContent  = activeCourse.title;
    document.getElementById('modalLessonTitle').textContent  = activeLesson.title;
    document.getElementById('modalDuration').textContent     = `⏱ ${activeLesson.duration_minutes} menit`;
    document.getElementById('lessonContent').textContent     = activeLesson.content || '';

    const completeBtn = document.getElementById('completeLessonBtn');
    if (activeLesson.is_completed) {
        completeBtn.textContent  = '✓ Sudah Selesai';
        completeBtn.className    = 'px-4 py-2 bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold rounded-xl text-xs cursor-not-allowed';
        completeBtn.disabled     = true;
    } else {
        completeBtn.textContent  = '✓ Tandai Selesai';
        completeBtn.className    = 'px-4 py-2 bg-sky-600 text-white font-bold rounded-xl text-xs hover:bg-sky-700 transition shadow-sm';
        completeBtn.disabled     = false;
    }

    document.getElementById('prevLessonBtn').disabled = idx <= 0;
    document.getElementById('nextLessonBtn').disabled = idx >= activeLessons.length - 1;

    // Adjust button disabled states class helper
    document.getElementById('prevLessonBtn').classList.toggle('opacity-50', idx <= 0);
    document.getElementById('nextLessonBtn').classList.toggle('opacity-50', idx >= activeLessons.length - 1);

    document.getElementById('lessonModal').classList.add('show');
    document.getElementById('lessonModal').querySelector('.modal-body').scrollTop = 0;
}

function closeLessonModal() {
    document.getElementById('lessonModal').classList.remove('show');
}

/* ── Actions ── */
async function doEnroll() {
    const btn = document.getElementById('enrollBtn');
    btn.disabled = true;
    try {
        await api(`/api/skill-training/courses/${activeCourse.id}/enroll`, { method: 'POST' });
        showToast('Berhasil mendaftar! Sekarang kamu bisa mengakses semua materi. 🎉', 'success');
        await openCourseDetail(activeCourse.id);
    } catch (err) {
        showToast(err.message || 'Gagal mendaftar.', 'error');
        btn.disabled = false;
    }
}

async function doCompleteLesson() {
    if (!activeCourse || !activeLesson) return;
    const btn = document.getElementById('completeLessonBtn');
    btn.disabled = true;

    try {
        const res = await api(
            `/api/skill-training/courses/${activeCourse.id}/lessons/${activeLesson.id}/complete`,
            { method: 'POST' }
        );
        const data = res.data;

        activeLesson.is_completed = true;
        activeLessons[activeLessonIdx].is_completed = true;

        activeCourse.progress_pct    = data.progress_pct;
        activeCourse.completed_count = data.completed_count;
        activeCourse.course_completed= data.course_completed;

        document.getElementById('progressPct').textContent  = `${data.progress_pct}%`;
        document.getElementById('progressFill').style.width = `${data.progress_pct}%`;
        document.getElementById('progressDetail').textContent =
            data.course_completed
                ? '🎉 Kamu telah menyelesaikan seluruh materi kursus ini!'
                : `${data.completed_count} dari ${activeCourse.total_lessons} materi selesai`;
        document.getElementById('certBtn').classList.toggle('hidden', !data.course_completed);

        btn.textContent = '✓ Sudah Selesai';
        btn.className   = 'px-4 py-2 bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold rounded-xl text-xs cursor-not-allowed';

        renderLessons();

        if (data.course_completed) {
            showToast('🎉 Selamat! Kamu telah menyelesaikan seluruh kursus!', 'success', 4000);
        } else {
            showToast('Materi berhasil ditandai selesai!', 'success');
        }

        if (activeLessonIdx < activeLessons.length - 1) {
            setTimeout(() => openLessonReader(activeLessonIdx + 1), 800);
        }
    } catch (err) {
        showToast(err.message || 'Gagal menandai selesai.', 'error');
        btn.disabled = false;
    }
}

/* ── View switching ── */
function showList() {
    document.getElementById('listView').classList.remove('hidden');
    document.getElementById('detailView').classList.add('hidden');
    activeCourse = null;
}

function showDetail() {
    document.getElementById('listView').classList.add('hidden');
    document.getElementById('detailView').classList.remove('hidden');
}

function switchTab(tab) {
    activeTab = tab;
    document.querySelectorAll('.tab-btn').forEach(b => {
        const isTarget = b.dataset.tab === tab;
        b.className = isTarget 
            ? 'tab-btn px-5 py-2.5 text-sm font-semibold rounded-xl bg-white text-slate-900 shadow-sm transition'
            : 'tab-btn px-5 py-2.5 text-sm font-semibold rounded-xl text-slate-500 hover:bg-slate-100/60 transition';
    });
    document.getElementById('catalogTab').style.display   = tab === 'catalog'    ? '' : 'none';
    document.getElementById('myCoursesTab').style.display = tab === 'my-courses' ? '' : 'none';
    if (tab === 'my-courses') loadMyCourses();
}

/* ── Events ── */
function bindEvents() {
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => switchTab(btn.dataset.tab));
    });

    document.getElementById('searchBtn').addEventListener('click', loadCatalog);
    document.getElementById('searchInput').addEventListener('keydown', e => { if (e.key==='Enter') loadCatalog(); });
    document.getElementById('categoryFilter').addEventListener('change', loadCatalog);
    document.getElementById('levelFilter').addEventListener('change', loadCatalog);

    document.getElementById('backBtn').addEventListener('click', () => {
        showList();
        if (activeTab === 'my-courses') loadMyCourses(); else loadCatalog();
    });

    document.getElementById('enrollBtn').addEventListener('click', doEnroll);

    document.getElementById('closeModalBtn').addEventListener('click', closeLessonModal);
    document.getElementById('lessonModal').addEventListener('click', e => {
        if (e.target === document.getElementById('lessonModal')) closeLessonModal();
    });

    document.getElementById('completeLessonBtn').addEventListener('click', doCompleteLesson);

    document.getElementById('prevLessonBtn').addEventListener('click', () => {
        if (activeLessonIdx > 0) openLessonReader(activeLessonIdx - 1);
    });

    document.getElementById('nextLessonBtn').addEventListener('click', () => {
        if (activeLessonIdx < activeLessons.length - 1) openLessonReader(activeLessonIdx + 1);
    });
}

/* ── Boot ── */
async function boot() {
    try {
        await loadMe();
        bindEvents();
        await loadCatalog();
    } catch (err) {
        if (String(err.message).toLowerCase().includes('unauthenticated')) {
            if (typeof window.hirifyClearAuth === 'function') {
                window.hirifyClearAuth();
            }
            window.location.href = '/login'; 
            return;
        }
        showToast(err.message || 'Gagal memuat halaman.', 'error');
    }
}

boot();
</script>
@endpush
