<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['user_id', 'question_id', 'score'];

    /**
     * Relasi: jawaban milik satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: jawaban terkait satu pertanyaan.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
