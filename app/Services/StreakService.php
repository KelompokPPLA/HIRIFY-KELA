<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\StreakBadge;
use App\Models\User;
use App\Models\UserStreak;
use App\Models\UserStreakBadge;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StreakService
{

    /**
     * Catat aktivitas pengguna dan perbarui streak.
     *
     * Dipanggil setelah user menyelesaikan:
     * training, self_assessment, mentorship, portofolio, atau cv.
     *
     * Kondisi A — belum ada aktivitas tipe ini hari ini:
     *   - Buat ActivityLog baru
     *   - Update streak counter (current, longest, total_activity_days)
     *   - Award badge jika memenuhi milestone
     *
     * Kondisi B — sudah ada aktivitas tipe ini hari ini:
     *   - Early return, tidak membuat record duplikat
     *   - Streak tidak berubah
     *
     * @param  User        $user
     * @param  string      $type  training|self_assessment|mentorship|portofolio|cv
     * @param  string|null $referenceId  UUID entitas terkait
     * @param  string|null $description  Deskripsi singkat aktivitas
     */
    public function recordActivity(
        User $user,
        string $type,
        ?string $referenceId = null,
        ?string $description = null
    ): void {
        $today = now()->toDateString();

        DB::transaction(function () use ($user, $type, $referenceId, $description, $today) {
            // ── Kondisi B: Cegah duplikasi aktivitas per tipe per hari ──────
            $alreadyLoggedToday = ActivityLog::where('user_id', $user->id)
                ->where('activity_type', $type)
                ->where('activity_date', $today)
                ->exists();

            if ($alreadyLoggedToday) {
                // Sudah ada aktivitas tipe ini hari ini — tidak perlu membuat record baru
                return;
            }

            // ── Kondisi A: Belum ada aktivitas tipe ini hari ini ────────────
            ActivityLog::create([
                'user_id'       => $user->id,
                'activity_type' => $type,
                'activity_date' => $today,
                'reference_id'  => $referenceId,
                'description'   => $description,
            ]);

            // Cek apakah ada aktivitas TIPE LAIN hari ini (untuk menentukan apakah streak sudah dihitung)
            $anyOtherActivityToday = ActivityLog::where('user_id', $user->id)
                ->where('activity_date', $today)
                ->where('activity_type', '!=', $type)
                ->exists();

            $streak = UserStreak::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'current_streak'      => 0,
                    'longest_streak'      => 0,
                    'last_activity_date'  => null,
                    'total_activity_days' => 0,
                ]
            );

            $lastDate = $streak->last_activity_date;

            // Hanya update streak jika belum ada aktivitas apapun hari ini
            if (! $anyOtherActivityToday &&
                ($lastDate === null || $lastDate->toDateString() !== $today)
            ) {
                $this->updateStreakCounter($streak, $today, $lastDate);
            } elseif ($lastDate === null || $lastDate->toDateString() !== $today) {
                // Ada aktivitas tipe lain tapi last_activity_date belum di-update hari ini
                $this->updateStreakCounter($streak, $today, $lastDate);
            }

            $this->checkAndAwardBadges($user, $streak->fresh());
        });
    }

    /**
     * Ambil semua data yang diperlukan untuk halaman dashboard streak.
     */
    public function getStreakDashboard(User $user): array
    {
        $streak = UserStreak::firstOrCreate(
            ['user_id' => $user->id],
            [
                'current_streak'      => 0,
                'longest_streak'      => 0,
                'last_activity_date'  => null,
                'total_activity_days' => 0,
            ]
        );

        $earnedBadges = UserStreakBadge::where('user_id', $user->id)
            ->with('badge')
            ->orderBy('earned_at', 'desc')
            ->get();

        $earnedBadgeIds = $earnedBadges->pluck('streak_badge_id')->toArray();

        $allBadges = StreakBadge::orderBy('milestone_days')->get();

        $nextBadge = $allBadges
            ->whereNotIn('id', $earnedBadgeIds)
            ->first();

        $nextBadgeProgress = 0;
        if ($nextBadge) {
            $nextBadgeProgress = $streak->current_streak > 0
                ? min(100, (int) round(($streak->current_streak / $nextBadge->milestone_days) * 100))
                : 0;
        }

        $heatmapData = $this->buildHeatmapData($user, 30);

        $activityStats = ActivityLog::where('user_id', $user->id)
            ->selectRaw('activity_type, COUNT(DISTINCT activity_date) as active_days, COUNT(*) as total_count')
            ->groupBy('activity_type')
            ->get()
            ->keyBy('activity_type');

        $recentActivities = ActivityLog::where('user_id', $user->id)
            ->orderByDesc('activity_date')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return [
            'streak'              => $streak,
            'isActiveToday'       => $streak->last_activity_date?->toDateString() === now()->toDateString(),
            'isStreakAlive'       => $streak->is_active,
            'earnedBadges'        => $earnedBadges,
            'allBadges'           => $allBadges,
            'earnedBadgeIds'      => $earnedBadgeIds,
            'nextBadge'           => $nextBadge,
            'nextBadgeProgress'   => $nextBadgeProgress,
            'heatmapData'         => $heatmapData,
            'activityStats'       => $activityStats,
            'recentActivities'    => $recentActivities,
        ];
    }

    /**
     * Kalkulasi dan perbarui counter streak berdasarkan tanggal aktivitas terakhir.
     */
    private function updateStreakCounter(UserStreak $streak, string $today, ?Carbon $lastDate): void
    {
        $yesterday = Carbon::yesterday()->toDateString();

        if ($lastDate === null) {
            // Pertama kali beraktivitas
            $streak->current_streak     = 1;
            $streak->total_activity_days = 1;
        } elseif ($lastDate->toDateString() === $yesterday) {
            // Aktivitas kemarin → lanjutkan streak
            $streak->current_streak++;
            $streak->total_activity_days++;
        } else {
            // Gap lebih dari 1 hari → reset streak
            $streak->current_streak     = 1;
            $streak->total_activity_days++;
        }

        if ($streak->current_streak > $streak->longest_streak) {
            $streak->longest_streak = $streak->current_streak;
        }

        $streak->last_activity_date = $today;
        $streak->save();
    }

    /**
     * Cek milestone badge dan award badge yang belum diperoleh.
     */
    private function checkAndAwardBadges(User $user, UserStreak $streak): void
    {
        $currentStreak = $streak->current_streak;

        if ($currentStreak <= 0) {
            return;
        }

        $eligibleBadges = StreakBadge::where('milestone_days', '<=', $currentStreak)->get();

        $alreadyEarned = UserStreakBadge::where('user_id', $user->id)
            ->pluck('streak_badge_id')
            ->toArray();

        foreach ($eligibleBadges as $badge) {
            if (! in_array($badge->id, $alreadyEarned, true)) {
                UserStreakBadge::create([
                    'user_id'        => $user->id,
                    'streak_badge_id' => $badge->id,
                    'earned_at'      => now(),
                ]);
            }
        }
    }

    /**
     * Bangun data kalender heatmap aktivitas N hari terakhir.
     * Return: array dengan key tanggal (Y-m-d) dan value jumlah aktivitas.
     */
    private function buildHeatmapData(User $user, int $days = 30): array
    {
        $startDate = now()->subDays($days - 1)->startOfDay();

        $logs = ActivityLog::where('user_id', $user->id)
            ->where('activity_date', '>=', $startDate->toDateString())
            ->selectRaw('activity_date, COUNT(*) as count')
            ->groupBy('activity_date')
            ->pluck('count', 'activity_date')
            ->toArray();

        // Isi semua tanggal dalam range (agar kalender penuh)
        $heatmap = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date           = now()->subDays($i)->toDateString();
            $heatmap[$date] = $logs[$date] ?? 0;
        }

        return $heatmap;
    }
}
