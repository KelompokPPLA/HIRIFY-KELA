<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('stores a jwt token in the session after web login', function () {
    $user = User::factory()->create([
        'email' => 'jobseeker@example.com',
        'password' => 'PasswordBaru123',
        'role' => 'jobseeker',
    ]);

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'PasswordBaru123',
    ])
        ->assertRedirect('/dashboard')
        ->assertSessionHas('jwt_token');
});

it('stores a jwt token in the session after web registration', function () {
    $this->post('/register', [
        'name' => 'Forum User',
        'email' => 'forum-user@example.com',
        'password' => 'PasswordBaru123',
        'password_confirmation' => 'PasswordBaru123',
        'role' => 'jobseeker',
    ])
        ->assertRedirect('/dashboard')
        ->assertSessionHas('jwt_token');
});

