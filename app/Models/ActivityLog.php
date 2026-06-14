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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('activity_type', $type);
    }

    public function scopeLastDays($query, int $days = 30)
    {
        return $query->where('activity_date', '>=', now()->subDays($days)->toDateString());
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->activity_type) {
            'training'        => 'Pelatihan',
            'self_assessment' => 'Self Assessment',
            'assessment'      => 'Self Assessment', // backward compat
            'mentorship'      => 'Mentorship',
            'portofolio'      => 'Portofolio',
            'cv'              => 'CV',
            default           => ucfirst(str_replace('_', ' ', $this->activity_type)),
        };
    }

    public function getTypeIconAttribute(): string
    {
        return match ($this->activity_type) {
            'training'        => '📚',
            'self_assessment' => '✅',
            'assessment'      => '✅', // backward compat
            'mentorship'      => '🤝',
            'portofolio'      => '🗂️',
            'cv'              => '📄',
            default           => '⚡',
        };
    }
}
