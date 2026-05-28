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
    public function index(): JsonResponse
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Tidak terautentikasi.', null, 401);
        }

        return ResponseHelper::jsonResponse(true, 'Statistik platform berhasil dimuat.', $this->buildStats(), 200);
    }

    public function show()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }

        $stats = $this->buildStats();

        return view('admin.statistics', [
            'summary' => $stats['summary'],
            'monthly' => $stats['monthly_activity'],
            'recentUsers' => $stats['recent_users'],
        ]);
    }

    public function users()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }

        $users = User::orderByDesc('created_at')->paginate(20);

        return view('admin.users', ['users' => $users]);
    }

    public function activity()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }

        $stats = $this->buildStats();
        $recentBookings = MentorBooking::with(['mentor.user', 'jobseeker'])
            ->latest()
            ->limit(15)
            ->get();
        $recentEnrollments = SkillEnrollment::with(['user', 'course'])
            ->latest()
            ->limit(15)
            ->get();
        $recentThreads = ForumThread::with('user')
            ->latest()
            ->limit(15)
            ->get();

        return view('admin.activity', [
            'monthly' => $stats['monthly_activity'],
            'recentBookings' => $recentBookings,
            'recentEnrollments' => $recentEnrollments,
            'recentThreads' => $recentThreads,
        ]);
    }

    private function buildStats(): array
    {
        $totalUsers = User::count();
        $usersByRole = User::select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->pluck('total', 'role');

        $totalBookings = MentorBooking::count();
        $bookingsByStatus = MentorBooking::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalCourses = SkillCourse::count();
        $totalEnrollments = SkillEnrollment::count();
        $completedEnrollments = SkillEnrollment::whereNotNull('completed_at')->count();

        $totalThreads = ForumThread::count();

        $months = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i)->format('Y-m'));
        $monthLabels = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i)->locale('id')->isoFormat('MMM YY'));

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

        $monthlyData = $months->map(fn ($m, $i) => [
            'month' => $m,
            'label' => $monthLabels[$i],
            'users' => (int) ($usersPerMonth[$m] ?? 0),
            'bookings' => (int) ($bookingsPerMonth[$m] ?? 0),
            'enrollments' => (int) ($enrollmentsPerMonth[$m] ?? 0),
        ])->values();

        $recentUsers = User::orderByDesc('created_at')
            ->limit(10)
            ->get(['id', 'name', 'email', 'role', 'created_at']);

        return [
            'summary' => [
                'total_users' => $totalUsers,
                'users_by_role' => [
                    'jobseeker' => (int) ($usersByRole['jobseeker'] ?? 0),
                    'mentor' => (int) ($usersByRole['mentor'] ?? 0),
                    'admin' => (int) ($usersByRole['admin'] ?? 0),
                ],
                'total_bookings' => $totalBookings,
                'bookings_by_status' => [
                    'pending' => (int) ($bookingsByStatus['pending'] ?? 0),
                    'confirmed' => (int) ($bookingsByStatus['confirmed'] ?? 0),
                    'completed' => (int) ($bookingsByStatus['completed'] ?? 0),
                    'cancelled' => (int) ($bookingsByStatus['cancelled'] ?? 0),
                ],
                'total_courses' => $totalCourses,
                'total_enrollments' => $totalEnrollments,
                'completed_enrollments' => $completedEnrollments,
                'total_forum_threads' => $totalThreads,
            ],
            'monthly_activity' => $monthlyData->all(),
            'recent_users' => $recentUsers->all(),
        ];
    }
}
