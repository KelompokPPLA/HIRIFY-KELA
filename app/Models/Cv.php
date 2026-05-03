<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory, UUID;

    protected $table = 'cvs';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'email',
        'telepon',
        'alamat',
        'linkedin',
        'ringkasan',
        // Kolom 'skills' dihapus — skills kini disimpan di tabel 'skills' (relasi hasMany)
    ];

    /**
     * Get the user that owns this CV.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the educations for this CV.
     */
    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    /**
     * Get the experiences for this CV.
     */
    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    /**
     * Get all skills for this CV.
     */
    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    /**
     * Get only technical skills.
     */
    public function technicalSkills()
    {
        return $this->hasMany(Skill::class)->where('tipe', 'technical');
    }

    /**
     * Get only soft skills.
     */
    public function softSkills()
    {
        return $this->hasMany(Skill::class)->where('tipe', 'soft');
    }
}
