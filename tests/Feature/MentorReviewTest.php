<?php

use App\Models\User;
use App\Models\Mentor;
use App\Models\MentorBooking;
use App\Models\MentorReview;
use App\Models\SesiJadwal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

uses(RefreshDatabase::class);

function authHeaders(User $user): array
{
    return [
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . JWTAuth::fromUser($user),
    ];
}

beforeEach(function () {
    // Create jobseeker user
    $this->jobseeker = User::factory()->create([
        'role' => 'jobseeker',
        'name' => 'John Jobseeker',
    ]);

    // Create mentor user & mentor profile
    $this->mentorUser = User::factory()->create([
        'role' => 'mentor',
        'name' => 'Dr. Jane Mentor',
    ]);
    
    $this->mentor = Mentor::create([
        'user_id' => $this->mentorUser->id,
        'expertise' => 'Software Engineering',
        'experience_years' => 5,
        'bio' => 'Senior Developer and mentor.',
    ]);
});

it('allows jobseekers to review completed bookings', function () {
    // Create a completed booking
    $booking = MentorBooking::create([
        'mentor_id' => $this->mentor->id,
        'jobseeker_user_id' => $this->jobseeker->id,
        'status' => 'completed',
        'scheduled_start' => now()->subHours(2),
        'scheduled_end' => now()->subHours(1),
        'price_per_session' => 150000,
    ]);

    $response = $this->withHeaders(authHeaders($this->jobseeker))
        ->postJson("/api/mentorship/bookings/{$booking->id}/reviews", [
            'rating' => 5,
            'comment' => 'Sesi yang luar biasa! Sangat membantu.',
        ]);

    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'Ulasan berhasil dikirim. Terima kasih atas masukan Anda!',
            'data' => [
                'rating' => 5,
                'comment' => 'Sesi yang luar biasa! Sangat membantu.',
            ]
        ]);

    $this->assertDatabaseHas('mentor_reviews', [
        'mentor_booking_id' => $booking->id,
        'mentor_id' => $this->mentor->id,
        'jobseeker_user_id' => $this->jobseeker->id,
        'rating' => 5,
        'comment' => 'Sesi yang luar biasa! Sangat membantu.',
    ]);
});

it('allows jobseekers to review bookings when related sesi jadwal is completed', function () {
    // Create SesiJadwal with completed status
    $sesiJadwal = SesiJadwal::create([
        'mentor_id' => $this->mentorUser->id,
        'title' => 'Sesi Kotlin & Android',
        'topic' => 'Android Development',
        'date' => now()->subDays(1)->toDateString(),
        'time' => '10:00',
        'duration' => 60,
        'status' => 'Completed',
    ]);

    // Create a booking referencing that SesiJadwal
    $booking = MentorBooking::create([
        'mentor_id' => $this->mentor->id,
        'jobseeker_user_id' => $this->jobseeker->id,
        'sesi_jadwal_id' => $sesiJadwal->id,
        'status' => 'confirmed', // Confirmed but SesiJadwal is Completed
        'scheduled_start' => now()->subDays(1),
        'scheduled_end' => now()->subDays(1)->addHour(),
        'price_per_session' => 150000,
    ]);

    $response = $this->withHeaders(authHeaders($this->jobseeker))
        ->postJson("/api/mentorship/bookings/{$booking->id}/reviews", [
            'rating' => 4,
            'comment' => 'Penjelasan bagus.',
        ]);

    $response->assertStatus(201);
    
    $this->assertDatabaseHas('mentor_reviews', [
        'mentor_booking_id' => $booking->id,
        'rating' => 4,
    ]);
});

it('fails to review if rating is missing or invalid', function () {
    $booking = MentorBooking::create([
        'mentor_id' => $this->mentor->id,
        'jobseeker_user_id' => $this->jobseeker->id,
        'status' => 'completed',
        'scheduled_start' => now()->subHours(2),
        'scheduled_end' => now()->subHours(1),
    ]);

    // Missing rating
    $response = $this->withHeaders(authHeaders($this->jobseeker))
        ->postJson("/api/mentorship/bookings/{$booking->id}/reviews", [
            'comment' => 'Bagus',
        ]);
    $response->assertStatus(422);

    // Invalid rating (not integer)
    $response = $this->withHeaders(authHeaders($this->jobseeker))
        ->postJson("/api/mentorship/bookings/{$booking->id}/reviews", [
            'rating' => 'dua',
        ]);
    $response->assertStatus(422);

    // Rating out of bounds
    $response = $this->withHeaders(authHeaders($this->jobseeker))
        ->postJson("/api/mentorship/bookings/{$booking->id}/reviews", [
            'rating' => 6,
        ]);
    $response->assertStatus(422);

    $response = $this->withHeaders(authHeaders($this->jobseeker))
        ->postJson("/api/mentorship/bookings/{$booking->id}/reviews", [
            'rating' => 0,
        ]);
    $response->assertStatus(422);
});

