<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class SkillCourse extends Model
{
    use UUID;

    protected $fillable = [
        'title',
        'description',
        'category',
        'level',
        'thumbnail_emoji',
        'instructor_name',
        'estimated_hours',
        'is_free',
    ];

    protected $casts = [
        'estimated_hours' => 'integer',
        'is_free'         => 'boolean',
    ];

    public function lessons()
    {
        return $this->hasMany(SkillLesson::class)->orderBy('order_number');
    }

    public function enrollments()
    {
        return $this->hasMany(SkillEnrollment::class);
    }

    public function completedEnrollments()
    {
        return $this->hasMany(SkillEnrollment::class)->whereNotNull('completed_at');
    }

    public function getLevelLabelAttribute(): string
    {
        return match ($this->level) {
            'beginner'     => 'Pemula',
            'intermediate' => 'Menengah',
            'advanced'     => 'Lanjutan',
            default        => $this->level,
        };
    }
}
