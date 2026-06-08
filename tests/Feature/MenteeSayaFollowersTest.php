<?php

use App\Models\User;
use App\Models\Mentor;
use App\Models\MentorBooking;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->jobseeker = User::factory()->create([
        'role' => 'jobseeker',
        'name' => 'John Jobseeker',
        'email' => 'john@jobseeker.com',
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

it('displays the followers count card on the mentee saya page', function () {
    // Check initially 0 followers
    $response = $this->actingAs($this->mentorUser)
        ->get(route('mentor.mentee.index'));
    $response->assertStatus(200);
    $response->assertSee('Jumlah Followers');
    $response->assertSee('0');

    // Add a follower
    DB::table('mentor_followers')->insert([
        'user_id' => $this->jobseeker->id,
        'mentor_id' => $this->mentor->id,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Check count updates to 1
    $response = $this->actingAs($this->mentorUser)
        ->get(route('mentor.mentee.index'));
    $response->assertStatus(200);
    $response->assertSee('Jumlah Followers');
    $response->assertSee('1');
});

it('filters by followers status and shows the followers badge', function () {
    // Add follower
    DB::table('mentor_followers')->insert([
        'user_id' => $this->jobseeker->id,
        'mentor_id' => $this->mentor->id,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Access page with followers status filter
    $response = $this->actingAs($this->mentorUser)
        ->get(route('mentor.mentee.index', ['status' => 'followers']));
    $response->assertStatus(200);

    // Should see follower name
    $response->assertSee('John Jobseeker');
    // Should see Followers badge/pill
    $response->assertSee('Followers');
});
