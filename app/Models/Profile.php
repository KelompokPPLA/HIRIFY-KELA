<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use UUID;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'bio',
        'phone',
        'location',
        'photo',
        'career_path',
        'education',
        'experience',
        'skills',
    ];

    protected $casts = [
        'education' => 'array',
        'experience' => 'array',
        'skills' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
