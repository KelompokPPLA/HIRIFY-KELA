@extends('layouts.app')

@section('title', 'Buat CV Presentasi')

@section('content')
<div class="cv-page space-y-8">
    <div class="main-card rounded-[32px] border border-slate-200 bg-white p-8 shadow-sm">

        <!-- HEADER -->
        <div class="flex flex-col gap-6 xl:flex-row xl:items-start xl:justify-between">
            <div class="max-w-3xl">
                <p class="label-tag">
                    ✦ Buat Presentasi Instan
                </p>
                <h1 class="mt-4 page-title">
                    Ubah profil atau CV Anda menjadi<br>
                    <span class="title-accent">presentasi profesional</span>
                </h1>
                <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-500">
                    Pilih sumber data, tentukan gaya presentasi, lalu hasilkan slide siap pakai dalam hitungan detik.
                </p>
            </div>

            <!-- STAT CHIPS -->
            <div class="flex flex-wrap gap-2 xl:flex-col xl:items-end xl:pt-2">
                <div class="stat-chip">
                    <span class="stat-dot bg-emerald-400"></span>
                    Powered by AI
                </div>
                <div class="stat-chip">
                    <span class="stat-dot bg-sky-400"></span>
                    Format PPTX / PDF
                </div>
                <div class="stat-chip">
                    <span class="stat-dot bg-violet-400"></span>
                    Siap dalam &lt;30 detik
                </div>
            </div>
        </div>

        <!-- PROGRESS STEPS -->
        <div class="mt-8 flex items-center gap-0">
            <div class="step-item active" data-step="1">
                <div class="step-circle">1</div>
                <span class="step-label">Sumber</span>
            </div>
            <div class="step-line" id="line-1-2"></div>
            <div class="step-item" data-step="2">
                <div class="step-circle">2</div>
                <span class="step-label">Konten</span>
            </div>
            <div class="step-line" id="line-2-3"></div>
            <div class="step-item" data-step="3">
                <div class="step-circle">3</div>
                <span class="step-label">Gaya</span>
            </div>
            <div class="step-line" id="line-3-4"></div>
            <div class="step-item" data-step="4">
                <div class="step-circle">4</div>
                <span class="step-label">Generate</span>
            </div>
        </div>

        <!-- MAIN GRID -->
        <div class="mt-10 grid gap-6 xl:grid-cols-[1fr_340px]">

            <!-- LEFT -->
            <div class="space-y-6">

                <!-- ========== SECTION 1: SOURCE ========== -->
                <section class="section-card" id="section-source">
                    <div class="section-header">
                        <div class="section-number">01</div>
                        <div>
                            <h2 class="section-title">Sumber Data</h2>
                            <p class="section-desc">Pilih dari mana data CV Anda berasal</p>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        <button type="button" data-source="profile" class="source-option active-source">
                            <div class="source-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                            <div>
                                <span class="source-subtitle">Dari Profil</span>
                                <span class="source-title">Gunakan profil Anda</span>
                                <span class="source-hint">Data terisi otomatis</span>
                            </div>
                            <div class="source-check">✓</div>
                        </button>

                        <button type="button" data-source="upload" class="source-option">
                            <div class="source-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            </div>
                            <div>
                                <span class="source-subtitle">Upload CV</span>
                                <span class="source-title">Unggah file CV</span>
                                <span class="source-hint">PDF / DOC / DOCX</span>
                            </div>
                            <div class="source-check">✓</div>
                        </button>
                    </div>

                    <!-- UPLOAD CARD -->
                    <div id="uploadCard" class="hidden mt-5">
                        <div id="dropArea" class="upload-box" role="button" tabindex="0" aria-label="Upload file CV">
                            <div class="upload-icon-wrap">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            </div>
                            <p class="upload-title">Klik atau drag file CV di sini</p>
                            <p class="upload-hint">PDF · DOC · DOCX &nbsp;|&nbsp; Maks. 2MB</p>
                            <input type="file" id="fileInput" class="hidden" accept=".pdf,.doc,.docx">
                        </div>

                        <!-- FILE PREVIEW -->
                        <div id="filePreview" class="hidden mt-3 file-preview-card">
                            <div class="file-preview-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                            <div class="file-preview-info">
                                <span id="fileName" class="file-name"></span>
                                <span id="fileSize" class="file-size"></span>
                            </div>
                            <button type="button" id="removeFile" class="file-remove" aria-label="Hapus file">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            </button>
                        </div>

                        <p id="fileError" class="hidden mt-2 text-sm text-red-500 flex items-center gap-1">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            <span id="fileErrorText"></span>
                        </p>
                    </div>
                </section>

                <!-- ========== SECTION 2: CONTENT ========== -->
                <section class="section-card" id="section-content">
                    <div class="section-header">
                        <div class="section-number">02</div>
                        <div>
                            <h2 class="section-title">Konten Presentasi</h2>
                            <p class="section-desc">Isi informasi yang ingin ditampilkan</p>
                        </div>
                    </div>

                    <div class="mt-6 space-y-4">
                        <div class="input-group">
                            <label class="input-label" for="summaryInput">
                                Ringkasan Profil
                                <span class="input-required">*</span>
                            </label>
                            <textarea id="summaryInput" rows="4"
                                class="cv-textarea"
                                maxlength="500"
                                placeholder="Contoh: Software engineer dengan 5 tahun pengalaman di bidang web development, spesialisasi Laravel dan Vue.js. Berpengalaman memimpin tim dan mengembangkan aplikasi skala enterprise..."></textarea>
                            <div class="flex justify-between mt-1">
                                <p id="summaryError" class="hidden text-xs text-red-500">Ringkasan profil wajib diisi</p>
                                <span id="charCount" class="char-count ml-auto">0 / 500</span>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="input-group">
                                <label class="input-label" for="jobTitle">Posisi / Jabatan</label>
                                <input type="text" id="jobTitle" class="cv-input" placeholder="Cth: Senior Backend Engineer">
                            </div>
                            <div class="input-group">
                                <label class="input-label" for="targetRole">Target Posisi</label>
                                <input type="text" id="targetRole" class="cv-input" placeholder="Cth: Lead Developer">
                            </div>
                        </div>

                        <div class="input-group">
                            <label class="input-label" for="keySkills">Keahlian Utama</label>
                            <input type="text" id="keySkills" class="cv-input" placeholder="Cth: Laravel, Vue.js, MySQL, Docker (pisahkan dengan koma)">
                        </div>
                    </div>
                </section>

                <!-- ========== SECTION 3: STYLE ========== -->
                <section class="section-card" id="section-style">
                    <div class="section-header">
                        <div class="section-number">03</div>
                        <div>
                            <h2 class="section-title">Gaya Presentasi</h2>
                            <p class="section-desc">Pilih tampilan yang sesuai kebutuhan</p>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-3 sm:grid-cols-3">
                        <button type="button" class="style-btn active-style" data-style="professional">
                            <div class="style-preview professional-preview">
                                <div class="preview-bar dark"></div>
                                <div class="preview-lines">
                                    <div class="preview-line long dark"></div>
                                    <div class="preview-line medium dark"></div>
                                    <div class="preview-line short dark"></div>
                                </div>
                            </div>
                            <div class="style-info">
                                <span class="style-name">Professional</span>
                                <span class="style-desc">Formal & bersih</span>
                            </div>
                            <div class="style-check">✓</div>
                        </button>

                        <button type="button" class="style-btn" data-style="modern">
                            <div class="style-preview modern-preview">
                                <div class="preview-bar accent"></div>
                                <div class="preview-lines">
                                    <div class="preview-line long accent"></div>
                                    <div class="preview-line medium light"></div>
                                    <div class="preview-line short light"></div>
                                </div>
                            </div>
                            <div class="style-info">
                                <span class="style-name">Modern</span>
                                <span class="style-desc">Dinamis & bold</span>
                            </div>
                            <div class="style-check">✓</div>
                        </button>

                        <button type="button" class="style-btn" data-style="creative">
                            <div class="style-preview creative-preview">
                                <div class="preview-bar gradient"></div>
                                <div class="preview-lines">
                                    <div class="preview-line long gradient"></div>
                                    <div class="preview-line medium light"></div>
                                    <div class="preview-line short gradient"></div>
                                </div>
                            </div>
                            <div class="style-info">
                                <span class="style-name">Creative</span>
                                <span class="style-desc">Artistik & unik</span>
                            </div>
                            <div class="style-check">✓</div>
                        </button>
                    </div>

                    <!-- SLIDE SETTINGS -->
                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        <div class="input-group">
                            <label class="input-label" for="slideCount">Jumlah Slide</label>
                            <select id="slideCount" class="cv-select">
                                <option value="8">8 slide (Ringkas)</option>
                                <option value="12" selected>12 slide (Standar)</option>
                                <option value="16">16 slide (Lengkap)</option>
                                <option value="20">20 slide (Komprehensif)</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label class="input-label" for="langSelect">Bahasa Presentasi</label>
                            <select id="langSelect" class="cv-select">
                                <option value="id">Indonesia</option>
                                <option value="en">English</option>
                                <option value="bilingual">Bilingual (ID + EN)</option>
                            </select>
                        </div>
                    </div>
                </section>

            </div>

            <!-- RIGHT SIDEBAR -->
            <aside class="space-y-4">

                <!-- SUMMARY CARD -->
                <div class="summary-card">
                    <div class="summary-header">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        Ringkasan Konfigurasi
                    </div>
                    <ul class="summary-list">
                        <li class="summary-item">
                            <span class="summary-key">Sumber</span>
                            <span class="summary-val" id="summarySource">Dari Profil</span>
                        </li>
                        <li class="summary-item">
                            <span class="summary-key">Gaya</span>
                            <span class="summary-val" id="summaryStyle">Professional</span>
                        </li>
                        <li class="summary-item">
                            <span class="summary-key">Slide</span>
                            <span class="summary-val" id="summarySlides">12 slide</span>
                        </li>
                        <li class="summary-item">
                            <span class="summary-key">Bahasa</span>
                            <span class="summary-val" id="summaryLang">Indonesia</span>
                        </li>
                    </ul>
                </div>

                <!-- WHAT YOU'LL GET -->
                <div class="get-card">
                    <h3 class="get-title">Yang Anda Dapatkan</h3>
                    <ul class="get-list">
                        <li>
                            <div class="get-icon">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                            <div>
                                <span class="get-item-title">File PPTX & PDF</span>
                                <span class="get-item-desc">Siap edit & presentasi</span>
                            </div>
                        </li>
                        <li>
                            <div class="get-icon">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            </div>
                            <div>
                                <span class="get-item-title">Layout Profesional</span>
                                <span class="get-item-desc">Desain siap pakai</span>
                            </div>
                        </li>
                        <li>
                            <div class="get-icon">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            </div>
                            <div>
                                <span class="get-item-title">Selesai &lt;30 Detik</span>
                                <span class="get-item-desc">Cepat & efisien</span>
                            </div>
                        </li>
                        <li>
                            <div class="get-icon">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </div>
                            <div>
                                <span class="get-item-title">Bisa Diedit</span>
                                <span class="get-item-desc">Sesuaikan sesukamu</span>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- GENERATE BUTTON -->
                <div class="generate-wrap">
                    <button id="generateBtn" type="button" class="generate-btn">
                        <span id="generateBtnContent" class="generate-btn-inner">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            Generate Presentasi
                        </span>
                    </button>
                    <p class="generate-hint">Dengan mengklik, Anda menyetujui ketentuan penggunaan</p>
                </div>

                <!-- RESULT CARD (hidden initially) -->
                <div id="resultCard" class="result-card hidden">
                    <div class="result-header">
                        <div class="result-icon">✓</div>
                        <div>
                            <p class="result-title">Presentasi Siap!</p>
                            <p class="result-desc">File berhasil digenerate</p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 mt-4">
                        <a href="#" id="downloadPptx" class="download-btn pptx-btn">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Download PPTX
                        </a>
                        <a href="#" id="downloadPdf" class="download-btn pdf-btn">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Download PDF
                        </a>
                    </div>
                </div>

            </aside>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jszip@3.10.1/dist/jszip.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pptxgenjs@3.12.0/dist/pptxgen.min.js"></script>
