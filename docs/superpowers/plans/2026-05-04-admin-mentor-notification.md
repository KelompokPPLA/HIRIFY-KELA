# Admin, Mentor Monitoring, and Notification Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build DEV-17 admin CRUD, DEV-15 mentor mentee monitoring, and DEV-16 jobseeker notifications for the Laravel web app.

**Architecture:** Add focused web controllers for admin user, mentor, and training module management. Add a database-backed `UserNotification` model for notification state. Extend `MenteeSayaController` with a detail view that aggregates roadmap, assessment, training, booking, and feedback data without changing existing API behavior.

**Tech Stack:** Laravel 12, Blade, Tailwind CDN, Pest feature tests, MySQL/SQLite-compatible migrations.

---

### Task 1: Admin User CRUD

**Files:**
- Create: `app/Http/Controllers/AdminUserManagementController.php`
- Create: `resources/views/admin/users/form.blade.php`
- Modify: `resources/views/admin/users.blade.php`
- Modify: `routes/web.php`

- [ ] Add routes for listing, creating, updating, and deleting users under `/admin/users`.
- [ ] Validate name, email, password, and role with unique email rules.
- [ ] Prevent an admin from deleting their own account.
- [ ] Keep redirects and flash messages consistent with existing admin pages.

### Task 2: Admin Mentor and Training Module CRUD

**Files:**
- Create: `app/Http/Controllers/AdminMentorManagementController.php`
- Create: `app/Http/Controllers/AdminTrainingModuleController.php`
- Create: `resources/views/admin/mentors/*.blade.php`
- Create: `resources/views/admin/training-modules/*.blade.php`
- Modify: `resources/views/layouts/admin.blade.php`
- Modify: `routes/web.php`

- [ ] Add CRUD routes and forms for mentor profiles linked to users with `role = mentor`.
- [ ] Add CRUD routes and forms for `SkillCourse` plus inline lesson creation on course create/edit.
- [ ] Normalize comma-separated mentor skills into JSON arrays.
- [ ] Preserve existing course/lesson relationships and cascade deletes.

### Task 3: Mentor Mentee Monitoring Detail

**Files:**
- Modify: `app/Http/Controllers/MenteeSayaController.php`
- Modify: `resources/views/mentor/mentee/index.blade.php`
- Create: `resources/views/mentor/mentee/show.blade.php`
- Modify: `routes/web.php`

- [ ] Add `/mentor/mentee/{user}` route scoped to the logged-in mentor.
- [ ] Aggregate roadmap progress, latest self-assessment, training progress, booking history, and feedback.
- [ ] Calculate success score from roadmap, assessment, training, sessions, and rating.
- [ ] Show a clear recommendation based on the weakest metric.

### Task 4: Jobseeker Notifications

**Files:**
- Create: `database/migrations/*_create_user_notifications_table.php`
- Create: `app/Models/UserNotification.php`
- Create: `app/Http/Controllers/NotificationController.php`
- Modify: `resources/views/notifikasi/index.blade.php`
- Modify: `app/Http/Controllers/MentorDashboardController.php`
- Modify: `app/Http/Controllers/FeedbackController.php`
- Modify: `routes/web.php`

- [ ] Store user notifications with type, title, message, action URL, read timestamp, and metadata JSON.
- [ ] Replace static notification Blade data with database records for the authenticated user.
- [ ] Add mark-one-read and mark-all-read routes.
- [ ] Create notifications when bookings are accepted/rejected and when mentor feedback is submitted.

### Task 5: Verification

- [ ] Run `C:\xampp3\php\php.exe artisan test tests/Feature/AdminMentorNotificationWebTest.php`.
- [ ] Run the full feature test suite with `C:\xampp3\php\php.exe artisan test`.
- [ ] Run `C:\xampp3\php\php.exe artisan migrate`.
- [ ] Smoke check the main web routes with Artisan route list and selected GET requests.
