<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\ForumThread;
use App\Models\MentorBooking;
use App\Models\SkillCourse;
use App\Models\SkillEnrollment;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminStatisticsController extends Controller
{
    private function authUser()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    public function index(): JsonResponse
    {
        $this->authUser();

        $totalUsers    = User::count();
        $usersByRole   = User::select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->pluck('total', 'role');

        $totalBookings      = MentorBooking::count();
        $bookingsByStatus   = MentorBooking::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalCourses          = SkillCourse::count();
        $totalEnrollments      = SkillEnrollment::count();
        $completedEnrollments  = SkillEnrollment::whereNotNull('completed_at')->count();

        $totalThreads = ForumThread::count();

        $months = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i)->format('Y-m'));

        $usersPerMonth = User::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->pluck('total', 'month');

        $bookingsPerMonth = MentorBooking::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->pluck('total', 'month');

        $enrollmentsPerMonth = SkillEnrollment::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyData = $months->map(fn ($m) => [
            'month'       => $m,
            'users'       => $usersPerMonth[$m]       ?? 0,
            'bookings'    => $bookingsPerMonth[$m]     ?? 0,
            'enrollments' => $enrollmentsPerMonth[$m]  ?? 0,
        ])->values();

        $recentUsers = User::orderByDesc('created_at')
            ->limit(10)
            ->get(['id', 'name', 'email', 'role', 'created_at']);

        return ResponseHelper::jsonResponse(true, 'Statistik platform berhasil dimuat.', [
            'summary' => [
                'total_users'          => $totalUsers,
                'users_by_role'        => [
                    'jobseeker' => (int) ($usersByRole['jobseeker'] ?? 0),
                    'mentor'    => (int) ($usersByRole['mentor']    ?? 0),
                    'admin'     => (int) ($usersByRole['admin']     ?? 0),
                ],
                'total_bookings'       => $totalBookings,
                'bookings_by_status'   => [
                    'pending'   => (int) ($bookingsByStatus['pending']   ?? 0),
                    'confirmed' => (int) ($bookingsByStatus['confirmed'] ?? 0),
                    'completed' => (int) ($bookingsByStatus['completed'] ?? 0),
                    'cancelled' => (int) ($bookingsByStatus['cancelled'] ?? 0),
                ],
                'total_courses'           => $totalCourses,
                'total_enrollments'       => $totalEnrollments,
                'completed_enrollments'   => $completedEnrollments,
                'total_forum_threads'     => $totalThreads,
            ],
            'monthly_activity' => $monthlyData,
            'recent_users'     => $recentUsers,
        ], 200);
    }
}
