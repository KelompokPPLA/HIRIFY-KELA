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

it('auto-completes past sessions and updates bookings when accessed via schedule index', function () {
    // Create a past session (e.g. yesterday) with Pending status
    $session = SesiJadwal::create([
        'mentor_id' => $this->mentorUser->id,
        'topic' => 'Past Android Session',
        'date' => now()->subDays(1)->toDateString(),
        'time' => '10:00:00',
        'duration' => 60,
        'status' => 'Pending',
    ]);

    // Create a confirmed booking
    $bookingConfirmed = MentorBooking::create([
        'mentor_id' => $this->mentor->id,
        'jobseeker_user_id' => $this->jobseeker->id,
        'sesi_jadwal_id' => $session->id,
        'status' => 'confirmed',
        'scheduled_start' => now()->subDays(1),
        'scheduled_end' => now()->subDays(1)->addHour(),
        'price_per_session' => 150000,
    ]);

    // Create a pending booking
    $bookingPending = MentorBooking::create([
        'mentor_id' => $this->mentor->id,
        'jobseeker_user_id' => $this->jobseeker->id,
        'sesi_jadwal_id' => $session->id,
        'status' => 'pending',
        'scheduled_start' => now()->subDays(1),
        'scheduled_end' => now()->subDays(1)->addHour(),
        'price_per_session' => 150000,
    ]);

    // Make request to SesiJadwal index
    $response = $this->actingAs($this->mentorUser)
        ->get(route('mentor.sesi-jadwal.index'));
    $response->assertStatus(200);

    // Verify session updated to Completed
    $session->refresh();
    expect($session->status)->toEqual('Completed');

    // Verify bookingConfirmed updated to completed
    $bookingConfirmed->refresh();
    expect($bookingConfirmed->status)->toEqual('completed');

    // Verify bookingPending updated to rejected
    $bookingPending->refresh();
    expect($bookingPending->status)->toEqual('rejected');
    expect($bookingPending->rejection_reason)->toEqual('Sesi sudah selesai.');
});

it('auto-completes past sessions and updates bookings when accessed via mentee index', function () {
    // Create a past session (e.g. yesterday) with Pending status
    $session = SesiJadwal::create([
        'mentor_id' => $this->mentorUser->id,
        'topic' => 'Past Android Session',
        'date' => now()->subDays(1)->toDateString(),
        'time' => '10:00:00',
        'duration' => 60,
        'status' => 'Pending',
    ]);

    // Create a pending booking
    $bookingPending = MentorBooking::create([
        'mentor_id' => $this->mentor->id,
        'jobseeker_user_id' => $this->jobseeker->id,
        'sesi_jadwal_id' => $session->id,
        'status' => 'pending',
        'scheduled_start' => now()->subDays(1),
        'scheduled_end' => now()->subDays(1)->addHour(),
        'price_per_session' => 150000,
    ]);

    // Make request to Mentee Saya index
    $response = $this->actingAs($this->mentorUser)
        ->get(route('mentor.mentee.index'));
    $response->assertStatus(200);

    // Verify session updated to Completed
    $session->refresh();
    expect($session->status)->toEqual('Completed');

    // Verify bookingPending updated to rejected
    $bookingPending->refresh();
    expect($bookingPending->status)->toEqual('rejected');
    expect($bookingPending->rejection_reason)->toEqual('Sesi sudah selesai.');
});
