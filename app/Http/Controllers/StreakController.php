<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Services\StreakService;
use Illuminate\Http\Request;

class StreakController extends Controller
{
    public function __construct(private readonly StreakService $streakService) {}

    public function index()
    {
        $user = auth()->user();
        $data = $this->streakService->getStreakDashboard($user);

        return view('streak.index', $data);
    }

    public function history(Request $request)
    {
        $user     = auth()->user();
        $perPage  = 15;
        $type     = $request->query('type');

        $query = ActivityLog::where('user_id', $user->id)
            ->orderByDesc('activity_date')
            ->orderByDesc('created_at');

        if ($type && in_array($type, ['training', 'self_assessment', 'assessment', 'mentorship', 'portofolio', 'cv'], true)) {
            // 'assessment' masih didukung untuk backward compat
            $filterType = $type === 'assessment' ? 'self_assessment' : $type;
            $query->where('activity_type', $filterType);
        }

        $activities = $query->paginate($perPage)->withQueryString();
        $data       = $this->streakService->getStreakDashboard($user);

        return view('streak.history', array_merge($data, [
            'activities'  => $activities,
            'activeType'  => $type,
        ]));
    }
}
