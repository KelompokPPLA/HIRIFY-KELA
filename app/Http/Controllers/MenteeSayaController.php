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
                'stats' => [
                    'total' => 0,
                    'confirmed' => 0,
                    'rejected' => 0,
                ],
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

            // Get the latest booking status
            $latestBooking = MentorBooking::where('mentor_id', $mentorId)
                            ->where('jobseeker_user_id', $user->id)
                            ->orderBy('created_at', 'desc')
                            ->first();
            $latestStatus = $latestBooking ? strtolower($latestBooking->status) : 'pending';

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
                'latest_status'     => $latestStatus,
                'started_at'        => $data ? $data->started_at : null,
                'avg_mentee_rating' => $avgMenteeRating ? round($avgMenteeRating, 1) : null,
            ];
        });

        // Apply status filter on collection
        if ($filterStatus === 'confirmed') {
            $mentees = $mentees->filter(fn($m) => in_array($m['latest_status'], ['confirmed', 'completed']));
        } elseif ($filterStatus === 'rejected') {
            $mentees = $mentees->filter(fn($m) => $m['latest_status'] === 'rejected');
        }

        $mentees = $mentees->values();

        // Stats calculation based on mapped list
        $allMenteeUsers = User::whereIn('id', $menteeIds)->get();
        $statsCalculated = $allMenteeUsers->map(function ($u) use ($mentorId) {
            $latestBooking = MentorBooking::where('mentor_id', $mentorId)
                            ->where('jobseeker_user_id', $u->id)
                            ->orderBy('created_at', 'desc')
                            ->first();
            return $latestBooking ? strtolower($latestBooking->status) : 'pending';
        });

        $stats = [
            'total'     => $statsCalculated->count(),
            'confirmed' => $statsCalculated->filter(fn($s) => in_array($s, ['confirmed', 'completed']))->count(),
            'rejected'  => $statsCalculated->filter(fn($s) => $s === 'rejected')->count(),
        ];

        return view('mentor.mentee.index', compact('mentees', 'stats', 'search', 'filterStatus'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $mentor = Mentor::where('user_id', $user->id)->firstOrFail();

        // Get the mentee User
        $mentee = User::with('profile')->findOrFail($id);

        // 1. Roadmap Progress
        $roadmap = Roadmap::where('user_id', $mentee->id)->orderBy('step_order')->get();
        $roadmapTotal = $roadmap->count();
        $roadmapCompleted = $roadmap->where('is_completed', true)->count();
        $roadmapProgress = $roadmapTotal > 0 ? (int)round(($roadmapCompleted / $roadmapTotal) * 100) : 0;

        // 2. Self Assessment
        $latestAssessment = SelfAssessment::where('user_id', $mentee->id)->latest()->first();
        $assessmentScore = $latestAssessment ? (int)$latestAssessment->score : 0;
        $assessmentScores = [];
        if ($latestAssessment) {
            $assessmentScores = json_decode($latestAssessment->category_scores_json, true) ?? [];
        }

        // 3. Pelatihan (Skill Enrollments)
        $userEnrollments = SkillEnrollment::where('user_id', $mentee->id)->with('course.lessons')->get();
        $enrollments = $userEnrollments->map(function ($enrollment) use ($mentee) {
            $course = $enrollment->course;
            if (!$course) return null;
            $lessons = $course->lessons;
            $totalLessons = $lessons->count();
            $lessonIds = $lessons->pluck('id');
            $completedLessons = SkillLessonProgress::where('user_id', $mentee->id)
                ->whereIn('skill_lesson_id', $lessonIds)
                ->whereNotNull('completed_at')
                ->count();
            $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
            return [
                'title' => $course->title,
                'category' => $course->category,
                'completed_lessons' => $completedLessons,
                'total_lessons' => $totalLessons,
                'progress' => $progress,
            ];
        })->filter()->values();

        $avgCourseProgress = $enrollments->count() > 0 ? (int)round($enrollments->avg('progress')) : 0;

        // 4. Mentorship Bookings
        $bookings = MentorBooking::where('mentor_id', $mentor->id)
            ->where('jobseeker_user_id', $mentee->id)
            ->orderBy('scheduled_start', 'desc')
            ->get();

        $completedSessions = $bookings->where('status', 'completed')->count();
        $totalSessions = $bookings->count();
        $sessionProgress = $totalSessions > 0 ? (int)round(($completedSessions / $totalSessions) * 100) : 0;

        // 5. Feedbacks
        $feedbacks = Feedback::where('mentor_id', $user->id)
            ->where('mentee_id', $mentee->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $avgMenteeRating = $feedbacks->whereNotNull('mentee_rating')->avg('mentee_rating');
        $ratingProgress = $avgMenteeRating ? (int)round($avgMenteeRating * 20) : 0;

        // 6. Success Score Calculation
        $components = [
            'Roadmap Progres' => $roadmapProgress,
            'Self Assessment' => $assessmentScore,
            'Pelatihan Selesai' => $avgCourseProgress,
            'Sesi Mentorship' => $sessionProgress,
            'Average Rating' => $ratingProgress,
        ];

        $successScore = (int)round(collect($components)->avg());

        // 7. Latest CV
        $cv = \App\Models\Cv::where('user_id', $mentee->id)
            ->with(['educations', 'experiences', 'skills'])
            ->latest()
            ->first();

        return view('mentor.mentee.show', compact(
            'mentee',
            'successScore',
            'components',
            'roadmapCompleted',
            'roadmapTotal',
            'roadmapProgress',
            'roadmap',
            'latestAssessment',
            'assessmentScore',
            'assessmentScores',
            'feedbacks',
            'enrollments',
            'bookings',
            'cv'
        ));
    }
}
