<?php

use App\Models\User;
use App\Models\SesiJadwal;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->mentor = User::factory()->create([
        'role' => 'mentor',
    ]);
});

it('filters sessions by tab parameter', function () {
    // Create sessions with different statuses (excluding Confirmed status)
    SesiJadwal::create([
        'mentor_id' => $this->mentor->id,
        'topic' => 'Sesi Pending',
        'date' => '2026-06-10',
        'time' => '10:00:00',
        'duration' => 60,
        'status' => 'Pending',
    ]);

    SesiJadwal::create([
        'mentor_id' => $this->mentor->id,
        'topic' => 'Sesi Completed',
        'date' => '2026-06-08',
        'time' => '12:00:00',
        'duration' => 60,
        'status' => 'Completed',
    ]);

    SesiJadwal::create([
        'mentor_id' => $this->mentor->id,
        'topic' => 'Sesi Cancelled',
        'date' => '2026-06-09',
        'time' => '13:00:00',
        'duration' => 60,
        'status' => 'Cancelled',
    ]);

    // Test Mendatang (default, only Pending status exists now)
    $response = $this->actingAs($this->mentor)
        ->get(route('mentor.sesi-jadwal.index'));
    $response->assertStatus(200);
    $response->assertSee('Sesi Pending');
    $response->assertDontSee('Sesi Completed');
    $response->assertDontSee('Sesi Cancelled');

    // Test Completed
    $response = $this->actingAs($this->mentor)
        ->get(route('mentor.sesi-jadwal.index', ['tab' => 'completed']));
    $response->assertStatus(200);
    $response->assertSee('Sesi Completed');
    $response->assertDontSee('Sesi Pending');
    $response->assertDontSee('Sesi Cancelled');

    // Test Cancelled
    $response = $this->actingAs($this->mentor)
        ->get(route('mentor.sesi-jadwal.index', ['tab' => 'cancelled']));
    $response->assertStatus(200);
    $response->assertSee('Sesi Cancelled');
    $response->assertDontSee('Sesi Pending');
    $response->assertDontSee('Sesi Completed');

    // Test Riwayat (Completed + Cancelled)
    $response = $this->actingAs($this->mentor)
        ->get(route('mentor.sesi-jadwal.index', ['tab' => 'riwayat']));
    $response->assertStatus(200);
    $response->assertSee('Sesi Completed');
    $response->assertSee('Sesi Cancelled');
    $response->assertDontSee('Sesi Pending');
});
