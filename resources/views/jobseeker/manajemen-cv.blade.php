@extends('layouts.app')

@section('title', 'Manajemen CV')

@section('content')
<div class="cv-management-page">
    <div class="max-w-6xl mx-auto px-6 py-8">

        <!-- PAGE HEADER -->
        <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between mb-8">
            <div>
                <p class="text-xs uppercase tracking-[0.32em] text-sky-600 font-semibold mb-2">Manajemen CV</p>
                <h1 class="text-4xl font-bold text-slate-900 leading-tight">Kelola dan organize CV Anda dengan mudah</h1>
                <p class="text-slate-600 mt-3 max-w-2xl">Unggah dokumen CV, lihat riwayat file, dan edit informasi CV tanpa repot.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('buat-cv-ats.index') }}"
                   class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Buat CV Baru
                </a>
                <a href="{{ route('buat-cv-presentasi.index') }}"
                   class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-50">
                    Buat Presentasi
                </a>
            </div>
        </div>

        <!-- MAIN LAYOUT -->
        <div class="grid gap-8 xl:grid-cols-[1.7fr_1fr]">

            <!-- LEFT COLUMN -->
            <div class="space-y-8">

                <!-- UPLOAD CARD -->
                <div class="rounded-[32px] border border-slate-200 bg-white p-8 shadow-sm">
                    <div class="flex flex-col gap-6 xl:flex-row xl:items-center xl:justify-between">
                        <div>
                            <p class="text-sky-600 text-sm font-semibold uppercase tracking-[0.3em] mb-2">Upload CV Baru</p>
                            <h2 class="text-2xl font-bold text-slate-900">Unggah CV & dokumen pekerjaan Anda</h2>
                            <p class="text-slate-600 mt-2">Drag & drop file CV Anda di sini atau klik tombol pilih file.</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <button id="chooseFileBtn" type="button"
                                    class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                                Pilih File
                            </button>
                            <a href="{{ route('buat-cv-ats.index') }}"
                               class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-50">
                                Buat CV Baru
                            </a>
                        </div>
                    </div>

                    <div id="dropZone"
                         class="mt-8 cursor-pointer rounded-[28px] border-2 border-dashed border-slate-300 bg-slate-50 p-10 text-center transition hover:border-sky-500 hover:bg-sky-50">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-white text-sky-600 shadow-sm">
                            <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 4v12"/><path d="M8 8l4-4 4 4"/><path d="M12 18v2"/>
                            </svg>
                        </div>
                        <p id="dropZoneText" class="mt-6 text-lg font-semibold text-slate-900">Tarik dan lepas file di sini</p>
                        <p class="mt-2 text-sm text-slate-600">PDF, DOC, DOCX • maksimal 2MB</p>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <button id="uploadBtn" type="button" disabled
                                class="inline-flex w-full items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50 sm:w-auto">
                            Upload File
                        </button>
                        <span id="selectedFileInfo" class="text-sm text-slate-500">Belum ada file dipilih</span>
                    </div>

                    <div id="uploadError" class="hidden mt-5 rounded-3xl border border-red-200 bg-red-50 px-5 py-4">
                        <p class="text-sm text-red-700 flex items-center gap-2">
                            <svg class="h-4 w-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-5h2v2h-2v-2zm0-8h2v6h-2V5z" clip-rule="evenodd"/>
                            </svg>
                            <span id="errorMessage"></span>
                        </p>
                    </div>
                </div>

                <!-- CV LIST CARD -->
                <div class="rounded-[32px] border border-slate-200 bg-white shadow-sm overflow-hidden">
                    <div class="flex flex-col gap-2 px-8 py-6 border-b border-slate-200 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">CV Saya</h2>
                            <p class="text-sm text-slate-500">Kelola dokumen CV yang sudah Anda unggah.</p>
                        </div>
                        <div class="flex flex-wrap gap-2 text-sm text-slate-600">
                            <span class="rounded-full bg-slate-100 px-3 py-1">Total CV: <span id="headerTotalCVs" class="font-semibold text-slate-900">0</span></span>
                            <span class="rounded-full bg-slate-100 px-3 py-1">Terakhir: <span id="headerLastUpdated" class="font-semibold text-slate-900">Belum ada</span></span>
                        </div>
                    </div>

                    <div id="cvTableContainer" class="hidden overflow-x-auto">
                        <table class="min-w-full text-left text-sm text-slate-700">
                            <thead class="bg-slate-50 text-slate-500">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">Nama File</th>
                                    <th class="px-6 py-4 font-semibold">Tanggal Upload</th>
                                    <th class="px-6 py-4 font-semibold">Ukuran</th>
                                    <th class="px-6 py-4 font-semibold">Tipe</th>
                                    <th class="px-6 py-4 font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="cvList" class="divide-y divide-slate-200 bg-white">
                            </tbody>
                        </table>
                    </div>

                    <div id="emptyState" class="hidden p-12 text-center text-slate-500">
                        <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-3xl bg-slate-100 text-slate-500">
                            <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </div>
                        <p class="text-lg font-semibold text-slate-900">Belum ada CV tersimpan</p>
                        <p class="mt-2 text-sm">Unggah CV terlebih dahulu untuk melihat riwayat dokumen Anda.</p>
                    </div>

                    <div id="loadingState" class="p-12 text-center">
                        <div class="mx-auto mb-4 h-12 w-12 rounded-full border-4 border-slate-200 border-t-sky-500 animate-spin"></div>
                        <p class="text-sm text-slate-600">Memuat data CV...</p>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: SIDEBAR -->
            <aside class="space-y-6">

                <div class="bg-gradient-to-br from-sky-50 to-blue-50 rounded-2xl border border-sky-200 p-6">
                    <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z"/>
                        </svg>
                        Tips Upload CV
                    </h3>
                    <ul class="space-y-3 text-sm text-slate-700">
                        <li class="flex gap-2"><span class="text-sky-600 font-bold flex-shrink-0">✓</span><span>Gunakan format PDF untuk hasil terbaik</span></li>
                        <li class="flex gap-2"><span class="text-sky-600 font-bold flex-shrink-0">✓</span><span>Pastikan ukuran file di bawah 2MB</span></li>
                        <li class="flex gap-2"><span class="text-sky-600 font-bold flex-shrink-0">✓</span><span>Gunakan nama file yang deskriptif</span></li>
                        <li class="flex gap-2"><span class="text-sky-600 font-bold flex-shrink-0">✓</span><span>Perbarui CV secara berkala</span></li>
                    </ul>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4">
                    <div>
                        <p class="text-slate-600 text-sm mb-1">Total CV Tersimpan</p>
                        <p class="text-3xl font-bold text-slate-900" id="sidebarTotalCVs">0</p>
                    </div>
                    <hr class="border-slate-200">
                    <div>
                        <p class="text-slate-600 text-sm mb-1">CV Terakhir Diperbarui</p>
                        <p class="text-slate-900 font-semibold" id="sidebarLastUpdated">Belum ada</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-6">
                    <h3 class="font-bold text-slate-900 mb-4">Aksi Cepat</h3>
                    <div class="space-y-2">
                        <a href="{{ route('buat-cv-ats.index') }}"
                           class="block px-4 py-3 bg-sky-600 text-white font-semibold rounded-lg text-center hover:bg-sky-700 transition-colors">
                            Buat CV Baru (ATS)
                        </a>
                        <a href="{{ route('buat-cv-presentasi.index') }}"
                           class="block px-4 py-3 bg-slate-200 text-slate-900 font-semibold rounded-lg text-center hover:bg-slate-300 transition-colors">
                            Buat Presentasi
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-slate-200 p-6 flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900">Edit CV</h2>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Nama Lengkap</label>
                <input type="text" id="editNamaLengkap" placeholder="Nama Lengkap"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500"/>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Email</label>
                <input type="email" id="editEmail" placeholder="email@example.com"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500"/>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Telepon</label>
                <input type="tel" id="editTelepon" placeholder="+62XXX"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500"/>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Alamat <span class="font-normal text-slate-400">(Opsional)</span></label>
                <input type="text" id="editAlamat" placeholder="Alamat"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500"/>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">LinkedIn <span class="font-normal text-slate-400">(Opsional)</span></label>
                <input type="url" id="editLinkedin" placeholder="https://linkedin.com/in/..."
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500"/>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Ringkasan <span class="font-normal text-slate-400">(Opsional)</span></label>
                <textarea id="editRingkasan" rows="3" placeholder="Ringkasan profil Anda..."
                          class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500"></textarea>
            </div>
            <div class="flex gap-3 pt-4">
                <button onclick="closeEditModal()"
                        class="flex-1 px-4 py-2 border border-slate-300 text-slate-900 font-semibold rounded-lg hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <button onclick="saveEdit()" id="saveEditBtn"
                        class="flex-1 px-4 py-2 bg-sky-600 text-white font-semibold rounded-lg hover:bg-sky-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- DELETE MODAL -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full">
        <div class="p-6 text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-red-100 text-red-600 mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-slate-900 mb-2">Hapus CV?</h2>
            <p class="text-slate-600 mb-6">Tindakan ini tidak dapat dibatalkan. CV dan semua datanya akan dihapus secara permanen.</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2 border border-slate-300 text-slate-900 font-semibold rounded-lg hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <button onclick="confirmDelete()" id="confirmDeleteBtn"
                        class="flex-1 px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<!-- TOAST -->
