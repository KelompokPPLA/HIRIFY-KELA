<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['question', 'category'];

    /**
     * Relasi: satu pertanyaan memiliki banyak jawaban.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
