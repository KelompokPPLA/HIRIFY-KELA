<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use UUID;

    protected $fillable = [
        'user_id',
        'activity_type',
        'activity_date',
        'reference_id',
        'description',
    ];

    protected $casts = [
        'activity_date' => 'date',
    ];

    // ─── Relasi ─────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ─── Scopes ─────────────────────────────────────────────

    /**
     * Filter log berdasarkan tipe aktivitas.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('activity_type', $type);
    }

    /**
     * Filter log untuk 30 hari terakhir (untuk kalender heatmap).
     */
    public function scopeLastDays($query, int $days = 30)
    {
        return $query->where('activity_date', '>=', now()->subDays($days)->toDateString());
    }

    // ─── Helper ─────────────────────────────────────────────

    /**
     * Label aktivitas yang ramah pembaca.
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->activity_type) {
            'training'   => 'Pelatihan',
            'assessment' => 'Self Assessment',
            'mentorship' => 'Mentorship',
            default      => ucfirst($this->activity_type),
        };
    }

    /**
     * Icon emoji berdasarkan tipe aktivitas.
     */
    public function getTypeIconAttribute(): string
    {
        return match ($this->activity_type) {
            'training'   => '📚',
            'assessment' => '✅',
            'mentorship' => '🤝',
            default      => '⚡',
        };
    }
}
