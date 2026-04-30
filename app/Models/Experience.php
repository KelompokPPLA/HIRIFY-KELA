<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory, UUID;

    protected $table = 'experiences';

    protected $fillable = [
        'cv_id',
        'posisi',
        'perusahaan',
        'deskripsi',
        'periode',
    ];

    /**
     * Get the CV that owns this experience.
     */
    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}
