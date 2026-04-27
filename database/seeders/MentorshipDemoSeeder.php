<?php

namespace Database\Seeders;

use App\Models\Mentor;
use App\Models\MentorAvailability;
use App\Models\MentorBooking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MentorshipDemoSeeder extends Seeder
{
    public function run(): void
    {
        $jobseeker = User::updateOrCreate(
            ['email' => 'jobseeker@hirify.test'],
            [
                'name' => 'Career Seeker',
                'password' => Hash::make('password123'),
                'role' => 'jobseeker',
            ]
        );

        $mentorProfiles = [
            [
                'name' => 'Sarah Wijaya',
                'email' => 'sarah.mentor@hirify.test',
                'expertise' => 'Senior UI/UX Design',
                'experience_years' => 8,
                'bio' => 'Passionate designer dengan pengalaman memimpin tim design di berbagai perusahaan teknologi.',
                'education' => 'Tokopedia',
                'skills' => ['UI/UX Design', 'Product Design', 'Design Systems'],
                'price_per_session' => 150000,
                'availability' => 'Senin - Jumat, 18:00 - 21:00',
            ],
            [
                'name' => 'Ahmad Rizki',
                'email' => 'ahmad.mentor@hirify.test',
                'expertise' => 'Tech Lead',
                'experience_years' => 10,
                'bio' => 'Full-stack engineer yang senang berbagi insight tentang web development dan career growth.',
                'education' => 'Gojek',
                'skills' => ['React', 'Node.js', 'System Design'],
                'price_per_session' => 200000,
                'availability' => 'Selasa - Jumat, 19:00 - 22:00',
            ],
            [
                'name' => 'Diana Putri',
                'email' => 'diana.mentor@hirify.test',
                'expertise' => 'Data Scientist',
                'experience_years' => 6,
                'bio' => 'Data enthusiast yang fokus pada praktik data science dan analytics di industri teknologi.',
                'education' => 'Traveloka',
                'skills' => ['Python', 'Machine Learning', 'Data Analysis'],
                'price_per_session' => 175000,
                'availability' => 'Senin - Kamis, 20:00 - 22:00',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.mentor@hirify.test',
                'expertise' => 'Product Manager',
                'experience_years' => 7,
                'bio' => 'Experienced PM dengan track record meluncurkan berbagai produk digital yang sukses.',
                'education' => 'Bukalapak',
                'skills' => ['Product Strategy', 'Agile', 'Stakeholder Management'],
                'price_per_session' => 180000,
                'availability' => 'Rabu - Jumat, 18:00 - 21:00',
            ],
        ];

        foreach ($mentorProfiles as $index => $profile) {
            $mentorUser = User::updateOrCreate(
                ['email' => $profile['email']],
                [
                    'name' => $profile['name'],
                    'password' => Hash::make('password123'),
                    'role' => 'mentor',
                ]
            );

            $mentor = Mentor::updateOrCreate(
                ['user_id' => $mentorUser->id],
                [
                    'expertise' => $profile['expertise'],
                    'experience_years' => $profile['experience_years'],
                    'bio' => $profile['bio'],
                    'education' => $profile['education'],
                    'skills' => $profile['skills'],
                    'price_per_session' => $profile['price_per_session'],
                    'availability' => $profile['availability'],
                ]
            );

            $this->seedAvailabilitySlots($mentor, $index);
        }

        $firstMentor = Mentor::with('availabilities')->first();

        if ($firstMentor) {
            $confirmedSlot = $firstMentor->availabilities()
                ->where('is_booked', false)
                ->where('start_at', '>', now())
                ->orderBy('start_at')
                ->first();

            if ($confirmedSlot) {
                MentorBooking::firstOrCreate(
                    [
                        'mentor_id' => $firstMentor->id,
                        'jobseeker_user_id' => $jobseeker->id,
                        'mentor_availability_id' => $confirmedSlot->id,
                    ],
                    [
                        'scheduled_start' => $confirmedSlot->start_at,
                        'scheduled_end' => $confirmedSlot->end_at,
                        'status' => 'confirmed',
                        'price_per_session' => $firstMentor->price_per_session,
                        'booking_notes' => 'Diskusi roadmap 6 bulan untuk transisi karier.',
                        'meeting_url' => 'https://meet.google.com/',
                    ]
                );

                $confirmedSlot->update(['is_booked' => true]);
            }
        }
    }

    private function seedAvailabilitySlots(Mentor $mentor, int $offset = 0): void
    {
        $baseDate = Carbon::now()->addDays(2 + $offset);

        for ($i = 0; $i < 6; $i++) {
            $start = $baseDate->copy()->addDays($i)->setTime(19, 0);
            $end = $start->copy()->addHour();

            MentorAvailability::firstOrCreate(
                [
                    'mentor_id' => $mentor->id,
                    'start_at' => $start,
                    'end_at' => $end,
                ],
                [
                    'timezone' => 'Asia/Jakarta',
                    'label' => 'Sesi 1-on-1',
                    'is_booked' => false,
                ]
            );
        }
    }
}
