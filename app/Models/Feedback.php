<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'mentor_id',
        'mentee_id',
        'session_id',
        'rating',
        'strength',
        'improvement',
        'recommendation',
    ];

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function mentee()
    {
        return $this->belongsTo(User::class, 'mentee_id');
    }

    public function session()
    {
        return $this->belongsTo(SesiJadwal::class, 'session_id');
    }
}
