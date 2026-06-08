<?php

use App\Models\User;
use App\Models\Mentor;
use Illuminate\Support\Facades\DB;
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

it('shows followers count and follow activities on mentor dashboard', function () {
    // Check followers is initially 0
    $response = $this->actingAs($this->mentorUser)
        ->get(route('mentor.dashboard'));
    $response->assertStatus(200);
    $response->assertSee('Total Followers');

    // Add a follower
    DB::table('mentor_followers')->insert([
        'user_id' => $this->jobseeker->id,
        'mentor_id' => $this->mentor->id,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Check followers count is updated and follow activity is in timeline
    $response = $this->actingAs($this->mentorUser)
        ->get(route('mentor.dashboard'));
    $response->assertStatus(200);
    $response->assertSee('John Jobseeker');
    $response->assertSee('mulai mengikuti Anda');
});
