<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hirify | Buat CV ATS</title>
    <meta name="description" content="Buat CV ATS-friendly yang mudah dibaca oleh Applicant Tracking System">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#f4f8fd;--card:#fff;--ink:#0d1b3d;--muted:#6c7a93;--line:#e5edf6;--brand:#06cbe5;--brand-dark:#06b0c6;--deep:#08152f;--shadow:0 20px 45px rgba(9,20,51,.08)}
        *{box-sizing:border-box;margin:0}
        body{font-family:'Manrope',sans-serif;color:var(--ink);background:radial-gradient(circle at 5% 15%,rgba(6,203,229,.16),transparent 24%),radial-gradient(circle at 95% 5%,rgba(6,203,229,.12),transparent 20%),var(--bg)}
        .layout{min-height:100vh;display:grid;grid-template-columns:250px 1fr}
        /* Sidebar */
        .sidebar{background:#fff;border-right:1px solid var(--line);padding:22px 16px;display:flex;flex-direction:column;gap:18px}
        .brand{display:flex;align-items:center;gap:10px;font-weight:800;font-size:30px;letter-spacing:-.02em}
        .brand-mark{width:34px;height:34px;border-radius:12px;background:linear-gradient(145deg,#0399b7,#06d8ee);display:grid;place-items:center;color:#fff;font-size:17px;font-weight:800}
        .menu{display:grid;gap:8px}
        .menu a{border:0;background:transparent;color:#1a2a4c;font:inherit;text-align:left;border-radius:12px;padding:11px 12px;display:flex;align-items:center;gap:10px;cursor:pointer;font-weight:600;text-decoration:none}
        .menu a:hover{background:#f2f8ff}
        .menu .active{background:linear-gradient(145deg,#0a1632,#111f45);color:#f2fbff;box-shadow:0 10px 20px rgba(11,24,54,.22)}
        .profile-mini{margin-top:auto;background:#f8fbff;border:1px solid var(--line);border-radius:14px;padding:12px;display:flex;align-items:center;gap:10px}
        .avatar-mini{width:34px;height:34px;border-radius:50%;background:linear-gradient(140deg,#0499b3,#05d5ef);color:#fff;display:grid;place-items:center;font-weight:800}
        .profile-mini strong{display:block;font-size:.92rem}
        .profile-mini span{color:var(--muted);font-size:.82rem}
        /* Content */
        .content{padding:24px;overflow-y:auto}
        .title-wrap h1{font-size:clamp(26px,3.5vw,36px);letter-spacing:-.03em}
        .title-wrap p{margin:6px 0 0;color:var(--muted);font-weight:500}
        /* Split layout */
        .split{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:18px;align-items:start}
        /* Form Card */
        .form-card{background:var(--card);border:1px solid var(--line);border-radius:18px;box-shadow:var(--shadow);padding:24px}
        .section-title{font-size:1.05rem;font-weight:800;margin:20px 0 12px;padding-bottom:8px;border-bottom:1px solid var(--line);display:flex;align-items:center;gap:8px}
        .section-title:first-child{margin-top:0}
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
        .form-grid.full{grid-template-columns:1fr}
        label{font-size:.88rem;font-weight:700;color:#1a2a4c;margin-bottom:4px;display:block}
        .required::after{content:' *';color:#e63946}
        .input,.textarea{width:100%;border-radius:12px;border:1px solid #d5e3f1;background:#fff;padding:11px 13px;font:inherit;color:var(--ink);outline:none;transition:border-color .2s,box-shadow .2s}
        .input:focus,.textarea:focus{border-color:var(--brand);box-shadow:0 0 0 4px rgba(6,203,229,.16)}
        .textarea{resize:vertical;min-height:70px}
        .field{display:flex;flex-direction:column}
        .btn{border:0;border-radius:12px;padding:11px 16px;font:inherit;font-weight:700;cursor:pointer;transition:transform .15s,box-shadow .2s;display:inline-flex;align-items:center;gap:8px}
        .btn:hover{transform:translateY(-1px)}
        .btn-brand{background:linear-gradient(140deg,#08cde6,#00b2cb);color:#fff}
        .btn-ghost{background:#f3f8fe;color:#17315f;border:1px solid #dbe8f6}
        .btn-danger-sm{background:none;border:1px solid rgba(180,35,24,.3);color:#b42318;border-radius:10px;padding:7px 12px;font:inherit;font-weight:700;cursor:pointer;font-size:.82rem}
        .btn-add{background:#edfcff;color:#0494ab;border:1px dashed #b0e8f0;border-radius:12px;padding:10px;font:inherit;font-weight:700;cursor:pointer;width:100%;text-align:center;transition:background .2s}
        .btn-add:hover{background:#ddf7fc}
        .repeatable{background:#f8fbff;border:1px solid #e8f0fa;border-radius:14px;padding:14px;margin-bottom:10px;position:relative}
        .repeatable .remove-btn{position:absolute;top:10px;right:10px}
        .btn-submit{width:100%;padding:14px;font-size:1rem;margin-top:16px;background:linear-gradient(140deg,#0a1632,#111f45);color:#fff;box-shadow:0 10px 30px rgba(11,24,54,.22)}
        .error-text{color:#e63946;font-size:.8rem;margin-top:4px}
        /* Preview Panel — clean ATS document */
        .preview-wrap{position:sticky;top:24px}
        .preview-toolbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
        .preview-toolbar h2{font-size:1rem;font-weight:800;color:var(--ink)}
        .ats-badge{background:#edfcff;color:#0494ab;font-size:.72rem;font-weight:800;padding:4px 10px;border-radius:999px;border:1px solid #b0e8f0}
        /* ATS Document — A4 paper feel */
        .cv-doc{background:#fff;padding:40px 36px;max-width:100%;min-height:700px;font-family:'Manrope',Arial,Helvetica,sans-serif;border:1px solid #d0d0d0;box-shadow:0 2px 8px rgba(0,0,0,.06);overflow:hidden;word-break:break-word;overflow-wrap:break-word;white-space:normal}
        .cv-name{text-align:center;font-size:1.25rem;font-weight:800;text-transform:uppercase;letter-spacing:.04em;color:#111;margin-bottom:6px;word-break:break-word}
        .cv-contact{text-align:center;color:#555;font-size:.82rem;line-height:1.6;word-break:break-word;overflow-wrap:break-word}
        .cv-section-title{font-size:.78rem;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:#111;margin:20px 0 6px;padding-bottom:4px;border-bottom:1px solid #333}
        .cv-summary{color:#333;font-size:.84rem;line-height:1.7;text-align:justify;word-break:break-word;overflow-wrap:break-word}
        .cv-edu-item{margin-bottom:10px}
        .cv-edu-row{display:flex;justify-content:space-between;align-items:baseline;gap:12px}
        .cv-edu-left{flex:1;min-width:0}
        .cv-edu-inst{font-weight:700;font-size:.86rem;color:#111;word-break:break-word}
        .cv-edu-degree{color:#444;font-size:.82rem}
        .cv-edu-year{color:#666;font-size:.8rem;white-space:nowrap;flex-shrink:0}
        .cv-exp-item{margin-bottom:12px}
        .cv-exp-header{display:flex;justify-content:space-between;align-items:baseline;flex-wrap:wrap;gap:4px}
        .cv-exp-title{font-weight:700;font-size:.86rem;color:#111;word-break:break-word;overflow-wrap:break-word}
        .cv-exp-period{color:#666;font-size:.8rem;white-space:nowrap}
        .cv-exp-desc{margin:4px 0 0;padding:0;list-style:none}
        .cv-exp-desc li{color:#333;font-size:.82rem;line-height:1.6;padding-left:14px;position:relative;word-break:break-word;overflow-wrap:break-word}
        .cv-exp-desc li::before{content:'\2022';position:absolute;left:0;color:#333}
        .cv-skills-sub{font-weight:600;font-size:.84rem;color:#111;margin:10px 0 4px}
        .cv-skills-sub:first-child{margin-top:0}
        .cv-skills-list{margin:0 0 0 18px;padding:0;list-style:disc;color:#333;font-size:.82rem;line-height:1.7}
        .cv-skills-list li{word-break:break-word}
        .cv-empty{color:#bbb;font-style:italic;font-size:.82rem}
        @media(max-width:1100px){.split{grid-template-columns:1fr}.preview-wrap{position:static}}
        @media(max-width:980px){.layout{grid-template-columns:1fr}.sidebar{border-right:0;border-bottom:1px solid var(--line)}}
        @media(max-width:640px){.content{padding:14px}.form-grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <div class="brand"><span class="brand-mark">H</span><span>Hirify!</span></div>
        <div class="menu">
            <a href="/dashboard">Dashboard</a>
            <a href="#">Profil</a>
            <a href="/cv">Manajemen CV</a>
            <a href="/cv/create" class="active">✦ Buat CV ATS</a>
            <a href="#">Roadmap Karier</a>
            <a href="#">Self Assessment</a>
            <a href="#">Pelatihan</a>
            <a href="/mentorship">Mentorship</a>
            <a href="#">Notifikasi</a>
        </div>
        <div class="profile-mini">
            <div class="avatar-mini">U</div>
            <div><strong>User Name</strong><span>user@email.com</span></div>
        </div>
    </aside>

    <main class="content">
        <div class="title-wrap">
            <h1>Generate CV ATS</h1>
            <p>Buat CV yang mudah dibaca oleh Applicant Tracking System</p>
        </div>

        <div class="split">
            {{-- LEFT: Form --}}
            <form id="cvForm" action="{{ route('cv.store') }}" method="POST" class="form-card">
                @csrf

                <div class="section-title">📋 Data Diri</div>

                <div class="form-grid" style="margin-bottom:12px">
                    <div class="field">
                        <label class="required" for="nama_lengkap">Nama Lengkap</label>
                        <input id="nama_lengkap" name="nama_lengkap" class="input" placeholder="John Doe" value="{{ old('nama_lengkap') }}" oninput="updatePreview()">
                        @error('nama_lengkap')<span class="error-text">{{ $message }}</span>@enderror
                    </div>
                    <div></div>
                </div>

                <div class="form-grid" style="margin-bottom:12px">
                    <div class="field">
                        <label class="required" for="email">Email</label>
                        <input id="email" name="email" type="email" class="input" placeholder="john@email.com" value="{{ old('email') }}" oninput="updatePreview()">
                        @error('email')<span class="error-text">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label class="required" for="telepon">Telepon</label>
                        <input id="telepon" name="telepon" class="input" placeholder="+62 812 3456 7890" value="{{ old('telepon') }}" oninput="updatePreview()">
                        @error('telepon')<span class="error-text">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-grid" style="margin-bottom:12px">
                    <div class="field">
                        <label for="linkedin">LinkedIn / Portfolio</label>
                        <input id="linkedin" name="linkedin" class="input" placeholder="https://linkedin.com/in/johndoe" value="{{ old('linkedin') }}" oninput="updatePreview()">
                    </div>
                    <div class="field">
                        <label for="alamat">Alamat / Lokasi</label>
                        <input id="alamat" name="alamat" class="input" placeholder="Tangerang, Indonesia" value="{{ old('alamat') }}" oninput="updatePreview()">
                    </div>
                </div>

                <div class="form-grid full" style="margin-bottom:4px">
                    <div class="field">
                        <label for="ringkasan">Ringkasan Profesional</label>
                        <textarea id="ringkasan" name="ringkasan" class="textarea" placeholder="Jelaskan tentang diri Anda dalam 2-3 kalimat..." oninput="updatePreview()">{{ old('ringkasan') }}</textarea>
                    </div>
                </div>

                {{-- PENDIDIKAN --}}
                <div class="section-title">🎓 Pendidikan</div>
                <div id="eduContainer"></div>
                <button type="button" class="btn-add" onclick="addEducation()">+ Tambah Pendidikan</button>

                {{-- PENGALAMAN --}}
                <div class="section-title">💼 Pengalaman</div>
                <div id="expContainer"></div>
                <button type="button" class="btn-add" onclick="addExperience()">+ Tambah Pengalaman</button>

                {{-- SKILLS --}}
                <div class="section-title">⚡ Skills</div>
                <div class="form-grid full" style="margin-bottom:12px">
                    <div class="field">
                        <label for="technical_skills">Technical Skills (pisahkan dengan koma)</label>
                        <input id="technical_skills" name="technical_skills" class="input" placeholder="HTML, CSS, JavaScript, Laravel, MySQL" value="{{ old('technical_skills') }}" oninput="updatePreview()">
                    </div>
                </div>
                <div class="form-grid full">
                    <div class="field">
                        <label for="soft_skills">Soft Skills (pisahkan dengan koma)</label>
                        <input id="soft_skills" name="soft_skills" class="input" placeholder="Communication, Teamwork, Problem Solving" value="{{ old('soft_skills') }}" oninput="updatePreview()">
                    </div>
                </div>
                {{-- Hidden field to combine skills for backend --}}
                <input type="hidden" id="skills" name="skills" value="{{ old('skills') }}">

                <button type="submit" class="btn btn-submit">💾 Simpan CV ATS</button>
            </form>

            {{-- RIGHT: Preview --}}
            <div class="preview-wrap">
                <div class="preview-toolbar">
                    <h2>Preview CV ATS</h2>
                    <span class="ats-badge">ATS-Friendly Format</span>
                </div>
                <div class="cv-doc" id="cvPreview">
                    <div class="cv-name" id="prevName">NAMA LENGKAP</div>
                    <div class="cv-contact" id="prevContact">email@example.com | +62 xxx</div>

                    <div class="cv-section-title">PROFESSIONAL SUMMARY</div>
                    <div class="cv-summary" id="prevSummary"><span class="cv-empty">Ringkasan profesional Anda akan muncul di sini...</span></div>

                    <div class="cv-section-title">EDUCATION</div>
                    <div id="prevEducation"><span class="cv-empty">Tambahkan pendidikan Anda...</span></div>

                    <div class="cv-section-title">EXPERIENCE</div>
                    <div id="prevExperience"><span class="cv-empty">Tambahkan pengalaman kerja Anda...</span></div>

                    <div class="cv-section-title">KEY SKILLS</div>
                    <div id="prevSkills"><span class="cv-empty">Tambahkan skills Anda...</span></div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
let eduCount = 0, expCount = 0;

function addEducation() {
    const c = document.getElementById('eduContainer');
    const i = eduCount++;
    const div = document.createElement('div');
    div.className = 'repeatable';
    div.id = 'edu-' + i;
    div.innerHTML = `
        <button type="button" class="btn-danger-sm remove-btn" onclick="removeBlock('edu-${i}')">✕</button>
        <div class="form-grid" style="margin-bottom:10px">
            <div class="field">
                <label class="required">Institusi</label>
                <input name="pendidikan[${i}][institusi]" class="input" placeholder="Universitas Indonesia" oninput="updatePreview()">
            </div>
            <div class="field">
                <label class="required">Gelar</label>
                <input name="pendidikan[${i}][gelar]" class="input" placeholder="Bachelor of Computer Science" oninput="updatePreview()">
            </div>
        </div>
        <div class="field">
            <label class="required">Tahun</label>
            <input name="pendidikan[${i}][tahun]" class="input" placeholder="2019 - 2023" oninput="updatePreview()" style="max-width:200px">
        </div>
    `;
    c.appendChild(div);
    updatePreview();
}

function addExperience() {
    const c = document.getElementById('expContainer');
    const i = expCount++;
    const div = document.createElement('div');
    div.className = 'repeatable';
    div.id = 'exp-' + i;
    div.innerHTML = `
        <button type="button" class="btn-danger-sm remove-btn" onclick="removeBlock('exp-${i}')">✕</button>
        <div class="form-grid" style="margin-bottom:10px">
            <div class="field">
                <label class="required">Posisi</label>
                <input name="pengalaman[${i}][posisi]" class="input" placeholder="Frontend Developer" oninput="updatePreview()">
            </div>
            <div class="field">
                <label class="required">Perusahaan</label>
                <input name="pengalaman[${i}][perusahaan]" class="input" placeholder="Tech Startup Indonesia" oninput="updatePreview()">
            </div>
        </div>
        <div class="field" style="margin-bottom:10px">
            <label>Deskripsi Pekerjaan</label>
            <textarea name="pengalaman[${i}][deskripsi]" class="textarea" placeholder="Deskripsikan tanggung jawab dan pencapaian..." oninput="updatePreview()"></textarea>
        </div>
        <div class="field">
            <label class="required">Periode</label>
            <input name="pengalaman[${i}][periode]" class="input" placeholder="Jun 2022 - Des 2022" oninput="updatePreview()" style="max-width:240px">
        </div>
    `;
    c.appendChild(div);
    updatePreview();
}

function removeBlock(id) {
    document.getElementById(id)?.remove();
    updatePreview();
}

function updatePreview() {
    // Name
    const name = document.getElementById('nama_lengkap').value;
    document.getElementById('prevName').textContent = name ? name.toUpperCase() : 'NAMA LENGKAP';

    // Contact line: alamat | no hp | email | linkedin
    const alamat = document.getElementById('alamat').value;
    const email = document.getElementById('email').value;
    const telepon = document.getElementById('telepon').value;
    const linkedin = document.getElementById('linkedin').value;
    const contactParts = [
        alamat,
        telepon || '+62 xxx',
        email || 'email@example.com',
        linkedin
    ].filter(Boolean);
    document.getElementById('prevContact').textContent = contactParts.join(' | ');

    // Summary
    const ringkasan = document.getElementById('ringkasan').value;
    document.getElementById('prevSummary').innerHTML = ringkasan
        ? escHtml(ringkasan)
        : '<span class="cv-empty">Ringkasan profesional Anda akan muncul di sini...</span>';

    // Education
    const eduBlocks = document.querySelectorAll('#eduContainer .repeatable');
    let eduHtml = '';
    eduBlocks.forEach(b => {
        const inst = b.querySelector('[name*="[institusi]"]')?.value || '';
        const gelar = b.querySelector('[name*="[gelar]"]')?.value || '';
        const tahun = b.querySelector('[name*="[tahun]"]')?.value || '';
        if (inst || gelar) {
            eduHtml += `<div class="cv-edu-item"><div class="cv-edu-row"><div class="cv-edu-left"><div class="cv-edu-inst">${escHtml(inst)}</div><div class="cv-edu-degree">${escHtml(gelar)}</div></div>`;
            if (tahun) eduHtml += `<div class="cv-edu-year">${escHtml(tahun)}</div>`;
            eduHtml += `</div></div>`;
        }
    });
    document.getElementById('prevEducation').innerHTML = eduHtml || '<span class="cv-empty">Tambahkan pendidikan Anda...</span>';

    // Experience
    const expBlocks = document.querySelectorAll('#expContainer .repeatable');
    let expHtml = '';
    expBlocks.forEach(b => {
        const posisi = b.querySelector('[name*="[posisi]"]')?.value || '';
        const perusahaan = b.querySelector('[name*="[perusahaan]"]')?.value || '';
        const deskripsi = b.querySelector('[name*="[deskripsi]"]')?.value || '';
        const periode = b.querySelector('[name*="[periode]"]')?.value || '';
        if (posisi || perusahaan) {
            expHtml += `<div class="cv-exp-item">`;
            expHtml += `<div class="cv-exp-header"><span class="cv-exp-title">${escHtml(posisi)}${perusahaan ? ' – ' + escHtml(perusahaan) : ''}</span><span class="cv-exp-period">${escHtml(periode)}</span></div>`;
            if (deskripsi) {
                const lines = deskripsi.split('\n').map(l => l.trim()).filter(Boolean);
                expHtml += `<ul class="cv-exp-desc">`;
                lines.forEach(l => { expHtml += `<li>${escHtml(l)}</li>`; });
                expHtml += `</ul>`;
            }
            expHtml += `</div>`;
        }
    });
    document.getElementById('prevExperience').innerHTML = expHtml || '<span class="cv-empty">Tambahkan pengalaman kerja Anda...</span>';

    // Skills — split into Technical & Soft with bullet lists
    const techVal = document.getElementById('technical_skills').value;
    const softVal = document.getElementById('soft_skills').value;
    const techArr = techVal ? techVal.split(',').map(s => s.trim()).filter(Boolean) : [];
    const softArr = softVal ? softVal.split(',').map(s => s.trim()).filter(Boolean) : [];

    // Combine into hidden field for backend (JSON format)
    const combined = JSON.stringify({technical: techArr, soft: softArr});
    document.getElementById('skills').value = combined;

    let skillsHtml = '';
    if (techArr.length) {
        skillsHtml += `<div class="cv-skills-sub">Technical Skills</div>`;
        skillsHtml += `<ul class="cv-skills-list">${techArr.map(s => `<li>${escHtml(s)}</li>`).join('')}</ul>`;
    }
    if (softArr.length) {
        skillsHtml += `<div class="cv-skills-sub">Soft Skills</div>`;
        skillsHtml += `<ul class="cv-skills-list">${softArr.map(s => `<li>${escHtml(s)}</li>`).join('')}</ul>`;
    }
    document.getElementById('prevSkills').innerHTML = skillsHtml || '<span class="cv-empty">Tambahkan skills Anda...</span>';
}

function escHtml(str) {
    const d = document.createElement('div');
    d.textContent = str;
    return d.innerHTML;
}

// Add first education and experience on load
addEducation();
addExperience();
</script>
</body>
</html>