<style>
/* =========================================================
   FONTS
   ========================================================= */
@import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap');

.cv-page * {
    font-family: 'DM Sans', sans-serif;
}

/* =========================================================
   PAGE LAYOUT
   ========================================================= */
.main-card {
    animation: fadeSlideUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
}
@keyframes fadeSlideUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* =========================================================
   HEADER
   ========================================================= */
.label-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: #0ea5e9;
    background: #f0f9ff;
    border: 1px solid #bae6fd;
    padding: 5px 14px;
    border-radius: 100px;
}
.page-title {
    font-family: 'Sora', sans-serif;
    font-size: clamp(1.6rem, 3vw, 2.4rem);
    font-weight: 700;
    color: #0f172a;
    line-height: 1.25;
}
.title-accent {
    background: linear-gradient(135deg, #0ea5e9 0%, #6366f1 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.stat-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 100px;
    padding: 5px 12px;
    font-size: 12px;
    color: #475569;
    font-weight: 500;
    white-space: nowrap;
}
.stat-dot {
    display: inline-block;
    width: 7px;
    height: 7px;
    border-radius: 50%;
}

/* =========================================================
   PROGRESS STEPS
   ========================================================= */
.step-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    position: relative;
}
.step-circle {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    border: 2px solid #e2e8f0;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 600;
    color: #94a3b8;
    transition: all 0.3s ease;
}
.step-item.active .step-circle {
    background: #0f172a;
    border-color: #0f172a;
    color: white;
    box-shadow: 0 0 0 4px rgba(15,23,42,0.08);
}
.step-item.done .step-circle {
    background: #10b981;
    border-color: #10b981;
    color: white;
}
.step-item.done .step-circle::after {
    content: '✓';
}
.step-label {
    font-size: 11px;
    font-weight: 500;
    color: #94a3b8;
    transition: color 0.3s ease;
}
.step-item.active .step-label {
    color: #0f172a;
    font-weight: 600;
}
.step-item.done .step-label {
    color: #10b981;
}
.step-line {
    flex: 1;
    height: 2px;
    background: #e2e8f0;
    margin: 0 4px;
    margin-bottom: 18px;
    border-radius: 2px;
    transition: background 0.4s ease;
    min-width: 30px;
}
.step-line.done {
    background: #10b981;
}

