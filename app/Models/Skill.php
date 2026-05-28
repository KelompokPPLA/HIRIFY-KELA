<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory, UUID;

    protected $table = 'skills';

    protected $fillable = [
        'cv_id',
        'nama_skill',
        'tipe',
    ];

    /**
     * Get the CV that owns this skill.
     */
    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}
