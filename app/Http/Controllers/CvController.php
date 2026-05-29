<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCvRequest;
use App\Models\Cv;
use App\Services\CvService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CvController extends Controller
{
    public function __construct(protected CvService $cvService) {}

    // ─── GET /buat-cv-ats — Form create CV ─────────────────────────────────
    public function create()
    {
        return view('buat-cv-ats.create');
    }

    // ─── POST /buat-cv-ats — Simpan CV baru ────────────────────────────────
    public function store(StoreCvRequest $request)
    {
        try {
            $cv = $this->cvService->create(
                $request->validated(),
                auth()->id()
            );

            Log::info('[CvController@store] CV tersimpan', ['cv_id' => $cv->id]);

            return redirect()
                ->route('cv.show', $cv->id)
                ->with('success', 'CV ATS berhasil dibuat!');

        } catch (\Throwable $e) {
            Log::error('[CvController@store] Gagal simpan CV', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan CV: ' . $e->getMessage());
        }
    }

    // ─── GET /manajemen-cv — Daftar CV user ────────────────────────────────
    public function index()
    {
        $cvs = $this->cvService->getAllByUser(auth()->id());

        return view('buat-cv-ats.index', compact('cvs'));
    }

    // ─── GET /cv/{cv} — Detail / preview CV ───────────────────────────────
    public function show(string $id)
    {
        $cv = Cv::with(['educations', 'experiences', 'skills'])
                ->where('user_id', auth()->id())
                ->findOrFail($id);

        return view('buat-cv-ats.show', compact('cv'));
    }

    // ─── GET /cv/{cv}/download — Download CV sebagai PDF ──────────────────
    public function download(string $id)
    {
        $cv = Cv::with(['educations', 'experiences', 'skills'])
                ->where('user_id', auth()->id())
                ->findOrFail($id);

        $pdf = Pdf::loadView('buat-cv-ats.pdf', compact('cv'))
                  ->setPaper('a4', 'portrait');

        $filename = 'CV-ATS-' . str_replace(' ', '-', $cv->nama_lengkap) . '.pdf';

        return $pdf->download($filename);
    }

    // ─── DELETE /cv/{cv} — Hapus CV ───────────────────────────────────────
    public function destroy(string $id)
    {
        $cv = Cv::where('user_id', auth()->id())
                ->findOrFail($id);

        $cv->delete();

        return redirect()
            ->route('cv.index')
            ->with('success', 'CV berhasil dihapus.');
    }
}
