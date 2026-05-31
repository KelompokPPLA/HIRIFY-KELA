<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cv;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Skill;
use Illuminate\Support\Facades\DB;

class GenerateController extends Controller
{
    public function store(Request $request)
    {
        // Support both API (JSON) and regular form submissions (redirect)
        $data = $request->all();

        $cv = DB::transaction(function () use ($data) {
            $cv = Cv::create([
                'user_id' => auth()->id() ?? 1,
                'nama_lengkap' => $data['name'] ?? ($data['nama_lengkap'] ?? 'Auto Generated'),
                'email' => $data['email'] ?? 'auto@mail.com',
                'telepon' => $data['phone'] ?? ($data['telepon'] ?? null),
                'alamat' => $data['address'] ?? ($data['alamat'] ?? null),
                'linkedin' => $data['linkedin'] ?? null,
                'ringkasan' => $data['summary'] ?? ($data['ringkasan'] ?? null),
            ]);

            // educations: named 'educations' array of arrays (institution, degree, year)
            foreach ($data['educations'] ?? [] as $edu) {
                if (empty(trim((string)($edu['institution'] ?? '')))) continue;
                Education::create([
                    'cv_id' => $cv->id,
                    'institusi' => $edu['institution'] ?? null,
                    'gelar' => $edu['degree'] ?? null,
                    'tahun' => $edu['year'] ?? null,
                ]);
            }

            // experiences: array of arrays (position, company, period, description)
            foreach ($data['experiences'] ?? [] as $exp) {
                if (empty(trim((string)($exp['position'] ?? ''))) && empty(trim((string)($exp['company'] ?? '')))) continue;
                Experience::create([
                    'cv_id' => $cv->id,
                    'posisi' => $exp['position'] ?? null,
                    'perusahaan' => $exp['company'] ?? null,
                    'deskripsi' => $exp['description'] ?? null,
                    'periode' => $exp['period'] ?? null,
                ]);
            }

            // skills: accept comma-separated fields 'technical_skills' and 'soft_skills'
            $tech = $data['technical_skills'] ?? '';
            $soft = $data['soft_skills'] ?? '';

            foreach (array_filter(array_map('trim', explode(',', $tech))) as $skill) {
                Skill::create([
                    'cv_id' => $cv->id,
                    'nama_skill' => $skill,
                    'tipe' => 'technical',
                ]);
            }

            foreach (array_filter(array_map('trim', explode(',', $soft))) as $skill) {
                Skill::create([
                    'cv_id' => $cv->id,
                    'nama_skill' => $skill,
                    'tipe' => 'soft',
                ]);
            }

            return $cv;
        });

        // If request expects JSON (API), return JSON payload
        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json(['data' => ['id' => $cv->id]], 201);
        }

        // Otherwise redirect to the CV page
        return redirect()->route('cv.show', $cv->id)->with('success', 'CV ATS berhasil dibuat.');
    }
}
