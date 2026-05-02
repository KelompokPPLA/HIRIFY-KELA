<?php

use App\Models\SelfAssessment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

uses(RefreshDatabase::class);

function careerToolHeaders(User $user): array
{
    return [
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . JWTAuth::fromUser($user),
    ];
}

it('stores self assessment results for the authenticated jobseeker', function () {
    $user = User::factory()->create(['role' => 'jobseeker']);

    $this->withHeaders(careerToolHeaders($user))
        ->getJson('/api/self-assessment/questions')
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonCount(10, 'data');

    $this->withHeaders(careerToolHeaders($user))
        ->postJson('/api/self-assessment', [
            'answers' => [5, 4, 4, 4, 5, 4, 4, 5, 4, 4],
        ])
        ->assertCreated()
        ->assertJsonPath('success', true)
        ->assertJsonStructure(['data' => ['id', 'score', 'level', 'category_scores']]);

    expect(SelfAssessment::where('user_id', $user->id)->count())->toBe(1);
});

it('stores the selected career roadmap on the user profile', function () {
    $user = User::factory()->create(['role' => 'jobseeker']);

    $this->withHeaders(careerToolHeaders($user))
        ->getJson('/api/roadmap-karier')
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonStructure(['data' => ['paths', 'selected_path']]);

    $this->withHeaders(careerToolHeaders($user))
        ->postJson('/api/roadmap-karier/select', [
            'path_id' => 'backend',
        ])
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.selected_path', 'backend');

    expect($user->refresh()->profile->career_path)->toBe('backend');
});

