<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use UUID;

    protected $table = 'mentors';

    protected $fillable = [
        'user_id',
        'profile_picture',
        'phone_number',
        'expertise',
        'experience_years',
        'bio',
        'education',
        'skills',
        'availability',
        'price_per_session'
    ];

    /**
     * Casting untuk JSON & tipe data
     */
    protected $casts = [
        'skills' => 'array',
        'price_per_session' => 'decimal:2',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function certifications()
    {
        return $this->hasMany(MentorCertification::class);
    }

    /**
     * Scope Search (berdasarkan nama user)
     */
    public function scopeSearch($query, $search)
    {
        return $query->whereHas('user', function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        });
    }
}