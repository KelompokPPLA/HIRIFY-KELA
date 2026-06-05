@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="space-y-8">
    @if(session('success'))
    <div class="rounded-2xl bg-emerald-50 border border-emerald-200 px-5 py-3 text-sm font-medium text-emerald-700">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="rounded-2xl bg-red-50 border border-red-200 px-5 py-3 text-sm font-medium text-red-700">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form id="profileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between mb-8">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Profil</p>
                <h1 class="text-3xl font-semibold text-slate-950">Edit Profil</h1>
                <p class="mt-2 text-sm text-slate-600 max-w-2xl">Perbarui data pribadi Anda untuk memperkuat profil karier.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('profile.index') }}" class="inline-flex items-center rounded-xl bg-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-300">Batalkan Perubahan</a>
                <button type="submit" class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">Simpan Perubahan</button>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[0.72fr_0.28fr]">
            <div class="space-y-6">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Akun</p>
                            <h2 class="mt-2 text-xl font-semibold text-slate-950">Informasi Diri</h2>
                        </div>
                        <span class="rounded-2xl bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700">{{ ucfirst($user->role) }}</span>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <label class="space-y-2 text-sm">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-slate-600">Nama Lengkap</span>
                                <span class="text-xs text-slate-400" id="nameCounter">0/60 karakter</span>
                            </div>
                            <input id="nameInput" type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full rounded-2xl border {{ $errors->has('name') ? 'border-red-500' : 'border-slate-200' }} bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/10" required />
                            <p id="nameError" class="hidden text-xs text-red-500 mt-1">Maksimal 60 karakter.</p>
                            <p id="nameHint" class="text-xs text-slate-500 mt-1 {{ $errors->has('name') ? 'hidden' : '' }}">Maksimal 60 karakter.</p>
                        </label>
                        <label class="space-y-2 text-sm">
                            <span class="text-slate-600">Email</span>
                            <input id="emailInput" type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full rounded-2xl border {{ $errors->has('email') ? 'border-red-500' : 'border-slate-200' }} bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/10" required />
                            <p class="text-xs text-slate-500 mt-1">Gunakan format email yang valid.</p>
                        </label>
                        <label class="space-y-2 text-sm">
                            <span class="text-slate-600">Telepon</span>
                            <input id="phoneInput" type="text" name="phone" value="{{ old('phone', $profile?->phone ?? '') }}"
                                class="w-full rounded-2xl border {{ $errors->has('phone') ? 'border-red-500' : 'border-slate-200' }} bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/10" />
                            <p class="text-xs text-slate-500 mt-1">Gunakan format 08xxxxxxxxxx (10-13 digit).</p>
                        </label>
                        <label class="space-y-2 text-sm">
                            <span class="text-slate-600">Lokasi</span>
                            <input id="locationInput" type="text" name="location" value="{{ old('location', $profile?->location ?? '') }}" maxlength="100"
                                class="w-full rounded-2xl border {{ $errors->has('location') ? 'border-red-500' : 'border-slate-200' }} bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/10" />
                            <p class="text-xs text-slate-500 mt-1">Maksimal 50 karakter.</p>
                        </label>
                        <label class="space-y-2 text-sm">
                            <span class="text-slate-600">Foto Profil</span>
                            <input id="photoInput" type="file" name="photo" accept=".jpg,.jpeg,.png"
                                class="w-full rounded-2xl border {{ $errors->has('photo') ? 'border-red-500' : 'border-slate-200' }} bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/10" />
                            <p class="text-xs text-slate-500 mt-1">Format JPG, JPEG, PNG. Maksimal 2 MB.</p>
                        </label>
                        <label class="space-y-2 text-sm sm:col-span-2">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-slate-600">Bio</span>
                                <span class="text-xs text-slate-400" id="bioCounter">0/500 karakter</span>
                            </div>
                            <textarea id="bioInput" name="bio" rows="3"
                                class="w-full rounded-2xl border {{ $errors->has('bio') ? 'border-red-500' : 'border-slate-200' }} bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/10 resize-none">{{ old('bio', $profile?->bio ?? '') }}</textarea>
                            <p id="bioError" class="hidden text-xs text-red-500 mt-1">Maksimal 500 karakter.</p>
                            <p id="bioHint" class="text-xs text-slate-500 mt-1 {{ $errors->has('bio') ? 'hidden' : '' }}">Maksimal 500 karakter.</p>
                        </label>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-950">Pendidikan</h2>
                            <p class="mt-3 text-sm text-slate-500">Isi riwayat pendidikan dengan format ATS: institusi, gelar, dan tahun.</p>
                        </div>
                        <button type="button" class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100" onclick="addEducation()">+ Tambah Pendidikan</button>
                    </div>
                    <div id="educationSection" class="mt-6 space-y-4"></div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-950">Pengalaman Kerja</h2>
                            <p class="mt-3 text-sm text-slate-500">Isi pengalaman kerja dengan jabatan, perusahaan, periode, dan deskripsi singkat.</p>
                        </div>
                        <button type="button" class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100" onclick="addExperience()">+ Tambah Pengalaman</button>
                    </div>
                    <div id="experienceSection" class="mt-6 space-y-4"></div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-950">Skill</h2>
                            <p class="mt-3 text-sm text-slate-500">Tambahkan skill yang ingin ditampilkan di profil Anda.</p>
                        </div>
                        <button type="button" class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100" onclick="addSkill()">+ Tambah Skill</button>
                    </div>
                    <div id="skillSection" class="mt-6 space-y-4"></div>
                </div>
            </div>

            <aside class="space-y-6">
                <div class="rounded-3xl bg-gradient-to-br from-slate-950 to-slate-800 p-6 text-white shadow-lg">
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <div id="previewAvatarContainer" class="h-20 w-20 overflow-hidden rounded-3xl border border-white/20 bg-white/10">
                                    <img id="previewAvatar" src="{{ $profile?->photo ? asset('storage/' . $profile->photo) : '' }}" alt="Foto Profil"
                                        class="h-full w-full object-cover {{ $profile?->photo ? '' : 'hidden' }}" />
                                    <div id="previewInitials" class="h-full w-full grid place-items-center bg-white/10 text-2xl font-semibold text-white {{ $profile?->photo ? 'hidden' : '' }}">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm uppercase tracking-[0.24em] text-slate-300">Akun</p>
                                <h3 id="previewName" class="mt-2 text-xl font-semibold">{{ $user->name }}</h3>
                                <p class="mt-1 text-sm text-slate-300">{{ ucfirst($user->role) }}</p>
                            </div>
                        </div>
                        <div class="rounded-3xl bg-white/10 p-4">
                            <p class="text-xs text-slate-300">Bio</p>
                            <p id="previewBio" class="mt-1 text-sm leading-relaxed text-white">{{ $profile?->bio ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="mt-6 grid gap-3">
                        <div class="rounded-3xl bg-white/10 p-4">
                            <p class="text-xs text-slate-300">Email</p>
                            <p id="previewEmail" class="mt-1 text-sm font-medium text-white">{{ $user->email }}</p>
                        </div>
                        <div class="rounded-3xl bg-white/10 p-4">
                            <p class="text-xs text-slate-300">Telepon</p>
                            <p id="previewPhone" class="mt-1 text-sm font-medium text-white">{{ $profile?->phone ?? '-' }}</p>
                        </div>
                        <div class="rounded-3xl bg-white/10 p-4">
                            <p class="text-xs text-slate-300">Lokasi</p>
                            <p id="previewLocation" class="mt-1 text-sm font-medium text-white">{{ $profile?->location ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-950">Status Akun</h3>
                    <div class="mt-4 space-y-3">
                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                            <span class="text-sm text-slate-600">Role</span>
                            <span class="text-sm font-semibold text-slate-900">{{ ucfirst($user->role) }}</span>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                            <span class="text-sm text-slate-600">Status</span>
                            <span class="text-sm font-semibold text-emerald-600">Aktif</span>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                            <span class="text-sm text-slate-600">Bergabung</span>
                            <span class="text-sm font-semibold text-slate-900">{{ $user->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </form>
</div>

<script>
    const previewName = document.getElementById('previewName');
    const previewEmail = document.getElementById('previewEmail');
    const previewPhone = document.getElementById('previewPhone');
    const previewLocation = document.getElementById('previewLocation');
    const previewBio = document.getElementById('previewBio');
    const previewAvatar = document.getElementById('previewAvatar');
    const previewInitials = document.getElementById('previewInitials');

    const nameInput = document.getElementById('nameInput');
    const emailInput = document.getElementById('emailInput');
    const phoneInput = document.getElementById('phoneInput');
    const locationInput = document.getElementById('locationInput');
    const bioInput = document.getElementById('bioInput');
    const photoInput = document.getElementById('photoInput');

    function normalizeEmpty(value) {
        return value?.trim() ? value.trim() : '-';
    }

    function updateInitials(value) {
        const initials = value.trim() ? value.trim().slice(0, 2).toUpperCase() : '{{ strtoupper(substr($user->name, 0, 2)) }}';
        previewInitials.textContent = initials;
    }

    function updatePreview() {
        previewName.textContent = nameInput.value || '{{ $user->name }}';
        previewEmail.textContent = emailInput.value || '{{ $user->email }}';
        previewPhone.textContent = normalizeEmpty(phoneInput.value);
        previewLocation.textContent = normalizeEmpty(locationInput.value);
        previewBio.textContent = normalizeEmpty(bioInput.value === '' ? '{{ $profile?->bio ?? '' }}' : bioInput.value);
        updateInitials(nameInput.value || '{{ $user->name }}');
        
        // Validation length check for Bio
        const len = bioInput.value.length;
        const counter = document.getElementById('bioCounter');
        const errorMsg = document.getElementById('bioError');
        const hintMsg = document.getElementById('bioHint');
        
        if (counter) counter.innerText = len + '/500 karakter';
        
        if (len > 500) {
            bioInput.classList.remove('border-slate-200', 'focus:border-slate-900', 'focus:ring-slate-900/10');
            bioInput.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/10');
            if (counter) { counter.classList.add('text-red-500'); counter.classList.remove('text-slate-400'); }
            if (errorMsg) errorMsg.classList.remove('hidden');
            if (hintMsg) hintMsg.classList.add('hidden');
        } else {
            bioInput.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/10');
            bioInput.classList.add('border-slate-200', 'focus:border-slate-900', 'focus:ring-slate-900/10');
            if (counter) { counter.classList.remove('text-red-500'); counter.classList.add('text-slate-400'); }
            if (errorMsg) errorMsg.classList.add('hidden');
            if (hintMsg) hintMsg.classList.remove('hidden');
        }
        
        // Validation length check for Name
        const nameLen = nameInput.value.length;
        const nameCounter = document.getElementById('nameCounter');
        const nameErrorMsg = document.getElementById('nameError');
        const nameHintMsg = document.getElementById('nameHint');
        
        if (nameCounter) nameCounter.innerText = nameLen + '/60 karakter';
        
        let hasNameError = false;
        let nameErrMsg = '';
        
        if (nameLen > 60) {
            hasNameError = true;
            nameErrMsg = 'Maksimal 60 karakter.';
        } else if (nameLen > 0 && nameLen < 2) {
            hasNameError = true;
            nameErrMsg = 'Nama minimal 2 karakter.';
        } else if (nameInput.value.trim() && !/^[a-zA-Z\s]+$/.test(nameInput.value)) {
            hasNameError = true;
            nameErrMsg = 'Nama hanya boleh mengandung huruf.';
        }
        
        if (hasNameError) {
            nameInput.classList.remove('border-slate-200', 'focus:border-slate-900', 'focus:ring-slate-900/10');
            nameInput.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/10');
            if (nameCounter) { nameCounter.classList.add('text-red-500'); nameCounter.classList.remove('text-slate-400'); }
            if (nameErrorMsg) {
                nameErrorMsg.innerText = nameErrMsg;
                nameErrorMsg.classList.remove('hidden');
            }
            if (nameHintMsg) nameHintMsg.classList.add('hidden');
        } else {
            nameInput.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/10');
            nameInput.classList.add('border-slate-200', 'focus:border-slate-900', 'focus:ring-slate-900/10');
            if (nameCounter) { nameCounter.classList.remove('text-red-500'); nameCounter.classList.add('text-slate-400'); }
            if (nameErrorMsg) nameErrorMsg.classList.add('hidden');
            if (nameHintMsg) nameHintMsg.classList.remove('hidden');
        }
    }

    nameInput.addEventListener('input', updatePreview);
    emailInput.addEventListener('input', updatePreview);
    phoneInput.addEventListener('input', updatePreview);
    locationInput.addEventListener('input', updatePreview);
    bioInput.addEventListener('input', updatePreview);
    
    // Initial call to set bio counter
    updatePreview();

    photoInput.addEventListener('change', function () {
        const file = this.files?.[0];
        if (!file) {
            if (previewAvatar.src) {
                if (previewAvatar.src.includes('data:')) {
                    previewAvatar.classList.add('hidden');
                    previewInitials.classList.remove('hidden');
                } else {
                    previewAvatar.classList.toggle('hidden', !previewAvatar.src);
                    previewInitials.classList.toggle('hidden', !!previewAvatar.src);
                }
            }
            return;
        }

        const allowedExtensions = ['image/jpeg', 'image/png', 'image/jpg'];
        let errorMsg = null;
        
        if (!allowedExtensions.includes(file.type)) {
            errorMsg = 'Format foto profil harus JPG, JPEG, atau PNG.';
        } else if (file.size > 2 * 1024 * 1024) {
            errorMsg = 'Ukuran foto maksimal 2MB';
        }

        if (errorMsg) {
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: `<ul class="text-left list-disc list-inside text-sm"><li>${errorMsg}</li></ul>`,
                confirmButtonColor: '#0f172a'
            });
            this.value = ''; // Clear the invalid file
            return;
        }

        const reader = new FileReader();
        reader.onload = function (event) {
            previewAvatar.src = event.target.result;
            previewAvatar.classList.remove('hidden');
            previewInitials.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    });

    const educationSection = document.getElementById('educationSection');
    const experienceSection = document.getElementById('experienceSection');
    const skillSection = document.getElementById('skillSection');

    const initialEducations = @json(old('pendidikan', $profile?->education ?? []));
    const initialExperiences = @json(old('pengalaman', $profile?->experience ?? []));
    const initialSkills = @json(old('skills', $profile?->skills ?? []));

    let educationCount = 0;
    let experienceCount = 0;
    let skillCount = 0;

    function escAttr(value) {
        return String(value ?? '').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    function escHtml(value) {
        return String(value ?? '').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    function handleDescInput(textarea, index) {
        const len = textarea.value.length;
        const counter = document.getElementById('counter-' + index);
        const errorMsg = document.getElementById('error-desc-' + index);
        
        if (counter) counter.innerText = len + '/500 karakter';
        
        if (len > 500) {
            textarea.classList.remove('border-slate-200', 'focus:border-slate-900', 'focus:ring-slate-900/10');
            textarea.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/10');
            if (counter) { counter.classList.add('text-red-500'); counter.classList.remove('text-slate-400'); }
            if (errorMsg) errorMsg.classList.remove('hidden');
        } else {
            textarea.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/10');
            textarea.classList.add('border-slate-200', 'focus:border-slate-900', 'focus:ring-slate-900/10');
            if (counter) { counter.classList.remove('text-red-500'); counter.classList.add('text-slate-400'); }
            if (errorMsg) errorMsg.classList.add('hidden');
        }
    }

    function removeBlock(id) {
        const block = document.getElementById(id);
        if (block) {
            block.remove();
        }
    }

    function addEducation(data = {}) {
        const index = educationCount++;
        const wrapper = document.createElement('div');
        wrapper.id = `education-${index}`;
        wrapper.className = 'rounded-3xl border border-slate-200 bg-slate-50 p-4';
        wrapper.innerHTML = `
            <div class="flex items-start justify-between gap-3 mb-4">
                <div>
                    <div class="text-sm font-semibold text-slate-900">Pendidikan ${index + 1}</div>
                    <div class="text-sm text-slate-500">Masukkan institusi, gelar, dan tahun kelulusan.</div>
                </div>
                <button type="button" class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700 hover:bg-red-100" onclick="removeBlock('education-${index}')">Hapus</button>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <label class="space-y-2 text-sm">
                    <span class="text-slate-600">Institusi</span>
                    <input name="pendidikan[${index}][institusi]" required maxlength="100" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900" placeholder="Universitas Indonesia" value="${escAttr(data.institusi || '')}" oninvalid="this.setCustomValidity('Institusi pendidikan wajib di isi.')" oninput="this.setCustomValidity('')" />
                    <p class="text-xs text-slate-500 mt-1">Maksimal 100 karakter.</p>
                </label>
                <label class="space-y-2 text-sm">
                    <span class="text-slate-600">Gelar</span>
                    <input name="pendidikan[${index}][gelar]" required maxlength="100" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900" placeholder="Sarjana Teknik Informatika" value="${escAttr(data.gelar || '')}" oninvalid="this.setCustomValidity('Gelar pendidikan wajib di isi.')" oninput="this.setCustomValidity('')" />
                    <p class="text-xs text-slate-500 mt-1">Maksimal 100 karakter.</p>
                </label>
            </div>
            <label class="mt-4 space-y-2 text-sm block">
                <span class="text-slate-600">Tahun / Periode</span>
                <input name="pendidikan[${index}][tahun]" required class="w-full max-w-md rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900" placeholder="2019-2023" value="${escAttr(data.tahun || '')}" oninvalid="this.setCustomValidity('Tahun pendidikan wajib di isi.')" oninput="this.setCustomValidity('')" />
                <p class="text-xs text-slate-500 mt-1">Format: YYYY-YYYY (contoh: 2019-2023).</p>
            </label>
        `;
        educationSection.appendChild(wrapper);
    }

    function addExperience(data = {}) {
        const index = experienceCount++;
        const wrapper = document.createElement('div');
        wrapper.id = `experience-${index}`;
        wrapper.className = 'rounded-3xl border border-slate-200 bg-slate-50 p-4';
        wrapper.innerHTML = `
            <div class="flex items-start justify-between gap-3 mb-4">
                <div>
                    <div class="text-sm font-semibold text-slate-900">Pengalaman ${index + 1}</div>
                    <div class="text-sm text-slate-500">Masukkan posisi, perusahaan, periode, dan deskripsi tugas.</div>
                </div>
                <button type="button" class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700 hover:bg-red-100" onclick="removeBlock('experience-${index}')">Hapus</button>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <label class="space-y-2 text-sm">
                    <span class="text-slate-600">Posisi</span>
                    <input name="pengalaman[${index}][posisi]" required maxlength="100" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900" placeholder="Frontend Developer" value="${escAttr(data.posisi || '')}" oninvalid="this.setCustomValidity('Posisi wajib di isi.')" oninput="this.setCustomValidity('')" />
                    <p class="text-xs text-slate-500 mt-1">Maksimal 100 karakter.</p>
                </label>
                <label class="space-y-2 text-sm">
                    <span class="text-slate-600">Perusahaan</span>
                    <input name="pengalaman[${index}][perusahaan]" required maxlength="100" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900" placeholder="Tech Startup Indonesia" value="${escAttr(data.perusahaan || '')}" oninvalid="this.setCustomValidity('Perusahaan wajib di isi.')" oninput="this.setCustomValidity('')" />
                    <p class="text-xs text-slate-500 mt-1">Maksimal 100 karakter.</p>
                </label>
            </div>
            <label class="mt-4 space-y-2 text-sm block">
                <span class="text-slate-600">Periode</span>
                <input name="pengalaman[${index}][periode]" required class="w-full max-w-md rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900" placeholder="Jun 2022 - Des 2022" value="${escAttr(data.periode || '')}" oninvalid="this.setCustomValidity('Periode kerja wajib di isi.')" oninput="this.setCustomValidity('')" />
                <p class="text-xs text-slate-500 mt-1">Format: MMM YYYY - MMM YYYY (contoh: Jun 2022 - Jul 2026).</p>
            </label>
            <label class="mt-4 space-y-2 text-sm block">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-slate-600">Deskripsi Pekerjaan</span>
                    <span class="text-xs text-slate-400" id="counter-${index}">${data.deskripsi ? data.deskripsi.length : 0}/500 karakter</span>
                </div>
                <textarea name="pengalaman[${index}][deskripsi]" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/10" rows="3" placeholder="Tuliskan tanggung jawab dan pencapaian utama..." oninput="handleDescInput(this, ${index})">${escHtml(data.deskripsi || '')}</textarea>
                <p id="error-desc-${index}" class="hidden text-xs text-red-500 mt-1">Maksimal 500 karakter.</p>
            </label>
        `;
        experienceSection.appendChild(wrapper);
    }

    function addSkill(data = '') {
        const index = skillCount++;
        const wrapper = document.createElement('div');
        wrapper.id = `skill-${index}`;
        wrapper.className = 'flex items-center gap-3 rounded-3xl border border-slate-200 bg-slate-50 p-4';
        wrapper.innerHTML = `
            <div class="flex-1 space-y-2 text-sm">
                <label class="block">
                    <span class="text-slate-600">Skill ${index + 1}</span>
                    <input name="skills[${index}]" type="text" value="${escAttr(data)}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/10" placeholder="Contoh: JavaScript" />
                </label>
            </div>
            <button type="button" class="inline-flex items-center rounded-full bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-100" onclick="removeBlock('skill-${index}')">Hapus</button>
        `;
        skillSection.appendChild(wrapper);
    }

    function renderInitialCvSections() {
        if (Array.isArray(initialEducations) && initialEducations.length) {
            initialEducations.forEach(item => addEducation(item));
        } else {
            addEducation();
        }

        if (Array.isArray(initialExperiences) && initialExperiences.length) {
            initialExperiences.forEach(item => addExperience(item));
        } else {
            addExperience();
        }

        if (Array.isArray(initialSkills) && initialSkills.length) {
            initialSkills.forEach(item => addSkill(item));
        } else {
            addSkill();
        }
    }

    renderInitialCvSections();

    // Validasi Form & SweetAlert
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const name = document.getElementById('nameInput').value.trim();
        const email = document.getElementById('emailInput').value.trim();
        const phone = document.getElementById('phoneInput').value.trim();
        const location = document.getElementById('locationInput').value.trim();
        const bio = document.getElementById('bioInput').value.trim();
        const photo = document.getElementById('photoInput').files[0];
        
        let errors = [];

        if (name.length === 0) {
            errors.push('Nama lengkap wajib diisi.');
        } else if (name.length < 2) {
            errors.push('Nama minimal 2 karakter.');
        } else if (name.length > 60) {
            errors.push('Nama lengkap maksimal 60 karakter.');
        } else if (!/^[a-zA-Z\s]+$/.test(name)) {
            errors.push('Nama hanya boleh mengandung huruf.');
        }

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email.length === 0) {
            errors.push('Email wajib diisi.');
        } else if (!emailPattern.test(email)) {
            errors.push('Format email tidak valid.');
        }

        if (phone.length === 0) {
            errors.push('Nomor handphone tidak boleh kosong.');
        } else if (phone.length < 10) {
            errors.push('Nomor telepon minimal 10 digit.');
        } else if (phone.length > 13) {
            errors.push('Nomor telepon maksimal 13 digit.');
        } else {
            const phonePattern = /^08[0-9]{8,11}$/;
            if (!phonePattern.test(phone)) {
                errors.push('Nomor telepon harus diawali dengan 08 dan hanya terdiri dari angka.');
            }
        }

        if (location.length > 100) {
            errors.push('Lokasi maksimal 100 karakter.');
        }

        if (bio.length > 500) {
            errors.push('Bio maksimal 500 karakter.');
        }

        if (photo) {
            const allowedExtensions = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!allowedExtensions.includes(photo.type)) {
                errors.push('Format foto profil harus JPG, JPEG, atau PNG.');
            } else if (photo.size > 2 * 1024 * 1024) {
                errors.push('Ukuran foto maksimal 2MB');
            }
        }

        const institusis = document.querySelectorAll('input[name^="pendidikan"][name$="[institusi]"]');
        const gelars = document.querySelectorAll('input[name^="pendidikan"][name$="[gelar]"]');
        const tahuns = document.querySelectorAll('input[name^="pendidikan"][name$="[tahun]"]');

        institusis.forEach(input => {
            if(input.value.length > 100) errors.push('Nama institusi maksimal 100 karakter.');
        });
        gelars.forEach(input => {
            if(input.value.length > 100) errors.push('Nama gelar maksimal 100 karakter.');
        });
        tahuns.forEach(input => {
            if(!/^\d{4}-\d{4}$/.test(input.value)) errors.push('Format periode pendidikan harus YYYY-YYYY (contoh: 2019-2023).');
        });

        const posisis = document.querySelectorAll('input[name^="pengalaman"][name$="[posisi]"]');
        const perusahaans = document.querySelectorAll('input[name^="pengalaman"][name$="[perusahaan]"]');
        const periodes = document.querySelectorAll('input[name^="pengalaman"][name$="[periode]"]');
        const deskripsis = document.querySelectorAll('textarea[name^="pengalaman"][name$="[deskripsi]"]');

        posisis.forEach(input => {
            if(input.value.length > 100) errors.push('Nama posisi maksimal 100 karakter.');
        });
        perusahaans.forEach(input => {
            if(input.value.length > 100) errors.push('Nama perusahaan maksimal 100 karakter.');
        });
        periodes.forEach(input => {
            if(!/^[a-zA-Z]{3} \d{4} - [a-zA-Z]{3} \d{4}$/.test(input.value)) errors.push('Format periode kerja harus MMM YYYY - MMM YYYY (contoh: Jun 2022 - Jul 2026).');
        });
        deskripsis.forEach(input => {
            if(input.value.length > 500) errors.push('Deskripsi pekerjaan maksimal 500 karakter.');
        });

        if (errors.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: '<ul class="text-left list-disc list-inside text-sm">' + errors.map(err => `<li>${err}</li>`).join('') + '</ul>',
                confirmButtonColor: '#0f172a'
            });
        } else {
            this.submit();
        }
    });

    // Menampilkan error dari backend menggunakan SweetAlert (jika ada)
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal',
            html: '<ul class="text-left list-disc list-inside text-sm">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#0f172a'
        });
    @endif
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
