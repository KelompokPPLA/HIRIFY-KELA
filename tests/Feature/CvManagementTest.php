<?php

use App\Models\Cv;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('opens the CV management aliases with real user data', function () {
    $user = User::factory()->create(['role' => 'jobseeker']);

    Cv::create([
        'user_id' => $user->id,
        'nama_lengkap' => 'Abrar Rayhan',
        'email' => 'abrarrayhan8@gmail.com',
        'telepon' => '08123456789',
        'ringkasan' => 'Jobseeker yang siap bekerja.',
    ]);

    $this->actingAs($user)
        ->get('/manajemen-cv')
        ->assertOk()
        ->assertSee('Abrar Rayhan');

    $this->actingAs($user)
        ->get('/buat-cv-ats')
        ->assertOk()
        ->assertSee('Generate CV ATS');
});

it('allows a user to edit and update their CV ATS', function () {
    $user = User::factory()->create(['role' => 'jobseeker']);

    $cv = Cv::create([
        'user_id' => $user->id,
        'nama_lengkap' => 'Nama Lama',
        'email' => 'lama@example.com',
        'telepon' => '0811111111',
        'ringkasan' => 'Ringkasan lama.',
    ]);

    $this->actingAs($user)
        ->get(route('cv.edit', $cv))
        ->assertOk()
        ->assertSee('Nama Lama');

    $this->actingAs($user)
        ->put(route('cv.update', $cv), [
            'nama_lengkap' => 'Nama Baru',
            'email' => 'baru@example.com',
            'telepon' => '0822222222',
            'ringkasan' => 'Ringkasan baru untuk ATS.',
            'technical_skills' => 'Laravel, MySQL',
            'soft_skills' => 'Komunikasi, Kolaborasi',
            'pendidikan' => [
                ['institusi' => 'Universitas Hirify', 'gelar' => 'S1 Informatika', 'tahun' => '2022'],
            ],
            'pengalaman' => [
                ['posisi' => 'Backend Developer', 'perusahaan' => 'Hirify Lab', 'periode' => '2025', 'deskripsi' => 'Membangun API.'],
            ],
        ])
        ->assertRedirect(route('cv.show', $cv));

    $this->assertDatabaseHas('cvs', [
        'id' => $cv->id,
        'nama_lengkap' => 'Nama Baru',
        'email' => 'baru@example.com',
    ]);

    $this->assertDatabaseHas('skills', [
        'cv_id' => $cv->id,
        'nama_skill' => 'Laravel',
        'tipe' => 'technical',
    ]);
});

