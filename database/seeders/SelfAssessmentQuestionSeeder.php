<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * SelfAssessmentQuestionSeeder
 *
 * Mengisi bank pertanyaan Self Assessment dengan 15 pertanyaan
 * yang terbagi dalam 3 kategori: Technical Skills, Soft Skills, Career Readiness.
 *
 * Skala jawaban: 1=Sangat Kurang, 2=Kurang, 3=Cukup, 4=Baik, 5=Sangat Baik
 *
 * Jalankan:
 *   php artisan db:seed --class=SelfAssessmentQuestionSeeder
 *   php artisan db:seed   (jika sudah didaftarkan di DatabaseSeeder)
 */
class SelfAssessmentQuestionSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus pertanyaan lama agar tidak terjadi duplikasi
        // (jawaban & assessment terkait juga akan terhapus via cascade)
        DB::table('answers')->delete();
        DB::table('assessments')->delete();
        DB::table('questions')->delete();

        $questions = [
            // ── TECHNICAL SKILLS (5 pertanyaan) ──────────────────────────
            [
                'question' => 'Seberapa baik pemahaman Anda tentang fundamental programming?',
                'category' => 'Technical Skills',
            ],
            [
                'question' => 'Seberapa percaya diri Anda menggunakan database dan SQL?',
                'category' => 'Technical Skills',
            ],
            [
                'question' => 'Seberapa baik kemampuan Anda dalam debugging aplikasi?',
                'category' => 'Technical Skills',
            ],
            [
                'question' => 'Seberapa sering Anda mengerjakan proyek pemrograman secara mandiri?',
                'category' => 'Technical Skills',
            ],
            [
                'question' => 'Seberapa baik pemahaman Anda tentang Git dan version control?',
                'category' => 'Technical Skills',
            ],

            // ── SOFT SKILLS (5 pertanyaan) ───────────────────────────────
            [
                'question' => 'Seberapa baik kemampuan komunikasi Anda dalam tim?',
                'category' => 'Soft Skills',
            ],
            [
                'question' => 'Seberapa nyaman Anda melakukan presentasi di depan umum?',
                'category' => 'Soft Skills',
            ],
            [
                'question' => 'Seberapa baik kemampuan problem solving Anda?',
                'category' => 'Soft Skills',
            ],
            [
                'question' => 'Seberapa baik kemampuan manajemen waktu Anda?',
                'category' => 'Soft Skills',
            ],
            [
                'question' => 'Seberapa baik kemampuan bekerja sama dalam tim?',
                'category' => 'Soft Skills',
            ],

            // ── CAREER READINESS (5 pertanyaan) ──────────────────────────
            [
                'question' => 'Seberapa siap Anda menghadapi proses wawancara kerja?',
                'category' => 'Career Readiness',
            ],
            [
                'question' => 'Seberapa baik kualitas CV atau resume Anda saat ini?',
                'category' => 'Career Readiness',
            ],
            [
                'question' => 'Seberapa jelas tujuan karier yang ingin Anda capai?',
                'category' => 'Career Readiness',
            ],
            [
                'question' => 'Seberapa aktif Anda mengikuti pelatihan atau pengembangan skill?',
                'category' => 'Career Readiness',
            ],
            [
                'question' => 'Seberapa siap Anda memasuki dunia kerja dalam 6 bulan ke depan?',
                'category' => 'Career Readiness',
            ],
        ];

        foreach ($questions as $q) {
            Question::create($q);
        }

        $this->command->info('✅ 15 pertanyaan Self Assessment berhasil ditambahkan.');
        $this->command->table(
            ['#', 'Kategori', 'Pertanyaan'],
            collect($questions)->map(fn ($q, $i) => [
                $i + 1,
                $q['category'],
                mb_strimwidth($q['question'], 0, 60, '...'),
            ])->toArray()
        );
    }
}
