<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Cv;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Skill;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Barryvdh\DomPDF\Facade\Pdf;

class CvApiController extends Controller
{
    private function authUser()
    {
        // Attempt JWT token auth first if a token was provided.
        try {
            if (JWTAuth::getToken()) {
                return JWTAuth::parseToken()->authenticate();
            }
        } catch (JWTException $e) {
            // Ignore JWT token parse errors; fallback to session auth below.
        }

        // Fallback to standard session/web guard authentication.
        if ($user = Auth::guard('web')->user()) {
            return $user;
        }

        if ($user = Auth::user()) {
            return $user;
        }

        throw new AuthenticationException('Unauthenticated.');
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

    /**
     * Handle file upload CV.
     * Simpan file dan buat CV entry dengan data minimal.
     */
    public function uploadFile(Request $request): JsonResponse
    {
        try {
            $user = $this->authUser();

            // Validate file
            $validated = $request->validate([
                'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
            ]);

            // Ensure cv directory exists
            $cvDir = storage_path('app/public/cv');
            if (!File::isDirectory($cvDir)) {
                File::makeDirectory($cvDir, 0755, true);
            }

            // Simpan file ke storage/app/public/cv
            $file = $validated['file'];
            $filename = $file->getClientOriginalName();
            
            // Create unique filename
            $uniqueName = time() . '_' . uniqid() . '_' . $filename;
            $path = $file->storeAs('cv', $uniqueName, 'public');

            if (!$path) {
                return ResponseHelper::jsonResponse(false, 'Gagal menyimpan file CV.', null, 500);
            }

            // Extract nama dari filename (tanpa extension)
            $namaLengkap = pathinfo($filename, PATHINFO_FILENAME);
            
            // Create CV dengan data minimal dan metadata file
            $cv = Cv::create([
                'user_id'      => $user->id,
                'nama_lengkap' => $namaLengkap,
                'email'        => $user->email,
                'telepon'      => '-',
                'alamat'       => null,
                'linkedin'     => null,
                'ringkasan'    => null,
                'file_path'    => $path,
                'file_name'    => $filename,
                'file_type'    => $file->getClientMimeType(),
                'file_size'    => $file->getSize(),
            ]);

            return ResponseHelper::jsonResponse(
                true, 
                'File CV berhasil diupload. Silakan lengkapi detail CV.', 
                $this->formatCv($cv->load(['educations', 'experiences', 'technicalSkills', 'softSkills'])), 
                201
            );

        } catch (\Illuminate\Validation\ValidationException $e) {
            return ResponseHelper::jsonResponse(false, 'Validasi gagal: ' . implode(', ', array_map(fn($msg) => implode(', ', $msg), $e->errors())), null, 422);
        } catch (\Exception $e) {
            \Log::error('CV Upload Error: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return ResponseHelper::jsonResponse(false, 'Gagal upload file: ' . $e->getMessage(), null, 500);
        }
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
            'file_path'       => $cv->file_path,
            'file_name'       => $cv->file_name,
            'file_type'       => $cv->file_type,
            'file_size'       => $cv->file_size,
            'file_url'        => $cv->file_path ? Storage::disk('public')->url($cv->file_path) : null,
            'pendidikan'      => $cv->educations->map(fn($e) => ['id' => $e->id, 'institusi' => $e->institusi, 'gelar' => $e->gelar, 'tahun' => $e->tahun]),
            'pengalaman'      => $cv->experiences->map(fn($e) => ['id' => $e->id, 'posisi' => $e->posisi, 'perusahaan' => $e->perusahaan, 'deskripsi' => $e->deskripsi, 'periode' => $e->periode]),
            'technical_skills'=> $cv->technicalSkills->pluck('nama_skill'),
            'soft_skills'     => $cv->softSkills->pluck('nama_skill'),
            'created_at'      => $cv->created_at->format('d M Y'),
        ];
    }
}