/* =========================================================
   SECTION CARDS
   ========================================================= */
.section-card {
    border-radius: 24px;
    border: 1px solid #e2e8f0;
    background: #fafafa;
    padding: 24px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.section-card:focus-within {
    border-color: #cbd5e1;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
}
.section-header {
    display: flex;
    align-items: flex-start;
    gap: 14px;
}
.section-number {
    font-family: 'Sora', sans-serif;
    font-size: 11px;
    font-weight: 700;
    color: #94a3b8;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 4px 8px;
    letter-spacing: 0.05em;
    flex-shrink: 0;
    margin-top: 2px;
}
.section-title {
    font-family: 'Sora', sans-serif;
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}
.section-desc {
    font-size: 12px;
    color: #94a3b8;
    margin-top: 2px;
}

/* =========================================================
   SOURCE BUTTONS
   ========================================================= */
.source-option {
    display: flex;
    align-items: center;
    gap: 14px;
    border: 1.5px solid #e2e8f0;
    border-radius: 16px;
    padding: 14px 16px;
    text-align: left;
    background: white;
    transition: all 0.2s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}
.source-option:hover {
    border-color: #94a3b8;
    background: #f8fafc;
}
.active-source {
    border: 2px solid #0ea5e9 !important;
    background: #f0f9ff !important;
    box-shadow: 0 0 0 3px rgba(14,165,233,0.1);
}
.source-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64748b;
    flex-shrink: 0;
    transition: all 0.2s;
}
.active-source .source-icon {
    background: #e0f2fe;
    color: #0ea5e9;
}
.source-subtitle {
    display: block;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #94a3b8;
    margin-bottom: 2px;
}
.source-title {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
}
.source-hint {
    display: block;
    font-size: 11px;
    color: #94a3b8;
    margin-top: 1px;
}
.source-check {
    margin-left: auto;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    color: transparent;
    flex-shrink: 0;
    transition: all 0.2s;
}
.active-source .source-check {
    background: #0ea5e9;
    color: white;
}

/* =========================================================
   UPLOAD BOX
   ========================================================= */
