## 📌 Overview

**Hirify** adalah platform pengembangan karier berbasis web yang membantu mahasiswa dan pencari kerja meningkatkan kesiapan kerja melalui fitur terintegrasi seperti:

* Manajemen profil & CV
* Generate CV berbasis ATS
* Career roadmap & self-assessment
* Pelatihan skill & komunitas
* Mentorship profesional
* Job matching & success score
* Notifikasi real-time

Sistem dirancang berbasis **microservices architecture** untuk skalabilitas dan maintainability tinggi.

> Sistem ini dikembangkan untuk menjawab permasalahan kesiapan kerja dan kesenjangan antara skill individu dengan kebutuhan industri 

---

## 🏗️ Architecture

### 🔹 High-Level Architecture

* **Frontend**: Vue 3 + Vite + Tailwind
* **Backend**: Laravel (Microservices)
* **Database**: MySQL (schema per service)
* **Realtime**: Socket.IO
* **Communication**: REST API

---

## ⚙️ Microservices Structure

| Service              | Port | Description          |
| -------------------- | ---- | -------------------- |
| Auth Service         | 4001 | Authentication & JWT |
| Profile Service      | 4002 | User profile         |
| CV Service           | 4003 | CV & ATS generator   |
| Roadmap Service      | 4004 | Career roadmap       |
| Training Service     | 4005 | Skill training       |
| Mentorship Service   | 4006 | Mentor system        |
| Job Matching Service | 4007 | Job recommendation   |
| Notification Service | 4008 | Notification system  |
| Realtime Service     | 4010 | WebSocket            |

---

## 🧱 Tech Stack

### Backend (Laravel Microservices)

* Laravel 10+
* Laravel Sanctum / JWT
* Eloquent ORM
* MySQL
* Redis (optional - caching)

### Frontend

* Vue 3 + Vite
* Tailwind CSS
* Pinia
* Vue Router
* Axios
* Socket.IO Client

---

## 📂 Project Structure

```
career-platform/
│
├── frontend/
│   ├── src/
│   │   ├── modules/
│   │   ├── services/
│   │   ├── stores/
│   │   ├── router/
│   │   └── socket/
│
├── backend/
│   ├── auth-service/         # Laravel
│   ├── profile-service/
│   ├── cv-service/
│   ├── roadmap-service/
│   ├── training-service/
│   ├── mentorship-service/
│   ├── jobmatching-service/
│   ├── notification-service/
│   └── realtime-service/
│
├── shared/
│   ├── middleware/
│   ├── config/
│   └── utils/
│
├── scripts/
│   ├── init.sql
│   └── seed.sql
│
└── README.md
```

---

## 🚀 Quick Start

### 🔧 Prerequisites

* PHP 8.2+
* Composer
* Node.js 18+
* MySQL 8+

---

### 📥 Installation

#### 1. Clone Repository

```bash
git clone <repo-url>
cd career-platform
```

---

#### 2. Setup Backend (Laravel Microservices)

```bash
cd backend/auth-service
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve --port=4001
```

Lakukan hal yang sama untuk semua service (4002–4008).

---

#### 3. Setup Frontend

```bash
cd frontend
npm install
npm run dev
```

---

## 🌐 Service Endpoints

| Service      | URL                                            |
| ------------ | ---------------------------------------------- |
| Frontend     | [http://localhost:3000](http://localhost:3000) |
| Auth         | [http://localhost:4001](http://localhost:4001) |
| Profile      | [http://localhost:4002](http://localhost:4002) |
| CV           | [http://localhost:4003](http://localhost:4003) |
| Roadmap      | [http://localhost:4004](http://localhost:4004) |
| Training     | [http://localhost:4005](http://localhost:4005) |
| Mentorship   | [http://localhost:4006](http://localhost:4006) |
| Job Matching | [http://localhost:4007](http://localhost:4007) |
| Notification | [http://localhost:4008](http://localhost:4008) |
| Realtime     | [http://localhost:4010](http://localhost:4010) |

---

## 🗄️ Database Schema

### Users Table

* id
* email
* password
* role (admin, mentor, user)
* timestamps

### Core Tables

* profiles
* cvs
* roadmaps
* trainings
* mentorship_requests
* jobs
* notifications

> Struktur database dirancang terpusat pada entitas user dengan relasi ke berbagai modul seperti CV, training, dan mentorship 

---

## 🔐 Authentication

### JWT Flow

1. User login → token dibuat
2. Token disimpan di frontend
3. Token dikirim via header:

```
Authorization: Bearer {token}
```

### Roles

* Admin → full access
* Mentor → mentorship access
* User → default user

---

## 🔌 API Example

### Auth Service

#### Register

```http
POST /api/auth/register
```

#### Login

```http
POST /api/auth/login
```

#### Validate Token

```http
GET /api/auth/validate
```

---

### Profile Service

#### Create Profile

```http
POST /api/profiles
```

#### Get Profile

```http
GET /api/profiles/{id}
```

---

## 🔄 Service Communication

```php
Http::post(
  config('services.notification') . '/api/notifications',
  $data
);
```

---

## 🔌 Realtime (Socket.IO)

### Events

* notification
* new-message
* user-progress
* new-job-match

---

## 📊 Features Mapping (Proposal → System)

| Feature          | Microservice         |
| ---------------- | -------------------- |
| Manajemen Profil | Profile Service      |
| CV ATS Generator | CV Service           |
| Career Roadmap   | Roadmap Service      |
| Self Assessment  | Roadmap Service      |
| Pelatihan Skill  | Training Service     |
| Mentorship       | Mentorship Service   |
| Job Matching     | Job Matching Service |
| Notifikasi       | Notification Service |

---

## 🧪 Testing

```bash
php artisan test
```

---

## 🚦 Production Considerations

### Security

* JWT secret harus diganti
* HTTPS wajib
* Rate limiting

### Performance

* Redis caching
* Load balancing
* API Gateway (Nginx/Kong)

### Monitoring

* Logging centralized
* Health check endpoint
* Error tracking (Sentry)

---

## 👨‍💻 Development Workflow

1. Create branch
2. Develop feature
3. Testing
4. Pull request
5. Code review

---

## 📦 Key Dependencies

### Backend

* Laravel
* Sanctum / JWT
* MySQL

### Frontend

* Vue
* Pinia
* Axios
* Tailwind

---

## 📌 Methodology

Project menggunakan **Scrum (Agile)**:

* Sprint 1 → Core features
* Sprint 2 → Testing & deployment

> Setiap sprint menghasilkan increment fitur yang dapat diuji dan dievaluasi 
* Generate **API endpoint lengkap per service**
* Atau langsung **scaffold project Laravel microservices siap jalan** 🚀
