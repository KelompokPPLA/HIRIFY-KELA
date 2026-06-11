@extends('layouts.app')

@section('title', 'Manajemen CV — Hirify')

@section('content')
<div class="space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Manajemen CV</p>
            <h1 class="text-3xl font-semibold text-slate-950">CV Saya</h1>
            <p class="mt-2 text-sm text-slate-600 max-w-2xl">Kelola semua CV yang telah Anda buat atau unggah.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <button onclick="document.getElementById('uploadModal').classList.remove('hidden')"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
                Upload CV
            </button>
            <a href="{{ route('buat-cv-ats.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Buat CV Baru
            </a>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="px-5 py-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="px-5 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="px-5 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CV List --}}
    @if($cvs->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-800 mb-1">Belum ada CV</h3>
            <p class="text-sm text-slate-500 mb-5">Buat CV ATS atau unggah file PDF untuk memulai.</p>
            <div class="flex justify-center gap-3">
                <button onclick="document.getElementById('uploadModal').classList.remove('hidden')"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Upload CV
                </button>
                <a href="{{ route('buat-cv-ats.create') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 transition">
                    Buat CV Sekarang
                </a>
            </div>
        </div>
    @else
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @foreach($cvs as $cv)
                <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm hover:shadow-md transition flex flex-col gap-4">

                    {{-- CV Header --}}
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl {{ $cv->file_path ? 'bg-sky-100 text-sky-600' : 'bg-slate-900 text-white' }} font-bold text-sm">
                            @if($cv->file_path)
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            @else
                                {{ strtoupper(substr($cv->nama_lengkap, 0, 1)) }}
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="font-semibold text-slate-900 text-sm truncate">{{ $cv->nama_lengkap }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ $cv->email }}</p>
                        </div>
                    </div>

                    {{-- CV Meta --}}
                    <div class="flex flex-wrap gap-2 text-xs">
                        @if($cv->file_path)
                            <span class="rounded-full bg-sky-50 border border-sky-200 px-2.5 py-1 text-sky-700 font-medium">PDF</span>
                            @if($cv->file_size)
                                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-slate-600">{{ number_format($cv->file_size / 1024, 1) }} KB</span>
                            @endif
                        @else
                            @if($cv->educations->isNotEmpty())
                                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-slate-600">{{ $cv->educations->count() }} Pendidikan</span>
                            @endif
                            @if($cv->experiences->isNotEmpty())
                                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-slate-600">{{ $cv->experiences->count() }} Pengalaman</span>
                            @endif
                            @if($cv->skills->isNotEmpty())
                                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-slate-600">{{ $cv->skills->count() }} Skills</span>
                            @endif
                        @endif
                    </div>

                    {{-- Tanggal --}}
                    <p class="text-xs text-slate-400">Dibuat: {{ $cv->created_at->format('d M Y, H:i') }}</p>

                    {{-- Actions --}}
                    <div class="flex flex-wrap gap-2 mt-auto">
                        @if($cv->file_path)
                            <a href="{{ asset('storage/' . $cv->file_path) }}" target="_blank"
                                class="flex-1 text-center rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                                Lihat
                            </a>
                        @else
                            <a href="{{ route('cv.show', $cv->id) }}"
                                class="flex-1 text-center rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                                Lihat
                            </a>
                        @endif
                        <a href="{{ route('cv.download', $cv->id) }}"
                            class="flex-1 text-center rounded-xl bg-slate-900 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-700 transition">
                            Download
                        </a>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button onclick="openEditModal('{{ $cv->id }}', {{ json_encode(['nama_lengkap'=>$cv->nama_lengkap,'email'=>$cv->email,'telepon'=>$cv->telepon,'alamat'=>$cv->alamat,'linkedin'=>$cv->linkedin,'ringkasan'=>$cv->ringkasan]) }})"
                            class="flex-1 text-center rounded-xl border border-sky-200 bg-sky-50 px-3 py-2 text-xs font-semibold text-sky-700 hover:bg-sky-100 transition cursor-pointer">
                            Edit
                        </button>
                        @if($cv->file_path)
                            <button onclick="openReplaceModal('{{ $cv->id }}', '{{ $cv->file_name }}')"
                                class="flex-1 text-center rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-100 transition cursor-pointer">
                                Ganti File
                            </button>
                        @endif
                        <button onclick="openDeleteModal('{{ $cv->id }}', '{{ addslashes($cv->nama_lengkap) }}')"
                            class="flex-1 text-center rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-100 transition cursor-pointer">
                            Hapus
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>

