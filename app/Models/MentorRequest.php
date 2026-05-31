<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentorRequest extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'user_id', 'mentor_id', 'message', 'status', 'preferred_at', 'preferred_start', 'preferred_end',
    ];

    protected $casts = [
        'preferred_at' => 'datetime',
        'preferred_start' => 'string',
        'preferred_end' => 'string',
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
