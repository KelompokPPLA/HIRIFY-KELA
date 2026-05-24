<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StreakBadge extends Model
{
    use UUID;

    protected $fillable = [
        'name',
        'description',
        'milestone_days',
        'icon',
        'color',
    ];

    protected $casts = [
        'milestone_days' => 'integer',
    ];

    // ─── Relasi ─────────────────────────────────────────────

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_streak_badges')
                    ->withPivot('earned_at')
                    ->withTimestamps();
    }

    public function userStreakBadges(): HasMany
    {
        return $this->hasMany(UserStreakBadge::class);
    }

    // ─── Scope ──────────────────────────────────────────────

    /**
     * Badge yang sesuai atau lebih kecil dari streak tertentu.
     */
    public function scopeEligibleFor($query, int $streakDays)
    {
        return $query->where('milestone_days', '<=', $streakDays)->orderBy('milestone_days');
    }
}
