@extends('layouts.app')

@section('title', 'Manajemen CV')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Manajemen CV</h1>

    <!-- Upload Section -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Upload CV</h2>

        <!-- Drag Drop -->
        <div id="dropArea"
             class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-blue-500 transition">

            <p id="fileText" class="text-gray-500">
                Drag & drop atau klik untuk pilih file
            </p>

            <p class="text-xs text-gray-400 mt-2">
                PDF, DOC, DOCX (max 2MB)
            </p>
        </div>

        <!-- Upload Button -->
        <button id="uploadBtn"
                class="mt-4 bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed"
                disabled>
            Upload File
        </button>

        <p id="errorText" class="text-red-500 text-sm mt-2"></p>
    </div>

    <!-- List CV -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Daftar CV</h2>

        <div id="cvList" class="space-y-4"></div>

        <div id="emptyState" class="text-center text-gray-500 hidden">
            Belum ada CV
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
const API_BASE = '/api';

let selectedFile = null;

/* ================= TOKEN ================= */
function getToken() {
    const token = localStorage.getItem('token');

    if (!token) {
        alert('Session habis, login ulang');
        window.location.href = '/login';
        return null;
    }

    return token;
}

/* ================= FETCH ================= */
async function apiFetch(url, options = {}) {
    const token = getToken();
    if (!token) return;

    options.headers = {
        ...(options.headers || {}),
        'Authorization': `Bearer ${token}`,
    };

    const res = await fetch(url, options);

    if (res.status === 401) {
        localStorage.removeItem('token');
        alert('Session expired');
        window.location.href = '/login';
        return;
    }

    return res;
}

/* ================= ELEMENT ================= */
const dropArea = document.getElementById('dropArea');
const uploadBtn = document.getElementById('uploadBtn');
const fileText = document.getElementById('fileText');
const errorText = document.getElementById('errorText');

/* ================= INPUT HIDDEN ================= */
const fileInput = document.createElement('input');
fileInput.type = 'file';
fileInput.accept = '.pdf,.doc,.docx';
fileInput.style.display = 'none';
document.body.appendChild(fileInput);

/* ================= EVENT ================= */

// click pilih file
dropArea.addEventListener('click', () => fileInput.click());

// file dipilih
fileInput.addEventListener('change', (e) => {
    handleFile(e.target.files[0]);
});

// drag over
dropArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropArea.classList.add('border-blue-500');
});

// drag leave
dropArea.addEventListener('dragleave', () => {
    dropArea.classList.remove('border-blue-500');
});

// drop file
dropArea.addEventListener('drop', (e) => {
    e.preventDefault();
    dropArea.classList.remove('border-blue-500');
    handleFile(e.dataTransfer.files[0]);
});

/* ================= HANDLE FILE ================= */
function handleFile(file) {
    if (!file) return;

    const allowed = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];

    if (!allowed.includes(file.type)) {
        errorText.textContent = 'Format harus PDF/DOC/DOCX';
        return;
    }

    if (file.size > 2 * 1024 * 1024) {
        errorText.textContent = 'Maksimal 2MB';
        return;
    }

    errorText.textContent = '';
    selectedFile = file;

    fileText.innerText = file.name;

    // enable button
    uploadBtn.disabled = false;
    uploadBtn.classList.remove('bg-gray-400','cursor-not-allowed');
    uploadBtn.classList.add('bg-blue-600');
}

/* ================= UPLOAD ================= */
uploadBtn.addEventListener('click', async () => {
    if (!selectedFile) {
        errorText.textContent = 'Pilih file dulu';
        return;
    }

    const formData = new FormData();

    // ⚠️ sesuaikan dengan backend lo
    formData.append('file', selectedFile);

    try {
        uploadBtn.innerText = 'Uploading...';

        const res = await apiFetch(`${API_BASE}/cv`, {
            method: 'POST',
            body: formData
        });

        const data = await res.json();

        if (!res.ok) throw new Error(data.message || 'Upload gagal');

        alert('Upload berhasil');

        // reset
        selectedFile = null;
        fileText.innerText = 'Drag & drop atau klik untuk pilih file';
        uploadBtn.disabled = true;
        uploadBtn.classList.remove('bg-blue-600');
        uploadBtn.classList.add('bg-gray-400','cursor-not-allowed');

        loadCV();

    } catch (err) {
        errorText.textContent = err.message;
    } finally {
        uploadBtn.innerText = 'Upload File';
    }
});

/* ================= LOAD ================= */
async function loadCV() {
    try {
        const res = await apiFetch(`${API_BASE}/cv`);
        const result = await res.json();

        const data = result.data || result;

        const list = document.getElementById('cvList');
        const empty = document.getElementById('emptyState');

        list.innerHTML = '';

        if (!data.length) {
            empty.classList.remove('hidden');
            return;
        }

        empty.classList.add('hidden');

        data.forEach(cv => {
            list.innerHTML += `
            <div class="border p-4 rounded flex justify-between items-center">
                <div>
                    <p class="font-semibold">${cv.nama_lengkap || 'CV'}</p>
                    <p class="text-sm text-gray-500">
                        ${new Date(cv.created_at).toLocaleDateString()}
                    </p>
                </div>

                <div class="flex gap-2">
                    <a href="/cv/${cv.id}" class="bg-blue-200 px-3 py-1 rounded">
                        View
                    </a>

                    <button onclick="deleteCV('${cv.id}')"
                        class="bg-red-500 text-white px-3 py-1 rounded">
                        Delete
                    </button>
                </div>
            </div>
            `;
        });

    } catch (err) {
        console.error(err);
    }
}

/* ================= DELETE ================= */
async function deleteCV(id) {
    if (!confirm('Hapus CV?')) return;

    try {
        const res = await apiFetch(`${API_BASE}/cv/${id}`, {
            method: 'DELETE'
        });

        if (!res.ok) throw new Error('Gagal delete');

        loadCV();

    } catch (err) {
        alert(err.message);
    }
}

/* ================= INIT ================= */
loadCV();
</script>
@endpush