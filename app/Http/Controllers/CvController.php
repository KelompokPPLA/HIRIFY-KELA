<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCvRequest;
use App\Models\Cv;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CvController extends Controller
{
    /**
     * Display a listing of user's CVs.
     */
    public function index()
    {
        $cvs = Cv::where('user_id', auth()->id())
                  ->with(['educations', 'experiences', 'skills'])
                  ->orderBy('created_at', 'desc')
                  ->get();

        return view('cv.index', compact('cvs'));
    }

    /**
     * Show the form for creating a new CV.
     */
    public function create()
    {
        return view('cv.create');
    }

    /**
     * Store a newly created CV in storage.
     */
    public function store(StoreCvRequest $request)
    {
        $validated = $request->validated();
        $userId    = auth()->id();

        $cv = DB::transaction(function () use ($validated, $userId) {
            // 1. Buat CV utama
            $cv = Cv::create([
                'user_id'      => $userId,
                'nama_lengkap' => $validated['nama_lengkap'],
                'email'        => $validated['email'],
                'telepon'      => $validated['telepon'],
                'alamat'       => $validated['alamat']    ?? null,
                'linkedin'     => $validated['linkedin']  ?? null,
                'ringkasan'    => $validated['ringkasan'] ?? null,
            ]);

            // 2. Simpan pendidikan
            if (!empty($validated['pendidikan'])) {
                foreach ($validated['pendidikan'] as $edu) {
                    Education::create([
                        'cv_id'    => $cv->id,
                        'institusi' => $edu['institusi'],
                        'gelar'    => $edu['gelar'],
                        'tahun'    => $edu['tahun'],
                    ]);
                }
            }

            // 3. Simpan pengalaman
            if (!empty($validated['pengalaman'])) {
                foreach ($validated['pengalaman'] as $exp) {
                    Experience::create([
                        'cv_id'      => $cv->id,
                        'posisi'     => $exp['posisi'],
                        'perusahaan' => $exp['perusahaan'],
                        'deskripsi'  => $exp['deskripsi'] ?? null,
                        'periode'    => $exp['periode'],
                    ]);
                }
            }

            // 4. Simpan technical skills
            if (!empty($validated['technical_skills'])) {
                $techSkills = array_filter(
                    array_map('trim', explode(',', $validated['technical_skills']))
                );
                foreach ($techSkills as $skill) {
                    Skill::create([
                        'cv_id'      => $cv->id,
                        'nama_skill' => $skill,
                        'tipe'       => 'technical',
                    ]);
                }
            }

            // 5. Simpan soft skills
            if (!empty($validated['soft_skills'])) {
                $softSkills = array_filter(
                    array_map('trim', explode(',', $validated['soft_skills']))
                );
                foreach ($softSkills as $skill) {
                    Skill::create([
                        'cv_id'      => $cv->id,
                        'nama_skill' => $skill,
                        'tipe'       => 'soft',
                    ]);
                }
            }

            return $cv;
        });

        return redirect()
            ->route('cv.show', $cv->id)
            ->with('success', 'CV ATS berhasil dibuat!');
    }

    /**
     * Display the specified CV.
     */
    public function show(string $id)
    {
        $cv = Cv::with(['educations', 'experiences', 'skills'])
                ->where('user_id', auth()->id())
                ->findOrFail($id);

        return view('cv.show', compact('cv'));
    }

    /**
     * Remove the specified CV from storage.
     */
    public function destroy(string $id)
    {
        $cv = Cv::where('user_id', auth()->id())->findOrFail($id);
        $cv->delete();

        return redirect()
            ->route('cv.index')
            ->with('success', 'CV berhasil dihapus.');
    }
}
