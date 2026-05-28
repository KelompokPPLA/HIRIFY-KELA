<?php

use App\Models\ForumComment;
use App\Models\ForumThread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

uses(RefreshDatabase::class);

function forumAuthHeaders(User $user): array
{
    return [
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . JWTAuth::fromUser($user),
    ];
}

it('allows an authenticated user to manage forum threads and comments', function () {
    $user = User::factory()->create([
        'role' => 'jobseeker',
    ]);

    $this->withHeaders(forumAuthHeaders($user))
        ->getJson('/api/forum/threads')
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.total', 0);

    $createResponse = $this->withHeaders(forumAuthHeaders($user))
        ->postJson('/api/forum/threads', [
            'title' => 'Tips membuat CV ATS',
            'body' => 'Bagaimana cara membuat CV ATS yang mudah dibaca sistem rekrutmen?',
        ])
        ->assertCreated()
        ->assertJsonPath('success', true)
        ->assertJsonPath('message', 'Thread berhasil dibuat.');

    $threadId = $createResponse->json('data.id');

    $this->assertDatabaseHas('forum_threads', [
        'id' => $threadId,
        'user_id' => $user->id,
        'title' => 'Tips membuat CV ATS',
    ]);

    $this->withHeaders(forumAuthHeaders($user))
        ->getJson("/api/forum/threads/{$threadId}")
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.title', 'Tips membuat CV ATS')
        ->assertJsonPath('data.comments', []);

    $commentResponse = $this->withHeaders(forumAuthHeaders($user))
        ->postJson("/api/forum/threads/{$threadId}/comments", [
            'body' => 'Mulai dari ringkasan singkat, pengalaman relevan, dan skill yang spesifik.',
        ])
        ->assertCreated()
        ->assertJsonPath('success', true)
        ->assertJsonPath('message', 'Komentar berhasil ditambahkan.');

    $commentId = $commentResponse->json('data.id');

    $this->assertDatabaseHas('forum_comments', [
        'id' => $commentId,
        'forum_thread_id' => $threadId,
        'user_id' => $user->id,
    ]);

    $this->withHeaders(forumAuthHeaders($user))
        ->putJson("/api/forum/threads/{$threadId}", [
            'title' => 'Tips membuat CV ATS yang kuat',
            'body' => 'Bagaimana cara membuat CV ATS yang jelas, singkat, dan relevan untuk lowongan?',
        ])
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.title', 'Tips membuat CV ATS yang kuat');

    $this->withHeaders(forumAuthHeaders($user))
        ->putJson("/api/forum/threads/{$threadId}/comments/{$commentId}", [
            'body' => 'Gunakan struktur ringkas, kata kunci relevan, dan pencapaian terukur.',
        ])
        ->assertOk()
        ->assertJsonPath('success', true);

    $this->withHeaders(forumAuthHeaders($user))
        ->deleteJson("/api/forum/threads/{$threadId}/comments/{$commentId}")
        ->assertOk()
        ->assertJsonPath('success', true);

    expect(ForumComment::find($commentId))->toBeNull();

    $this->withHeaders(forumAuthHeaders($user))
        ->deleteJson("/api/forum/threads/{$threadId}")
        ->assertOk()
        ->assertJsonPath('success', true);

    expect(ForumThread::find($threadId))->toBeNull();
});

