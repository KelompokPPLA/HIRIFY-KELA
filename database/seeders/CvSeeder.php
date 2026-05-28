<?php

namespace Database\Seeders;

use App\Models\Cv;
use App\Models\Education;
use App\Models\Experience;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or find a demo user
        $user = User::firstOrCreate(
            ['email' => 'demo@hirify.com'],
            [
                'id'       => '0000-000000000001',
                'name'     => 'John Doe',
                'password' => bcrypt('password'),
                'role'     => 'jobseeker',
            ]
        );

        // CV 1
        $cv1 = Cv::create([
            'user_id'       => $user->id,
            'nama_lengkap'  => 'John Doe',
            'email'         => 'john.doe@email.com',
            'telepon'       => '+62 812 3456 7890',
            'alamat'        => 'Tangerang, Indonesia',
            'linkedin'      => 'https://linkedin.com/in/johndoe',
            'ringkasan'     => 'Fresh graduate with strong passion in frontend development. Experienced in building responsive web applications using modern technologies. Eager to contribute to innovative tech teams.',
            'skills'        => json_encode(['technical' => ['JavaScript', 'TypeScript', 'React', 'Vue.js', 'Laravel', 'Tailwind CSS', 'Node.js', 'Git'], 'soft' => ['Communication', 'Teamwork', 'Problem Solving', 'Time Management']]),
        ]);

        Education::create([
            'cv_id'     => $cv1->id,
            'institusi' => 'Universitas Indonesia',
            'gelar'     => 'Bachelor of Computer Science',
            'tahun'     => '2019 - 2023',
        ]);

        Experience::create([
            'cv_id'       => $cv1->id,
            'posisi'      => 'Frontend Developer Intern',
            'perusahaan'  => 'Tech Startup Indonesia',
            'deskripsi'   => 'Developed responsive UI using React and Tailwind CSS. Collaborated with backend team to integrate RESTful APIs. Improved page load performance by 40%.',
            'periode'     => 'Jun 2022 - Des 2022',
        ]);

        Experience::create([
            'cv_id'       => $cv1->id,
            'posisi'      => 'Freelance Web Developer',
            'perusahaan'  => 'Self-employed',
            'deskripsi'   => 'Built 5+ responsive websites for local businesses. Implemented SEO best practices resulting in 60% increase in organic traffic.',
            'periode'     => 'Jan 2023 - Present',
        ]);

        // CV 2
        $cv2 = Cv::create([
            'user_id'       => $user->id,
            'nama_lengkap'  => 'John Doe',
            'email'         => 'john.doe@email.com',
            'telepon'       => '+62 812 3456 7890',
            'alamat'        => 'Jakarta, Indonesia',
            'linkedin'      => 'https://linkedin.com/in/johndoe',
            'ringkasan'     => 'Backend developer with 2 years of experience in building scalable APIs and microservices. Proficient in PHP, Laravel, and database optimization.',
            'skills'        => json_encode(['technical' => ['PHP', 'Laravel', 'MySQL', 'PostgreSQL', 'Redis', 'Docker', 'REST API', 'Unit Testing'], 'soft' => ['Analytical Thinking', 'Collaboration', 'Adaptability']]),
        ]);

        Education::create([
            'cv_id'     => $cv2->id,
            'institusi' => 'Universitas Indonesia',
            'gelar'     => 'Bachelor of Computer Science',
            'tahun'     => '2019 - 2023',
        ]);

        Experience::create([
            'cv_id'       => $cv2->id,
            'posisi'      => 'Backend Developer',
            'perusahaan'  => 'PT Digital Nusantara',
            'deskripsi'   => 'Designed and implemented RESTful APIs serving 10K+ daily active users. Optimized database queries reducing response time by 50%.',
            'periode'     => 'Mar 2023 - Present',
        ]);

        $this->command->info('CV dummy data seeded successfully!');
    }
}
