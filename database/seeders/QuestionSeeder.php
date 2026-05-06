<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            // Teknikal
            ['question' => 'Seberapa baik kemampuan teknis Anda sesuai dengan bidang karier yang dituju?', 'category' => 'Teknikal'],
            ['question' => 'Apakah Anda memiliki pengalaman menggunakan tools/software yang relevan di bidang Anda?', 'category' => 'Teknikal'],
            ['question' => 'Seberapa sering Anda memperbarui keterampilan teknis Anda?', 'category' => 'Teknikal'],
            ['question' => 'Apakah Anda pernah menyelesaikan proyek nyata di bidang yang Anda minati?', 'category' => 'Teknikal'],
            ['question' => 'Seberapa yakin Anda bisa menyelesaikan tugas teknis dasar di pekerjaan target Anda?', 'category' => 'Teknikal'],

            // Soft Skills
            ['question' => 'Bagaimana kemampuan komunikasi Anda saat bekerja dalam tim?', 'category' => 'Soft Skills'],
            ['question' => 'Seberapa baik Anda mengelola waktu dan prioritas tugas?', 'category' => 'Soft Skills'],
            ['question' => 'Apakah Anda mudah beradaptasi ketika dihadapkan pada perubahan atau tantangan baru?', 'category' => 'Soft Skills'],
            ['question' => 'Seberapa percaya diri Anda saat melakukan presentasi atau pitching ide?', 'category' => 'Soft Skills'],
            ['question' => 'Bagaimana kemampuan Anda dalam memecahkan masalah secara mandiri?', 'category' => 'Soft Skills'],

            // Karier
            ['question' => 'Apakah Anda sudah memiliki roadmap karier yang jelas untuk 1-3 tahun ke depan?', 'category' => 'Karier'],
            ['question' => 'Seberapa aktif Anda membangun jaringan profesional (networking)?', 'category' => 'Karier'],
            ['question' => 'Apakah CV/portofolio Anda sudah siap untuk melamar pekerjaan?', 'category' => 'Karier'],
            ['question' => 'Seberapa sering Anda mencari informasi lowongan kerja di bidang yang Anda minati?', 'category' => 'Karier'],
            ['question' => 'Apakah Anda sudah pernah mengikuti wawancara kerja atau mock interview?', 'category' => 'Karier'],
        ];

        foreach ($questions as $q) {
            Question::create($q);
        }
    }
}
