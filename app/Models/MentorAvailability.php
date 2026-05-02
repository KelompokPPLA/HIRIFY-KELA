<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class MentorAvailability extends Model
{
    use UUID;

    protected $table = 'mentor_availabilities';

    protected $fillable = [
        'mentor_id',
        'start_at',
        'end_at',
        'timezone',
        'is_booked',
        'label',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'is_booked' => 'boolean',
    ];

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

    public function booking()
    {
        return $this->hasOne(MentorBooking::class, 'mentor_availability_id');
    }
}
