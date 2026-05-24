<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserStreak extends Model
{
    use UUID;

    protected $fillable = [
        'user_id',
        'current_streak',
        'longest_streak',
        'last_activity_date',
        'total_activity_days',
    ];

    protected $casts = [
        'last_activity_date'   => 'date',
        'current_streak'       => 'integer',
        'longest_streak'       => 'integer',
        'total_activity_days'  => 'integer',
    ];

    // ─── Relasi ─────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'user_id', 'user_id');
    }

    // ─── Helper Attributes ──────────────────────────────────

    /**
     * Cek apakah streak pengguna masih aktif (aktivitas hari ini atau kemarin).
     */
    public function getIsActiveAttribute(): bool
    {
        if (! $this->last_activity_date) {
            return false;
        }

        $today     = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();

        return $this->last_activity_date->toDateString() === $today
            || $this->last_activity_date->toDateString() === $yesterday;
    }

    /**
     * Cek apakah pengguna sudah aktif hari ini.
     */
    public function getIsActiveToday(): bool
    {
        return $this->last_activity_date?->toDateString() === now()->toDateString();
    }
}
