<?php

use App\Models\User;
use App\Models\Mentor;
use App\Models\MentorBooking;
use App\Models\SesiJadwal;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->jobseeker = User::factory()->create([
        'role' => 'jobseeker',
        'name' => 'John Jobseeker',
    ]);

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

it('rejects booking when mentor accepts a completed or cancelled session', function () {
    $session = SesiJadwal::create([
        'mentor_id' => $this->mentorUser->id,
        'topic' => 'Android Development',
        'date' => '2026-06-10',
        'time' => '10:00:00',
        'duration' => 60,
        'status' => 'Completed',
    ]);

    $booking = MentorBooking::create([
        'mentor_id' => $this->mentor->id,
        'jobseeker_user_id' => $this->jobseeker->id,
        'sesi_jadwal_id' => $session->id,
        'status' => 'pending',
        'scheduled_start' => now()->addDay(),
        'scheduled_end' => now()->addDay()->addHour(),
        'price_per_session' => 150000,
    ]);

    $response = $this->actingAs($this->mentorUser)
        ->post(route('mentor.bookings.accept', $booking->id));

    $response->assertSessionHas('error', 'Sesi sudah selesai atau dibatalkan. Permintaan booking otomatis ditolak.');

    // Verify booking is rejected in db
    $this->assertDatabaseHas('mentor_bookings', [
        'id' => $booking->id,
        'status' => 'rejected',
        'rejection_reason' => 'Sesi sudah selesai atau dibatalkan.',
    ]);
});

it('auto-rejects pending bookings when updating session to completed or cancelled', function () {
    $session = SesiJadwal::create([
        'mentor_id' => $this->mentorUser->id,
        'topic' => 'Android Development',
        'date' => '2026-06-10',
        'time' => '10:00:00',
        'duration' => 60,
        'status' => 'Pending',
    ]);

    $bookingConfirmed = MentorBooking::create([
        'mentor_id' => $this->mentor->id,
        'jobseeker_user_id' => $this->jobseeker->id,
        'sesi_jadwal_id' => $session->id,
        'status' => 'confirmed',
        'scheduled_start' => now()->addDay(),
        'scheduled_end' => now()->addDay()->addHour(),
        'price_per_session' => 150000,
    ]);

    $bookingPending = MentorBooking::create([
        'mentor_id' => $this->mentor->id,
        'jobseeker_user_id' => $this->jobseeker->id,
        'sesi_jadwal_id' => $session->id,
        'status' => 'pending',
        'scheduled_start' => now()->addDay(),
        'scheduled_end' => now()->addDay()->addHour(),
        'price_per_session' => 150000,
    ]);

    // Update SesiJadwal to Completed
    $response = $this->actingAs($this->mentorUser)
        ->put(route('mentor.sesi-jadwal.update', $session->id), [
            'topic' => 'Android Development',
            'date' => '2026-06-10',
            'time' => '10:00:00',
            'duration' => 60,
            'status' => 'Completed',
        ]);

    $response->assertRedirect(route('mentor.sesi-jadwal.show', $session->id));

    // bookingConfirmed should be completed
    $this->assertDatabaseHas('mentor_bookings', [
        'id' => $bookingConfirmed->id,
        'status' => 'completed',
    ]);

    // bookingPending should be rejected
    $this->assertDatabaseHas('mentor_bookings', [
        'id' => $bookingPending->id,
        'status' => 'rejected',
        'rejection_reason' => 'Sesi sudah selesai.',
    ]);
});
