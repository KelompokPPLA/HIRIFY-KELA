<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentorReview extends Model
{
    use HasFactory, UUID;

    protected $table = 'mentor_reviews';

    protected $fillable = [
        'mentor_booking_id',
        'mentor_id',
        'jobseeker_user_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Get the booking associated with the review.
     */
    public function booking()
    {
        return $this->belongsTo(MentorBooking::class, 'mentor_booking_id');
    }

    /**
     * Get the mentor being reviewed.
     */
    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'mentor_id');
    }

    /**
     * Get the jobseeker who wrote the review.
     */
    public function jobseeker()
    {
        return $this->belongsTo(User::class, 'jobseeker_user_id');
    }
}
