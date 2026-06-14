@extends('layouts.app')

@section('title', isset($portofolio) ? 'Edit Portofolio' : 'Tambah Portofolio')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Back button & Header -->
    <div class="flex items-center gap-3 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <a href="{{ route('portofolio.index') }}" class="p-2 hover:bg-slate-50 text-slate-500 hover:text-navy rounded-xl transition-colors border border-slate-200">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
        </a>
        <div>
            <h1 class="text-xl font-extrabold text-navy-900 tracking-tight">
                {{ isset($portofolio) ? 'Edit Portofolio' : 'Tambah Portofolio Baru' }}
            </h1>
            <p class="text-slate-500 text-xs mt-0.5">Isi detail portofolio Anda di bawah ini dengan lengkap.</p>
        </div>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <form action="{{ isset($portofolio) ? route('portofolio.update', $portofolio->id) : route('portofolio.store') }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="p-6 space-y-6">
            @csrf
            @if(isset($portofolio))
                @method('PUT')
            @endif

            <!-- 1. Portfolio Type Selector (Project or Certificate) -->
            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-wider text-slate-400">Tipe Portofolio</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Project Option -->
                    <label class="relative flex flex-col p-4 bg-slate-50 border-2 rounded-2xl cursor-pointer hover:bg-slate-100/50 transition-all select-none group border-slate-200" id="type-project-container">
                        <input type="radio" name="type" value="project" class="sr-only" id="type-project" 
                               {{ (old('type', $portofolio->type ?? 'project') === 'project') ? 'checked' : '' }}
                               onchange="handleTypeChange('project')">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl group-hover:scale-110 transition-transform">💻</span>
                            <div>
                                <p class="text-sm font-bold text-navy-900">Proyek Mandiri / Hasil Karya</p>
                                <p class="text-[11px] text-slate-500 mt-0.5">Aplikasi, web, desain, riset, atau tulisan yang dikerjakan.</p>
                            </div>
                        </div>
                        <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-slate-300 flex items-center justify-center bg-white" id="radio-project-check">
                            <div class="w-2.5 h-2.5 rounded-full bg-navy hidden" id="radio-project-dot"></div>
                        </div>
                    </label>

                    <!-- Certificate Option -->
                    <label class="relative flex flex-col p-4 bg-slate-50 border-2 rounded-2xl cursor-pointer hover:bg-slate-100/50 transition-all select-none group border-slate-200" id="type-certificate-container">
                        <input type="radio" name="type" value="certificate" class="sr-only" id="type-certificate" 
                               {{ (old('type', $portofolio->type ?? '') === 'certificate') ? 'checked' : '' }}
                               onchange="handleTypeChange('certificate')">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl group-hover:scale-110 transition-transform">📜</span>
                            <div>
                                <p class="text-sm font-bold text-navy-900">Sertifikat Kelulusan / Lisensi</p>
                                <p class="text-[11px] text-slate-500 mt-0.5">Sertifikat kompetensi, kursus online, pelatihan, atau penghargaan.</p>
                            </div>
                        </div>
                        <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-slate-300 flex items-center justify-center bg-white" id="radio-certificate-check">
                            <div class="w-2.5 h-2.5 rounded-full bg-navy hidden" id="radio-certificate-dot"></div>
                        </div>
                    </label>
                </div>
                @error('type')
                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <hr class="border-slate-100">

            <!-- 2. Portfolio Title -->
            <div class="space-y-1.5">
                <label for="title" class="text-xs font-bold uppercase tracking-wider text-slate-500" id="title-label">Nama Proyek / Hasil Karya</label>
                <input type="text" name="title" id="title" value="{{ old('title', $portofolio->title ?? '') }}" 
                       placeholder="Contoh: E-Commerce Platform dengan Laravel & Vue" 
                       required minlength="3" maxlength="150"
                       class="block w-full px-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent transition-all @error('title') border-red-300 focus:ring-red-500 @enderror">
                @error('title')
                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 3. Portfolio Description -->
            <div class="space-y-1.5">
                <label for="description" class="text-xs font-bold uppercase tracking-wider text-slate-500">Deskripsi Detail</label>
                <textarea name="description" id="description" rows="5" 
                          placeholder="Jelaskan detail proyek, peran Anda, teknologi yang digunakan, serta fitur utama atau pencapaian yang diraih..." 
                          required minlength="30" maxlength="2000"
                          class="block w-full px-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent transition-all @error('description') border-red-300 focus:ring-red-500 @enderror">{{ old('description', $portofolio->description ?? '') }}</textarea>
                @error('description')
                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 4. Portfolio Link -->
            <div class="space-y-1.5">
                <label for="link" class="text-xs font-bold uppercase tracking-wider text-slate-500" id="link-label">Link Proyek / Repositori (Opsional)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                        </svg>
                    </div>
                    <input type="url" name="link" id="link" value="{{ old('link', $portofolio->link ?? '') }}" 
                           placeholder="https://github.com/username/project atau https://my-portfolio-link.com" 
                           class="block w-full pl-10 pr-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent transition-all @error('link') border-red-300 focus:ring-red-500 @enderror">
                </div>
                @error('link')
                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 5. Technology / Skills tags -->
            <div class="space-y-1.5">
                <label for="skills" class="text-xs font-bold uppercase tracking-wider text-slate-500" id="skills-label">Teknologi / Keahlian yang Relevan (Opsional)</label>
                <input type="text" name="skills" id="skills" value="{{ old('skills', $portofolio->skills ?? '') }}" 
                       placeholder="Pisahkan dengan koma. Contoh: Laravel, React, TailwindCSS, MySQL" 
                       class="block w-full px-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent transition-all @error('skills') border-red-300 focus:ring-red-500 @enderror">
                <p class="text-[10px] text-slate-400 font-semibold mt-1">Teknologi ini akan muncul sebagai label tag pada halaman portofolio Anda.</p>
                @error('skills')
                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 6. Date Timeline -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="start_date" class="text-xs font-bold uppercase tracking-wider text-slate-500" id="start-date-label">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" 
                           value="{{ old('start_date', isset($portofolio->start_date) ? $portofolio->start_date->format('Y-m-d') : '') }}" 
                           required
                           class="block w-full px-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent transition-all @error('start_date') border-red-300 focus:ring-red-500 @enderror">
                    @error('start_date')
                        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-1.5" id="end-date-group">
                    <label for="end_date" class="text-xs font-bold uppercase tracking-wider text-slate-500" id="end-date-label">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date" 
                           value="{{ old('end_date', isset($portofolio->end_date) ? $portofolio->end_date->format('Y-m-d') : '') }}" 
                           required
                           class="block w-full px-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent transition-all @error('end_date') border-red-300 focus:ring-red-500 @enderror">
                    @error('end_date')
                        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Ongoing checkbox -->
            <div class="flex items-center gap-2 select-none" id="ongoing-group">
                <input type="checkbox" name="is_ongoing" id="is_ongoing" value="1" 
                       {{ (old('is_ongoing', $portofolio->is_ongoing ?? false)) ? 'checked' : '' }}
                       class="w-4 h-4 rounded text-navy focus:ring-navy border-slate-300 cursor-pointer"
                       onchange="toggleEndDate(this.checked)">
                <label for="is_ongoing" class="text-xs font-bold text-slate-600 cursor-pointer" id="ongoing-label">Proyek ini sedang berjalan / aktif</label>
            </div>

            <hr class="border-slate-100">

            <!-- 7. File Upload Area -->
            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500" id="file-label">Lampiran Portofolio (Gambar / PDF)</label>
                
                @if(isset($portofolio) && $portofolio->file_path)
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 flex items-center justify-between gap-3 text-sm">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">
                                {{ in_array(pathinfo($portofolio->file_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'webp']) ? '🖼️' : '📄' }}
                            </span>
                            <div>
                                <p class="font-bold text-slate-800 truncate max-w-sm sm:max-w-md">{{ $portofolio->file_name }}</p>
                                <p class="text-[11px] text-slate-400 font-semibold mt-0.5">Sudah terunggah ({{ $portofolio->file_size }})</p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $portofolio->file_path) }}" target="_blank" class="px-3.5 py-1.5 bg-white text-slate-600 hover:text-navy border border-slate-200 rounded-lg text-xs font-semibold shadow-sm transition-colors">
                            Lihat File
                        </a>
                    </div>
                @endif

                <div class="border-2 border-dashed border-slate-200 rounded-2xl hover:border-navy hover:bg-slate-50/50 transition-all cursor-pointer relative" id="upload-zone">
                    <input type="file" name="file" id="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                           accept=".pdf, .png, .jpg, .jpeg"
                           onchange="handleFileSelect(this)">
                    <div class="p-6 text-center flex flex-col items-center">
                        <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center text-xl mb-3 shadow-inner" id="upload-icon-container">
                            📥
                        </div>
                        <p class="text-sm font-bold text-slate-700" id="upload-text">
                            {{ isset($portofolio) && $portofolio->file_path ? 'Unggah file baru untuk menggantikan' : 'Klik untuk mengunggah atau seret file ke sini' }}
                        </p>
                        <p class="text-[11px] text-slate-400 font-semibold mt-1">Format yang didukung: PDF, PNG, JPG, JPEG (Maks. 5MB)</p>
                    </div>
                </div>
                @error('file')
                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 8. Submit buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('portofolio.index') }}" class="px-5 py-3 border border-slate-200 hover:bg-slate-50 text-slate-600 font-semibold rounded-xl text-sm transition-colors shadow-sm">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-navy text-white hover:bg-slate-800 font-semibold rounded-xl text-sm shadow-sm transition-all hover:shadow-md transform active:scale-95">
                    {{ isset($portofolio) ? 'Simpan Perubahan' : 'Tambah Portofolio' }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Initialize labels on page load
    document.addEventListener('DOMContentLoaded', function() {
        const initialType = document.querySelector('input[name="type"]:checked').value;
        handleTypeChange(initialType);
        
        const isOngoingChecked = document.getElementById('is_ongoing').checked;
        toggleEndDate(isOngoingChecked);
    });

    // Handle portfolio type toggles and update text dynamically
    function handleTypeChange(type) {
        // UI Visual container update
        const projectContainer = document.getElementById('type-project-container');
        const certificateContainer = document.getElementById('type-certificate-container');
        
        const projectDot = document.getElementById('radio-project-dot');
        const certificateDot = document.getElementById('radio-certificate-dot');
        
        const projectCheck = document.getElementById('radio-project-check');
        const certificateCheck = document.getElementById('radio-certificate-check');

        if (type === 'project') {
            // Project selected
            projectContainer.classList.add('border-navy', 'bg-slate-100/30');
            projectContainer.classList.remove('border-slate-200');
            projectCheck.classList.add('border-navy');
            projectDot.classList.remove('hidden');

            certificateContainer.classList.remove('border-navy', 'bg-slate-100/30');
            certificateContainer.classList.add('border-slate-200');
            certificateCheck.classList.remove('border-navy');
            certificateDot.classList.add('hidden');

            // Set Labels and Placeholders
            document.getElementById('title-label').innerText = 'Nama Proyek / Hasil Karya';
            document.getElementById('title').placeholder = 'Contoh: E-Commerce Platform dengan Laravel & Vue';
            
            document.getElementById('link-label').innerText = 'Link Proyek / Repositori (Opsional)';
            document.getElementById('link').placeholder = 'https://github.com/username/project atau https://my-portfolio-link.com';

            document.getElementById('skills-label').innerText = 'Teknologi / Keahlian yang Relevan (Opsional)';
            document.getElementById('skills').placeholder = 'Pisahkan dengan koma. Contoh: Laravel, React, TailwindCSS, MySQL';

            document.getElementById('start-date-label').innerText = 'Tanggal Mulai';
            document.getElementById('end-date-label').innerText = 'Tanggal Selesai';

            document.getElementById('ongoing-label').innerText = 'Proyek ini sedang berjalan / aktif';
            document.getElementById('file-label').innerText = 'Lampiran Portofolio / Bukti Proyek (Gambar / PDF)';
        } else {
            // Certificate selected
            certificateContainer.classList.add('border-navy', 'bg-slate-100/30');
            certificateContainer.classList.remove('border-slate-200');
            certificateCheck.classList.add('border-navy');
            certificateDot.classList.remove('hidden');

            projectContainer.classList.remove('border-navy', 'bg-slate-100/30');
            projectContainer.classList.add('border-slate-200');
            projectCheck.classList.remove('border-navy');
            projectDot.classList.add('hidden');

            // Set Labels and Placeholders
            document.getElementById('title-label').innerText = 'Nama Sertifikat / Penghargaan';
            document.getElementById('title').placeholder = 'Contoh: Google UX Design Professional Certificate';
            
            document.getElementById('link-label').innerText = 'Link Kredensial / Verifikasi Sertifikat (Opsional)';
            document.getElementById('link').placeholder = 'https://coursera.org/verify/credential-id atau https://credential-lookup.com';

            document.getElementById('skills-label').innerText = 'Keahlian yang Diperoleh (Opsional)';
            document.getElementById('skills').placeholder = 'Pisahkan dengan koma. Contoh: UI Design, Wireframing, User Research';

            document.getElementById('start-date-label').innerText = 'Tanggal Terbit';
            document.getElementById('end-date-label').innerText = 'Tanggal Kedaluwarsa';

            document.getElementById('ongoing-label').innerText = 'Sertifikat ini berlaku selamanya / tidak memiliki kedaluwarsa';
            document.getElementById('file-label').innerText = 'Unduhan Sertifikat (Format PDF / Gambar)';
        }
    }

    // Toggle End Date input based on is_ongoing status
    function toggleEndDate(isOngoing) {
        const endDateGroup = document.getElementById('end-date-group');
        const endDateInput = document.getElementById('end_date');
        
        if (isOngoing) {
            endDateInput.value = '';
            endDateInput.disabled = true;
            endDateInput.removeAttribute('required');
            endDateGroup.classList.add('opacity-50');
        } else {
            endDateInput.disabled = false;
            endDateInput.setAttribute('required', 'required');
            endDateGroup.classList.remove('opacity-50');
        }
    }

    // File selection UI visual feedback
    function handleFileSelect(input) {
        const uploadZone = document.getElementById('upload-zone');
        const uploadText = document.getElementById('upload-text');
        const uploadIconContainer = document.getElementById('upload-icon-container');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            uploadZone.classList.add('border-navy', 'bg-slate-100/30');
            uploadIconContainer.innerText = '✅';
            uploadText.innerText = `File terpilih: ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
        } else {
            uploadZone.classList.remove('border-navy', 'bg-slate-100/30');
            uploadIconContainer.innerText = '📥';
            uploadText.innerText = 'Klik untuk mengunggah atau seret file ke sini';
        }
    }
</script>
@endpush
@endsection