<div id="toast" class="hidden fixed bottom-6 right-6 max-w-sm rounded-2xl shadow-lg p-4 flex items-center gap-3 z-50">
    <span id="toastIcon"></span>
    <span id="toastMessage" class="text-sm font-medium"></span>
</div>

<style>
    @keyframes fadeIn  { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
    @keyframes fadeOut { from { opacity:1; transform:translateY(0); }    to { opacity:0; transform:translateY(12px); } }
    .animate-fade-in  { animation: fadeIn  0.3s ease forwards; }
    .animate-fade-out { animation: fadeOut 0.3s ease forwards; }
    .hidden { display: none !important; }
</style>
@endsection

@push('scripts')
<script>
/* ============================================================
   CONFIG
   -------
   Blade menyuntikkan CSRF token dan, jika ada, Bearer token
   dari session. Ini menghindari keharusan menyimpan token di
   localStorage dan mencegah redirect-loop ke /dashboard.
============================================================ */
const API_BASE    = '/api';
const CSRF_TOKEN  = '{{ csrf_token() }}';

/*
 * FIX — ROOT CAUSE REDIRECT LOOP:
 *
 * Kode lama memanggil getToken() saat halaman dimuat. Jika tidak
 * ada token di localStorage, langsung redirect ke /login.
 * Karena user sudah login via session Laravel, route /login
 * punya middleware 'guest' yang redirect session-user ke /dashboard.
 * Akibatnya: setiap buka halaman ini langsung terlempar ke dashboard.
 *
 * SOLUSI:
 * 1. getToken() TIDAK PERNAH redirect. Hanya kembalikan nilai atau null.
 * 2. apiFetch() selalu kirim CSRF token + credentials (session cookie)
 *    sehingga API call tetap ter-autentikasi lewat session Laravel.
 * 3. Redirect ke /login HANYA saat server benar-benar balas 401.
 */
function getToken() {
    // Prioritas: Bearer token dari localStorage (jika ada dari flow SPA/mobile)
    // Fallback: null → apiFetch akan andalkan session cookie saja
    return localStorage.getItem('token') ?? null;
}

let selectedFile    = null;
let currentEditId   = null;
let currentDeleteId = null;
const cvDataStore   = {};

/* ============================================================
   FETCH WRAPPER
   Selalu kirim CSRF + credentials. Bearer token opsional.
============================================================ */
async function apiFetch(url, options = {}) {
    const token = getToken();

    options.credentials = 'same-origin'; // kirim session cookie

    // Jangan override Content-Type jika body adalah FormData (let browser set multipart/form-data)
    const isFormData = options.body instanceof FormData;
    
    options.headers = {
        'Accept': 'application/json',       // minta JSON response
        'X-CSRF-TOKEN': CSRF_TOKEN,        // wajib untuk POST/PUT/DELETE
        ...(options.headers || {}),
        ...(token ? { 'Authorization': `Bearer ${token}` } : {}),
    };

    // FormData handling: jangan set Content-Type, biar browser set boundary
    if (isFormData && 'Content-Type' in options.headers) {
        delete options.headers['Content-Type'];
    }

    let res;
    try {
        res = await fetch(url, options);
    } catch (networkErr) {
        console.error('Network error:', networkErr);
        throw new Error('Tidak dapat terhubung ke server. Periksa koneksi Anda.');
    }

    // Hanya redirect ke login jika server memang menolak sesi (401)
    if (res.status === 401) {
        localStorage.removeItem('token');
        window.location.href = '/login';
        return null;
    }

    return res;
}

/* ============================================================
   TOAST
============================================================ */
function showToast(message, type = 'success') {
    const toast   = document.getElementById('toast');
    const icon    = document.getElementById('toastIcon');
    const msgEl   = document.getElementById('toastMessage');
    const isOk    = type === 'success';

    toast.className = [
        'fixed bottom-6 right-6 max-w-sm rounded-2xl shadow-lg p-4 flex items-center gap-3 z-50 animate-fade-in',
        isOk ? 'bg-green-50 border border-green-200 text-green-800'
             : 'bg-red-50 border border-red-200 text-red-800',
    ].join(' ');

    icon.innerHTML = isOk
        ? `<svg class="h-5 w-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
               <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
           </svg>`
        : `<svg class="h-5 w-5 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
               <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-5h2v2h-2v-2zm0-8h2v6h-2V5z" clip-rule="evenodd"/>
           </svg>`;

    msgEl.textContent = message;
    toast.classList.remove('hidden');

    setTimeout(() => {
        toast.classList.add('animate-fade-out');
        setTimeout(() => {
            toast.classList.add('hidden');
            toast.classList.remove('animate-fade-out', 'animate-fade-in');
        }, 300);
    }, 3000);
}

/* ============================================================
   UPLOAD ERROR
============================================================ */
function showUploadError(msg) {
    document.getElementById('errorMessage').textContent = msg;
    document.getElementById('uploadError').classList.remove('hidden');
}
function clearUploadError() {
    document.getElementById('errorMessage').textContent = '';
    document.getElementById('uploadError').classList.add('hidden');
}

/* ============================================================
   STATS
============================================================ */
function updateStats(cvs) {
    const total = cvs.length;
    const last  = total > 0
        ? new Date(cvs[0].created_at).toLocaleDateString('id-ID', {
              day: 'numeric', month: 'short', year: 'numeric',
          })
        : 'Belum ada';

    [['headerTotalCVs', total], ['sidebarTotalCVs', total],
     ['headerLastUpdated', last], ['sidebarLastUpdated', last]]
        .forEach(([id, val]) => {
            const el = document.getElementById(id);
            if (el) el.textContent = val;
        });
}

/* ============================================================
   FILE INPUT
============================================================ */
const fileInput = document.createElement('input');
fileInput.type   = 'file';
fileInput.accept = '.pdf,.doc,.docx';
fileInput.style.display = 'none';
document.body.appendChild(fileInput);

document.getElementById('chooseFileBtn').addEventListener('click', () => fileInput.click());
document.getElementById('dropZone').addEventListener('click',      () => fileInput.click());

fileInput.addEventListener('change', (e) => {
    if (e.target.files.length > 0) handleFile(e.target.files[0]);
});

const dropZone = document.getElementById('dropZone');
dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('border-sky-500', 'bg-sky-50');
    dropZone.classList.remove('border-slate-300', 'bg-slate-50');
});
dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('border-sky-500', 'bg-sky-50');
    dropZone.classList.add('border-slate-300', 'bg-slate-50');
});
dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-sky-500', 'bg-sky-50');
    dropZone.classList.add('border-slate-300', 'bg-slate-50');
    if (e.dataTransfer.files.length > 0) handleFile(e.dataTransfer.files[0]);
});