.upload-box {
    border: 2px dashed #cbd5e1;
    border-radius: 20px;
    padding: 36px 24px;
    text-align: center;
    background: white;
    cursor: pointer;
    transition: all 0.2s ease;
    outline: none;
}
.upload-box:hover,
.upload-box:focus,
.upload-box.dragover {
    border-color: #0ea5e9;
    background: #f0f9ff;
}
.upload-icon-wrap {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
    color: #64748b;
    transition: all 0.2s;
}
.upload-box:hover .upload-icon-wrap {
    background: #e0f2fe;
    color: #0ea5e9;
}
.upload-title {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin: 0;
}
.upload-hint {
    font-size: 12px;
    color: #94a3b8;
    margin-top: 4px;
}
.file-preview-card {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 14px;
    padding: 12px 16px;
}
.file-preview-icon {
    width: 34px;
    height: 34px;
    background: #dcfce7;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #16a34a;
    flex-shrink: 0;
}
.file-preview-info {
    flex: 1;
    min-width: 0;
}
.file-name {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #166534;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.file-size {
    display: block;
    font-size: 11px;
    color: #4ade80;
}
.file-remove {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: #dcfce7;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #16a34a;
    cursor: pointer;
    flex-shrink: 0;
    transition: all 0.2s;
}
.file-remove:hover {
    background: #fee2e2;
    color: #dc2626;
}

/* =========================================================
   INPUTS
   ========================================================= */
