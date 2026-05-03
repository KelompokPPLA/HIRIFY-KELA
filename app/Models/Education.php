<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory, UUID;

    protected $table = 'educations';

    protected $fillable = [
        'cv_id',
        'institusi',
        'gelar',
        'tahun',
    ];

    /**
     * Get the CV that owns this education.
     */
    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}
