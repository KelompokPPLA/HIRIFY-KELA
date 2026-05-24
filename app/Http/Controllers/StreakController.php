<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Services\StreakService;
use Illuminate\Http\Request;

class StreakController extends Controller
{
    public function __construct(private readonly StreakService $streakService) {}

    /**
     * Dashboard utama Career Streak.
     */
    public function index()
    {
        $user = auth()->user();
        $data = $this->streakService->getStreakDashboard($user);

        return view('streak.index', $data);
    }

    /**
     * Riwayat aktivitas dengan pagination.
     */
    public function history(Request $request)
    {
        $user     = auth()->user();
        $perPage  = 15;
        $type     = $request->query('type'); // filter opsional

        $query = ActivityLog::where('user_id', $user->id)
            ->orderByDesc('activity_date')
            ->orderByDesc('created_at');

        if ($type && in_array($type, ['training', 'assessment', 'mentorship'], true)) {
            $query->where('activity_type', $type);
        }

        $activities = $query->paginate($perPage)->withQueryString();
        $data       = $this->streakService->getStreakDashboard($user);

        return view('streak.history', array_merge($data, [
            'activities'  => $activities,
            'activeType'  => $type,
        ]));
    }
}
