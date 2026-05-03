<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\MentorProfileUpdateRequest;
use App\Http\Resources\MentorProfileResource;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MentorProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        $mentor = Mentor::with(['user', 'certifications'])
            ->firstOrCreate(
                ['user_id' => $user->id],
                [
                    'expertise' => 'Belum diisi',
                    'experience_years' => 0,
                    'skills' => [],
                ]
            );

        return ResponseHelper::jsonResponse(true, 'Profil mentor berhasil diambil.', new MentorProfileResource($mentor), 200);
    }

    public function update(MentorProfileUpdateRequest $request)
    {
        $user = $request->user();
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $mentor = Mentor::with(['user', 'certifications'])
                ->firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'expertise' => 'Belum diisi',
                        'experience_years' => 0,
                        'skills' => [],
                    ]
                );

            $skills = collect($validated['skills'] ?? [])
                ->map(fn ($item) => trim($item))
                ->filter()
                ->unique()
                ->values()
                ->all();

            $mentor->update([
                'phone_number' => $validated['phone_number'] ?? null,
                'expertise' => $validated['expertise'],
                'experience_years' => $validated['experience_years'] ?? 0,
                'bio' => $validated['bio'] ?? null,
                'education' => $validated['education'] ?? null,
                'skills' => $skills,
            ]);

            DB::commit();

            $mentor->load(['user', 'certifications']);

            return ResponseHelper::jsonResponse(true, 'Profil mentor berhasil diperbarui.', new MentorProfileResource($mentor), 200);
        } catch (\Throwable $e) {
            DB::rollBack();

            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function updateAvatar(Request $request)
    {
        $validated = $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = $request->user();

        $mentor = Mentor::with(['user', 'certifications'])
            ->firstOrCreate(
                ['user_id' => $user->id],
                [
                    'expertise' => 'Belum diisi',
                    'experience_years' => 0,
                    'skills' => [],
                ]
            );

        if ($mentor->profile_picture) {
            Storage::disk('public')->delete($mentor->profile_picture);
        }

        $path = $request->file('avatar')->store('mentor-avatars', 'public');
        $mentor->update(['profile_picture' => $path]);

        $mentor->load(['user', 'certifications']);

        return ResponseHelper::jsonResponse(true, 'Foto profil berhasil diperbarui.', new MentorProfileResource($mentor), 200);
    }
}
