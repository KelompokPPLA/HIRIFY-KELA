<?php

namespace App\Services;

use App\Models\Cv;
use Illuminate\Support\Facades\DB;

class CvService
{
    /**
     * Get all CVs for a given user.
     */
    public function getAllByUser(string $userId)
    {
        return Cv::where('user_id', $userId)
                 ->with(['educations', 'experiences', 'skills'])
                 ->orderBy('created_at', 'desc')
                 ->get();
    }

    /**
     * Find a single CV by ID with relations.
     */
    public function findById(string $id): ?Cv
    {
        return Cv::with(['educations', 'experiences', 'skills'])->find($id);
    }

    /**
     * Create a new CV with educations and experiences.
     */
    public function create(array $data, string $userId): Cv
    {
        return DB::transaction(function () use ($data, $userId) {
            $cv = Cv::create([
                'user_id'       => $userId,
                'nama_lengkap'  => $data['nama_lengkap'],
                'email'         => $data['email'],
                'telepon'       => $data['telepon'],
                'alamat'        => $data['alamat'] ?? null,
                'linkedin'      => $data['linkedin'] ?? null,
                'ringkasan'     => $data['ringkasan'] ?? null,
                'skills'        => $data['skills'] ?? null,
            ]);

            // Create education entries
            if (!empty($data['pendidikan'])) {
                foreach ($data['pendidikan'] as $edu) {
                    $cv->educations()->create([
                        'institusi' => $edu['institusi'],
                        'gelar'     => $edu['gelar'],
                        'tahun'     => $edu['tahun'],
                    ]);
                }
            }

            // Create experience entries
            if (!empty($data['pengalaman'])) {
                foreach ($data['pengalaman'] as $exp) {
                    $cv->experiences()->create([
                        'posisi'      => $exp['posisi'],
                        'perusahaan'  => $exp['perusahaan'],
                        'deskripsi'   => $exp['deskripsi'] ?? null,
                        'periode'     => $exp['periode'],
                    ]);
                }
            }

            // Create technical skills
            if (!empty($data['technical_skills'])) {
                $technicalSkills = array_filter(array_map('trim', explode(',', $data['technical_skills'])));
                foreach ($technicalSkills as $skill) {
                    if ($skill) {
                        $cv->skills()->create([
                            'nama_skill' => $skill,
                            'tipe'       => 'technical',
                        ]);
                    }
                }
            }

            // Create soft skills
            if (!empty($data['soft_skills'])) {
                $softSkills = array_filter(array_map('trim', explode(',', $data['soft_skills'])));
                foreach ($softSkills as $skill) {
                    if ($skill) {
                        $cv->skills()->create([
                            'nama_skill' => $skill,
                            'tipe'       => 'soft',
                        ]);
                    }
                }
            }

            return $cv->load(['educations', 'experiences', 'skills']);
        });
    }

    /**
     * Delete a CV and all its related data.
     */
    public function delete(string $id, string $userId = null): bool
    {
        $cv = Cv::where('id', $id);
        
        // Jika userId disediakan, pastikan CV milik user tersebut
        if ($userId) {
            $cv = $cv->where('user_id', $userId);
        }
        
        $cv = $cv->first();
        
        if (!$cv) {
            return false;
        }

        return (bool) $cv->delete();
    }
}
