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
                 ->with(['educations', 'experiences'])
                 ->orderBy('created_at', 'desc')
                 ->get();
    }

    /**
     * Find a single CV by ID with relations.
     */
    public function findById(string $id): ?Cv
    {
        return Cv::with(['educations', 'experiences'])->find($id);
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

            return $cv->load(['educations', 'experiences']);
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
