<?php

use App\Models\Portofolio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('allows an authenticated jobseeker to view their portfolio list', function () {
    $user = User::factory()->create(['role' => 'jobseeker']);
    
    Portofolio::create([
        'user_id' => $user->id,
        'title' => 'Sistem Informasi E-Commerce',
        'type' => 'project',
        'description' => 'Membangun platform belanja online dengan Laravel.',
        'skills' => 'Laravel, Vue.js, Tailwind',
    ]);

    $this->actingAs($user)
        ->get(route('portofolio.index'))
        ->assertOk()
        ->assertSee('Sistem Informasi E-Commerce')
        ->assertSee('Proyek');

    $this->actingAs($user)
        ->get('/profile')
        ->assertOk()
        ->assertSee('Sistem Informasi E-Commerce')
        ->assertSee('Portofolio');
});

it('allows a jobseeker to create a portfolio item with files', function () {
    Storage::fake('public');
    
    $user = User::factory()->create(['role' => 'jobseeker']);
    
    $file = UploadedFile::fake()->image('project_preview.jpg');

    $this->actingAs($user)
        ->post(route('portofolio.store'), [
            'title' => 'Aplikasi Pembayaran Digital',
            'type' => 'project',
            'description' => 'Aplikasi dompet digital dengan QRIS.',
            'skills' => 'Laravel, Flutter, PostgreSQL',
            'link' => 'https://github.com/myusername/wallet-app',
            'start_date' => '2026-01-01',
            'end_date' => '2026-03-31',
            'file' => $file,
        ])
        ->assertRedirect(route('portofolio.index'));

    $this->assertDatabaseHas('portofolios', [
        'user_id' => $user->id,
        'title' => 'Aplikasi Pembayaran Digital',
        'type' => 'project',
    ]);

    $portfolio = Portofolio::where('title', 'Aplikasi Pembayaran Digital')->first();
    expect($portfolio->file_path)->not->toBeNull();
    Storage::disk('public')->assertExists($portfolio->file_path);
});

it('allows a jobseeker to edit and update their portfolio', function () {
    $user = User::factory()->create(['role' => 'jobseeker']);
    
    $portfolio = Portofolio::create([
        'user_id' => $user->id,
        'title' => 'Sertifikat AWS Cloud Practitioner',
        'type' => 'certificate',
        'description' => 'Sertifikat cloud computing dasar.',
        'skills' => 'AWS, Cloud Computing',
    ]);

    $this->actingAs($user)
        ->get(route('portofolio.edit', $portfolio->id))
        ->assertOk()
        ->assertSee('Sertifikat AWS Cloud Practitioner');

    $this->actingAs($user)
        ->put(route('portofolio.update', $portfolio->id), [
            'title' => 'AWS Certified Cloud Practitioner - Updated',
            'type' => 'certificate',
            'description' => 'Sertifikat cloud computing dasar terverifikasi.',
            'skills' => 'AWS, Cloud Computing, IAM',
            'is_ongoing' => '1',
        ])
        ->assertRedirect(route('portofolio.index'));

    $this->assertDatabaseHas('portofolios', [
        'id' => $portfolio->id,
        'title' => 'AWS Certified Cloud Practitioner - Updated',
        'is_ongoing' => true,
    ]);
});

it('allows a jobseeker to delete their portfolio', function () {
    $user = User::factory()->create(['role' => 'jobseeker']);
    
    $portfolio = Portofolio::create([
        'user_id' => $user->id,
        'title' => 'Desain Landing Page Agency',
        'type' => 'project',
    ]);

    $this->actingAs($user)
        ->delete(route('portofolio.destroy', $portfolio->id))
        ->assertRedirect(route('portofolio.index'));

    $this->assertDatabaseMissing('portofolios', [
        'id' => $portfolio->id,
    ]);
});
