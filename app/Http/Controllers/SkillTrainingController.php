<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\SkillCourse;
use App\Models\SkillEnrollment;
use App\Models\SkillLesson;
use App\Models\SkillLessonProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class SkillTrainingController extends Controller
{
    private function authUser()
    {
        try {
            return JWTAuth::parseToken()->authenticate();
        } catch (\Throwable $e) {
            abort(401, 'Token tidak valid atau sudah kedaluwarsa.');
        }
    }

    public function catalog(Request $request): JsonResponse
    {
        $user     = $this->authUser();
        $search   = trim($request->query('search', ''));
        $category = trim($request->query('category', ''));
        $level    = trim($request->query('level', ''));
        $perPage  = max(6, min((int) $request->query('per_page', 12), 50));
        $sort     = $request->query('sort', 'latest');

        $enrolledIds = SkillEnrollment::where('user_id', $user->id)
            ->pluck('skill_course_id')
            ->toArray();

        $query = SkillCourse::withCount('lessons');

        match ($sort) {
            'title'  => $query->orderBy('title'),
            'oldest' => $query->orderBy('created_at'),
            default  => $query->orderByDesc('created_at'),
        };

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($category !== '') {
            $query->where('category', $category);
        }

        if ($level !== '') {
            $query->where('level', $level);
        }

        $paginated = $query->paginate($perPage);

        $items = collect($paginated->items())->map(fn ($c) => [
            'id'              => $c->id,
            'title'           => $c->title,
            'description'     => $c->description,
            'category'        => $c->category,
            'level'           => $c->level,
            'level_label'     => $this->levelLabel($c->level),
            'thumbnail_emoji' => $c->thumbnail_emoji,
            'instructor_name' => $c->instructor_name,
            'estimated_hours' => $c->estimated_hours,
            'is_free'         => $c->is_free,
            'lessons_count'   => $c->lessons_count,
            'is_enrolled'     => in_array($c->id, $enrolledIds),
            'price_label'     => $c->is_free ? 'Gratis' : 'Berbayar',
        ]);

        $categories = SkillCourse::distinct()->pluck('category')->sort()->values();
        $levelCounts = SkillCourse::selectRaw('level, COUNT(*) as total')->groupBy('level')->pluck('total', 'level');

        return ResponseHelper::jsonResponse(true, 'Katalog kursus berhasil dimuat.', [
            'items'           => $items,
            'categories'      => $categories,
            'level_counts'    => $levelCounts,
            'total_enrolled'  => count($enrolledIds),
            'total'           => $paginated->total(),
            'current_page'    => $paginated->currentPage(),
            'last_page'       => $paginated->lastPage(),
        ], 200);
    }

    public function courseDetail(string $id): JsonResponse
    {
        $user   = $this->authUser();
        $course = SkillCourse::with(['lessons' => fn ($q) => $q->orderBy('order_number')])->find($id);

        if (! $course) {
            return ResponseHelper::jsonResponse(false, 'Kursus tidak ditemukan.', null, 404);
        }

        $enrollment = SkillEnrollment::where('user_id', $user->id)
            ->where('skill_course_id', $id)
            ->first();

        $completedLessonIds = [];
        if ($enrollment) {
            $completedLessonIds = SkillLessonProgress::where('user_id', $user->id)
                ->whereIn('skill_lesson_id', $course->lessons->pluck('id'))
                ->pluck('skill_lesson_id')
                ->toArray();
        }

        $totalLessons     = $course->lessons->count();
        $completedLessons = count($completedLessonIds);
        $progressPct      = $totalLessons > 0 ? (int) round(($completedLessons / $totalLessons) * 100) : 0;

        $lessons = $course->lessons->map(fn ($l) => [
            'id'               => $l->id,
            'title'            => $l->title,
            'content'          => $enrollment ? $l->content : null,
            'order_number'     => $l->order_number,
            'duration_minutes' => $l->duration_minutes,
            'is_completed'     => in_array($l->id, $completedLessonIds),
        ]);

        return ResponseHelper::jsonResponse(true, 'Detail kursus berhasil dimuat.', [
            'id'              => $course->id,
            'title'           => $course->title,
            'description'     => $course->description,
            'category'        => $course->category,
            'level'           => $course->level,
            'level_label'     => $this->levelLabel($course->level),
            'thumbnail_emoji' => $course->thumbnail_emoji,
            'instructor_name' => $course->instructor_name,
            'estimated_hours' => $course->estimated_hours,
            'is_free'         => $course->is_free,
            'is_enrolled'     => (bool) $enrollment,
            'progress_pct'    => $progressPct,
            'completed_count' => $completedLessons,
            'total_lessons'   => $totalLessons,
            'course_completed'  => $enrollment?->completed_at !== null,
            'course_status'     => ! $enrollment ? 'not_enrolled' : ($enrollment->completed_at ? 'completed' : ($completedLessons > 0 ? 'in_progress' : 'not_started')),
            'total_duration_minutes' => $course->lessons->sum('duration_minutes'),
            'lessons'          => $lessons,
        ], 200);
    }

    public function enroll(string $id): JsonResponse
    {
        $user   = $this->authUser();
        $course = SkillCourse::find($id);

        if (! $course) {
            return ResponseHelper::jsonResponse(false, 'Kursus tidak ditemukan.', null, 404);
        }

        $exists = SkillEnrollment::where('user_id', $user->id)
            ->where('skill_course_id', $id)
            ->exists();

        if ($exists) {
            return ResponseHelper::jsonResponse(false, 'Anda sudah terdaftar di kursus ini.', null, 409);
        }

        SkillEnrollment::create([
            'user_id'         => $user->id,
            'skill_course_id' => $id,
        ]);

        $totalLessons = $course->lessons()->count();

        return ResponseHelper::jsonResponse(true, 'Berhasil mendaftar ke kursus.', [
            'course_id'     => $id,
            'title'         => $course->title,
            'category'      => $course->category,
            'total_lessons' => $totalLessons,
            'enrolled_at'   => now()->toDateTimeString(),
        ], 201);
    }

    public function completeLesson(string $courseId, string $lessonId): JsonResponse
    {
        $user   = $this->authUser();

        $enrollment = SkillEnrollment::where('user_id', $user->id)
            ->where('skill_course_id', $courseId)
            ->first();

        if (! $enrollment) {
            return ResponseHelper::jsonResponse(false, 'Anda belum mendaftar ke kursus ini.', null, 403);
        }

        $lesson = SkillLesson::where('id', $lessonId)
            ->where('skill_course_id', $courseId)
            ->first();

        if (! $lesson) {
            return ResponseHelper::jsonResponse(false, 'Materi tidak ditemukan.', null, 404);
        }

        $alreadyCompleted = SkillLessonProgress::where('user_id', $user->id)
            ->where('skill_lesson_id', $lessonId)
            ->exists();

        if (! $alreadyCompleted) {
            SkillLessonProgress::create([
                'user_id'         => $user->id,
                'skill_lesson_id' => $lessonId,
                'completed_at'    => now(),
            ]);
        }

        $lessonIds    = SkillLesson::where('skill_course_id', $courseId)->pluck('id');
        $totalLessons = $lessonIds->count();
        $completed    = SkillLessonProgress::where('user_id', $user->id)
            ->whereIn('skill_lesson_id', $lessonIds)
            ->count();

        $progressPct = $totalLessons > 0 ? (int) round(($completed / $totalLessons) * 100) : 0;

        if ($progressPct === 100 && ! $enrollment->completed_at) {
            $enrollment->update(['completed_at' => now()]);
        }

        return ResponseHelper::jsonResponse(true, 'Materi ditandai selesai.', [
            'progress_pct'    => $progressPct,
            'completed_count' => $completed,
            'total_lessons'   => $totalLessons,
            'course_completed'=> $progressPct === 100,
            'lesson_was_new'  => ! $alreadyCompleted,
        ], 200);
    }

    public function myEnrollments(): JsonResponse
    {
        $user = $this->authUser();

        $enrollments = SkillEnrollment::where('user_id', $user->id)
            ->with('course.lessons')
            ->orderByDesc('created_at')
            ->get();

        $items = $enrollments->map(function ($enrollment) use ($user) {
            $course       = $enrollment->course;
            $totalLessons = $course->lessons->count();

            $completed = SkillLessonProgress::where('user_id', $user->id)
                ->whereIn('skill_lesson_id', $course->lessons->pluck('id'))
                ->count();

            $progressPct = $totalLessons > 0 ? (int) round(($completed / $totalLessons) * 100) : 0;

            $nextLesson = null;
            if (! $enrollment->completed_at && $totalLessons > 0) {
                $completedIds = SkillLessonProgress::where('user_id', $user->id)
                    ->whereIn('skill_lesson_id', $course->lessons->pluck('id'))
                    ->pluck('skill_lesson_id')
                    ->toArray();
                $nextLesson = $course->lessons
                    ->sortBy('order_number')
                    ->first(fn ($l) => ! in_array($l->id, $completedIds));
            }

            return [
                'enrollment_id'        => $enrollment->id,
                'course_id'            => $course->id,
                'title'                => $course->title,
                'category'             => $course->category,
                'level_label'          => $this->levelLabel($course->level),
                'thumbnail_emoji'      => $course->thumbnail_emoji,
                'instructor_name'      => $course->instructor_name,
                'estimated_hours'      => $course->estimated_hours,
                'progress_pct'         => $progressPct,
                'completed_count'      => $completed,
                'total_lessons'        => $totalLessons,
                'course_completed'     => (bool) $enrollment->completed_at,
                'completed_at'         => $enrollment->completed_at?->toDateTimeString(),
                'enrolled_at'          => $enrollment->created_at->diffForHumans(),
                'next_lesson_id'       => $nextLesson?->id,
                'next_lesson_title'    => $nextLesson?->title,
                'course_status'        => $enrollment->completed_at ? 'completed' : ($completed > 0 ? 'in_progress' : 'not_started'),
            ];
        });

        $completedCount = $enrollments->filter(fn ($e) => $e->completed_at !== null)->count();

        return ResponseHelper::jsonResponse(true, 'Kursus saya berhasil dimuat.', [
            'items'           => $items,
            'total'           => $enrollments->count(),
            'total_completed' => $completedCount,
            'total_in_progress' => $enrollments->count() - $completedCount,
        ], 200);
    }

    private function levelLabel(string $level): string
    {
        return match ($level) {
            'beginner'     => 'Pemula',
            'intermediate' => 'Menengah',
            'advanced'     => 'Lanjutan',
            default        => $level,
        };
    }
}
