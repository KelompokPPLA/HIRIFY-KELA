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
        'price_per_session',
    ];

    protected $casts = [
        'skills' => 'array',
        'price_per_session' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function certifications()
    {
        return $this->hasMany(MentorCertification::class);
    }

    public function availabilities()
    {
        return $this->hasMany(MentorAvailability::class);
    }

    public function bookings()
    {
        return $this->hasMany(MentorBooking::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('user', function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        });
    }
}
