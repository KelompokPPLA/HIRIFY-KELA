<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\MentorBooking;
use App\Models\Feedback;
use App\Models\Roadmap;
use App\Models\SelfAssessment;
use App\Models\SkillEnrollment;
use App\Models\SkillLessonProgress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenteeSayaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Get mentor profile for this user
        $mentor = Mentor::where('user_id', $user->id)->first();

        if (!$mentor) {
            return view('mentor.mentee.index', [
                'mentees' => collect(),
                'stats' => ['total' => 0, 'active' => 0, 'inactive' => 0],
                'search' => '',
                'filterStatus' => 'all',
            ]);
        }

        // Build query: get all bookings for this mentor grouped by mentee
        $query = MentorBooking::with('jobseeker.profile')
            ->where('mentor_id', $mentor->id);

        // Apply status filter
        $filterStatus = $request->input('status', 'all');
        $search = $request->input('search', '');

        // Get unique mentee IDs from bookings
        $menteeData = MentorBooking::where('mentor_id', $mentor->id)
            ->whereNotNull('jobseeker_user_id')
            ->selectRaw('
                jobseeker_user_id,
                COUNT(*) as total_sessions,
                SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_sessions,
                MIN(created_at) as started_at,
                MAX(updated_at) as last_activity
            ')
            ->groupBy('jobseeker_user_id')
            ->get()
            ->keyBy('jobseeker_user_id');

        // Get mentee user records
        $menteeIds = $menteeData->keys();

        $menteesQuery = User::whereIn('id', $menteeIds)->with('profile');

        // Apply search
        if ($search) {
            $menteesQuery->where('name', 'like', '%' . $search . '%');
        }

        $menteeUsers = $menteesQuery->get();

        // Build enriched mentee list
        $mentorId     = $mentor->id;
        $mentorUserId = $user->id;
        $mentees = $menteeUsers->map(function ($user) use ($menteeData, $mentorId, $mentorUserId) {
            $data             = $menteeData->get($user->id);
            $totalSessions    = $data ? (int)$data->total_sessions : 0;
            $completedSessions= $data ? (int)$data->completed_sessions : 0;
            $progress         = $totalSessions > 0 ? round(($completedSessions / $totalSessions) * 100) : 0;

            // Active: has booking that is confirmed or pending (in progress)
            $isActive = MentorBooking::where('mentor_id', $mentorId)
                            ->where('jobseeker_user_id', $user->id)
                            ->whereIn('status', ['confirmed', 'pending'])
                            ->exists();

            // Average mentee_rating given by this mentor for this mentee
            $avgMenteeRating = Feedback::where('mentor_id', $mentorUserId)
                            ->where('mentee_id', $user->id)
                            ->whereNotNull('mentee_rating')
                            ->avg('mentee_rating');

            return [
                'id'                => $user->id,
                'name'              => $user->name,
                'email'             => $user->email,
                'avatar'            => strtoupper(substr($user->name, 0, 2)),
                'bidang'            => optional($user->profile)->posisi_kerja ?? 'Tidak Ada',
                'total_sessions'    => $totalSessions,
                'completed_sessions'=> $completedSessions,
                'progress'          => $progress,
                'is_active'         => $isActive,
                'started_at'        => $data ? $data->started_at : null,
                'avg_mentee_rating' => $avgMenteeRating ? round($avgMenteeRating, 1) : null,
            ];
        });

        // Apply status filter on collection
        if ($filterStatus === 'active') {
            $mentees = $mentees->filter(fn($m) => $m['is_active']);
        } elseif ($filterStatus === 'inactive') {
            $mentees = $mentees->filter(fn($m) => !$m['is_active']);
        }

        $mentees = $mentees->values();

        $stats = [
            'total'    => $mentees->count(),
            'active'   => $mentees->where('is_active', true)->count(),
            'inactive' => $mentees->where('is_active', false)->count(),
        ];

        return view('mentor.mentee.index', compact('mentees', 'stats', 'search', 'filterStatus'));
    }

    public function show(string $menteeId)
    {
        $mentorUser = Auth::user();
        $mentor = $mentorUser?->mentorProfile;

        if (! $mentor) {
            abort(404, 'Profil mentor tidak ditemukan.');
        }

        $mentee = User::with('profile')->where('role', 'jobseeker')->findOrFail($menteeId);

        $hasRelationship = MentorBooking::where('mentor_id', $mentor->id)
            ->where('jobseeker_user_id', $mentee->id)
            ->exists();

        if (! $hasRelationship) {
            abort(403, 'Mentee ini belum pernah memiliki booking dengan Anda.');
        }

        $roadmap = Roadmap::where('user_id', $mentee->id)
            ->orderBy('step_order')
            ->get();
        $roadmapTotal = $roadmap->count();
        $roadmapCompleted = $roadmap->where('is_completed', true)->count();
        $roadmapProgress = $roadmapTotal > 0 ? (int) round(($roadmapCompleted / $roadmapTotal) * 100) : 0;

        $latestAssessment = SelfAssessment::where('user_id', $mentee->id)
            ->latest()
            ->first();
        $assessmentScores = $latestAssessment ? json_decode($latestAssessment->category_scores_json, true) : [];
        $assessmentScore = (int) ($latestAssessment->score ?? 0);

        $bookings = MentorBooking::with('availability')
            ->where('mentor_id', $mentor->id)
            ->where('jobseeker_user_id', $mentee->id)
            ->orderByDesc('scheduled_start')
            ->get();
        $totalSessions = $bookings->count();
        $completedSessions = $bookings->where('status', 'completed')->count();
        $sessionProgress = $totalSessions > 0 ? (int) round(($completedSessions / $totalSessions) * 100) : 0;

        $feedbacks = Feedback::where('mentor_id', $mentorUser->id)
            ->where('mentee_id', $mentee->id)
            ->orderByDesc('created_at')
            ->get();
        $averageRating = $feedbacks->whereNotNull('mentee_rating')->avg('mentee_rating');
        $ratingScore = $averageRating ? (int) round(($averageRating / 5) * 100) : 0;

        $enrollments = SkillEnrollment::with('course.lessons')
            ->where('user_id', $mentee->id)
            ->latest()
            ->get()
            ->map(function ($enrollment) use ($mentee) {
                $course = $enrollment->course;
                $lessonIds = $course?->lessons?->pluck('id') ?? collect();
                $totalLessons = $lessonIds->count();
                $completedLessons = $totalLessons > 0
                    ? SkillLessonProgress::where('user_id', $mentee->id)->whereIn('skill_lesson_id', $lessonIds)->count()
                    : 0;
                $progress = $totalLessons > 0 ? (int) round(($completedLessons / $totalLessons) * 100) : 0;

                return [
                    'title' => $course?->title ?? 'Kursus',
                    'category' => $course?->category ?? '-',
                    'completed_lessons' => $completedLessons,
                    'total_lessons' => $totalLessons,
                    'progress' => $progress,
                    'completed_at' => $enrollment->completed_at,
                ];
            });

        $trainingProgress = $enrollments->count() > 0 ? (int) round($enrollments->avg('progress')) : 0;

        $components = [
            'Roadmap' => $roadmapProgress,
            'Assessment' => $assessmentScore,
            'Pelatihan' => $trainingProgress,
            'Sesi' => $sessionProgress,
            'Rating' => $ratingScore,
        ];

        $successScore = (int) round(
            ($roadmapProgress * 0.25)
            + ($assessmentScore * 0.25)
            + ($trainingProgress * 0.20)
            + ($sessionProgress * 0.20)
            + ($ratingScore * 0.10)
        );

        $recommendation = $this->recommendationFor($components);

        return view('mentor.mentee.show', compact(
            'mentee',
            'roadmap',
            'roadmapTotal',
            'roadmapCompleted',
            'roadmapProgress',
            'latestAssessment',
            'assessmentScores',
            'assessmentScore',
            'bookings',
            'totalSessions',
            'completedSessions',
            'sessionProgress',
            'feedbacks',
            'averageRating',
            'enrollments',
            'trainingProgress',
            'components',
            'successScore',
            'recommendation'
        ));
    }

    private function recommendationFor(array $components): string
    {
        asort($components);
        $weakest = array_key_first($components);

        return match ($weakest) {
            'Roadmap' => 'Arahkan mentee untuk menyelesaikan langkah roadmap yang belum selesai sebelum menambah target baru.',
            'Assessment' => 'Ajak mentee melakukan refleksi skill dan ulangi self assessment setelah sesi pendampingan berikutnya.',
            'Pelatihan' => 'Rekomendasikan modul pelatihan yang paling dekat dengan target karier mentee minggu ini.',
            'Sesi' => 'Jadwalkan sesi lanjutan agar progres mentorship lebih konsisten dan terdokumentasi.',
            'Rating' => 'Berikan feedback yang lebih spesifik agar mentee tahu kekuatan dan area perbaikan prioritas.',
            default => 'Pertahankan ritme belajar saat ini dan tetapkan target kecil untuk minggu berikutnya.',
        };
    }
}
