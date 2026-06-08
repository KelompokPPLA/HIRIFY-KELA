<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiJadwal extends Model
{
    use HasFactory;

    protected $table = 'sesiJadwal';

    protected $fillable = [
        'mentor_id',
        'topic',
        'description',
        'date',
        'time',
        'duration',
        'platform',
        'status',
        'notes',
        'material_file',
    ];

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'session_id');
    }

    public function bookings()
    {
        return $this->hasMany(MentorBooking::class, 'sesi_jadwal_id');
    }

    public static function autoCheckCompleted()
    {
        $pendingSessions = self::where('status', 'Pending')->get();

        foreach ($pendingSessions as $session) {
            $endDateTime = \Carbon\Carbon::parse($session->date . ' ' . $session->time)->addMinutes($session->duration);
            if ($endDateTime->isPast()) {
                $session->status = 'Completed';
                $session->save();

                // Sync status with related bookings
                $session->bookings()->where('status', 'confirmed')
                    ->update(['status' => 'completed']);
                $session->bookings()->where('status', 'pending')
                    ->update([
                        'status' => 'rejected',
                        'rejection_reason' => 'Sesi sudah selesai.',
                    ]);
            }
        }
    }
}
