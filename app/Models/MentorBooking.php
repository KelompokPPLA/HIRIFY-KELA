<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class MentorBooking extends Model
{
    use UUID;

    protected $table = 'mentor_bookings';

    protected $fillable = [
        'mentor_id',
        'jobseeker_user_id',
        'mentor_availability_id',
        'sesi_jadwal_id',
        'scheduled_start',
        'scheduled_end',
        'status',
        'price_per_session',
        'booking_notes',
        'rejection_reason',
        'meeting_url',
    ];

    protected $casts = [
        'scheduled_start' => 'datetime',
        'scheduled_end' => 'datetime',
        'price_per_session' => 'decimal:2',
    ];

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

    public function jobseeker()
    {
        return $this->belongsTo(User::class, 'jobseeker_user_id');
    }

    public function availability()
    {
        return $this->belongsTo(MentorAvailability::class, 'mentor_availability_id');
    }

    public function sesiJadwal()
    {
        return $this->belongsTo(SesiJadwal::class, 'sesi_jadwal_id');
    }

    public function getDurationMinutesAttribute(): int
    {
        if (! $this->scheduled_start || ! $this->scheduled_end) {
            return 0;
        }
        return (int) $this->scheduled_start->diffInMinutes($this->scheduled_end);
    }

    public function getIsUpcomingAttribute(): bool
    {
        return in_array($this->status, ['pending', 'confirmed'], true)
            && $this->scheduled_start
            && $this->scheduled_start->isFuture();
    }
}