function handleFile(file) {
    clearUploadError();

    const allowed = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    if (!allowed.includes(file.type)) {
        showUploadError('Format file harus PDF, DOC, atau DOCX.');
        return;
    }
    if (file.size > 2 * 1024 * 1024) {
        showUploadError('Ukuran file maksimal 2MB.');
        return;
    }

    selectedFile = file;
    document.getElementById('dropZoneText').textContent  = file.name;
    document.getElementById('selectedFileInfo').textContent = `${file.name} (${(file.size / 1024).toFixed(1)} KB)`;
    document.getElementById('uploadBtn').disabled = false;
}

/* ============================================================
   UPLOAD
============================================================ */
document.getElementById('uploadBtn').addEventListener('click', async () => {
    if (!selectedFile) { showUploadError('Pilih file terlebih dahulu.'); return; }

    clearUploadError();
    const btn       = document.getElementById('uploadBtn');
    btn.textContent = 'Mengupload...';
    btn.disabled    = true;

    const formData = new FormData();
    formData.append('file', selectedFile);

    try {
        const res = await apiFetch(`${API_BASE}/cv/upload-file`, { method: 'POST', body: formData });
        if (!res) {
            throw new Error('Tidak mendapat respons dari server.');
        }

        // Try to parse JSON, handle case where response is HTML (error)
        let data;
        const contentType = res.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            data = await res.json();
        } else {
            const text = await res.text();
            console.error('Non-JSON response:', text.substring(0, 200));
            throw new Error('Server mengembalikan respons yang tidak valid.');
        }

        if (!res.ok) {
            throw new Error(data.message || 'Upload gagal.');
        }

        selectedFile = null;
        fileInput.value = '';
        document.getElementById('dropZoneText').textContent     = 'Tarik dan lepas file di sini';
        document.getElementById('selectedFileInfo').textContent = 'Belum ada file dipilih';
        btn.disabled = true;

        showToast('CV berhasil diupload! Silakan lengkapi detail CV.');
        await loadCV();

    } catch (err) {
        console.error('Upload error:', err);
        showUploadError(err.message || 'Gagal upload file.');
        btn.disabled = false;
    } finally {
        btn.textContent = 'Upload File';
    }
});

