<?php

namespace Database\Seeders;

use App\Models\JobListing;
use App\Models\JobSkill;
use Illuminate\Database\Seeder;

class JobListingSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = [
            [
                'title' => 'Frontend Developer',
                'company_name' => 'Tokopedia',
                'location' => 'Jakarta',
                'job_type' => 'full-time',
                'level' => 'mid',
                'category' => 'Teknologi',
                'description' => 'Bergabunglah dengan tim frontend kami untuk membangun pengalaman belanja yang luar biasa bagi jutaan pengguna.',
                'requirements' => "- Pengalaman 2+ tahun dengan React.js\n- Menguasai TypeScript\n- Familiar dengan REST API dan GraphQL\n- Memahami konsep UI/UX",
                'salary_min' => '12.000.000',
                'salary_max' => '20.000.000',
                'salary_visible' => true,
                'deadline' => now()->addDays(30)->toDateString(),
                'apply_url' => 'https://tokopedia.com/careers',
                'skills' => ['React.js', 'TypeScript', 'CSS', 'Git'],
            ],
            [
                'title' => 'Data Analyst',
                'company_name' => 'Gojek',
                'location' => 'Jakarta',
                'job_type' => 'full-time',
                'level' => 'entry',
                'category' => 'Data & Analytics',
                'description' => 'Analisis data dari berbagai sumber untuk menghasilkan insight bisnis yang membantu pengambilan keputusan.',
                'requirements' => "- Fresh graduate S1 jurusan Statistik, Matematika, atau Informatika\n- Menguasai SQL dan Python\n- Familiar dengan Tableau atau Power BI",
                'salary_min' => '8.000.000',
                'salary_max' => '14.000.000',
                'salary_visible' => true,
                'deadline' => now()->addDays(20)->toDateString(),
                'apply_url' => 'https://gojek.com/careers',
                'skills' => ['SQL', 'Python', 'Excel', 'Tableau'],
            ],
            [
                'title' => 'Backend Engineer (Laravel)',
                'company_name' => 'Traveloka',
                'location' => 'Jakarta',
                'job_type' => 'full-time',
                'level' => 'mid',
                'category' => 'Teknologi',
                'description' => 'Kembangkan dan maintain sistem backend yang mendukung platform perjalanan terbesar di Asia Tenggara.',
                'requirements' => "- Pengalaman 2+ tahun dengan Laravel\n- Menguasai MySQL dan Redis\n- Memahami arsitektur microservices",
                'salary_min' => '15.000.000',
                'salary_max' => '25.000.000',
                'salary_visible' => true,
                'deadline' => now()->addDays(25)->toDateString(),
                'apply_url' => 'https://traveloka.com/careers',
                'skills' => ['Laravel', 'PHP', 'MySQL', 'Redis', 'Docker'],
            ],
            [
                'title' => 'UI/UX Designer',
                'company_name' => 'Shopee Indonesia',
                'location' => 'Jakarta',
                'job_type' => 'full-time',
                'level' => 'entry',
                'category' => 'Desain',
                'description' => 'Rancang pengalaman pengguna yang intuitif dan menarik untuk aplikasi mobile dan web Shopee.',
                'requirements' => "- Portfolio desain yang kuat\n- Menguasai Figma dan Adobe XD\n- Memahami user research dan usability testing",
                'salary_min' => '8.000.000',
                'salary_max' => '15.000.000',
                'salary_visible' => true,
                'deadline' => now()->addDays(15)->toDateString(),
                'apply_url' => 'https://shopee.co.id/careers',
                'skills' => ['Figma', 'Adobe XD', 'Prototyping', 'User Research'],
            ],
            [
                'title' => 'Digital Marketing Specialist',
                'company_name' => 'Bukalapak',
                'location' => 'Bandung',
                'job_type' => 'full-time',
                'level' => 'mid',
                'category' => 'Marketing',
                'description' => 'Kelola kampanye digital marketing di berbagai channel untuk meningkatkan brand awareness dan konversi.',
                'requirements' => "- Pengalaman 2+ tahun di digital marketing\n- Menguasai Google Ads dan Meta Ads\n- Kemampuan analisis data marketing",
                'salary_min' => '10.000.000',
                'salary_max' => '18.000.000',
                'salary_visible' => true,
                'deadline' => now()->addDays(28)->toDateString(),
                'apply_url' => 'https://bukalapak.com/careers',
                'skills' => ['Google Ads', 'SEO', 'Content Marketing', 'Analytics'],
            ],
            [
                'title' => 'Mobile Developer (Flutter)',
                'company_name' => 'Dana Indonesia',
                'location' => 'Jakarta',
                'job_type' => 'full-time',
                'level' => 'mid',
                'category' => 'Teknologi',
                'description' => 'Bangun dan kembangkan fitur-fitur baru aplikasi dompet digital DANA yang digunakan jutaan pengguna.',
                'requirements' => "- Pengalaman 2+ tahun dengan Flutter/Dart\n- Familiar dengan state management (BLoC/Provider)\n- Menguasai integrasi REST API",
                'salary_min' => null,
                'salary_max' => null,
                'salary_visible' => false,
                'deadline' => now()->addDays(21)->toDateString(),
                'apply_url' => 'https://dana.id/careers',
                'skills' => ['Flutter', 'Dart', 'REST API', 'Git'],
            ],
            [
                'title' => 'Software Engineer Intern',
                'company_name' => 'Telkom Indonesia',
                'location' => 'Bandung',
                'job_type' => 'internship',
                'level' => 'entry',
                'category' => 'Teknologi',
                'description' => 'Program magang 3-6 bulan untuk mahasiswa aktif. Terlibat langsung dalam pengembangan produk digital Telkom.',
                'requirements' => "- Mahasiswa semester 5+ jurusan IT/Informatika/TI\n- Menguasai minimal 1 bahasa pemrograman\n- Bersedia belajar dan bekerja dalam tim",
                'salary_min' => '2.500.000',
                'salary_max' => '4.000.000',
                'salary_visible' => true,
                'deadline' => now()->addDays(14)->toDateString(),
                'apply_url' => null,
                'skills' => ['JavaScript', 'Python', 'SQL'],
            ],
            [
                'title' => 'Cloud Engineer',
                'company_name' => 'Indosat Ooredoo',
                'location' => 'Jakarta',
                'job_type' => 'full-time',
                'level' => 'senior',
                'category' => 'Infrastruktur',
                'description' => 'Desain, implementasi, dan kelola infrastruktur cloud untuk mendukung layanan digital Indosat.',
                'requirements' => "- Pengalaman 5+ tahun di cloud computing\n- Sertifikasi AWS/GCP/Azure\n- Menguasai Terraform dan Kubernetes",
                'salary_min' => '25.000.000',
                'salary_max' => '40.000.000',
                'salary_visible' => true,
                'deadline' => now()->addDays(35)->toDateString(),
                'apply_url' => 'https://indosat.com/careers',
                'skills' => ['AWS', 'Kubernetes', 'Terraform', 'Docker', 'Linux'],
            ],
        ];

        foreach ($jobs as $jobData) {
            $skills = $jobData['skills'];
            unset($jobData['skills']);

            $job = JobListing::create($jobData);

            foreach ($skills as $skill) {
                JobSkill::create(['job_listing_id' => $job->id, 'skill_name' => $skill]);
            }
        }
    }
}
