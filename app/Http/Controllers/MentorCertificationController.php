<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\MentorCertificationStoreRequest;
use App\Http\Resources\MentorCertificationResource;
use App\Models\Mentor;
use App\Models\MentorCertification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MentorCertificationController extends Controller
{
    public function index(Request $request)
    {
        $mentor = $this->resolveMentor($request);

        if (! $mentor) {
            return ResponseHelper::jsonResponse(false, 'Profil mentor belum tersedia.', null, 404);
        }

        $certifications = $mentor->certifications()->latest()->get();

        return ResponseHelper::jsonResponse(true, 'Riwayat sertifikasi berhasil diambil.', MentorCertificationResource::collection($certifications), 200);
    }

    public function store(MentorCertificationStoreRequest $request)
    {
        $mentor = $this->resolveMentor($request);

        if (! $mentor) {
            return ResponseHelper::jsonResponse(false, 'Profil mentor belum tersedia.', null, 404);
        }

        $file = $request->file('certificate_file');
        $path = $file->store('mentor-certifications', 'public');

        $certification = $mentor->certifications()->create([
            'title' => $request->validated()['title'],
            'file_path' => $path,
        ]);

        return ResponseHelper::jsonResponse(true, 'Sertifikasi berhasil ditambahkan.', new MentorCertificationResource($certification), 201);
    }

    public function destroy(Request $request, string $id)
    {
        $mentor = $this->resolveMentor($request);

        if (! $mentor) {
            return ResponseHelper::jsonResponse(false, 'Profil mentor belum tersedia.', null, 404);
        }

        $certification = $mentor->certifications()->where('id', $id)->first();

        if (! $certification) {
            return ResponseHelper::jsonResponse(false, 'Sertifikasi tidak ditemukan.', null, 404);
        }

        if ($certification->file_path) {
            Storage::disk('public')->delete($certification->file_path);
        }

        $certification->delete();

        return ResponseHelper::jsonResponse(true, 'Sertifikasi berhasil dihapus.', null, 200);
    }

    private function resolveMentor(Request $request): ?Mentor
    {
        return Mentor::firstOrCreate(
            ['user_id' => $request->user()->id],
            [
                'expertise' => 'Belum diisi',
                'experience_years' => 0,
                'skills' => [],
            ]
        );
    }
}