{{-- ==================== UPLOAD MODAL ==================== --}}
<div id="uploadModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-xl">
        <div class="border-b border-slate-200 p-6 flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900">Upload CV (PDF)</h2>
            <button onclick="document.getElementById('uploadModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form action="{{ route('cv.upload') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Pilih File PDF</label>
                <input type="file" name="file" accept=".pdf" required
                    class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200"/>
                <p class="mt-2 text-xs text-slate-500">Format: PDF • Maksimal 2MB</p>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('uploadModal').classList.add('hidden')"
                    class="flex-1 px-4 py-2.5 border border-slate-300 text-slate-900 font-semibold rounded-xl hover:bg-slate-50 transition text-sm">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2.5 bg-slate-900 text-white font-semibold rounded-xl hover:bg-slate-800 transition text-sm">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== EDIT MODAL ==================== --}}
<div id="editModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full max-h-[90vh] overflow-y-auto shadow-xl">
        <div class="sticky top-0 bg-white border-b border-slate-200 p-6 flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900">Edit CV</h2>
            <button onclick="document.getElementById('editModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="editForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="editNamaLengkap" required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm"/>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-1">Email</label>
                <input type="email" name="email" id="editEmail" required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm"/>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-1">Telepon</label>
                <input type="tel" name="telepon" id="editTelepon" required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm"/>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-1">Alamat <span class="font-normal text-slate-400">(Opsional)</span></label>
                <input type="text" name="alamat" id="editAlamat"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm"/>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-1">LinkedIn <span class="font-normal text-slate-400">(Opsional)</span></label>
                <input type="url" name="linkedin" id="editLinkedin"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm"/>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-1">Ringkasan <span class="font-normal text-slate-400">(Opsional)</span></label>
                <textarea name="ringkasan" id="editRingkasan" rows="3"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm"></textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')"
                    class="flex-1 px-4 py-2.5 border border-slate-300 text-slate-900 font-semibold rounded-xl hover:bg-slate-50 transition text-sm">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2.5 bg-sky-600 text-white font-semibold rounded-xl hover:bg-sky-700 transition text-sm">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== REPLACE FILE MODAL ==================== --}}
<div id="replaceModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-xl">
        <div class="border-b border-slate-200 p-6 flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900">Ganti File CV</h2>
            <button onclick="document.getElementById('replaceModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="replaceForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <p class="text-sm text-slate-600">File saat ini: <span id="replaceCurrentFile" class="font-semibold text-slate-900"></span></p>
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Pilih File PDF Baru</label>
                <input type="file" name="file" accept=".pdf" required
                    class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200"/>
                <p class="mt-2 text-xs text-slate-500">Format: PDF • Maksimal 2MB</p>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('replaceModal').classList.add('hidden')"
                    class="flex-1 px-4 py-2.5 border border-slate-300 text-slate-900 font-semibold rounded-xl hover:bg-slate-50 transition text-sm">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2.5 bg-amber-600 text-white font-semibold rounded-xl hover:bg-amber-700 transition text-sm">
                    Ganti File
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== DELETE MODAL ==================== --}}
<div id="deleteModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-xl">
        <div class="p-6 text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-red-100 text-red-600 mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-slate-900 mb-2">Hapus CV?</h2>
            <p class="text-slate-600 mb-1">Anda akan menghapus CV:</p>
            <p class="font-semibold text-slate-900 mb-4" id="deleteFileName"></p>
            <p class="text-sm text-slate-500 mb-6">Tindakan ini tidak dapat dibatalkan.</p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 border border-slate-300 text-slate-900 font-semibold rounded-xl hover:bg-slate-50 transition text-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition text-sm">
                        Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openEditModal(id, data) {
    document.getElementById('editForm').action = '/cv/' + id;
    document.getElementById('editNamaLengkap').value = data.nama_lengkap || '';
    document.getElementById('editEmail').value = data.email || '';
    document.getElementById('editTelepon').value = data.telepon || '';
    document.getElementById('editAlamat').value = data.alamat || '';
    document.getElementById('editLinkedin').value = data.linkedin || '';
    const ringkasanEl = document.getElementById('editRingkasan');
    ringkasanEl.value = data.ringkasan || '';
    
    // Reset validation styles
    ['editNamaLengkap', 'editTelepon', 'editRingkasan'].forEach(id => {
        const el = document.getElementById(id);
        el.classList.remove('border-red-500', 'focus:ring-red-500');
        el.classList.add('border-slate-300', 'focus:ring-sky-500');
    });
    ['nama-error', 'telepon-error', 'ringkasan-error'].forEach(id => {
        const errorMsg = document.getElementById(id);
        if (errorMsg) errorMsg.remove();
    });

    document.getElementById('editModal').classList.remove('hidden');
}

function openReplaceModal(id, filename) {
    document.getElementById('replaceForm').action = '/cv/' + id + '/replace';
    document.getElementById('replaceCurrentFile').textContent = filename;
    document.getElementById('replaceModal').classList.remove('hidden');
}

function openDeleteModal(id, name) {
    document.getElementById('deleteForm').action = '/cv/' + id;
    document.getElementById('deleteFileName').textContent = name;
    document.getElementById('deleteModal').classList.remove('hidden');
}

// Close modals on backdrop click
['uploadModal', 'editModal', 'replaceModal', 'deleteModal'].forEach(function(id) {
    document.getElementById(id).addEventListener('click', function(e) {
        if (e.target === this) this.classList.add('hidden');
    });
});

