<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class SkillEnrollment extends Model
{
    use UUID;

    protected $fillable = [
        'user_id',
        'skill_course_id',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(SkillCourse::class, 'skill_course_id');
    }
}
