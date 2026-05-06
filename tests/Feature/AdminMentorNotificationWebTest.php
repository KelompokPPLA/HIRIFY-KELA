<?php

use App\Models\Feedback;
use App\Models\Mentor;
use App\Models\MentorBooking;
use App\Models\Roadmap;
use App\Models\SelfAssessment;
use App\Models\SesiJadwal;
use App\Models\SkillCourse;
use App\Models\SkillEnrollment;
use App\Models\SkillLesson;
use App\Models\SkillLessonProgress;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lets an admin create update and delete users from the web panel', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->get('/admin/users')
        ->assertOk()
        ->assertSee('Manajemen Pengguna');

    $this->actingAs($admin)
        ->get('/admin/users/create')
        ->assertOk()
        ->assertSee('Tambah Pengguna');

    $this->actingAs($admin)
        ->post('/admin/users', [
            'name' => 'Alya Mentor',
            'email' => 'alya.mentor@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'mentor',
        ])
        ->assertRedirect('/admin/users');

    $user = User::where('email', 'alya.mentor@example.test')->firstOrFail();

    $this->actingAs($admin)
        ->patch("/admin/users/{$user->id}", [
            'name' => 'Alya Mentor Updated',
            'email' => 'alya.updated@example.test',
            'role' => 'jobseeker',
        ])
        ->assertRedirect('/admin/users');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Alya Mentor Updated',
        'email' => 'alya.updated@example.test',
        'role' => 'jobseeker',
    ]);

    $this->actingAs($admin)
        ->delete("/admin/users/{$user->id}")
        ->assertRedirect('/admin/users');

    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});

it('lets an admin manage mentor profiles and training modules', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->get('/admin/mentors')
        ->assertOk()
        ->assertSee('Manajemen Mentor');

    $this->actingAs($admin)
        ->get('/admin/mentors/create')
        ->assertOk()
        ->assertSee('Tambah Mentor');

    $this->actingAs($admin)
        ->get('/admin/training-modules')
        ->assertOk()
        ->assertSee('Modul Konten Pelatihan');

    $this->actingAs($admin)
        ->get('/admin/training-modules/create')
        ->assertOk()
        ->assertSee('Tambah Modul Pelatihan');

    $this->actingAs($admin)
        ->post('/admin/mentors', [
            'name' => 'Raka Mentor',
            'email' => 'raka.mentor@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'expertise' => 'Backend Engineering',
            'experience_years' => 5,
            'bio' => 'Membantu mentee memahami backend production.',
            'education' => 'S1 Informatika',
            'skills' => 'Laravel,API Design,MySQL',
            'availability' => 'Senin dan Rabu malam',
            'price_per_session' => 125000,
        ])
        ->assertRedirect('/admin/mentors');

    $mentorUser = User::where('email', 'raka.mentor@example.test')->firstOrFail();
    $this->assertDatabaseHas('mentors', [
        'user_id' => $mentorUser->id,
        'expertise' => 'Backend Engineering',
        'experience_years' => 5,
    ]);

    $mentor = Mentor::where('user_id', $mentorUser->id)->firstOrFail();

    $this->actingAs($admin)
        ->patch("/admin/mentors/{$mentor->id}", [
            'name' => 'Raka Mentor Senior',
            'email' => 'raka.senior@example.test',
            'expertise' => 'Laravel Architecture',
            'experience_years' => 7,
            'bio' => 'Fokus pada arsitektur Laravel dan mentoring karier.',
            'education' => 'S2 Sistem Informasi',
            'skills' => 'Laravel,Testing,Architecture',
            'availability' => 'Jumat malam',
            'price_per_session' => 150000,
        ])
        ->assertRedirect('/admin/mentors');

    $this->assertDatabaseHas('users', [
        'id' => $mentorUser->id,
        'name' => 'Raka Mentor Senior',
        'email' => 'raka.senior@example.test',
        'role' => 'mentor',
    ]);

    $this->actingAs($admin)
        ->post('/admin/training-modules', [
            'title' => 'Laravel CRUD untuk Admin',
            'description' => 'Belajar membuat CRUD aman untuk panel admin.',
            'category' => 'Backend',
            'level' => 'intermediate',
            'thumbnail_emoji' => 'LA',
            'instructor_name' => 'Tim Hirify',
            'estimated_hours' => 3,
            'is_free' => '1',
            'lesson_title' => ['Validasi Form', 'Relasi Data'],
            'lesson_duration_minutes' => [25, 35],
            'lesson_content' => ['Materi validasi request.', 'Materi relasi model.'],
        ])
        ->assertRedirect('/admin/training-modules');

    $course = SkillCourse::where('title', 'Laravel CRUD untuk Admin')->firstOrFail();

    expect($course->lessons()->count())->toBe(2);

    $this->actingAs($admin)
        ->delete("/admin/training-modules/{$course->id}")
        ->assertRedirect('/admin/training-modules');

    $this->assertDatabaseMissing('skill_courses', ['id' => $course->id]);
});

