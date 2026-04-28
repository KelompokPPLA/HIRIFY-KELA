<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class ForumThread extends Model
{
    use UUID;

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'views_count',
    ];

    protected $casts = [
        'views_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(ForumComment::class);
    }
}
