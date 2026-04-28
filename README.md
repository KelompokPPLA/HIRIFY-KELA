# 📄 README.md — Hirify (Laravel 12 + Tailwind)
## 📌 Overview

**Hirify** adalah platform pengembangan karier berbasis web yang membantu mahasiswa dan pencari kerja meningkatkan kesiapan kerja melalui fitur terintegrasi seperti:

* Manajemen Profil & CV
* Generate CV berbasis ATS
* Career Roadmap & Self Assessment
* Pelatihan Skill
* Mentorship
* Job Matching
* Notifikasi

> Sistem ini bertujuan meningkatkan kesiapan kerja secara terstruktur dan berbasis data 

---

## 🏗️ Architecture

### 🔹 Type

**Monolithic Web Application (SSR)**

### 🔹 Stack

* **Framework**: Laravel 12
* **Frontend**: Blade Template
* **Styling**: Tailwind CSS
* **Database**: MySQL
* **Authentication**: JWT (JSON Web Token)

---

## 📂 Project Structure (Laravel 12)

```bash
hirify/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Requests/
│   │   └── Middleware/
│   ├── Models/
│   ├── Services/          # Custom business logic
│   └── Providers/
│
├── bootstrap/
├── config/
│
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
│
├── public/
│
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   ├── components/
│   │   ├── auth/
│   │   ├── dashboard/
│   │   ├── profile/
│   │   ├── cv/
│   │   ├── roadmap/
│   │   ├── training/
│   │   ├── mentorship/
│   │   └── notification/
│   │
│   ├── css/
│   │   └── app.css
│   └── js/ (optional)
│
├── routes/
│   ├── web.php
│   └── api.php
│
├── storage/
├── tests/
└── README.md
```

---

## 🚀 Quick Start

### 🔧 Prerequisites

* PHP 8.2+
* Composer
* MySQL 8+

---

### 📥 Installation

#### 1. Clone Repository

```bash
git clone <repository-url>
cd hirify
```

---

#### 2. Install Dependencies

```bash
composer install
```

---

#### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```env
DB_DATABASE=hirify
DB_USERNAME=root
DB_PASSWORD=
```

---

#### 4. Setup Database

```bash
php artisan migrate
```

---

#### 5. Run Application

```bash
php artisan serve
```

---

## 🌐 Access

```
http://localhost:8000
```

---

## 🎨 Tailwind CSS Setup

### resources/css/app.css

```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```

---

### tailwind.config.js

```js
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
```

---

### Contoh Blade UI

```html
<div class="min-h-screen bg-gray-100 p-6">
    <div class="bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold text-gray-800">
            Dashboard Hirify
        </h1>
    </div>
</div>
```

---

## 🧠 Feature Modules

| Feature      | Description            |
| ------------ | ---------------------- |
| Auth         | Registrasi & Login     |
| Profile      | Data pengguna          |
| CV           | Upload & ATS Generator |
| Roadmap      | Jalur karier           |
| Assessment   | Self assessment        |
| Training     | Pelatihan              |
| Mentorship   | Mentor                 |
| Job Matching | Rekomendasi kerja      |
| Notification | Notifikasi             |

---

## 🗄️ Database Design

### Users

* uuid
* email
* password
* role (admin, mentor, jobseeker)

### Tables

* profiles
* educations
* experiences
* skills
* cvs
* roadmaps
* trainings
* enrollments
* mentorships
* jobs
* notifications

> Database dirancang dengan user sebagai entitas utama yang terhubung ke semua fitur 

---

## 🔐 Authentication

Menggunakan:

* JWT (JSON Web Token)

Flow:

1. User login
2. Session dibuat
3. Middleware menjaga akses

---

## 🔌 Routing Example

```php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CvController;

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', fn() => view('dashboard'));

    Route::resource('profile', ProfileController::class);
    Route::resource('cv', CvController::class);

    Route::get('/roadmap', [RoadmapController::class, 'index']);
});
```

---

## ⚙️ Business Logic Layer (Best Practice)

Gunakan Service Layer:

```php
// app/Services/ProfileService.php
class ProfileService {
    public function update($user, $data) {
        return $user->profile()->update($data);
    }
}
```

---

## 🧪 Testing

```bash
php artisan test
```

---
### Optimization

```bash
php artisan optimize
php artisan config:cache
php artisan route:cache
```