document.getElementById('editForm').addEventListener('submit', function(e) {
    let isValid = true;

    const namaEl = document.getElementById('editNamaLengkap');
    if (namaEl.value.trim() === '') {
        isValid = false;
        namaEl.classList.remove('border-slate-300', 'focus:ring-sky-500');
        namaEl.classList.add('border-red-500', 'focus:ring-red-500');
        let errorMsg = document.getElementById('nama-error');
        if (!errorMsg) {
            errorMsg = document.createElement('p');
            errorMsg.id = 'nama-error';
            errorMsg.className = 'text-red-500 text-sm mt-1';
            namaEl.parentNode.appendChild(errorMsg);
        }
        errorMsg.textContent = 'Nama lengkap tidak boleh kosong.';
    }

    const teleponEl = document.getElementById('editTelepon');
    const teleponVal = teleponEl.value.trim();
    if (teleponVal.length < 10 || teleponVal.length > 13) {
        isValid = false;
        teleponEl.classList.remove('border-slate-300', 'focus:ring-sky-500');
        teleponEl.classList.add('border-red-500', 'focus:ring-red-500');
        let errorMsg = document.getElementById('telepon-error');
        if (!errorMsg) {
            errorMsg = document.createElement('p');
            errorMsg.id = 'telepon-error';
            errorMsg.className = 'text-red-500 text-sm mt-1';
            teleponEl.parentNode.appendChild(errorMsg);
        }
        if (teleponVal.length < 10) {
            errorMsg.textContent = 'Nomor telepon tidak boleh kurang dari 10 karakter.';
        } else {
            errorMsg.textContent = 'Nomor telepon tidak boleh lebih dari 13 karakter.';
        }
    }

    const ringkasanEl = document.getElementById('editRingkasan');
    if (ringkasanEl.value.length > 500) {
        isValid = false;
        ringkasanEl.classList.remove('border-slate-300', 'focus:ring-sky-500');
        ringkasanEl.classList.add('border-red-500', 'focus:ring-red-500');
        let errorMsg = document.getElementById('ringkasan-error');
        if (!errorMsg) {
            errorMsg = document.createElement('p');
            errorMsg.id = 'ringkasan-error';
            errorMsg.className = 'text-red-500 text-sm mt-1';
            ringkasanEl.parentNode.appendChild(errorMsg);
        }
        errorMsg.textContent = 'Karakter melebihi batas maksimal (' + ringkasanEl.value.length + '/500).';
    }

    if (!isValid) {
        e.preventDefault();
    }
});

document.getElementById('editNamaLengkap').addEventListener('input', function() {
    let errorMsg = document.getElementById('nama-error');
    if (this.value.trim() === '') {
        this.classList.remove('border-slate-300', 'focus:ring-sky-500');
        this.classList.add('border-red-500', 'focus:ring-red-500');
        if (!errorMsg) {
            errorMsg = document.createElement('p');
            errorMsg.id = 'nama-error';
            errorMsg.className = 'text-red-500 text-sm mt-1';
            this.parentNode.appendChild(errorMsg);
        }
        errorMsg.textContent = 'Nama lengkap tidak boleh kosong.';
    } else {
        this.classList.remove('border-red-500', 'focus:ring-red-500');
        this.classList.add('border-slate-300', 'focus:ring-sky-500');
        if (errorMsg) errorMsg.remove();
    }
});

document.getElementById('editTelepon').addEventListener('input', function() {
    let errorMsg = document.getElementById('telepon-error');
    const val = this.value.trim();
    if (val.length > 0 && (val.length < 10 || val.length > 13)) {
        this.classList.remove('border-slate-300', 'focus:ring-sky-500');
        this.classList.add('border-red-500', 'focus:ring-red-500');
        if (!errorMsg) {
            errorMsg = document.createElement('p');
            errorMsg.id = 'telepon-error';
            errorMsg.className = 'text-red-500 text-sm mt-1';
            this.parentNode.appendChild(errorMsg);
        }
        if (val.length < 10) {
            errorMsg.textContent = 'Nomor telepon tidak boleh kurang dari 10 karakter.';
        } else {
            errorMsg.textContent = 'Nomor telepon tidak boleh lebih dari 13 karakter.';
        }
    } else {
        this.classList.remove('border-red-500', 'focus:ring-red-500');
        this.classList.add('border-slate-300', 'focus:ring-sky-500');
        if (errorMsg) errorMsg.remove();
    }
});

document.getElementById('editRingkasan').addEventListener('input', function() {
    let errorMsg = document.getElementById('ringkasan-error');
    if (this.value.length > 500) {
        this.classList.remove('border-slate-300', 'focus:ring-sky-500');
        this.classList.add('border-red-500', 'focus:ring-red-500');
        if (!errorMsg) {
            errorMsg = document.createElement('p');
            errorMsg.id = 'ringkasan-error';
            errorMsg.className = 'text-red-500 text-sm mt-1';
            this.parentNode.appendChild(errorMsg);
        }
        errorMsg.textContent = 'Karakter melebihi batas maksimal (' + this.value.length + '/500).';
    } else {
        this.classList.remove('border-red-500', 'focus:ring-red-500');
        this.classList.add('border-slate-300', 'focus:ring-sky-500');
        if (errorMsg) errorMsg.remove();
    }
});
</script>
@endpush
