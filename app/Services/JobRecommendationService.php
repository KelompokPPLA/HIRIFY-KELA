<?php

namespace App\Services;

use App\Models\JobListing;
use App\Models\Profile;
use App\Models\SkillEnrollment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class JobRecommendationService
{
    // Mapping kategori kursus → kategori lowongan & skill inferens
    private const COURSE_TO_JOB_MAP = [
        'Programming'    => ['categories' => ['Teknologi', 'Infrastruktur'], 'skills' => ['JavaScript', 'Python', 'PHP', 'Java', 'Git', 'SQL', 'React.js', 'Node.js']],
        'Data Science'   => ['categories' => ['Data & Analytics'], 'skills' => ['Python', 'SQL', 'Excel', 'Statistics', 'Machine Learning', 'Data Visualization']],
        'Product'        => ['categories' => ['Produk'], 'skills' => ['Product Management', 'Analytics', 'Agile', 'Figma', 'SQL']],
        'Marketing'      => ['categories' => ['Marketing'], 'skills' => ['Content Marketing', 'SEO', 'Google Ads', 'Analytics', 'Copywriting']],
        'Design'         => ['categories' => ['Desain'], 'skills' => ['Figma', 'Adobe XD', 'Prototyping', 'UI Design', 'User Research']],
        'Soft Skills'    => ['categories' => ['Bisnis', 'Human Resources'], 'skills' => ['Komunikasi', 'Presentasi', 'Negosiasi']],
        'Finance'        => ['categories' => ['Keuangan'], 'skills' => ['Excel', 'Financial Modeling', 'Accounting', 'SQL']],
        'Management'     => ['categories' => ['Bisnis', 'Human Resources', 'Produk'], 'skills' => ['Manajemen', 'Komunikasi', 'Excel']],
    ];

    // Mapping career path → kategori lowongan
    private const CAREER_PATH_MAP = [
        'software engineer'    => ['Teknologi', 'Infrastruktur'],
        'data scientist'       => ['Data & Analytics'],
        'data analyst'         => ['Data & Analytics'],
        'product manager'      => ['Produk'],
        'ui ux designer'       => ['Desain'],
        'digital marketer'     => ['Marketing'],
        'financial analyst'    => ['Keuangan'],
        'business analyst'     => ['Bisnis', 'Data & Analytics'],
        'hr'                   => ['Human Resources'],
        'frontend'             => ['Teknologi'],
        'backend'              => ['Teknologi'],
        'mobile developer'     => ['Teknologi'],
        'fullstack'            => ['Teknologi'],
    ];

    public function getRecommendations(int $limit = 6): array
    {
        $userId  = Auth::id();
        $reasons = [];
        $scores  = [];

        // 1. Kumpulkan sinyal dari profil
        $profile    = Profile::where('user_id', $userId)->first();
        $manualSkills = $profile ? collect($profile->skills ?? [])->map(fn($s) => strtolower($s))->toArray() : [];
        $careerPath   = $profile ? strtolower($profile->career_path ?? '') : '';

        // 2. Inferens skill dari kursus yang diikuti/selesai
        $enrollments     = SkillEnrollment::with('course')->where('user_id', $userId)->get();
        $inferredSkills  = [];
        $inferredCategories = [];

        foreach ($enrollments as $enrollment) {
            if (! $enrollment->course) continue;
            $courseCategory = $enrollment->course->category;
            $weight = $enrollment->completed_at ? 2 : 1; // kursus selesai bobotnya lebih tinggi

            foreach (self::COURSE_TO_JOB_MAP as $key => $map) {
                if (stripos($courseCategory, $key) !== false) {
                    foreach ($map['skills'] as $skill) {
                        $inferredSkills[$skill] = ($inferredSkills[$skill] ?? 0) + $weight;
                    }
                    foreach ($map['categories'] as $cat) {
                        $inferredCategories[$cat] = ($inferredCategories[$cat] ?? 0) + $weight;
                    }
                }
            }
        }

        // 3. Inferens dari career path
        foreach (self::CAREER_PATH_MAP as $keyword => $cats) {
            if ($careerPath && str_contains($careerPath, $keyword)) {
                foreach ($cats as $cat) {
                    $inferredCategories[$cat] = ($inferredCategories[$cat] ?? 0) + 3;
                }
            }
        }

        // 4. Gabungkan semua skill (manual + inferens)
        $allSkills = array_merge($manualSkills, array_keys($inferredSkills));
        arsort($inferredCategories);
        $topCategories = array_slice(array_keys($inferredCategories), 0, 3);

        // 5. Scoring setiap lowongan
        $jobs = JobListing::with('skills')->active()->notExpired()->get();

        foreach ($jobs as $job) {
            $score = 0;
            $jobSkills = $job->skills->pluck('skill_name')->map(fn($s) => strtolower($s))->toArray();

            // Skor dari skill match
            foreach ($allSkills as $skill) {
                foreach ($jobSkills as $jobSkill) {
                    if (stripos($jobSkill, $skill) !== false || stripos($skill, $jobSkill) !== false) {
                        $score += ($inferredSkills[$skill] ?? 1);
                    }
                }
            }

            // Skor dari kategori match
            if (in_array($job->category, $topCategories)) {
                $score += ($inferredCategories[$job->category] ?? 1) * 2;
            }

            // Skor dari career path langsung
            foreach (self::CAREER_PATH_MAP as $keyword => $cats) {
                if ($careerPath && str_contains($careerPath, $keyword) && in_array($job->category, $cats)) {
                    $score += 5;
                }
            }

            if ($score > 0) {
                $scores[$job->id] = $score;
            }
        }

        if (empty($scores)) {
            // Fallback: lowongan entry level terbaru
            $recommended = JobListing::with('skills')->active()->notExpired()
                ->where('level', 'entry')->orderByDesc('created_at')->limit($limit)->get();
            return ['jobs' => $recommended, 'label' => 'Cocok untuk Anda'];
        }

        arsort($scores);
        $topIds = array_slice(array_keys($scores), 0, $limit);
        $recommended = $jobs->whereIn('id', $topIds)->sortBy(fn($j) => array_search($j->id, $topIds))->values();

        // Tentukan label berdasarkan sumber rekomendasi
        if (! empty($manualSkills)) {
            $label = 'Cocok dengan Skill Anda';
        } elseif (! empty($inferredCategories)) {
            $label = 'Cocok untuk Anda';
        } else {
            $label = 'Cocok untuk Anda';
        }

        return ['jobs' => $recommended, 'label' => $label];
    }
}
