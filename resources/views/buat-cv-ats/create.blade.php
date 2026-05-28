@extends('layouts.app')

@section('title', 'Buat CV ATS - Hirify')

@section('content')
<div class="max-w-[1300px] mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('buat-cv-ats.index') }}" class="text-slate-400 hover:text-slate-700 transition">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Buat CV ATS</h1>
            <p class="text-slate-500 text-sm mt-0.5">Isi form di kiri dan lihat preview CV real-time di kanan.</p>
        </div>
    </div>

    <div class="flex gap-6 items-start">
        {{-- ===== LEFT: FORM ===== --}}
        <div class="w-[420px] shrink-0">
            <form method="POST" action="{{ route('buat-cv-ats.store') }}" id="cv-form">
                @csrf

                {{-- Personal Info --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-5 mb-4">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide mb-4">Informasi Pribadi</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lengkap *</label>
                            <input type="text" name="name" id="f-name" value="{{ old('name', auth()->user()->name) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition"
                                placeholder="John Doe" oninput="syncPreview()">
                            @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Email *</label>
                            <input type="email" name="email" id="f-email" value="{{ old('email', auth()->user()->email) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition"
                                placeholder="john@email.com" oninput="syncPreview()">
                            @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">No. Telepon</label>
                                <input type="text" name="phone" id="f-phone" value="{{ old('phone') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition"
                                    placeholder="+62 812 3456 789" oninput="syncPreview()">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">LinkedIn</label>
                                <input type="text" name="linkedin" id="f-linkedin" value="{{ old('linkedin') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition"
                                    placeholder="linkedin.com/in/john" oninput="syncPreview()">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Alamat</label>
                            <input type="text" name="address" id="f-address" value="{{ old('address') }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition"
                                placeholder="Jakarta, Indonesia" oninput="syncPreview()">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Professional Summary</label>
                            <textarea name="summary" id="f-summary" rows="3"
                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition resize-none"
                                placeholder="Tuliskan ringkasan profesional Anda..." oninput="syncPreview()">{{ old('summary') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Education --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-5 mb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Pendidikan</h3>
                        <button type="button" onclick="addEducation()"
                            class="text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center gap-1 transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah
                        </button>
                    </div>
                    <div id="education-list" class="space-y-3">
                        <div class="education-item p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <div class="grid grid-cols-2 gap-2 mb-2">
                                <input type="text" name="educations[0][institution]"
                                    class="col-span-2 rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 transition"
                                    placeholder="Nama Institusi" oninput="syncPreview()">
                                <input type="text" name="educations[0][degree]"
                                    class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 transition"
                                    placeholder="Jenjang/Jurusan" oninput="syncPreview()">
                                <input type="text" name="educations[0][year]"
                                    class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 transition"
                                    placeholder="2020 - 2024" oninput="syncPreview()">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Experience --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-5 mb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Pengalaman Kerja</h3>
                        <button type="button" onclick="addExperience()"
                            class="text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center gap-1 transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah
                        </button>
                    </div>
                    <div id="experience-list" class="space-y-3">
                        <div class="experience-item p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <div class="space-y-2">
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="experiences[0][position]"
                                        class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 transition"
                                        placeholder="Posisi/Jabatan" oninput="syncPreview()">
                                    <input type="text" name="experiences[0][company]"
                                        class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 transition"
                                        placeholder="Nama Perusahaan" oninput="syncPreview()">
                                </div>
                                <input type="text" name="experiences[0][period]"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 transition"
                                    placeholder="Jan 2023 - Des 2023" oninput="syncPreview()">
                                <textarea name="experiences[0][description]" rows="2"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 transition resize-none"
                                    placeholder="Deskripsi tanggung jawab..." oninput="syncPreview()"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Skills --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-5 mb-6">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide mb-4">Key Skills</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Technical Skills</label>
                            <input type="text" name="technical_skills" id="f-technical"
                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition"
                                placeholder="Laravel, Vue.js, MySQL, Docker (pisahkan koma)" oninput="syncPreview()">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Soft Skills</label>
                            <input type="text" name="soft_skills" id="f-soft"
                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition"
                                placeholder="Komunikasi, Teamwork, Problem Solving (pisahkan koma)" oninput="syncPreview()">
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-3.5 bg-slate-900 text-white font-bold text-sm rounded-2xl hover:bg-slate-700 transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                    Simpan CV
                </button>
            </form>
        </div>

        {{-- ===== RIGHT: PREVIEW ===== --}}
        <div class="flex-1 sticky top-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-slate-900 px-5 py-3 flex items-center gap-2">
                    <div class="flex gap-1.5">
                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                        <div class="w-3 h-3 rounded-full bg-green-400"></div>
                    </div>
                    <p class="text-slate-400 text-xs ml-2 font-mono">CV Preview — ATS Format</p>
                </div>

                <div class="overflow-y-auto max-h-[80vh]">
                    <div id="cv-preview" class="max-w-[800px] mx-auto p-10 font-serif text-[13px] leading-relaxed text-slate-900 break-words overflow-wrap-anywhere">

                        {{-- Name --}}
                        <h1 id="p-name" class="text-2xl font-bold text-center uppercase tracking-wide mb-1 break-words"></h1>

                        {{-- Contact --}}
                        <div id="p-contact" class="text-center text-slate-600 text-xs mb-1 break-words"></div>
                        <div id="p-address" class="text-center text-slate-600 text-xs mb-4 break-words"></div>

                        <hr class="border-slate-900 border-t-2 mb-4">

                        {{-- Summary --}}
                        <div id="p-summary-section" class="hidden mb-4">
                            <h2 class="text-sm font-extrabold uppercase tracking-widest mb-2 border-b border-slate-200 pb-1">Professional Summary</h2>
                            <p id="p-summary" class="text-slate-700 break-words"></p>
                        </div>

                        {{-- Education --}}
                        <div id="p-education-section" class="mb-4">
                            <h2 class="text-sm font-extrabold uppercase tracking-widest mb-2 border-b border-slate-200 pb-1">Education</h2>
                            <div id="p-education-list"></div>
                        </div>

                        {{-- Experience --}}
                        <div id="p-experience-section" class="mb-4">
                            <h2 class="text-sm font-extrabold uppercase tracking-widest mb-2 border-b border-slate-200 pb-1">Experience</h2>
                            <div id="p-experience-list"></div>
                        </div>

                        {{-- Skills --}}
                        <div id="p-skills-section" class="hidden">
                            <h2 class="text-sm font-extrabold uppercase tracking-widest mb-2 border-b border-slate-200 pb-1">Key Skills</h2>
                            <div class="grid grid-cols-2 gap-4">
                                <div id="p-technical-section" class="hidden">
                                    <p class="font-bold text-xs mb-1">Technical Skills</p>
                                    <ul id="p-technical-list" class="space-y-0.5"></ul>
                                </div>
                                <div id="p-soft-section" class="hidden">
                                    <p class="font-bold text-xs mb-1">Soft Skills</p>
                                    <ul id="p-soft-list" class="space-y-0.5"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let eduCount = 1;
let expCount = 1;

function addEducation() {
    const i = eduCount++;
    const list = document.getElementById('education-list');
    const div = document.createElement('div');
    div.className = 'education-item p-3 bg-slate-50 rounded-xl border border-slate-100 relative';
    div.innerHTML = `
        <button type="button" onclick="this.parentElement.remove(); syncPreview()"
            class="absolute top-2 right-2 text-slate-400 hover:text-red-500 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div class="grid grid-cols-2 gap-2">
            <input type="text" name="educations[${i}][institution]"
                class="col-span-2 rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 transition"
                placeholder="Nama Institusi" oninput="syncPreview()">
            <input type="text" name="educations[${i}][degree]"
                class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 transition"
                placeholder="Jenjang/Jurusan" oninput="syncPreview()">
            <input type="text" name="educations[${i}][year]"
                class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 transition"
                placeholder="2020 - 2024" oninput="syncPreview()">
        </div>`;
    list.appendChild(div);
}

function addExperience() {
    const i = expCount++;
    const list = document.getElementById('experience-list');
    const div = document.createElement('div');
    div.className = 'experience-item p-3 bg-slate-50 rounded-xl border border-slate-100 relative';
    div.innerHTML = `
        <button type="button" onclick="this.parentElement.remove(); syncPreview()"
            class="absolute top-2 right-2 text-slate-400 hover:text-red-500 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div class="space-y-2">
            <div class="grid grid-cols-2 gap-2">
                <input type="text" name="experiences[${i}][position]"
                    class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 transition"
                    placeholder="Posisi/Jabatan" oninput="syncPreview()">
                <input type="text" name="experiences[${i}][company]"
                    class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 transition"
                    placeholder="Nama Perusahaan" oninput="syncPreview()">
            </div>
            <input type="text" name="experiences[${i}][period]"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 transition"
                placeholder="Jan 2023 - Des 2023" oninput="syncPreview()">
            <textarea name="experiences[${i}][description]" rows="2"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 transition resize-none"
                placeholder="Deskripsi tanggung jawab..." oninput="syncPreview()"></textarea>
        </div>`;
    list.appendChild(div);
}

function syncPreview() {
    // Personal info
    const name    = document.getElementById('f-name')?.value || '';
    const email   = document.getElementById('f-email')?.value || '';
    const phone   = document.getElementById('f-phone')?.value || '';
    const linkedin= document.getElementById('f-linkedin')?.value || '';
    const address = document.getElementById('f-address')?.value || '';
    const summary = document.getElementById('f-summary')?.value || '';

    document.getElementById('p-name').textContent = name;

    const contacts = [email, phone, linkedin].filter(Boolean).join(' | ');
    document.getElementById('p-contact').textContent = contacts;
    document.getElementById('p-address').textContent = address;

    const summarySection = document.getElementById('p-summary-section');
    if (summary) {
        summarySection.classList.remove('hidden');
        document.getElementById('p-summary').textContent = summary;
    } else {
        summarySection.classList.add('hidden');
    }

    // Education
    const eduItems = document.querySelectorAll('.education-item');
    const eduList  = document.getElementById('p-education-list');
    eduList.innerHTML = '';
    eduItems.forEach(item => {
        const inst   = item.querySelector('input[name*="institution"]')?.value || '';
        const degree = item.querySelector('input[name*="degree"]')?.value || '';
        const year   = item.querySelector('input[name*="year"]')?.value || '';
        if (inst) {
            const row = document.createElement('div');
            row.className = 'flex justify-between items-start mb-2';
            row.innerHTML = `
                <div>
                    <p class="font-bold text-xs">${escHtml(inst)}</p>
                    ${degree ? `<p class="text-slate-600 text-xs">${escHtml(degree)}</p>` : ''}
                </div>
                ${year ? `<span class="text-xs text-slate-500 whitespace-nowrap ml-2">${escHtml(year)}</span>` : ''}`;
            eduList.appendChild(row);
        }
    });

    // Experience
    const expItems = document.querySelectorAll('.experience-item');
    const expList  = document.getElementById('p-experience-list');
    expList.innerHTML = '';
    expItems.forEach(item => {
        const pos    = item.querySelector('input[name*="position"]')?.value || '';
        const comp   = item.querySelector('input[name*="company"]')?.value || '';
        const period = item.querySelector('input[name*="period"]')?.value || '';
        const desc   = item.querySelector('textarea[name*="description"]')?.value || '';
        if (pos || comp) {
            const row = document.createElement('div');
            row.className = 'mb-3';
            row.innerHTML = `
                <div class="flex justify-between items-start">
                    <p class="font-bold text-xs">${escHtml(pos)}</p>
                    ${period ? `<span class="text-xs text-slate-500 whitespace-nowrap ml-2">${escHtml(period)}</span>` : ''}
                </div>
                ${comp ? `<p class="text-slate-600 text-xs italic">${escHtml(comp)}</p>` : ''}
                ${desc ? `<p class="text-slate-700 text-xs mt-1 break-words">${escHtml(desc)}</p>` : ''}`;
            expList.appendChild(row);
        }
    });

    // Skills
    const technical = document.getElementById('f-technical')?.value || '';
    const soft      = document.getElementById('f-soft')?.value || '';
    const techSkills= technical.split(',').map(s => s.trim()).filter(Boolean);
    const softSkills= soft.split(',').map(s => s.trim()).filter(Boolean);

    const skillsSection   = document.getElementById('p-skills-section');
    const techSection     = document.getElementById('p-technical-section');
    const softSection     = document.getElementById('p-soft-section');
    const techList        = document.getElementById('p-technical-list');
    const softList        = document.getElementById('p-soft-list');

    techList.innerHTML = '';
    softList.innerHTML = '';

    if (techSkills.length) {
        techSection.classList.remove('hidden');
        techSkills.forEach(s => {
            const li = document.createElement('li');
            li.className = 'text-xs text-slate-700 flex gap-1 items-start';
            li.innerHTML = `<span class="text-slate-400">•</span><span>${escHtml(s)}</span>`;
            techList.appendChild(li);
        });
    } else {
        techSection.classList.add('hidden');
    }

    if (softSkills.length) {
        softSection.classList.remove('hidden');
        softSkills.forEach(s => {
            const li = document.createElement('li');
            li.className = 'text-xs text-slate-700 flex gap-1 items-start';
            li.innerHTML = `<span class="text-slate-400">•</span><span>${escHtml(s)}</span>`;
            softList.appendChild(li);
        });
    } else {
        softSection.classList.add('hidden');
    }

    if (techSkills.length || softSkills.length) {
        skillsSection.classList.remove('hidden');
    } else {
        skillsSection.classList.add('hidden');
    }
}

function escHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// Initial sync
syncPreview();
</script>
@endsection