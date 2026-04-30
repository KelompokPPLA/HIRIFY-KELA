<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCvRequest;
use App\Services\CvService;
use Illuminate\Http\Request;

class CvController extends Controller
{
    public function __construct(
        protected CvService $cvService
    ) {}

    /**
     * Display a listing of user's CVs.
     */
    public function index(Request $request)
    {
        // Gunakan auth()->user() untuk konsistensi session
        $user = auth()->user();

        if (!$user) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $cvs = $this->cvService->getAllByUser($user->id);

        return view('cv.index', compact('cvs'));
    }

    /**
     * Show the form for creating a new CV.
     */
    public function create()
    {
        // Debug: pastikan user sudah login
        $user = auth()->user();

        dd($user);

        if (!$user) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('cv.create');
    }

    /**
     * Store a newly created CV in storage.
     */
    public function store(StoreCvRequest $request)
    {
        $validated = $request->validated();

        // Gunakan auth()->id() untuk konsistensi session
        $user = auth()->user();

        if (!$user) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $cv = $this->cvService->create($validated, $user->id);

        return redirect()
            ->route('cv.show', $cv->id)
            ->with('success', 'CV ATS berhasil dibuat!');
    }

    /**
     * Display the specified CV.
     */
    public function show(string $id)
    {
        $cv = $this->cvService->findById($id);

        if (!$cv) {
            abort(404, 'CV tidak ditemukan.');
        }

        // Pastikan CV milik user yang login
        $user = auth()->user();
        if ($user && $cv->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke CV ini.');
        }

        return view('cv.show', compact('cv'));
    }

    /**
     * Remove the specified CV from storage.
     */
    public function destroy(string $id)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $this->cvService->delete($id, $user->id);

        return redirect()
            ->route('cv.index')
            ->with('success', 'CV berhasil dihapus.');
    }
}