/* ============================================================
   LOAD CV LIST
============================================================ */
async function loadCV() {
    const loading        = document.getElementById('loadingState');
    const empty          = document.getElementById('emptyState');
    const tableContainer = document.getElementById('cvTableContainer');
    const tbody          = document.getElementById('cvList');

    loading.classList.remove('hidden');
    empty.classList.add('hidden');
    tableContainer.classList.add('hidden');
    tbody.innerHTML = '';

    try {
        const res = await apiFetch(`${API_BASE}/cv`);
        if (!res) return;

        const result = await res.json().catch(() => null);
        if (!res.ok) {
            const message = result?.message || 'Gagal memuat data CV.';
            throw new Error(message);
        }

        const data = result.data ?? result;
        loading.classList.add('hidden');

        if (!Array.isArray(data) || data.length === 0) {
            empty.classList.remove('hidden');
            updateStats([]);
            return;
        }

        data.forEach(cv => { cvDataStore[cv.id] = cv; });

        data.forEach(cv => {
            const name = cv.file_name ?? cv.nama_lengkap ?? 'CV';
            const date = new Date(cv.created_at).toLocaleDateString('id-ID', {
                day: 'numeric', month: 'short', year: 'numeric',
            });
            const size    = cv.file_size ? (cv.file_size / 1024).toFixed(1) + ' KB' : '—';
            const rawType = cv.file_type ?? cv.mime_type ?? '';
            const type    = rawType ? rawType.split('/').pop().toUpperCase() : '—';
            const viewUrl = cv.file_url || `/cv/${cv.id}`;
            const viewLabel = cv.file_url ? 'Unduh' : 'Lihat';

            const tr = document.createElement('tr');
            tr.className = 'hover:bg-slate-50 transition-colors';
            tr.innerHTML = `
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-sky-100 text-sky-600">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </div>
                        <span class="font-medium text-slate-900">${escapeHtml(name)}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-slate-600">${date}</td>
                <td class="px-6 py-4 text-slate-600">${size}</td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center rounded-full bg-sky-100 px-2.5 py-0.5 text-xs font-semibold text-sky-700">${type}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex flex-wrap gap-2">
                        <a href="${escapeHtml(viewUrl)}" target="_blank" rel="noopener" class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">${viewLabel}</a>
                        <button data-edit-id="${cv.id}" class="inline-flex items-center rounded-xl border border-sky-200 bg-sky-50 px-3 py-1.5 text-xs font-semibold text-sky-700 hover:bg-sky-100 transition-colors">Edit</button>
                        <button data-delete-id="${cv.id}" class="inline-flex items-center rounded-xl border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-100 transition-colors">Hapus</button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });

        tableContainer.classList.remove('hidden');
        updateStats(data);

    } catch (err) {
        loading.classList.add('hidden');
        empty.classList.remove('hidden');
        console.error('Gagal memuat CV:', err);
    }
}

// Delegasi event pada tbody agar row dinamis tetap responsif
document.getElementById('cvList').addEventListener('click', (e) => {
    const editBtn   = e.target.closest('[data-edit-id]');
    const deleteBtn = e.target.closest('[data-delete-id]');
    if (editBtn)   openEditModal(editBtn.dataset.editId);
    if (deleteBtn) openDeleteModal(deleteBtn.dataset.deleteId);
});

/* ============================================================
   EDIT MODAL
============================================================ */
function openEditModal(id) {
    const cv = cvDataStore[id];
    if (!cv) return;
    currentEditId = id;
    document.getElementById('editNamaLengkap').value = cv.nama_lengkap ?? '';
    document.getElementById('editEmail').value       = cv.email        ?? '';
    document.getElementById('editTelepon').value     = cv.telepon      ?? '';
    document.getElementById('editAlamat').value      = cv.alamat       ?? '';
    document.getElementById('editLinkedin').value    = cv.linkedin     ?? '';
    document.getElementById('editRingkasan').value   = cv.ringkasan    ?? '';
    document.getElementById('editModal').classList.remove('hidden');
}
function closeEditModal() {
    currentEditId = null;
    document.getElementById('editModal').classList.add('hidden');
}
async function saveEdit() {
    if (!currentEditId) return;
    const btn       = document.getElementById('saveEditBtn');
    btn.textContent = 'Menyimpan...';
    btn.disabled    = true;

    const payload = {
        nama_lengkap: document.getElementById('editNamaLengkap').value.trim(),
        email:        document.getElementById('editEmail').value.trim(),
        telepon:      document.getElementById('editTelepon').value.trim(),
        alamat:       document.getElementById('editAlamat').value.trim(),
        linkedin:     document.getElementById('editLinkedin').value.trim(),
        ringkasan:    document.getElementById('editRingkasan').value.trim(),
    };

    try {
        const res = await apiFetch(`${API_BASE}/cv/${currentEditId}`, {
            method:  'PUT',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify(payload),
        });
        if (!res) return;
        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Gagal menyimpan perubahan.');
        closeEditModal();
        showToast('CV berhasil diperbarui!');
        await loadCV();
    } catch (err) {
        showToast(err.message, 'error');
    } finally {
        btn.textContent = 'Simpan';
        btn.disabled    = false;
    }
}

/* ============================================================
   DELETE MODAL
============================================================ */
function openDeleteModal(id) {
    currentDeleteId = id;
    document.getElementById('deleteModal').classList.remove('hidden');
}
function closeDeleteModal() {
    currentDeleteId = null;
    document.getElementById('deleteModal').classList.add('hidden');
}
async function confirmDelete() {
    if (!currentDeleteId) return;
    const btn       = document.getElementById('confirmDeleteBtn');
    btn.textContent = 'Menghapus...';
    btn.disabled    = true;

    try {
        const res = await apiFetch(`${API_BASE}/cv/${currentDeleteId}`, { method: 'DELETE' });
        if (!res) return;
        if (!res.ok) {
            const data = await res.json().catch(() => ({}));
            throw new Error(data.message || 'Gagal menghapus CV.');
        }
        delete cvDataStore[currentDeleteId];
        closeDeleteModal();
        showToast('CV berhasil dihapus.');
        await loadCV();
    } catch (err) {
        showToast(err.message, 'error');
    } finally {
        btn.textContent = 'Hapus';
        btn.disabled    = false;
    }
}

/* ============================================================
   HELPER
============================================================ */
function escapeHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;').replace(/</g, '&lt;')
        .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

/* ============================================================
   INIT — aman, tidak ada redirect di sini
============================================================ */
document.addEventListener('DOMContentLoaded', loadCV);
</script>
@endpush