<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = ['user_id', 'total_score', 'result'];

    /**
     * Relasi: assessment milik satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
