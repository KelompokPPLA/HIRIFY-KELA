# 📋 Dokumentasi Fitur Manajemen CV

## 🎯 Daftar Isi
1. [Ikhtisar](#ikhtisar)
2. [Struktur File](#struktur-file)
3. [Fitur Utama](#fitur-utama)
4. [Integrasi API](#integrasi-api)
5. [Alur Penggunaan](#alur-penggunaan)
6. [Validasi & Error Handling](#validasi--error-handling)
7. [Troubleshooting](#troubleshooting)

---

## 🔍 Ikhtisar

Fitur **Manajemen CV** memungkinkan user (pencari kerja) untuk:
- ✅ **Upload** file CV (PDF, DOC, DOCX)
- ✅ **Melihat** daftar CV yang sudah diupload
- ✅ **Edit** informasi CV (nama, email, telepon, alamat, LinkedIn, ringkasan)
- ✅ **Hapus** CV yang tidak diperlukan

### Teknologi yang Digunakan
- **Backend**: Laravel 12, JWT Authentication
- **Frontend**: Blade Template, Tailwind CSS, Vanilla JavaScript
- **API**: RESTful API dengan authentication JWT
- **Database**: Model CV dengan relasi ke educations, experiences, skills

---

## 📁 Struktur File

### View
```
resources/views/jobseeker/manajemen-cv.blade.php
```
- **Lokasi**: Blade view untuk halaman manajemen CV
- **Template**: Extends `layouts.app`
- **Komponen**: Upload area, CV list, modals (edit/delete)

### Routes
```
routes/web.php (baris 47)
```
**Sebelum**:
```php
Route::get('/manajemen-cv', [CvController::class, 'index'])->name('manajemen-cv.index');
```

**Setelah**:
```php
Route::view('/manajemen-cv', 'jobseeker.manajemen-cv')->name('manajemen-cv.index');
```

### API Endpoints (Existing)
Menggunakan endpoint API yang sudah tersedia:

| Method | Endpoint | Fungsi |
|--------|----------|--------|
| GET | `/api/cv` | Fetch daftar CV user |
| POST | `/api/cv` | Upload/create CV baru |
| GET | `/api/cv/{id}` | Detail CV spesifik |
| PUT | `/api/cv/{id}` | Update CV |
| DELETE | `/api/cv/{id}` | Delete CV |

---

## ✨ Fitur Utama

### 1. Upload CV (Drag & Drop)
**Lokasi**: Section "Unggah CV Baru"

**Fitur**:
- Drag and drop file
- Click to browse file
- Real-time validation (tipe file, ukuran)
- Visual feedback (hover state, drag over)
- Loading state saat upload

**Format File Accepted**:
- PDF (`application/pdf`)
- DOC (`application/msword`)
- DOCX (`application/vnd.openxmlformats-officedocument.wordprocessingml.document`)

**Ukuran File**: Max 2MB

**Validasi Frontend**:
```javascript
const allowedTypes = [
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
];

if (!allowedTypes.includes(file.type)) {
    showError('Format file tidak didukung...');
}

if (file.size > 2 * 1024 * 1024) {
    showError('Ukuran file terlalu besar...');
}
```

### 2. Daftar CV
**Lokasi**: Section "CV Saya"

**Menampilkan**:
- Nama lengkap
- Email & Telepon
- Tanggal dibuat
- Action buttons (Edit, View, Delete)

**States**:
- **Loading**: Spinner animation saat fetch data
- **Empty**: Ilustrasi + pesan saat tidak ada CV
- **Filled**: List CV dengan action buttons

### 3. Edit CV
**Trigger**: Klik button "Edit" di CV list

**Modal Form**:
- Nama Lengkap (required)
- Email (required)
- Telepon (required)
- Alamat (optional)
- LinkedIn (optional)
- Ringkasan (optional)

**Validasi**:
```javascript
if (!payload.nama_lengkap || !payload.email || !payload.telepon) {
    showToast('Nama, email, dan telepon harus diisi', 'error');
    return;
}
```

### 4. Delete CV
**Trigger**: Klik button "Hapus" di CV list

**Konfirmasi**: Modal dialog sebelum delete
**API Call**: `DELETE /api/cv/{id}`
**Refresh**: Auto-reload list setelah delete

### 5. Sidebar Info
**Menampilkan**:
- **Tips Upload CV**: 4 tips praktis
- **Statistik**: Total CV, CV terakhir diupdate
- **Aksi Cepat**: Button ke halaman Buat CV ATS & Presentasi

---

## 🔗 Integrasi API

### Authentication Token
Token JWT diambil dari (urutan prioritas):
```javascript
let TOKEN = localStorage.getItem('token') ||                    // Token dari login
            document.querySelector('meta[name="auth-token"]')?.content || 
            '';
```

**Catatan**: Token disimpan di `localStorage` saat user login via API.

### Request Headers
```javascript
headers: {
    'Authorization': `Bearer ${TOKEN}`,
    'Content-Type': 'application/json',  // Untuk PUT/DELETE
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
}
```

### Response Format
API mengembalikan response dengan format:
```json
{
    "status": true,
    "message": "CV berhasil dimuat.",
    "data": [
        {
            "id": "uuid-1",
            "nama_lengkap": "John Doe",
            "email": "john@example.com",
            "telepon": "+6281234567890",
            "alamat": "Jakarta",
            "linkedin": "linkedin.com/in/johndoe",
            "ringkasan": "...",
            "created_at": "01 Jan 2025"
        }
    ],
    "code": 200
}
```

### Upload CV (POST)
**Endpoint**: `POST /api/cv`

**Headers**:
```javascript
{
    'Authorization': `Bearer ${TOKEN}`
    // FormData headers auto set by browser
}
```

**Body**:
```javascript
FormData {
    file: File
}
```

**Response**:
```json
{
    "status": true,
    "message": "CV berhasil dibuat.",
    "data": { ...cv_data },
    "code": 201
}
```

---

## 🔄 Alur Penggunaan

### Alur Upload CV
```
1. User buka halaman /manajemen-cv
   ↓
2. Frontend fetch list CV via GET /api/cv
   ↓
3. User select/drag file CV
   ↓
4. Frontend validate file (tipe, size)
   ↓
5. User klik "Upload" button
   ↓
6. Frontend send POST /api/cv dengan FormData
   ↓
7. Backend process & save
   ↓
8. Toast success notification
   ↓
9. Auto reload CV list
```

### Alur Edit CV
```
1. User klik button "Edit" di CV card
   ↓
2. Modal terbuka dengan form pre-filled
   ↓
3. User edit field yang diinginkan
   ↓
4. User klik "Simpan" button
   ↓
5. Frontend validate input (required fields)
   ↓
6. Frontend send PUT /api/cv/{id} dengan JSON payload
   ↓
7. Backend update data
   ↓
8. Toast success notification
   ↓
9. Modal close & list reload
```

### Alur Delete CV
```
1. User klik button "Hapus" di CV card
   ↓
2. Confirm dialog muncul
   ↓
3. User confirm delete
   ↓
4. Frontend send DELETE /api/cv/{id}
   ↓
5. Backend delete CV
   ↓
6. Toast success notification
   ↓
7. Modal close & list reload
```

---

## ✔️ Validasi & Error Handling

### Frontend Validation

#### File Upload
```javascript
// Type validation
const allowedTypes = [
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
];

if (!allowedTypes.includes(file.type)) {
    showError('Format file tidak didukung. Gunakan PDF, DOC, atau DOCX.');
}

// Size validation
if (file.size > 2 * 1024 * 1024) {
    showError('Ukuran file terlalu besar. Maksimal 2MB.');
}
```

#### Edit Form
```javascript
const payload = {
    nama_lengkap: value.trim(),
    email: value.trim(),
    telepon: value.trim(),
    // ... fields
};

if (!payload.nama_lengkap || !payload.email || !payload.telepon) {
    showToast('Nama, email, dan telepon harus diisi', 'error');
    return;
}
```

### Error Handling
```javascript
try {
    const response = await fetch(url, options);
    const data = await response.json();
    
    if (!response.ok) {
        throw new Error(data.message || 'Request failed');
    }
    
    // Success handling
} catch (error) {
    console.error('Error:', error);
    showToast(error.message || 'An error occurred', 'error');
}
```

### Toast Notifications
```javascript
showToast(message, type)
// type: 'success', 'error', 'info'
```

**Contoh**:
```javascript
showToast('CV berhasil diupload!', 'success');
showToast('Gagal upload CV', 'error');
showToast('Memuat data...', 'info');
```

---

## 🎨 UI/UX Components

### Upload Area
- Drag & drop zone dengan visual feedback
- File input hidden (triggered by button click)
- Real-time error display
- Upload button status (disabled/enabled)

### CV Card
- Compact card dengan info CV
- Action buttons row (Edit, View, Delete)
- Hover effect untuk better UX
- Responsive layout (flex items wrap on mobile)

### Modal Dialogs
**Edit Modal**:
- Form inputs untuk edit CV data
- Simpan/Batal buttons
- Close button (X)
- Dimissable via outside click

**Delete Modal**:
- Confirm dialog dengan warning icon
- Hapus/Batal buttons
- Dimissable via outside click

### Loading States
- Spinner animation di CV list loading
- Button disabled + loading text saat request
- Smooth transitions

### Toast Notifications
- Fixed bottom-right position
- Color coded (green success, red error, blue info)
- Auto-dismiss after 3.5s
- Fade in/out animations

---

## 🐛 Troubleshooting

### Issue: "Token autentikasi tidak ditemukan"
**Penyebab**: User tidak login atau token expired

**Solusi**:
1. Ensure user login dulu via login page
2. Check if `localStorage.getItem('token')` return value
3. Re-login jika token expired

### Issue: CORS Error saat API call
**Penyebab**: API endpoint tidak allow request from frontend

**Solusi**:
1. Check API CORS configuration di `config/cors.php`
2. Ensure `routes/api.php` have proper middleware
3. Verify API endpoint accessible from browser

### Issue: File upload gagal
**Penyebab**: 
- File terlalu besar (> 2MB)
- Format tidak supported
- Server storage full
- Timeout

**Solusi**:
1. Check file size dengan File object
2. Validate file type sebelum upload
3. Check server storage space
4. Increase timeout di backend

### Issue: Modal tidak close setelah save
**Penyebab**: JavaScript error atau response status not ok

**Solusi**:
1. Open browser DevTools (F12)
2. Check Console tab untuk error messages
3. Check Network tab untuk API response
4. Verify API endpoint returning proper response

### Issue: CV list not updating
**Penyebab**: 
- Token invalid
- API error
- JavaScript error

**Solusi**:
1. Open DevTools Console untuk check errors
2. Check Network tab untuk API calls
3. Verify API endpoint accessible
4. Try refresh halaman (F5)

---

## 📝 Catatan Development

### File Structure
```
resources/views/jobseeker/manajemen-cv.blade.php
└── @extends('layouts.app')
    ├── Page header (title, description)
    ├── Main grid layout (3 columns: 2fr left, 1fr right sidebar)
    ├── LEFT SECTION
    │   ├── Upload card
    │   └── CV list card
    ├── RIGHT SIDEBAR
    │   ├── Info card (tips)
    │   ├── Stats card
    │   └── Action card
    ├── Modals (edit, delete)
    ├── Toast notification
    └── @push('scripts') JavaScript
```

### Key Functions
- `loadCVList()` - Fetch & render CV list
- `handleFileSelect(file)` - Validate file
- `uploadCV()` - POST file to API
- `openEditModal(id)` - Show edit modal
- `saveEdit()` - PUT update to API
- `openDeleteModal(id)` - Show delete modal
- `confirmDelete()` - DELETE from API
- `showToast(msg, type)` - Show notification

### Styling
- **Framework**: Tailwind CSS
- **Color scheme**: Sky-500 (primary), Slate (neutral)
- **Typography**: Manrope font family
- **Spacing**: Consistent padding/margin using Tailwind utilities
- **Responsive**: Mobile-first approach with `lg:` breakpoints

---

## 🚀 Performance Tips

1. **Lazy Load**: CV list loaded only saat halaman mount
2. **Debounce**: File validation real-time (tidak ada debounce needed)
3. **Caching**: Browser cache for GET requests
4. **Compression**: File upload dengan gzip (jika backend support)

---

## 📚 Referensi

### API Documentation
- **Endpoint Reference**: `routes/api.php` (baris 102-105)
- **Controller**: `app/Http/Controllers/CvApiController.php`
- **Model**: `app/Models/Cv.php`

### Frontend Tools
- **HTTP Client**: Fetch API (native browser API)
- **DOM Manipulation**: Vanilla JavaScript
- **Styling**: Tailwind CSS + Custom CSS animations

### Authentication
- **Type**: JWT Token
- **Storage**: localStorage
- **Header**: `Authorization: Bearer {TOKEN}`

---

**Last Updated**: May 4, 2025  
**Version**: 1.0.0
