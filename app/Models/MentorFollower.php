<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentorFollower extends Model
{
    use HasFactory;

    protected $table = 'mentor_followers';

    protected $fillable = [
        'user_id',
        'mentor_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }
}
