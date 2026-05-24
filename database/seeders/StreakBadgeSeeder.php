<?php

namespace Database\Seeders;

use App\Models\StreakBadge;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StreakBadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            [
                'name'          => 'Pemula Berdedikasi',
                'description'   => 'Pertahankan streak selama 3 hari berturut-turut.',
                'milestone_days' => 3,
                'icon'           => '🌱',
                'color'          => 'green',
            ],
            [
                'name'          => 'Konsisten Sepekan',
                'description'   => 'Aktif belajar selama 7 hari tanpa jeda.',
                'milestone_days' => 7,
                'icon'           => '🔥',
                'color'          => 'orange',
            ],
            [
                'name'          => 'Dua Minggu Gemilang',
                'description'   => 'Menyelesaikan 14 hari streak berturut-turut.',
                'milestone_days' => 14,
                'icon'           => '⚡',
                'color'          => 'yellow',
            ],
            [
                'name'          => 'Sang Pejuang Karier',
                'description'   => 'Luar biasa! 30 hari penuh tanpa henti.',
                'milestone_days' => 30,
                'icon'           => '🏆',
                'color'          => 'amber',
            ],
            [
                'name'          => 'Legenda Dua Bulan',
                'description'   => 'Konsisten 60 hari — kamu adalah inspirasi!',
                'milestone_days' => 60,
                'icon'           => '💎',
                'color'          => 'blue',
            ],
            [
                'name'          => 'Maestro 100 Hari',
                'description'   => '100 hari streak! Pencapaian luar biasa yang jarang diraih.',
                'milestone_days' => 100,
                'icon'           => '👑',
                'color'          => 'purple',
            ],
        ];

        foreach ($badges as $badge) {
            StreakBadge::firstOrCreate(
                ['milestone_days' => $badge['milestone_days']],
                $badge
            );
        }

        $this->command->info('✅ ' . count($badges) . ' streak badges seeded successfully.');
    }
}
