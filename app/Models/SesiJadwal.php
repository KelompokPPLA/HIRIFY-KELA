<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiJadwal extends Model
{
    use HasFactory;

    protected $table = 'sesiJadwal';

    protected $fillable = [
        'mentor_id',
        'topic',
        'date',
        'time',
        'duration',
        'platform',
        'status',
        'notes',
    ];

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'session_id');
    }
}
