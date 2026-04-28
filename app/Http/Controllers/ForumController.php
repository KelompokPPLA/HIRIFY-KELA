<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\ForumComment;
use App\Models\ForumThread;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ForumController extends Controller
{
    private function authUser()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    public function index(Request $request): JsonResponse
    {
        $search = $request->query('search', '');
        $perPage = min((int) $request->query('per_page', 15), 50);

        $query = ForumThread::with(['user:id,name,role'])
            ->withCount('comments')
            ->orderByDesc('created_at');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%");
            });
        }

        $paginated = $query->paginate($perPage);

        $items = collect($paginated->items())->map(fn ($thread) => [
            'id'             => $thread->id,
            'title'          => $thread->title,
            'body_preview'   => mb_substr($thread->body, 0, 200),
            'author'         => $thread->user?->name ?? 'Pengguna',
            'author_role'    => $thread->user?->role ?? '-',
            'comments_count' => $thread->comments_count,
            'views_count'    => $thread->views_count,
            'created_at'     => $thread->created_at->diffForHumans(),
        ]);

        return ResponseHelper::jsonResponse(true, 'Daftar thread berhasil dimuat.', [
            'items'        => $items,
            'total'        => $paginated->total(),
            'current_page' => $paginated->currentPage(),
            'last_page'    => $paginated->lastPage(),
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $user = $this->authUser();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string|max:10000',
        ]);

        $thread = ForumThread::create([
            'user_id' => $user->id,
            'title'   => $data['title'],
            'body'    => $data['body'],
        ]);

        return ResponseHelper::jsonResponse(true, 'Thread berhasil dibuat.', [
            'id'    => $thread->id,
            'title' => $thread->title,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $thread = ForumThread::with([
            'user:id,name,role',
            'comments.user:id,name,role',
        ])->find($id);

        if (! $thread) {
            return ResponseHelper::jsonResponse(false, 'Thread tidak ditemukan.', null, 404);
        }

        $thread->increment('views_count');

        $comments = $thread->comments->map(fn ($comment) => [
            'id'         => $comment->id,
            'body'       => $comment->body,
            'author'     => $comment->user?->name ?? 'Pengguna',
            'author_role'=> $comment->user?->role ?? '-',
            'user_id'    => $comment->user_id,
            'created_at' => $comment->created_at->diffForHumans(),
        ]);

        return ResponseHelper::jsonResponse(true, 'Detail thread berhasil dimuat.', [
            'id'             => $thread->id,
            'title'          => $thread->title,
            'body'           => $thread->body,
            'author'         => $thread->user?->name ?? 'Pengguna',
            'author_role'    => $thread->user?->role ?? '-',
            'user_id'        => $thread->user_id,
            'views_count'    => $thread->views_count,
            'created_at'     => $thread->created_at->diffForHumans(),
            'comments'       => $comments,
        ], 200);
    }

    public function addComment(Request $request, string $id): JsonResponse
    {
        $user = $this->authUser();

        $thread = ForumThread::find($id);
        if (! $thread) {
            return ResponseHelper::jsonResponse(false, 'Thread tidak ditemukan.', null, 404);
        }

        $data = $request->validate([
            'body' => 'required|string|max:5000',
        ]);

        $comment = ForumComment::create([
            'forum_thread_id' => $thread->id,
            'user_id'         => $user->id,
            'body'            => $data['body'],
        ]);

        return ResponseHelper::jsonResponse(true, 'Komentar berhasil ditambahkan.', [
            'id'          => $comment->id,
            'body'        => $comment->body,
            'author'      => $user->name,
            'author_role' => $user->role,
            'user_id'     => $user->id,
            'created_at'  => $comment->created_at->diffForHumans(),
        ], 201);
    }

    public function destroyThread(string $id): JsonResponse
    {
        $user = $this->authUser();

        $thread = ForumThread::find($id);
        if (! $thread) {
            return ResponseHelper::jsonResponse(false, 'Thread tidak ditemukan.', null, 404);
        }

        if ($thread->user_id !== $user->id && $user->role !== 'admin') {
            return ResponseHelper::jsonResponse(false, 'Anda tidak memiliki izin untuk menghapus thread ini.', null, 403);
        }

        $thread->delete();

        return ResponseHelper::jsonResponse(true, 'Thread berhasil dihapus.', null, 200);
    }

    public function destroyComment(string $threadId, string $commentId): JsonResponse
    {
        $user = $this->authUser();

        $comment = ForumComment::where('id', $commentId)
            ->where('forum_thread_id', $threadId)
            ->first();

        if (! $comment) {
            return ResponseHelper::jsonResponse(false, 'Komentar tidak ditemukan.', null, 404);
        }

        if ($comment->user_id !== $user->id && $user->role !== 'admin') {
            return ResponseHelper::jsonResponse(false, 'Anda tidak memiliki izin untuk menghapus komentar ini.', null, 403);
        }

        $comment->delete();

        return ResponseHelper::jsonResponse(true, 'Komentar berhasil dihapus.', null, 200);
    }
}
