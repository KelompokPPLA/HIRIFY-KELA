<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCvRequest;
use App\Models\Cv;
use App\Services\CvService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

    // ─── POST /cv/upload — Upload CV file (PDF only) ──────────────────────
    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:2048',
        ], [
            'file.required' => 'File CV wajib diunggah.',
            'file.mimes'    => 'Format file harus PDF.',
            'file.max'      => 'Ukuran file maksimal 2MB.',
        ]);

        try {
            $this->cvService->uploadFile(
                $request->file('file'),
                auth()->id()
            );

            return redirect()
                ->route('cv.index')
                ->with('success', 'CV berhasil diunggah!');

        } catch (\Throwable $e) {
            Log::error('[CvController@uploadFile] Gagal upload CV', [
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Gagal mengunggah CV: ' . $e->getMessage());
        }
    }

    // ─── PUT /cv/{id} — Update data CV ────────────────────────────────────
    public function update(Request $request, string $id)
    {
        $cv = Cv::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'telepon'      => 'required|string|max:20',
            'alamat'       => 'nullable|string|max:255',
            'linkedin'     => 'nullable|string|max:255',
            'ringkasan'    => 'nullable|string|max:2000',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'telepon.required'      => 'Nomor telepon wajib diisi.',
        ]);

        try {
            $this->cvService->update($id, $validated, auth()->id());

            return redirect()
                ->route('cv.index')
                ->with('success', 'CV berhasil diperbarui!');

        } catch (\Throwable $e) {
            Log::error('[CvController@update] Gagal update CV', [
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui CV: ' . $e->getMessage());
        }
    }

    // ─── POST /cv/{id}/replace — Ganti file CV (PDF only) ─────────────────
    public function replaceFile(Request $request, string $id)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:2048',
        ], [
            'file.required' => 'File CV wajib diunggah.',
            'file.mimes'    => 'Format file harus PDF.',
            'file.max'      => 'Ukuran file maksimal 2MB.',
        ]);

        try {
            $result = $this->cvService->replaceFile(
                $id,
                $request->file('file'),
                auth()->id()
            );

            if (!$result) {
                abort(404, 'CV tidak ditemukan.');
            }

            return redirect()
                ->route('cv.index')
                ->with('success', 'File CV berhasil diganti!');

        } catch (\Throwable $e) {
            Log::error('[CvController@replaceFile] Gagal replace file CV', [
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Gagal mengganti file CV: ' . $e->getMessage());
        }
    }

    // ─── DELETE /cv/{cv} — Hapus CV ───────────────────────────────────────
    public function destroy(string $id)
    {
        $deleted = $this->cvService->delete($id, auth()->id());

        if (!$deleted) {
            abort(404, 'CV tidak ditemukan.');
        }

        return redirect()
            ->route('cv.index')
            ->with('success', 'CV berhasil dihapus.');
    }
}
