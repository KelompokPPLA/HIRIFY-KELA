<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class MentorCertification extends Model
{
    use UUID;

    protected $table = 'mentor_certifications';

    protected $fillable = [
        'mentor_id',
        'title',
        'file_path',
    ];

    /**
     * Relasi ke Mentor
     */
    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }
}