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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
