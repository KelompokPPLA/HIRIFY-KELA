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
        'skills',
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
     * Get skills as array.
     */
    public function getSkillsArrayAttribute(): array
    {
        return $this->skills ? array_map('trim', explode(',', $this->skills)) : [];
    }
}
