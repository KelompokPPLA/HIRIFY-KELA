@extends('layouts.mentor')

@section('title', 'Pengaturan Profil')

@push('styles')
<style>
        :root {
            --bg: #f3f7fc;
            --paper: #ffffff;
            --ink: #0f172a;
            --muted: #64748b;
            --line: rgba(15, 23, 42, 0.1);
            --navy: #0f1b39;
            --navy-soft: #17274f;
            --cyan: #26c6da;
            --cyan-2: #1aa8c0;
            --chip: #d8f6fb;
            --danger: #b42318;
            --ring: rgba(38, 198, 218, 0.2);
            --shadow: 0 22px 48px rgba(15, 23, 42, 0.08);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background: var(--bg);
        }

        .app {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 246px 1fr;
        }

        .sidebar {
            background: #f7fbff;
            border-right: 1px solid var(--line);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            position: sticky;
            top: 0;
        }

        .sidebar-top {
            padding: 20px 16px;
            border-bottom: 1px solid var(--line);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 1.12rem;
            margin-bottom: 16px;
        }

        .brand-mark {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            color: #fff;
            font-size: 17px;
            font-weight: 800;
            background: linear-gradient(145deg, #0399b7, #06d8ee);
        }

        .panel-pill {
            width: 100%;
            border: 0;
            border-radius: 10px;
            padding: 8px 10px;
            background: #dff1f9;
            color: #06a9bf;
            text-transform: uppercase;
            letter-spacing: .04em;
            font-weight: 800;
            font-size: .76rem;
        }

        .nav {
            display: grid;
            gap: 6px;
            padding: 14px 10px;
        }

        .nav-item {
            border: 0;
            background: transparent;
            width: 100%;
            padding: 11px 12px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #0f172a;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
            text-align: left;
        }

        .nav-item svg {
            width: 17px;
            height: 17px;
            color: #0f172a;
            opacity: .82;
            flex: 0 0 auto;
        }

        .nav-item.is-active {
            background: var(--navy);
            color: #fff;
        }

        .nav-item.is-active svg {
            color: #fff;
            opacity: 1;
        }

        .sidebar-bottom {
            margin-top: auto;
            border-top: 1px solid var(--line);
            padding: 14px 10px;
        }

        .mini-user {
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: 12px;
            background: #eef6ff;
            padding: 10px;
        }

        .mini-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: #fff;
            font-weight: 800;
            background: linear-gradient(135deg, #1f3057 0%, #1bc2d5 100%);
        }

        .mini-user strong {
            font-size: .92rem;
            line-height: 1.1;
            display: block;
        }

        .mini-user span {
            font-size: .82rem;
            color: var(--muted);
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        .main {
            padding: 24px 30px;
        }

        .page-head h1 {
            margin: 0;
            font-size: clamp(1.7rem, 2.5vw, 2.15rem);
            letter-spacing: -0.03em;
        }

        .page-head p {
            margin: 6px 0 0;
            color: var(--muted);
            font-weight: 500;
        }

        .layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 310px;
            gap: 22px;
            margin-top: 18px;
            align-items: start;
        }

        .stack {
            display: grid;
            gap: 16px;
        }

        .card {
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: var(--shadow);
            padding: 18px;
        }

        .card h2 {
            margin: 0 0 14px;
            font-size: 1.05rem;
            letter-spacing: -0.02em;
        }

        .grid {
            display: grid;
            gap: 12px;
        }

        .grid-two {
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        label {
            display: block;
            margin: 0 0 6px;
            font-size: .87rem;
            font-weight: 700;
        }

        input,
        textarea {
            width: 100%;
            border: 1px solid #d6deea;
            background: #f8fbff;
            border-radius: 11px;
            padding: 10px 12px;
            font: inherit;
            color: var(--ink);
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        textarea {
            min-height: 94px;
            resize: vertical;
            line-height: 1.5;
        }

        input:focus,
        textarea:focus {
            border-color: var(--cyan);
            box-shadow: 0 0 0 4px var(--ring);
        }

        .chip-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 10px;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 10px;
            border: 1px solid rgba(38, 198, 218, 0.32);
            background: var(--chip);
            color: #089db0;
            font-size: .86rem;
            font-weight: 700;
            padding: 7px 11px;
        }

        .chip button {
            border: 0;
            background: transparent;
            color: #089db0;
            font: inherit;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        .chip-input-row {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 8px;
        }

        .cert-panel {
            display: grid;
            gap: 12px;
        }

        .cert-upload {
            display: grid;
            gap: 10px;
            padding: 14px;
            border-radius: 14px;
            border: 1px dashed rgba(38, 198, 218, 0.35);
            background: #f7feff;
        }

        .cert-upload-row {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;
        }

        .cert-list {
            display: grid;
            gap: 10px;
        }

        .cert-item {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 12px;
            align-items: center;
            padding: 12px 14px;
            border-radius: 14px;
            border: 1px solid #dbe5f0;
            background: #fbfdff;
        }

        .cert-item strong {
            display: block;
            font-size: .95rem;
            margin-bottom: 3px;
        }

        .cert-item small {
            color: var(--muted);
        }

        .cert-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .cert-actions .btn {
            padding: 9px 12px;
            border-radius: 10px;
            font-size: .86rem;
        }

        .btn {
            border: 0;
            border-radius: 11px;
            padding: 11px 15px;
            font: inherit;
            font-weight: 800;
            cursor: pointer;
            transition: transform .16s ease, box-shadow .16s ease;
            white-space: nowrap;
        }

        .btn:hover { transform: translateY(-1px); }

        .btn-primary {
            color: #fff;
            background: linear-gradient(135deg, var(--cyan) 0%, var(--cyan-2) 100%);
            box-shadow: 0 12px 24px rgba(38, 198, 218, 0.25);
        }

        .btn-dark {
            color: #fff;
            background: #08153a;
            box-shadow: 0 12px 24px rgba(8, 21, 58, 0.25);
        }

        .btn-ghost {
            color: #24324f;
            background: #edf2fa;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 4px;
        }

        .preview {
            position: sticky;
            top: 22px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: var(--shadow);
            padding: 20px;
        }

        .preview h3 {
            margin: 0 0 14px;
            font-size: 1rem;
        }

        .avatar-wrap {
            position: relative;
            width: 112px;
            margin: 0 auto 12px;
        }

        .avatar {
            width: 112px;
            height: 112px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1f3057 0%, #1bc2d5 100%);
            color: #fff;
            font-size: 2rem;
            font-weight: 800;
            display: grid;
            place-items: center;
            overflow: hidden;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .camera-btn {
            position: absolute;
            right: 0;
            bottom: 6px;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 0;
            background: linear-gradient(135deg, var(--cyan) 0%, var(--cyan-2) 100%);
            color: #fff;
            display: grid;
            place-items: center;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(38, 198, 218, 0.3);
        }

        .preview-name {
            text-align: center;
            margin: 0;
            font-size: 1.38rem;
            letter-spacing: -0.02em;
        }

        .preview-email {
            margin: 4px 0 14px;
            text-align: center;
            color: var(--muted);
            font-size: .92rem;
        }

        .preview-divider {
            height: 1px;
            background: var(--line);
            margin: 14px 0;
        }

        .preview-item {
            margin: 0 0 12px;
        }

        .preview-item label {
            margin-bottom: 2px;
            color: var(--muted);
            font-weight: 600;
        }

        .preview-item p {
            margin: 0;
            font-weight: 700;
            line-height: 1.4;
        }

        .preview-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 4px;
        }

        .preview-chip {
            font-size: .76rem;
            padding: 3px 9px;
            border-radius: 999px;
            background: #dff5fa;
            color: #0ea4b8;
            font-weight: 800;
        }

        .hidden {
            display: none;
        }

        @media (max-width: 1100px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .preview {
                position: static;
            }
        }

        @media (max-width: 860px) {
            .app {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
                min-height: auto;
            }

            .sidebar-bottom {
                display: none;
            }

            .main {
                padding: 18px 14px 30px;
            }

            .grid-two {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
<main class="main">
            <header class="page-head">
                <h1>Pengaturan Profil</h1>
                <p>Kelola informasi profil mentor Anda secara profesional.</p>
            </header>

            <div class="layout">
                <section class="stack">
                    <form id="profileForm" class="stack">
                        <article class="card">
                            <h2>Informasi Pribadi</h2>
                            <div class="grid">
                                <div>
                                    <label for="name">Nama Lengkap</label>
                                    <input id="name" name="name" required>
                                </div>
                                <div class="grid-two">
                                    <div>
                                        <label for="email">Email</label>
                                        <input id="email" name="email" type="email" required>
                                    </div>
                                    <div>
                                        <label for="phone_number">Nomor Telepon</label>
                                        <input id="phone_number" name="phone_number" placeholder="+62 8xxx xxxx xxxx">
                                    </div>
                                </div>
                            </div>
                        </article>

                        <article class="card">
                            <h2>Informasi Profesional</h2>
                            <div class="grid">
                                <div>
                                    <label for="expertise">Bidang Keahlian</label>
                                    <input id="expertise" name="expertise" placeholder="UI/UX Design & Frontend Development" required>
                                </div>
                                <div>
                                    <label for="experience_years">Pengalaman (tahun)</label>
                                    <input id="experience_years" name="experience_years" type="number" min="0" max="60" placeholder="8">
                                </div>
                                <div>
                                    <label for="bio">Bio</label>
                                    <textarea id="bio" name="bio" placeholder="Ceritakan latar belakang, fokus mentoring, dan pengalaman profesional Anda."></textarea>
                                </div>
                            </div>
                        </article>

                        <article class="card">
                            <h2>Pendidikan</h2>
                            <div class="grid">
                                <div>
                                    <label for="education">Pendidikan</label>
                                    <input id="education" name="education" placeholder="S1 Teknik Informatika - Universitas Indonesia">
                                </div>
                            </div>
                        </article>

                        <article class="card">
                            <h2>Riwayat Sertifikasi</h2>
                            <div class="cert-panel">
                                <div class="cert-upload">
                                    <div class="cert-upload-row">
                                        <div>
                                            <label for="certTitleInput">Judul Sertifikat</label>
                                            <input id="certTitleInput" placeholder="Contoh: Certified UX Designer">
                                        </div>
                                        <div style="align-self:end;">
                                            <button class="btn btn-primary" type="button" id="addCertBtn">Upload Sertifikat</button>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="certFileInput">File Sertifikat</label>
                                        <input id="certFileInput" type="file" accept="application/pdf,image/png,image/jpeg,image/webp">
                                        <small style="color:var(--muted); display:block; margin-top:6px;">Format yang didukung: PDF, JPG, JPEG, PNG, WEBP. Maks 5 MB.</small>
                                    </div>
                                </div>

                                <div id="certList" class="cert-list"></div>
                            </div>
                        </article>

                        <article class="card">
                            <h2>Skills</h2>
                            <div id="skillList" class="chip-list"></div>
                            <div class="chip-input-row">
                                <input id="skillInput" placeholder="Tambah skill baru">
                                <button class="btn btn-primary" type="button" id="addSkillBtn">+ Tambah</button>
                            </div>
                        </article>

                        <article class="card">
                            <h2>Ketersediaan & Tarif</h2>
                            <div class="grid">
                                <div>
                                    <label for="availability">Waktu Tersedia</label>
                                    <input id="availability" name="availability" placeholder="Senin - Jumat, 18:00 - 21:00">
                                </div>
                                <div>
                                    <label for="price_per_session">Tarif per Sesi (Rp)</label>
                                    <input id="price_per_session" name="price_per_session" type="number" min="0" step="1000" placeholder="150000">
                                </div>
                            </div>
                        </article>

                        <div class="actions">
                            <button class="btn btn-ghost" type="button" id="resetBtn">Batal</button>
                            <button class="btn btn-dark" type="submit" id="saveBtn">Simpan Perubahan</button>
                        </div>
                    </form>
                </section>

                <aside class="preview">
                    <h3>Preview Profil</h3>

                    <div class="avatar-wrap">
                        <div class="avatar" id="previewAvatar">M</div>
                        <button class="camera-btn" type="button" id="avatarBtn" aria-label="Ubah avatar">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                                <circle cx="12" cy="13" r="4"/>
                            </svg>
                        </button>
                        <input class="hidden" id="avatarInput" type="file" accept="image/png,image/jpeg,image/webp">
                    </div>

                    <h4 class="preview-name" id="previewName">Mentor Name</h4>
                    <p class="preview-email" id="previewEmail">mentor@hirify.com</p>
                    <div class="preview-divider"></div>

                    <div class="preview-item">
                        <label>Keahlian</label>
                        <p id="previewExpertise">-</p>
                    </div>

                    <div class="preview-item">
                        <label>Pengalaman</label>
                        <p id="previewExperience">0 tahun</p>
                    </div>

                    <div class="preview-item">
                        <label>Skills</label>
                        <div id="previewSkills" class="preview-chips"></div>
                    </div>

                    <div class="preview-item">
                        <label>Sertifikasi</label>
                        <div id="previewCerts" class="preview-chips"></div>
                    </div>

                    <div class="preview-item">
                        <label>Tarif</label>
                        <p id="previewPrice">Rp 0 / sesi</p>
                    </div>
                </aside>
            </div>
        </main>
    </div>

    <script>
        const showToast = window.hirifyShowToast;

        let token = localStorage.getItem('hirify_token') || sessionStorage.getItem('hirify_token');
        const activeStorage = localStorage.getItem('hirify_token') ? localStorage : sessionStorage;
        let profileCache = null;

        if (!token) {
            window.location.href = '/login';
        }

        const skillsState = [];
        let certificationsState = [];

        const profileForm = document.getElementById('profileForm');
        const saveBtn = document.getElementById('saveBtn');
        const resetBtn = document.getElementById('resetBtn');
        const addSkillBtn = document.getElementById('addSkillBtn');
        const addCertBtn = document.getElementById('addCertBtn');
        const skillInput = document.getElementById('skillInput');
        const certTitleInput = document.getElementById('certTitleInput');
        const certFileInput = document.getElementById('certFileInput');
        const skillList = document.getElementById('skillList');
        const certList = document.getElementById('certList');
        const avatarBtn = document.getElementById('avatarBtn');
        const avatarInput = document.getElementById('avatarInput');
        const navDashboard = document.getElementById('navDashboard');

        const fields = {
            name: document.getElementById('name'),
            email: document.getElementById('email'),
            phone_number: document.getElementById('phone_number'),
            expertise: document.getElementById('expertise'),
            experience_years: document.getElementById('experience_years'),
            bio: document.getElementById('bio'),
            education: document.getElementById('education'),
            availability: document.getElementById('availability'),
            price_per_session: document.getElementById('price_per_session'),
        };

        const preview = {
            avatar: document.getElementById('previewAvatar'),
            name: document.getElementById('previewName'),
            email: document.getElementById('previewEmail'),
            expertise: document.getElementById('previewExpertise'),
            experience: document.getElementById('previewExperience'),
            skills: document.getElementById('previewSkills'),
            certs: document.getElementById('previewCerts'),
            price: document.getElementById('previewPrice'),
            miniName: document.getElementById('miniName'),
            miniEmail: document.getElementById('miniEmail'),
            miniAvatar: document.getElementById('miniAvatar'),
        };

        function clearAuthStorage() {
            localStorage.removeItem('hirify_token');
            localStorage.removeItem('hirify_user');
            sessionStorage.removeItem('hirify_token');
            sessionStorage.removeItem('hirify_user');
            localStorage.removeItem('hirify_remember');
        }

        function formatRupiah(value) {
            const numeric = Number(value || 0);
            return new Intl.NumberFormat('id-ID').format(Number.isFinite(numeric) ? numeric : 0);
        }

        function addUniqueItem(target, rawValue) {
            const value = (rawValue || '').trim();
            if (!value) {
                return;
            }

            if (target.some((item) => item.toLowerCase() === value.toLowerCase())) {
                return;
            }

            target.push(value);
        }

        function removeItem(target, index) {
            target.splice(index, 1);
        }

        function renderChips(target, container, className, onRemove) {
            container.innerHTML = '';

            target.forEach((item, index) => {
                const chip = document.createElement('div');
                chip.className = className;
                chip.innerHTML = `<span>${item}</span><button type="button" aria-label="Hapus">x</button>`;
                chip.querySelector('button').addEventListener('click', () => {
                    onRemove(index);
                });
                container.appendChild(chip);
            });
        }

        function syncSkillViews() {
            renderChips(skillsState, skillList, 'chip', (index) => {
                removeItem(skillsState, index);
                syncSkillViews();
            });

            preview.skills.innerHTML = '';

            skillsState.forEach((item) => {
                const chip = document.createElement('span');
                chip.className = 'preview-chip';
                chip.textContent = item;
                preview.skills.appendChild(chip);
            });
        }

        function syncCertViews() {
            certList.innerHTML = '';
            preview.certs.innerHTML = '';

            certificationsState.forEach((item, index) => {
                const cert = document.createElement('div');
                cert.className = 'cert-item';
                cert.innerHTML = `
                    <div>
                        <strong>${item.title}</strong>
                        <small>${item.file_name || 'Sertifikat'}</small>
                    </div>
                    <div class="cert-actions">
                        ${item.file_url ? `<a class="btn btn-ghost" href="${item.file_url}" target="_blank" rel="noopener noreferrer">Lihat File</a>` : ''}
                        <button class="btn btn-ghost" type="button">Hapus</button>
                    </div>
                `;

                cert.querySelector('button').addEventListener('click', () => {
                    removeCertification(index);
                });

                certList.appendChild(cert);

                const chip = document.createElement('span');
                chip.className = 'preview-chip';
                chip.textContent = item.title;
                preview.certs.appendChild(chip);
            });
        }

        async function removeCertification(index) {
            const item = certificationsState[index];

            if (!item) {
                return;
            }

            if (!item.id) {
                certificationsState.splice(index, 1);
                syncCertViews();
                return;
            }

            try {
                await api(`/api/mentor/certifications/${item.id}`, {
                    method: 'DELETE',
                });

                certificationsState.splice(index, 1);
                syncCertViews();
                showToast('Sertifikat berhasil dihapus.', 'success');
            } catch (error) {
                showToast(error.message || 'Gagal menghapus sertifikat.', 'error');
            }
        }

        function syncPreviewFromInputs() {
            const name = fields.name.value.trim() || 'Mentor Name';
            const email = fields.email.value.trim() || 'mentor@hirify.com';
            const expertise = fields.expertise.value.trim() || '-';
            const years = Number(fields.experience_years.value || 0);
            const price = Number(fields.price_per_session.value || 0);

            preview.name.textContent = name;
            preview.email.textContent = email;
            preview.expertise.textContent = expertise;
            preview.experience.textContent = `${Number.isFinite(years) ? years : 0} tahun`;
            preview.price.textContent = `Rp ${formatRupiah(price)} / sesi`;

            const initial = (name[0] || 'M').toUpperCase();
            if (!preview.avatar?.querySelector('img')) {
                if (preview.avatar) preview.avatar.textContent = initial;
            }
            if (preview.miniAvatar) preview.miniAvatar.textContent = initial;
            if (preview.miniName) preview.miniName.textContent = name;
            if (preview.miniEmail) preview.miniEmail.textContent = email;
        }

        function fillForm(data) {
            fields.name.value = data.name || '';
            fields.email.value = data.email || '';
            fields.phone_number.value = data.phone_number || '';
            fields.expertise.value = data.expertise || '';
            fields.experience_years.value = data.experience_years ?? '';
            fields.bio.value = data.bio || '';
            fields.education.value = data.education || '';
            fields.availability.value = data.availability || '';
            fields.price_per_session.value = data.price_per_session ?? '';

            skillsState.splice(0, skillsState.length, ...(data.skills || []));
            certificationsState = [];

            syncSkillViews();
            syncCertViews();

            if (preview.avatar) {
                if (data.avatar_url) {
                    preview.avatar.innerHTML = `<img src="${data.avatar_url}" alt="Avatar mentor">`;
                } else {
                    preview.avatar.innerHTML = '';
                    preview.avatar.textContent = (data.name?.[0] || 'M').toUpperCase();
                }
            }

            syncPreviewFromInputs();
        }

        async function loadCertifications() {
            try {
                const response = await api('/api/mentor/certifications');
                certificationsState = Array.isArray(response.data) ? [...response.data] : [];
                syncCertViews();
            } catch (error) {
                showToast(error.message || 'Gagal memuat riwayat sertifikasi.', 'error');
            }
        }

        async function refreshToken() {
            if (!token) {
                return false;
            }

            try {
                const response = await fetch('/api/auth/refresh', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`,
                    },
                });

                const result = await response.json();

                if (!response.ok || result.success === false || !result?.data?.token) {
                    return false;
                }

                token = result.data.token;
                activeStorage.setItem('hirify_token', token);

                if (result.data.user) {
                    activeStorage.setItem('hirify_user', JSON.stringify(result.data.user));
                }

                return true;
            } catch (_) {
                return false;
            }
        }

        async function api(path, options = {}, canRetry = true) {
            const response = await fetch(path, {
                ...options,
                headers: {
                    'Accept': 'application/json',
                    ...(options.body instanceof FormData ? {} : { 'Content-Type': 'application/json' }),
                    'Authorization': `Bearer ${token}`,
                    ...(options.headers || {}),
                },
            });

            let data = {};
            try {
                data = await response.json();
            } catch (_) {
                data = {};
            }

            if (response.status === 401 && canRetry) {
                const refreshed = await refreshToken();
                if (refreshed) {
                    return api(path, options, false);
                }
            }

            if (!response.ok || data.success === false) {
                throw new Error(data.message || 'Request gagal diproses.');
            }

            return data;
        }

        async function ensureMentorRole() {
            try {
                const me = await api('/api/auth/me');
                const user = me.data;

                if (!user || user.role !== 'mentor') {
                    showToast('Halaman ini hanya untuk mentor.', 'error');
                    setTimeout(() => {
                        window.location.href = '/dashboard';
                    }, 900);
                    return false;
                }

                return true;
            } catch (error) {
                clearAuthStorage();
                window.location.href = '/login';
                return false;
            }
        }

        async function loadProfile() {
            const roleOk = await ensureMentorRole();
            if (!roleOk) {
                return;
            }

            try {
                const response = await api('/api/mentor/profile');
                profileCache = response.data;
                fillForm(response.data);
                await loadCertifications();
            } catch (error) {
                showToast(error.message || 'Gagal memuat profil mentor.', 'error');
            }
        }

        async function saveProfile(event) {
            event.preventDefault();
            saveBtn.disabled = true;

            const payload = {
                name: fields.name.value.trim(),
                email: fields.email.value.trim(),
                phone_number: fields.phone_number.value.trim(),
                expertise: fields.expertise.value.trim(),
                experience_years: fields.experience_years.value ? Number(fields.experience_years.value) : null,
                bio: fields.bio.value.trim(),
                education: fields.education.value.trim(),
                availability: fields.availability.value.trim(),
                price_per_session: fields.price_per_session.value ? Number(fields.price_per_session.value) : null,
                skills: [...skillsState],
            };

            try {
                const response = await api('/api/mentor/profile', {
                    method: 'PUT',
                    body: JSON.stringify(payload),
                });

                profileCache = response.data;
                fillForm(response.data);
                showToast('Profil mentor berhasil diperbarui.', 'success');
            } catch (error) {
                showToast(error.message || 'Gagal menyimpan profil.', 'error');
            } finally {
                saveBtn.disabled = false;
            }
        }

        async function uploadAvatar(file) {
            if (!file) {
                return;
            }

            const data = new FormData();
            data.append('avatar', file);

            try {
                const response = await api('/api/mentor/profile/avatar', {
                    method: 'POST',
                    body: data,
                });

                profileCache = response.data;
                fillForm(response.data);
                showToast('Foto profil berhasil diperbarui.', 'success');
            } catch (error) {
                showToast(error.message || 'Upload avatar gagal.', 'error');
            }
        }

        addSkillBtn.addEventListener('click', () => {
            addUniqueItem(skillsState, skillInput.value);
            skillInput.value = '';
            syncSkillViews();
            syncPreviewFromInputs();
        });

        skillInput.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                addSkillBtn.click();
            }
        });

        addCertBtn.addEventListener('click', async () => {
            const title = certTitleInput.value.trim();
            const file = certFileInput.files?.[0];

            if (!title || !file) {
                showToast('Judul sertifikat dan file wajib diisi.', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('title', title);
            formData.append('certificate_file', file);

            try {
                const response = await api('/api/mentor/certifications', {
                    method: 'POST',
                    body: formData,
                });

                certificationsState.unshift(response.data);
                certTitleInput.value = '';
                certFileInput.value = '';
                syncCertViews();
                showToast('Sertifikasi berhasil diunggah.', 'success');
            } catch (error) {
                showToast(error.message || 'Upload sertifikasi gagal.', 'error');
            }
        });

        Object.values(fields).forEach((input) => {
            input.addEventListener('input', syncPreviewFromInputs);
        });

        profileForm.addEventListener('submit', saveProfile);

        resetBtn.addEventListener('click', () => {
            if (profileCache) {
                fillForm(profileCache);
                showToast('Perubahan belum disimpan dibatalkan.', 'info');
            }
        });

        avatarBtn.addEventListener('click', () => avatarInput.click());
        avatarInput.addEventListener('change', () => uploadAvatar(avatarInput.files?.[0]));

        loadProfile();
    </script>

@endsection


