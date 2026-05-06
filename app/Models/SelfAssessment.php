<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class SelfAssessment extends Model
{
    use UUID;

    protected $fillable = [
        'user_id',
        'answers_json',
        'category_scores_json',
        'score',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