.input-group { display: flex; flex-direction: column; }
.input-label {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 4px;
}
.input-required { color: #ef4444; }
.cv-textarea, .cv-input, .cv-select {
    width: 100%;
    border-radius: 16px;
    border: 1.5px solid #e2e8f0;
    background: white;
    padding: 11px 16px;
    font-size: 14px;
    color: #1e293b;
    font-family: 'DM Sans', sans-serif;
    transition: all 0.2s ease;
    outline: none;
    box-sizing: border-box;
    -webkit-appearance: none;
}
.cv-textarea { resize: none; }
.cv-select { cursor: pointer; }
.cv-textarea:focus, .cv-input:focus, .cv-select:focus {
    border-color: #0ea5e9;
    box-shadow: 0 0 0 3px rgba(14,165,233,0.1);
}
.cv-textarea::placeholder, .cv-input::placeholder {
    color: #cbd5e1;
    font-size: 13px;
}
.cv-textarea.input-error, .cv-input.input-error {
    border-color: #f87171;
    box-shadow: 0 0 0 3px rgba(248,113,113,0.1);
}
.char-count {
    font-size: 11px;
    color: #94a3b8;
    display: block;
    text-align: right;
}
.char-count.near-limit { color: #f59e0b; }
.char-count.at-limit   { color: #ef4444; }

/* =========================================================
   STYLE BUTTONS
   ========================================================= */
.style-btn {
    border: 1.5px solid #e2e8f0;
    border-radius: 16px;
    padding: 14px;
    text-align: left;
    background: white;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
}
.style-btn:hover {
    border-color: #94a3b8;
    background: #f8fafc;
}
.active-style {
    border: 2px solid #0ea5e9 !important;
    background: #f0f9ff !important;
    box-shadow: 0 0 0 3px rgba(14,165,233,0.1);
}
.style-preview {
    height: 52px;
    border-radius: 10px;
    padding: 8px 10px;
    display: flex;
    gap: 6px;
    align-items: center;
    overflow: hidden;
    margin-bottom: 10px;
}
.professional-preview { background: #1e293b; }
.modern-preview       { background: #0f172a; }
.creative-preview     { background: linear-gradient(135deg, #312e81, #1e1b4b); }

.preview-bar {
    width: 6px;
    height: 100%;
    border-radius: 4px;
    flex-shrink: 0;
}
.preview-bar.dark     { background: #334155; }
.preview-bar.accent   { background: #0ea5e9; }
.preview-bar.gradient { background: linear-gradient(180deg, #818cf8, #c084fc); }

.preview-lines { display: flex; flex-direction: column; gap: 4px; flex: 1; }
.preview-line {
    height: 4px;
    border-radius: 4px;
    background: #334155;
}
.preview-line.long   { width: 100%; }
.preview-line.medium { width: 70%; }
.preview-line.short  { width: 45%; }
.preview-line.dark   { background: #475569; }
.preview-line.accent { background: #38bdf8; }
.preview-line.light  { background: #334155; }
.preview-line.gradient { background: linear-gradient(90deg, #818cf8, #c084fc); }

.style-info { display: flex; flex-direction: column; gap: 1px; }
.style-name {
    font-size: 13px;
    font-weight: 700;
    color: #1e293b;
}
.style-desc {
    font-size: 11px;
    color: #94a3b8;
}
.style-check {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    color: transparent;
    transition: all 0.2s;
}
.active-style .style-check {
    background: #0ea5e9;
    color: white;
}

/* =========================================================
   SIDEBAR CARDS
   ========================================================= */
.summary-card {
    background: #0f172a;
    border-radius: 20px;
    padding: 18px;
    color: white;
}
.summary-header {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 600;
    color: #94a3b8;
    border-bottom: 1px solid #1e293b;
    padding-bottom: 12px;
    margin-bottom: 14px;
}
.summary-list { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 8px; }
.summary-item { display: flex; align-items: center; justify-content: space-between; }
.summary-key  { font-size: 12px; color: #64748b; }
.summary-val  {
    font-size: 12px;
    font-weight: 600;
    color: #e2e8f0;
    background: #1e293b;
    padding: 3px 10px;
    border-radius: 100px;
    transition: all 0.2s;
}

.get-card {
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 18px;
    background: white;
}
.get-title {
    font-family: 'Sora', sans-serif;
    font-size: 13px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 14px;
}
.get-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.get-list li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
}
.get-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #0ea5e9;
    flex-shrink: 0;
}
.get-item-title { display: block; font-size: 13px; font-weight: 600; color: #1e293b; }
.get-item-desc  { display: block; font-size: 11px; color: #94a3b8; margin-top: 1px; }

/* =========================================================
   GENERATE BUTTON
   ========================================================= */
.generate-wrap { display: flex; flex-direction: column; gap: 8px; }
.generate-btn {
    width: 100%;
    border: none;
    border-radius: 18px;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    color: white;
    padding: 15px;
    font-size: 15px;
    font-weight: 700;
    font-family: 'Sora', sans-serif;
    cursor: pointer;
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
}
.generate-btn::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #0ea5e9, #6366f1);
    opacity: 0;
    transition: opacity 0.3s ease;
}
.generate-btn:hover::before { opacity: 1; }
.generate-btn:active { transform: scale(0.98); }
.generate-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    pointer-events: none;
}
.generate-btn-inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.generate-hint {
    text-align: center;
    font-size: 10px;
    color: #cbd5e1;
}

/* LOADING STATE */
.spinner {
    width: 18px;
    height: 18px;
    border: 2.5px solid rgba(255,255,255,0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
    flex-shrink: 0;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* =========================================================
   RESULT CARD
   ========================================================= */
.result-card {
    border: 2px solid #bbf7d0;
    border-radius: 20px;
    padding: 18px;
    background: #f0fdf4;
    animation: popIn 0.4s cubic-bezier(0.16,1,0.3,1) both;
}
@keyframes popIn {
    from { opacity: 0; transform: scale(0.92); }
    to   { opacity: 1; transform: scale(1); }
}
.result-header { display: flex; align-items: center; gap: 12px; }
.result-icon {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #10b981;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 700;
    flex-shrink: 0;
}
.result-title { font-size: 14px; font-weight: 700; color: #166534; }
.result-desc  { font-size: 12px; color: #4ade80; margin-top: 2px; }
.download-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border-radius: 14px;
    padding: 11px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    cursor: pointer;
}
.pptx-btn {
    background: #1e293b;
    color: white;
}
.pptx-btn:hover { background: #0f172a; }
.pdf-btn {
    border: 1.5px solid #d1d5db;
    background: white;
    color: #374151;
}
.pdf-btn:hover { background: #f9fafb; border-color: #9ca3af; }
.download-btn.disabled {
    opacity: 0.6;
    pointer-events: none;
}

/* Toast */
.toast {
    position: fixed;
    bottom: 28px;
    right: 28px;
    background: #1e293b;
    color: white;
    padding: 12px 20px;
    border-radius: 14px;
    font-size: 13px;
    font-weight: 500;
    box-shadow: 0 8px 32px rgba(0,0,0,0.18);
    z-index: 9999;
    display: flex;
    align-items: center;
    gap: 8px;
    animation: toastIn 0.3s cubic-bezier(0.16,1,0.3,1) both;
    max-width: 320px;
}
.toast.error { background: #ef4444; }
.toast.success { background: #10b981; }
@keyframes toastIn  { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
@keyframes toastOut { from { opacity:1; transform:translateY(0); }  to { opacity:0; transform:translateY(12px); } }

/* =========================================================
   RESPONSIVE
   ========================================================= */
@media (max-width: 640px) {
    .section-card { padding: 18px; }
    .main-card { padding: 20px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ===========================================
       STATE
    =========================================== */
    const state = {
        source: 'profile',
        style: 'professional',
        slideCount: '12',
        language: 'id',
        uploadedFile: null,
    };

    /* ===========================================
       ELEMENT REFS
    =========================================== */
    const sourceButtons  = document.querySelectorAll('.source-option');
    const uploadCard     = document.getElementById('uploadCard');
    const dropArea       = document.getElementById('dropArea');
    const fileInput      = document.getElementById('fileInput');
    const fileError      = document.getElementById('fileError');
    const fileErrorText  = document.getElementById('fileErrorText');
    const filePreview    = document.getElementById('filePreview');
    const fileNameEl     = document.getElementById('fileName');
    const fileSizeEl     = document.getElementById('fileSize');
    const removeFileBtn  = document.getElementById('removeFile');

    const summaryInput   = document.getElementById('summaryInput');
    const charCount      = document.getElementById('charCount');
    const summaryError   = document.getElementById('summaryError');

    const styleButtons   = document.querySelectorAll('.style-btn');
    const slideCount     = document.getElementById('slideCount');
    const langSelect     = document.getElementById('langSelect');

    const generateBtn        = document.getElementById('generateBtn');
    const generateBtnContent = document.getElementById('generateBtnContent');
    const resultCard         = document.getElementById('resultCard');
    const downloadPdf        = document.getElementById('downloadPdf');
    const downloadPptx       = document.getElementById('downloadPptx');
    let generatedPdfUrl      = null;

    const summarySource = document.getElementById('summarySource');
    const summaryStyle  = document.getElementById('summaryStyle');
    const summarySlides = document.getElementById('summarySlides');
    const summaryLang   = document.getElementById('summaryLang');

    /* ===========================================
       STEPS LOGIC
    =========================================== */
    const STEPS = { source: 1, content: 2, style: 3, generate: 4 };

    function setActiveStep(step) {
        document.querySelectorAll('.step-item').forEach(el => {
            const s = parseInt(el.dataset.step);
            el.classList.toggle('active', s === step);
            el.classList.toggle('done', s < step);
            if (s < step) {
                const circle = el.querySelector('.step-circle');
                circle.textContent = '';
            } else {
                const circle = el.querySelector('.step-circle');
                circle.textContent = s;
            }
        });
        // lines
        for (let i = 1; i <= 3; i++) {
            const line = document.getElementById(`line-${i}-${i+1}`);
            if (line) line.classList.toggle('done', i < step);
        }
    }

    function detectActiveStep() {
        const hasSummary = summaryInput.value.trim().length > 0;
        const hasFile = state.source === 'upload' && state.uploadedFile;
        const sourceReady = state.source === 'profile' || hasFile;

        if (!sourceReady) { setActiveStep(1); return; }
        if (!hasSummary && state.source === 'profile') { setActiveStep(2); return; }
        setActiveStep(3);
    }

    /* ===========================================
       SOURCE SWITCH
    =========================================== */
    sourceButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            sourceButtons.forEach(b => b.classList.remove('active-source'));
            btn.classList.add('active-source');
            state.source = btn.dataset.source;
            uploadCard.classList.toggle('hidden', state.source !== 'upload');
            updateSummaryCard();
            detectActiveStep();
        });
    });

    /* ===========================================
       FILE UPLOAD & DRAG DROP
    =========================================== */
    dropArea.addEventListener('click', () => fileInput.click());
    dropArea.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') fileInput.click(); });

    // Drag events
    ['dragenter','dragover'].forEach(evt => {
        dropArea.addEventListener(evt, e => {
            e.preventDefault();
            dropArea.classList.add('dragover');
        });
    });
    ['dragleave','dragend'].forEach(evt => {
        dropArea.addEventListener(evt, () => dropArea.classList.remove('dragover'));
    });
    dropArea.addEventListener('drop', e => {
        e.preventDefault();
        dropArea.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file) handleFile(file);
    });

    fileInput.addEventListener('change', () => {
        if (fileInput.files[0]) handleFile(fileInput.files[0]);
    });

    removeFileBtn.addEventListener('click', resetFile);

    function handleFile(file) {
        const allowed = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        hideError();

        if (!allowed.includes(file.type)) {
            return showFileError('Format tidak valid. Gunakan PDF, DOC, atau DOCX.');
        }
        if (file.size > 2 * 1024 * 1024) {
            return showFileError('Ukuran file melebihi batas 2MB.');
        }

        state.uploadedFile = file;

        // show preview
        fileNameEl.textContent = file.name;
        fileSizeEl.textContent = formatBytes(file.size);
        dropArea.classList.add('hidden');
        filePreview.classList.remove('hidden');

        detectActiveStep();
        showToast('✓ File berhasil diunggah', 'success');
    }

    function resetFile() {
        state.uploadedFile = null;
        fileInput.value = '';
        filePreview.classList.add('hidden');
        dropArea.classList.remove('hidden');
        hideError();
        detectActiveStep();
    }

    function showFileError(msg) {
        fileErrorText.textContent = msg;
        fileError.classList.remove('hidden');
    }

    function hideError() {
        fileError.classList.add('hidden');
    }

    function formatBytes(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    }

    /* ===========================================
       CHAR COUNT
    =========================================== */
    summaryInput.addEventListener('input', () => {
        const len = summaryInput.value.length;
        charCount.textContent = `${len} / 500`;
        charCount.classList.toggle('near-limit', len >= 400 && len < 480);
        charCount.classList.toggle('at-limit', len >= 480);

        if (len > 0) {
            summaryError.classList.add('hidden');
            summaryInput.classList.remove('input-error');
        }
        detectActiveStep();
    });

    /* ===========================================
       STYLE BUTTONS
    =========================================== */
    const styleLabels = { professional: 'Professional', modern: 'Modern', creative: 'Creative' };

    styleButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            styleButtons.forEach(b => b.classList.remove('active-style'));
            btn.classList.add('active-style');
            state.style = btn.dataset.style;
            summaryStyle.textContent = styleLabels[state.style];
            setActiveStep(3);
        });
    });

    /* ===========================================
       SLIDE COUNT & LANGUAGE
    =========================================== */
    slideCount.addEventListener('change', () => {
        state.slideCount = slideCount.value;
        summarySlides.textContent = slideCount.value + ' slide';
    });

    langSelect.addEventListener('change', () => {
        state.language = langSelect.value;
        const map = { id: 'Indonesia', en: 'English', bilingual: 'Bilingual' };
        summaryLang.textContent = map[state.language];
    });

    /* ===========================================
       SUMMARY CARD UPDATE
    =========================================== */
    function updateSummaryCard() {
        const sourceMap = { profile: 'Dari Profil', upload: 'Upload File' };
        summarySource.textContent = sourceMap[state.source];
    }

    function cleanupGeneratedPdf() {
        if (generatedPdfUrl) {
            URL.revokeObjectURL(generatedPdfUrl);
            generatedPdfUrl = null;
        }
    }

    let generatedPptxUrl = null;
    function cleanupGeneratedPptx() {
        if (generatedPptxUrl) {
            URL.revokeObjectURL(generatedPptxUrl);
            generatedPptxUrl = null;
        }
    }

    function setExportButtonsState(enabled) {
        if (enabled) {
            downloadPdf.classList.remove('disabled');
            downloadPdf.setAttribute('download', 'presentasi-cv.pdf');
            downloadPdf.setAttribute('aria-disabled', 'false');
            downloadPptx.classList.remove('disabled');
            downloadPptx.setAttribute('download', 'presentasi-cv.pptx');
            downloadPptx.setAttribute('aria-disabled', 'false');
        } else {
            downloadPdf.classList.add('disabled');
            downloadPdf.href = 'javascript:void(0)';
            downloadPdf.removeAttribute('download');
            downloadPdf.setAttribute('aria-disabled', 'true');
            downloadPptx.classList.add('disabled');
            downloadPptx.href = 'javascript:void(0)';
            downloadPptx.removeAttribute('download');
            downloadPptx.setAttribute('aria-disabled', 'true');
        }
    }

    async function prepareDownloadLinks() {
        cleanupGeneratedPdf();
        cleanupGeneratedPptx();

        const pdfBlob = createPdfBlob();
        generatedPdfUrl = URL.createObjectURL(pdfBlob);
        downloadPdf.href = generatedPdfUrl;
        
        const pptxBlob = await createPptxBlob();
        generatedPptxUrl = URL.createObjectURL(pptxBlob);
        downloadPptx.href = generatedPptxUrl;

        setExportButtonsState(true);
    }

    function createPdfBlob() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({ unit: 'pt', format: 'a4' });
        const margin = 40;
        let y = 50;

        doc.setFontSize(20);
        doc.setFont('helvetica', 'bold');
        doc.text('Presentasi CV', margin, y);
        y += 32;

        doc.setFontSize(12);
        doc.setFont('helvetica', 'normal');
        const sourceText = state.source === 'upload' ? 'Upload CV' : 'Dari Profil';
        const langText = { id: 'Indonesia', en: 'English', bilingual: 'Bilingual' }[state.language];

        doc.text(`Sumber       : ${sourceText}`, margin, y);
        y += 18;
        doc.text(`Gaya         : ${styleLabels[state.style]}`, margin, y);
        y += 18;
        doc.text(`Jumlah Slide : ${state.slideCount} slide`, margin, y);
        y += 18;
        doc.text(`Bahasa       : ${langText}`, margin, y);
        y += 28;

        doc.setFont('helvetica', 'bold');
        doc.text('Ringkasan Presentasi', margin, y);
        y += 18;
        doc.setFont('helvetica', 'normal');
        const summaryText = summaryInput.value.trim() || 'Ringkasan profil otomatis diambil dari data profil Anda.';
        const lines = doc.splitTextToSize(summaryText, 520);
        doc.text(lines, margin, y);
        y += (lines.length * 16) + 14;

        if (state.source === 'upload' && state.uploadedFile) {
            if (y > 720) { doc.addPage(); y = 50; }
            doc.setFont('helvetica', 'bold');
            doc.text('Informasi CV Sumber', margin, y);
            y += 18;
            doc.setFont('helvetica', 'normal');
            doc.text(`Nama file: ${state.uploadedFile.name}`, margin, y);
            y += 16;
            doc.text(`Ukuran   : ${formatBytes(state.uploadedFile.size)}`, margin, y);
            y += 24;
        }

        if (y > 680) { doc.addPage(); y = 50; }
        doc.setFont('helvetica', 'bold');
        doc.text('Highlight Presentasi', margin, y);
        y += 18;
        doc.setFont('helvetica', 'normal');
        const bullets = [
            'Struktur slide profesional dengan poin utama yang jelas.',
            'Template presentasi siap pakai dan mudah dibaca.',
            'Warna serta tipografi sesuai gaya pilihan.',
            'Ringkasan profil yang menarik untuk audiens.',
        ];
        bullets.forEach(item => {
            const itemLines = doc.splitTextToSize(item, 500);
            doc.text('• ' + itemLines[0], margin, y);
            y += 16;
            for (let i = 1; i < itemLines.length; i++) {
                doc.text(itemLines[i], margin + 12, y);
                y += 16;
            }
            if (y > 720) { doc.addPage(); y = 50; }
        });

        doc.setFontSize(10);
        doc.text('Generated by Hirify – Buat CV Presentasi', margin, 790);
        return doc.output('blob');
    }

    async function createPptxBlob() {
        const PptxGenJS = window.PptxGenJS;
        const pres = new PptxGenJS();
        
        // Set slide size
        pres.setPageSize({ cx: 10, cy: 5.625 });
        
        const brandColor = '#06cbe5';
        const darkColor = '#0d1b3d';

        // Slide 1: Title
        let slide = pres.addSlide();
        slide.background = { color: darkColor };
        slide.addText('Presentasi CV', {
            x: 0.5, y: 2, w: 9, h: 1,
            fontSize: 54, bold: true, color: 'FFFFFF',
            align: 'left', fontFace: 'Calibri'
        });
        slide.addText('Disusun oleh Hirify', {
            x: 0.5, y: 3.3, w: 9, h: 0.4,
            fontSize: 18, color: brandColor,
            align: 'left', fontFace: 'Calibri'
        });

        // Slide 2: Summary Info
        slide = pres.addSlide();
        slide.background = { color: 'FFFFFF' };
        slide.addShape(pres.ShapeType.rect, {
            x: 0, y: 0, w: 10, h: 0.6,
            fill: { color: brandColor }, line: { type: 'none' }
        });
        slide.addText('Informasi Presentasi', {
            x: 0.5, y: 0.1, w: 9, h: 0.4,
            fontSize: 32, bold: true, color: 'FFFFFF',
            align: 'left', fontFace: 'Calibri'
        });

        const sourceText = state.source === 'upload' ? 'Upload CV' : 'Dari Profil';
        const styleText = styleLabels[state.style] || 'Profesional';
        const langText = { id: 'Indonesia', en: 'English', bilingual: 'Bilingual' }[state.language];
        const infoData = [
            ['Sumber Data', sourceText],
            ['Gaya Presentasi', styleText],
            ['Jumlah Slide', state.slideCount + ' slide'],
            ['Bahasa', langText]
        ];

        let y = 1;
        infoData.forEach(([label, value]) => {
            slide.addText(label + ':', {
                x: 1, y: y, w: 3, h: 0.4,
                fontSize: 16, bold: true, color: darkColor,
                fontFace: 'Calibri'
            });
            slide.addText(value, {
                x: 4, y: y, w: 5, h: 0.4,
                fontSize: 16, color: '#4a5568',
                fontFace: 'Calibri'
            });
            y += 0.6;
        });

        // Slide 3: Summary
        slide = pres.addSlide();
        slide.background = { color: 'FFFFFF' };
        slide.addShape(pres.ShapeType.rect, {
            x: 0, y: 0, w: 10, h: 0.6,
            fill: { color: brandColor }, line: { type: 'none' }
        });
        slide.addText('Ringkasan Profil', {
            x: 0.5, y: 0.1, w: 9, h: 0.4,
            fontSize: 32, bold: true, color: 'FFFFFF',
            align: 'left', fontFace: 'Calibri'
        });

        const summaryText = summaryInput.value.trim() || 'Ringkasan profil otomatis diambil dari data profil Anda.';
        slide.addText(summaryText, {
            x: 1, y: 1, w: 8, h: 3.5,
            fontSize: 14, color: darkColor,
            align: 'left', valign: 'top', fontFace: 'Calibri',
            wrap: true
        });

        // Slide 4: Highlights
        slide = pres.addSlide();
        slide.background = { color: 'FFFFFF' };
        slide.addShape(pres.ShapeType.rect, {
            x: 0, y: 0, w: 10, h: 0.6,
            fill: { color: brandColor }, line: { type: 'none' }
        });
        slide.addText('Highlight Presentasi', {
            x: 0.5, y: 0.1, w: 9, h: 0.4,
            fontSize: 32, bold: true, color: 'FFFFFF',
            align: 'left', fontFace: 'Calibri'
        });

        const highlights = [
            'Struktur slide profesional dengan poin utama yang jelas',
            'Template presentasi siap pakai dan mudah dibaca',
            'Warna serta tipografi sesuai gaya pilihan',
            'Ringkasan profil yang menarik untuk audiens'
        ];
        
        y = 1;
        highlights.forEach(text => {
            slide.addText('• ' + text, {
                x: 1, y: y, w: 8, h: 0.5,
                fontSize: 13, color: darkColor,
                fontFace: 'Calibri', wrap: true
            });
            y += 0.65;
        });

        // Slide 5: Footer
        slide = pres.addSlide();
        slide.background = { color: darkColor };
        slide.addText('Siap untuk Tampil Percaya Diri', {
            x: 0.5, y: 2, w: 9, h: 1,
            fontSize: 48, bold: true, color: brandColor,
            align: 'center', fontFace: 'Calibri'
        });
        slide.addText('Generated by Hirify – Buat CV Presentasi', {
            x: 0.5, y: 4.8, w: 9, h: 0.3,
            fontSize: 12, color: '#a0aec0',
            align: 'center', fontFace: 'Calibri'
        });

        return await pres.write('blob');
    }

    /* ===========================================
       VALIDATION
    ===========================================
    */
    function validate() {
        let valid = true;

        // Source upload check
        if (state.source === 'upload' && !state.uploadedFile) {
            showToast('Silakan unggah file CV terlebih dahulu.', 'error');
            document.getElementById('uploadCard').scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }

        // Summary check (only for profile source)
        if (state.source === 'profile' && summaryInput.value.trim().length === 0) {
            summaryInput.classList.add('input-error');
            summaryError.classList.remove('hidden');
            summaryInput.focus();
            showToast('Harap isi ringkasan profil Anda.', 'error');
            return false;
        }

        return valid;
    }

    /* ===========================================
       GENERATE BUTTON
    =========================================== */
    generateBtn.addEventListener('click', async () => {
        if (!validate()) return;

        setActiveStep(4);
        setLoadingState(true);
        resultCard.classList.add('hidden');

        try {
            // Simulate API call (replace with actual endpoint)
            await new Promise(resolve => setTimeout(resolve, 2500));

            // TODO: Replace with actual fetch/axios call
            // const formData = new FormData();
            // formData.append('source', state.source);
            // formData.append('style', state.style);
            // formData.append('slides', state.slideCount);
            // formData.append('language', state.language);
            // formData.append('summary', summaryInput.value);
            // if (state.uploadedFile) formData.append('file', state.uploadedFile);
            // const res = await fetch('/api/cv/generate', { method: 'POST', body: formData });
            // const data = await res.json();

            // Show result
            await prepareDownloadLinks();
            resultCard.classList.remove('hidden');
            resultCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            showToast('✓ Presentasi berhasil digenerate!', 'success');

        } catch (err) {
            showToast('Gagal generate presentasi. Coba lagi.', 'error');
            setActiveStep(3);
        } finally {
            setLoadingState(false);
        }
    });

    function setLoadingState(isLoading) {
        generateBtn.disabled = isLoading;
        if (isLoading) {
            generateBtnContent.innerHTML = `<div class="spinner"></div> Generating...`;
        } else {
            generateBtnContent.innerHTML = `
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                Generate Presentasi
            `;
        }
    }

    /* ===========================================
       TOAST NOTIFICATION
    =========================================== */
    let toastTimeout;
    function showToast(msg, type = '') {
        // Remove existing toast
        const existing = document.querySelector('.toast');
        if (existing) existing.remove();
        clearTimeout(toastTimeout);

        const icon = type === 'error' ? '✕' : type === 'success' ? '✓' : 'ℹ';
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `<span>${icon}</span><span>${msg}</span>`;
        document.body.appendChild(toast);

        toastTimeout = setTimeout(() => {
            toast.style.animation = 'toastOut 0.3s ease both';
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    }

    /* ===========================================
       INIT
    =========================================== */
    setExportButtonsState(false);
    setActiveStep(1);
});
</script>
@endpush