it('fails to review if booking is not completed', function () {
    $booking = MentorBooking::create([
        'mentor_id' => $this->mentor->id,
        'jobseeker_user_id' => $this->jobseeker->id,
        'status' => 'confirmed', // not completed
        'scheduled_start' => now()->addDay(),
        'scheduled_end' => now()->addDay()->addHour(),
    ]);

    $response = $this->withHeaders(authHeaders($this->jobseeker))
        ->postJson("/api/mentorship/bookings/{$booking->id}/reviews", [
            'rating' => 5,
        ]);

    $response->assertStatus(400)
        ->assertJson([
            'success' => false,
            'message' => 'Anda hanya dapat memberikan ulasan untuk sesi mentoring yang telah selesai.',
        ]);
});

it('fails to review twice for the same booking', function () {
    $booking = MentorBooking::create([
        'mentor_id' => $this->mentor->id,
        'jobseeker_user_id' => $this->jobseeker->id,
        'status' => 'completed',
        'scheduled_start' => now()->subHours(2),
        'scheduled_end' => now()->subHours(1),
    ]);

    // First review
    MentorReview::create([
        'mentor_booking_id' => $booking->id,
        'mentor_id' => $this->mentor->id,
        'jobseeker_user_id' => $this->jobseeker->id,
        'rating' => 5,
    ]);

    // Try to review again
    $response = $this->withHeaders(authHeaders($this->jobseeker))
        ->postJson("/api/mentorship/bookings/{$booking->id}/reviews", [
            'rating' => 4,
            'comment' => 'Coba lagi.',
        ]);

    $response->assertStatus(400)
        ->assertJson([
            'success' => false,
            'message' => 'Anda sudah memberikan ulasan untuk sesi mentoring ini.',
        ]);
});

it('fails to review other users bookings', function () {
    $otherJobseeker = User::factory()->create(['role' => 'jobseeker']);

    $booking = MentorBooking::create([
        'mentor_id' => $this->mentor->id,
        'jobseeker_user_id' => $otherJobseeker->id, // belongs to another user
        'status' => 'completed',
        'scheduled_start' => now()->subHours(2),
        'scheduled_end' => now()->subHours(1),
    ]);

    $response = $this->withHeaders(authHeaders($this->jobseeker))
        ->postJson("/api/mentorship/bookings/{$booking->id}/reviews", [
            'rating' => 5,
        ]);

    $response->assertStatus(404)
        ->assertJson([
            'success' => false,
            'message' => 'Booking tidak ditemukan.',
        ]);
});

it('calculates average ratings and shows them in details and listings', function () {
    $otherJobseeker1 = User::factory()->create(['role' => 'jobseeker']);
    $otherJobseeker2 = User::factory()->create(['role' => 'jobseeker']);

    $booking1 = MentorBooking::create([
        'mentor_id' => $this->mentor->id,
        'jobseeker_user_id' => $otherJobseeker1->id,
        'status' => 'completed',
        'scheduled_start' => now()->subHours(4),
        'scheduled_end' => now()->subHours(3),
    ]);
    
    $booking2 = MentorBooking::create([
        'mentor_id' => $this->mentor->id,
        'jobseeker_user_id' => $otherJobseeker2->id,
        'status' => 'completed',
        'scheduled_start' => now()->subHours(2),
        'scheduled_end' => now()->subHours(1),
    ]);

    // Create 2 reviews
    MentorReview::create([
        'mentor_booking_id' => $booking1->id,
        'mentor_id' => $this->mentor->id,
        'jobseeker_user_id' => $otherJobseeker1->id,
        'rating' => 4,
        'comment' => 'Bagus sekali',
    ]);

    MentorReview::create([
        'mentor_booking_id' => $booking2->id,
        'mentor_id' => $this->mentor->id,
        'jobseeker_user_id' => $otherJobseeker2->id,
        'rating' => 5,
        'comment' => 'Sempurna',
    ]);

    // Call mentors marketplace list API
    $response = $this->withHeaders(authHeaders($this->jobseeker))
        ->getJson('/api/mentorship/mentors');

    $response->assertStatus(200);
    $items = $response->json('data.items');
    $mentorItem = collect($items)->firstWhere('id', $this->mentor->id);
    
    // Average of 4 and 5 is 4.5
    expect($mentorItem['rating'])->toEqual(4.5);

    // Call mentor details API
    $detailResponse = $this->withHeaders(authHeaders($this->jobseeker))
        ->getJson("/api/mentorship/mentors/{$this->mentor->id}");

    $detailResponse->assertStatus(200)
        ->assertJsonPath('data.mentor.rating', 4.5)
        ->assertJsonCount(2, 'data.reviews');
});