it('shows a mentor detailed mentee monitoring page with progress and recommendation data', function () {
    $mentorUser = User::factory()->create(['role' => 'mentor', 'name' => 'Mentor Hana']);
    $mentor = Mentor::create([
        'user_id' => $mentorUser->id,
        'expertise' => 'Product Management',
        'experience_years' => 6,
        'skills' => ['Roadmap', 'Interview'],
    ]);
    $mentee = User::factory()->create(['role' => 'jobseeker', 'name' => 'Dika Mentee']);

    Roadmap::create([
        'user_id' => $mentee->id,
        'career_field' => 'Product Manager',
        'step_title' => 'Riset Pengguna',
        'description' => 'Latihan interview dan sintesis insight.',
        'skills' => ['User Interview'],
        'tools' => ['FigJam'],
        'activities' => ['Interview 3 user'],
        'is_completed' => true,
        'step_order' => 1,
    ]);
    Roadmap::create([
        'user_id' => $mentee->id,
        'career_field' => 'Product Manager',
        'step_title' => 'Prioritization',
        'description' => 'Latihan RICE dan MoSCoW.',
        'skills' => ['RICE'],
        'tools' => ['Spreadsheet'],
        'activities' => ['Prioritasi backlog'],
        'is_completed' => false,
        'step_order' => 2,
    ]);

    SelfAssessment::create([
        'user_id' => $mentee->id,
        'answers_json' => json_encode([4, 4, 5, 4, 4, 5, 4, 4, 5, 4]),
        'category_scores_json' => json_encode(['Technical' => 80, 'Communication' => 90]),
        'score' => 85,
    ]);

    MentorBooking::create([
        'mentor_id' => $mentor->id,
        'jobseeker_user_id' => $mentee->id,
        'scheduled_start' => now()->subDays(3),
        'scheduled_end' => now()->subDays(3)->addHour(),
        'status' => 'completed',
        'price_per_session' => 100000,
    ]);

    $session = SesiJadwal::create([
        'mentor_id' => $mentorUser->id,
        'topic' => 'Product mentoring',
        'date' => now()->subDays(3)->toDateString(),
        'time' => '09:00',
        'duration' => 60,
        'platform' => 'Google Meet',
        'status' => 'Completed',
    ]);

    Feedback::create([
        'mentor_id' => $mentorUser->id,
        'mentee_id' => $mentee->id,
        'session_id' => $session->id,
        'rating' => 5,
        'mentee_rating' => 4,
        'strength' => 'Cepat memahami konteks produk.',
        'improvement' => 'Perlu memperkuat prioritas berbasis data.',
        'recommendation' => 'Latih studi kasus product sense setiap minggu.',
    ]);

    $course = SkillCourse::create([
        'title' => 'Product Roadmap',
        'description' => 'Belajar roadmap.',
        'category' => 'Product',
        'level' => 'beginner',
        'thumbnail_emoji' => 'PM',
        'instructor_name' => 'Tim Hirify',
        'estimated_hours' => 1,
        'is_free' => true,
    ]);
    $lesson = SkillLesson::create([
        'skill_course_id' => $course->id,
        'title' => 'Roadmap dasar',
        'content' => 'Materi roadmap dasar.',
        'order_number' => 1,
        'duration_minutes' => 20,
    ]);
    SkillEnrollment::create([
        'user_id' => $mentee->id,
        'skill_course_id' => $course->id,
        'completed_at' => now(),
    ]);
    SkillLessonProgress::create([
        'user_id' => $mentee->id,
        'skill_lesson_id' => $lesson->id,
        'completed_at' => now(),
    ]);

    $this->actingAs($mentorUser)
        ->get("/mentor/mentee/{$mentee->id}")
        ->assertOk()
        ->assertSee('Dika Mentee')
        ->assertSee('Success Score')
        ->assertSee('Roadmap Karier')
        ->assertSee('Latih studi kasus product sense setiap minggu.');
});

it('shows database backed notifications and lets a jobseeker mark them as read', function () {
    $jobseeker = User::factory()->create(['role' => 'jobseeker']);

    $notification = UserNotification::create([
        'user_id' => $jobseeker->id,
        'type' => 'booking',
        'title' => 'Booking mentorship dikonfirmasi',
        'message' => 'Sesi bersama Mentor Hana sudah dikonfirmasi.',
        'action_url' => '/mentorship',
    ]);

    $this->actingAs($jobseeker)
        ->get('/notifikasi')
        ->assertOk()
        ->assertSee('Booking mentorship dikonfirmasi')
        ->assertSee('Belum dibaca');

    $this->actingAs($jobseeker)
        ->post('/notifikasi/read-all')
        ->assertRedirect('/notifikasi');

    expect($notification->refresh()->read_at)->not->toBeNull();
});
