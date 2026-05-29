<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TrainingCertificate extends Model
{
    protected $fillable = [
        'certificate_number',
        'verification_code',
        'user_id',
        'skill_course_id',
        'user_name',
        'course_title',
        'instructor_name',
        'issued_at',
    ];

    protected $casts = [
        'issued_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(SkillCourse::class, 'skill_course_id');
    }

    public static function generateCertificateNumber(): string
    {
        do {
            $number = 'HIRIFY-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        } while (static::where('certificate_number', $number)->exists());

        return $number;
    }

    public static function generateVerificationCode(): string
    {
        do {
            $code = strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4));
        } while (static::where('verification_code', $code)->exists());

        return $code;
    }

    public static function issueForEnrollment(User $user, SkillCourse $course): self
    {
        // Cek apakah sertifikat sudah ada
        $existing = static::where('user_id', $user->id)
            ->where('skill_course_id', $course->id)
            ->first();

        if ($existing) {
            return $existing;
        }

        return static::create([
            'certificate_number' => static::generateCertificateNumber(),
            'verification_code'  => static::generateVerificationCode(),
            'user_id'            => $user->id,
            'skill_course_id'    => $course->id,
            'user_name'          => $user->name,
            'course_title'       => $course->title,
            'instructor_name'    => $course->instructor_name,
            'issued_at'          => now()->toDateString(),
        ]);
    }
}
