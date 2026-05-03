<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class SkillLesson extends Model
{
    use UUID;

    protected $fillable = [
        'skill_course_id',
        'title',
        'content',
        'order_number',
        'duration_minutes',
    ];

    protected $casts = [
        'order_number'     => 'integer',
        'duration_minutes' => 'integer',
    ];

    public function course()
    {
        return $this->belongsTo(SkillCourse::class, 'skill_course_id');
    }

    public function progress()
    {
        return $this->hasMany(SkillLessonProgress::class);
    }

    public function getDurationLabelAttribute(): string
    {
        $minutes = $this->duration_minutes ?? 0;
        if ($minutes < 60) {
            return $minutes . ' menit';
        }
        $hours   = intdiv($minutes, 60);
        $remaining = $minutes % 60;
        return $remaining > 0 ? $hours . ' jam ' . $remaining . ' menit' : $hours . ' jam';
    }
}
