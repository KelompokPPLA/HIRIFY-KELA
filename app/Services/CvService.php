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
     * Create a new CV with educations, experiences, and skills.
     */
    public function create(array $data, string $userId): Cv
    {
        return DB::transaction(function () use ($data, $userId) {

            /*
             * FIX: 'skills' was incorrectly passed as a column inside Cv::create().
             * Skills are managed through the skills() relationship below,
             * not as a column on the cvs table. Passing it here caused:
             * SQLSTATE[42S22]: Column not found: 1054 Unknown column 'skills'
             */
            $cv = Cv::create([
                'user_id'      => $userId,
                'nama_lengkap' => $data['nama_lengkap'],
                'email'        => $data['email'],
                'telepon'      => $data['telepon'],
                'alamat'       => $data['alamat']    ?? null,
                'linkedin'     => $data['linkedin']  ?? null,
                'ringkasan'    => $data['ringkasan'] ?? null,
            ]);

            // Pendidikan
            foreach ($data['pendidikan'] ?? [] as $edu) {
                $cv->educations()->create([
                    'institusi' => $edu['institusi'],
                    'gelar'     => $edu['gelar'],
                    'tahun'     => $edu['tahun'],
                ]);
            }

            // Pengalaman kerja
            foreach ($data['pengalaman'] ?? [] as $exp) {
                $cv->experiences()->create([
                    'posisi'     => $exp['posisi'],
                    'perusahaan' => $exp['perusahaan'],
                    'deskripsi'  => $exp['deskripsi'] ?? null,
                    'periode'    => $exp['periode'],
                ]);
            }

            // Technical skills
            foreach ($this->parseSkills($data['technical_skills'] ?? '') as $skill) {
                $cv->skills()->create([
                    'nama_skill' => $skill,
                    'tipe'       => 'technical',
                ]);
            }

            // Soft skills
            foreach ($this->parseSkills($data['soft_skills'] ?? '') as $skill) {
                $cv->skills()->create([
                    'nama_skill' => $skill,
                    'tipe'       => 'soft',
                ]);
            }

            return $cv->load(['educations', 'experiences', 'skills']);
        });
    }

    /**
     * Update an existing CV and sync its related data.
     *
     * FIX: Method was completely missing — Route::resource('cv', ...) generates
     *      PUT /cv/{cv} which calls CvController@update -> CvService@update.
     *      Without this, every update request threw a fatal error.
     */
    public function update(string $id, array $data, string $userId): ?Cv
    {
        $cv = Cv::where('id', $id)->where('user_id', $userId)->first();

        if (! $cv) {
            return null;
        }

        return DB::transaction(function () use ($cv, $data) {

            $cv->update([
                'nama_lengkap' => $data['nama_lengkap'] ?? $cv->nama_lengkap,
                'email'        => $data['email']        ?? $cv->email,
                'telepon'      => $data['telepon']      ?? $cv->telepon,
                'alamat'       => $data['alamat']       ?? $cv->alamat,
                'linkedin'     => $data['linkedin']     ?? $cv->linkedin,
                'ringkasan'    => $data['ringkasan']    ?? $cv->ringkasan,
            ]);

            // Sync pendidikan (replace strategy: delete all, re-insert)
            if (array_key_exists('pendidikan', $data)) {
                $cv->educations()->delete();
                foreach ($data['pendidikan'] ?? [] as $edu) {
                    $cv->educations()->create([
                        'institusi' => $edu['institusi'],
                        'gelar'     => $edu['gelar'],
                        'tahun'     => $edu['tahun'],
                    ]);
                }
            }

            // Sync pengalaman
            if (array_key_exists('pengalaman', $data)) {
                $cv->experiences()->delete();
                foreach ($data['pengalaman'] ?? [] as $exp) {
                    $cv->experiences()->create([
                        'posisi'     => $exp['posisi'],
                        'perusahaan' => $exp['perusahaan'],
                        'deskripsi'  => $exp['deskripsi'] ?? null,
                        'periode'    => $exp['periode'],
                    ]);
                }
            }

            // Sync skills — only when at least one skills key is present in payload
            if (array_key_exists('technical_skills', $data) || array_key_exists('soft_skills', $data)) {
                $cv->skills()->delete();

                foreach ($this->parseSkills($data['technical_skills'] ?? '') as $skill) {
                    $cv->skills()->create(['nama_skill' => $skill, 'tipe' => 'technical']);
                }

                foreach ($this->parseSkills($data['soft_skills'] ?? '') as $skill) {
                    $cv->skills()->create(['nama_skill' => $skill, 'tipe' => 'soft']);
                }
            }

            return $cv->load(['educations', 'experiences', 'skills']);
        });
    }

    /**
     * Delete a CV and all its related data.
     *
     * FIX 1: `string $userId = null` is invalid PHP — nullable defaults require
     *         the ? prefix. Corrected to `?string $userId = null`.
     *
     * FIX 2: Variable $cv was reused for both the query builder and the Eloquent
     *         model, which is confusing and error-prone. Separated into
     *         $query (builder) and $cv (model instance).
     */
    public function delete(string $id, ?string $userId = null): bool
    {
        $query = Cv::where('id', $id);

        if ($userId !== null) {
            $query->where('user_id', $userId);
        }

        $cv = $query->first();

        if (! $cv) {
            return false;
        }

        return (bool) $cv->delete();
    }

    /* ============================================================
       PRIVATE HELPERS
    ============================================================ */

    /**
     * Parse a comma-separated skills string into a trimmed, non-empty array.
     */
    private function parseSkills(string $raw): array
    {
        if (trim($raw) === '') {
            return [];
        }

        return array_values(
            array_filter(
                array_map('trim', explode(',', $raw))
            )
        );
    }
}