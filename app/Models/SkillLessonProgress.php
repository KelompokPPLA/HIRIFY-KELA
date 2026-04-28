<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class SkillLessonProgress extends Model
{
    use UUID;

    protected $table = 'skill_lesson_progress';

    protected $fillable = [
        'user_id',
        'skill_lesson_id',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(SkillLesson::class, 'skill_lesson_id');
    }
}
