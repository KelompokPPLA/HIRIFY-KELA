<?php

namespace App\Http\Controllers;

use App\Models\MentorBooking;
use App\Models\Profile;
use App\Models\SelfAssessment;
use App\Models\SkillEnrollment;
use App\Models\SkillLesson;
use App\Models\SkillLessonProgress;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.statistics');
        }

        if ($user->role === 'mentor') {
            return redirect()->route('mentor.dashboard');
        }

        $stats = $this->computeStats($user);
        $activities = $this->recentActivities($user);

        return view('dashboard.index', array_merge($stats, ['activities' => $activities]));
    }

    private function computeStats(User $user): array
    {
        $profile = $user->profile;
        $profileCompleteness = $this->profileCompleteness($profile);

        $enrolledCourseIds = SkillEnrollment::where('user_id', $user->id)->pluck('skill_course_id');
        $totalEnrolled = $enrolledCourseIds->count();
        $completedEnrolled = SkillEnrollment::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->count();

        if ($totalEnrolled > 0) {
            $lessonIds = SkillLesson::whereIn('skill_course_id', $enrolledCourseIds)->pluck('id');
            $totalLessons = $lessonIds->count();
            $completedLessons = $totalLessons > 0
                ? SkillLessonProgress::where('user_id', $user->id)
                    ->whereIn('skill_lesson_id', $lessonIds)
                    ->count()
                : 0;
            $trainingProgress = $totalLessons > 0
                ? (int) round(($completedLessons / $totalLessons) * 100)
                : 0;
        } else {
            $trainingProgress = 0;
        }

        $mentorshipTotal = MentorBooking::where('jobseeker_user_id', $user->id)->count();
        $mentorshipCompleted = MentorBooking::where('jobseeker_user_id', $user->id)
            ->where('status', 'completed')
            ->count();
        $mentorshipUpcoming = MentorBooking::where('jobseeker_user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        $latestAssessment = SelfAssessment::where('user_id', $user->id)
            ->latest()
            ->first();
        $careerReadiness = $latestAssessment ? (int) round($latestAssessment->score ?? 0) : 0;

        return [
            'profileCompleteness' => $profileCompleteness,
            'trainingCompleted' => $completedEnrolled,
            'trainingTotal' => $totalEnrolled,
            'trainingProgress' => $trainingProgress,
            'mentorshipTotal' => $mentorshipTotal,
            'mentorshipCompleted' => $mentorshipCompleted,
            'mentorshipUpcoming' => $mentorshipUpcoming,
            'careerReadiness' => $careerReadiness,
            'hasAssessment' => $latestAssessment !== null,
        ];
    }

    private function profileCompleteness(?Profile $profile): int
    {
        if (!$profile) {
            return 0;
        }

        $fields = ['first_name', 'last_name', 'bio', 'phone', 'location', 'photo', 'career_path'];
        $filled = 0;

        foreach ($fields as $field) {
            $value = $profile->{$field} ?? null;
            if (!empty(trim((string) $value))) {
                $filled++;
            }
        }

        return (int) round(($filled / count($fields)) * 100);
    }

    private function recentActivities(User $user): array
    {
        $items = collect();

        SkillEnrollment::with('course')
            ->where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->limit(5)
            ->get()
            ->each(function ($enrollment) use ($items) {
                $items->push([
                    'type' => 'training',
                    'icon' => '✓',
                    'color' => 'cyan',
                    'title' => 'Pelatihan "' . ($enrollment->course->title ?? 'Skill Course') . '" selesai',
                    'time' => $enrollment->completed_at,
                ]);
            });

        SkillLessonProgress::with('lesson.course')
            ->where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->limit(5)
            ->get()
            ->each(function ($progress) use ($items) {
                $title = $progress->lesson?->title ?? 'Lesson';
                $items->push([
                    'type' => 'lesson',
                    'icon' => '◉',
                    'color' => 'cyan',
                    'title' => 'Lesson "' . $title . '" selesai',
                    'time' => $progress->completed_at,
                ]);
            });

        MentorBooking::with('mentor.user')
            ->where('jobseeker_user_id', $user->id)
            ->latest('updated_at')
            ->limit(5)
            ->get()
            ->each(function ($booking) use ($items) {
                $mentorName = $booking->mentor?->user?->name ?? 'Mentor';
                $statusText = match ($booking->status) {
                    'pending' => 'Booking mentorship dengan ' . $mentorName . ' menunggu konfirmasi',
                    'confirmed' => 'Booking mentorship dengan ' . $mentorName . ' dikonfirmasi',
                    'completed' => 'Sesi mentorship dengan ' . $mentorName . ' selesai',
                    'cancelled' => 'Booking mentorship dengan ' . $mentorName . ' dibatalkan',
                    default => 'Booking mentorship dengan ' . $mentorName,
                };

                $items->push([
                    'type' => 'mentorship',
                    'icon' => $booking->status === 'completed' ? '✓' : '◷',
                    'color' => $booking->status === 'completed' ? 'cyan' : 'blue',
                    'title' => $statusText,
                    'time' => $booking->updated_at,
                ]);
            });

        SelfAssessment::where('user_id', $user->id)
            ->latest()
            ->limit(3)
            ->get()
            ->each(function ($assessment) use ($items) {
                $items->push([
                    'type' => 'assessment',
                    'icon' => '✓',
                    'color' => 'pink',
                    'title' => 'Self assessment selesai (skor: ' . round($assessment->score ?? 0) . ')',
                    'time' => $assessment->created_at,
                ]);
            });

        return $items
            ->filter(fn ($item) => $item['time'] !== null)
            ->sortByDesc('time')
            ->take(6)
            ->map(function ($item) {
                $item['time_label'] = Carbon::parse($item['time'])->diffForHumans();
                return $item;
            })
            ->values()
            ->all();
    }
}
