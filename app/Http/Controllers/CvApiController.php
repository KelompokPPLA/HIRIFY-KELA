<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Cv;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class CvApiController extends Controller
{
    private function authUser()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    public function index(): JsonResponse
    {
        $user = $this->authUser();

        $cvs = Cv::where('user_id', $user->id)
            ->with(['educations', 'experiences', 'technicalSkills', 'softSkills'])
            ->orderByDesc('created_at')
            ->get()
            ->map(fn ($cv) => $this->formatCv($cv));

        return ResponseHelper::jsonResponse(true, 'Daftar CV berhasil dimuat.', $cvs, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $user = $this->authUser();

        $validated = $request->validate([
            'nama_lengkap'           => 'required|string|max:255',
            'email'                  => 'required|email|max:255',
            'telepon'                => 'required|string|max:20',
            'alamat'                 => 'nullable|string|max:255',
            'linkedin'               => 'nullable|string|max:255',
            'ringkasan'              => 'nullable|string|max:2000',
            'technical_skills'       => 'nullable|string|max:2000',
            'soft_skills'            => 'nullable|string|max:2000',
            'pendidikan'             => 'nullable|array',
            'pendidikan.*.institusi' => 'required_with:pendidikan|string|max:255',
            'pendidikan.*.gelar'     => 'required_with:pendidikan|string|max:255',
            'pendidikan.*.tahun'     => 'required_with:pendidikan|string|max:20',
            'pengalaman'             => 'nullable|array',
            'pengalaman.*.posisi'    => 'required_with:pengalaman|string|max:255',
            'pengalaman.*.perusahaan'=> 'required_with:pengalaman|string|max:255',
            'pengalaman.*.deskripsi' => 'nullable|string|max:2000',
            'pengalaman.*.periode'   => 'required_with:pengalaman|string|max:50',
        ]);

        $cv = DB::transaction(function () use ($validated, $user) {
            $cv = Cv::create([
                'user_id'      => $user->id,
                'nama_lengkap' => $validated['nama_lengkap'],
                'email'        => $validated['email'],
                'telepon'      => $validated['telepon'],
                'alamat'       => $validated['alamat']    ?? null,
                'linkedin'     => $validated['linkedin']  ?? null,
                'ringkasan'    => $validated['ringkasan'] ?? null,
            ]);

            foreach ($validated['pendidikan'] ?? [] as $edu) {
                Education::create(['cv_id' => $cv->id, 'institusi' => $edu['institusi'], 'gelar' => $edu['gelar'], 'tahun' => $edu['tahun']]);
            }

            foreach ($validated['pengalaman'] ?? [] as $exp) {
                Experience::create(['cv_id' => $cv->id, 'posisi' => $exp['posisi'], 'perusahaan' => $exp['perusahaan'], 'deskripsi' => $exp['deskripsi'] ?? null, 'periode' => $exp['periode']]);
            }

            foreach (array_filter(array_map('trim', explode(',', $validated['technical_skills'] ?? ''))) as $s) {
                Skill::create(['cv_id' => $cv->id, 'nama_skill' => $s, 'tipe' => 'technical']);
            }

            foreach (array_filter(array_map('trim', explode(',', $validated['soft_skills'] ?? ''))) as $s) {
                Skill::create(['cv_id' => $cv->id, 'nama_skill' => $s, 'tipe' => 'soft']);
            }

            return $cv->load(['educations', 'experiences', 'technicalSkills', 'softSkills']);
        });

        return ResponseHelper::jsonResponse(true, 'CV berhasil dibuat.', $this->formatCv($cv), 201);
    }

    public function show(string $id): JsonResponse
    {
        $user = $this->authUser();
        $cv   = Cv::with(['educations', 'experiences', 'technicalSkills', 'softSkills'])
            ->where('user_id', $user->id)->find($id);

        if (!$cv) return ResponseHelper::jsonResponse(false, 'CV tidak ditemukan.', null, 404);

        return ResponseHelper::jsonResponse(true, 'Detail CV berhasil dimuat.', $this->formatCv($cv), 200);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $user = $this->authUser();
        $cv = Cv::where('user_id', $user->id)->find($id);

        if (!$cv) return ResponseHelper::jsonResponse(false, 'CV tidak ditemukan.', null, 404);

        $validated = $request->validate([
            'nama_lengkap'           => 'required|string|max:255',
            'email'                  => 'required|email|max:255',
            'telepon'                => 'required|string|max:20',
            'alamat'                 => 'nullable|string|max:255',
            'linkedin'               => 'nullable|string|max:255',
            'ringkasan'              => 'nullable|string|max:2000',
            'technical_skills'       => 'nullable|string|max:2000',
            'soft_skills'            => 'nullable|string|max:2000',
            'pendidikan'             => 'nullable|array',
            'pendidikan.*.institusi' => 'required_with:pendidikan|string|max:255',
            'pendidikan.*.gelar'     => 'required_with:pendidikan|string|max:255',
            'pendidikan.*.tahun'     => 'required_with:pendidikan|string|max:20',
            'pengalaman'             => 'nullable|array',
            'pengalaman.*.posisi'    => 'required_with:pengalaman|string|max:255',
            'pengalaman.*.perusahaan'=> 'required_with:pengalaman|string|max:255',
            'pengalaman.*.deskripsi' => 'nullable|string|max:2000',
            'pengalaman.*.periode'   => 'required_with:pengalaman|string|max:50',
        ]);

        $cv = DB::transaction(function () use ($cv, $validated) {
            $cv->update([
                'nama_lengkap' => $validated['nama_lengkap'],
                'email'        => $validated['email'],
                'telepon'      => $validated['telepon'],
                'alamat'       => $validated['alamat']    ?? null,
                'linkedin'     => $validated['linkedin']  ?? null,
                'ringkasan'    => $validated['ringkasan'] ?? null,
            ]);

            $cv->educations()->delete();
            $cv->experiences()->delete();
            $cv->skills()->delete();

            foreach ($validated['pendidikan'] ?? [] as $edu) {
                Education::create(['cv_id' => $cv->id, 'institusi' => $edu['institusi'], 'gelar' => $edu['gelar'], 'tahun' => $edu['tahun']]);
            }

            foreach ($validated['pengalaman'] ?? [] as $exp) {
                Experience::create(['cv_id' => $cv->id, 'posisi' => $exp['posisi'], 'perusahaan' => $exp['perusahaan'], 'deskripsi' => $exp['deskripsi'] ?? null, 'periode' => $exp['periode']]);
            }

            foreach (array_filter(array_map('trim', explode(',', $validated['technical_skills'] ?? ''))) as $s) {
                Skill::create(['cv_id' => $cv->id, 'nama_skill' => $s, 'tipe' => 'technical']);
            }

            foreach (array_filter(array_map('trim', explode(',', $validated['soft_skills'] ?? ''))) as $s) {
                Skill::create(['cv_id' => $cv->id, 'nama_skill' => $s, 'tipe' => 'soft']);
            }

            return $cv->load(['educations', 'experiences', 'technicalSkills', 'softSkills']);
        });

        return ResponseHelper::jsonResponse(true, 'CV berhasil diperbarui.', $this->formatCv($cv), 200);
    }

    public function destroy(string $id): JsonResponse
    {
        $user = $this->authUser();
        $cv   = Cv::where('user_id', $user->id)->find($id);

        if (!$cv) return ResponseHelper::jsonResponse(false, 'CV tidak ditemukan.', null, 404);

        $cv->delete();
        return ResponseHelper::jsonResponse(true, 'CV berhasil dihapus.', null, 200);
    }

    private function formatCv(Cv $cv): array
    {
        return [
            'id'              => $cv->id,
            'nama_lengkap'    => $cv->nama_lengkap,
            'email'           => $cv->email,
            'telepon'         => $cv->telepon,
            'alamat'          => $cv->alamat,
            'linkedin'        => $cv->linkedin,
            'ringkasan'       => $cv->ringkasan,
            'pendidikan'      => $cv->educations->map(fn($e) => ['id' => $e->id, 'institusi' => $e->institusi, 'gelar' => $e->gelar, 'tahun' => $e->tahun]),
            'pengalaman'      => $cv->experiences->map(fn($e) => ['id' => $e->id, 'posisi' => $e->posisi, 'perusahaan' => $e->perusahaan, 'deskripsi' => $e->deskripsi, 'periode' => $e->periode]),
            'technical_skills'=> $cv->technicalSkills->pluck('nama_skill'),
            'soft_skills'     => $cv->softSkills->pluck('nama_skill'),
            'created_at'      => $cv->created_at->format('d M Y'),
        ];
    }
}
