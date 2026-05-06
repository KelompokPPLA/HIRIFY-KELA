<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProfileApiController extends Controller
{
    private function authUser()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    public function show(): JsonResponse
    {
        $user    = $this->authUser();
        $profile = $user->profile;

        return ResponseHelper::jsonResponse(true, 'Profil berhasil dimuat.', [
            'id'       => $user->id,
            'name'     => $user->name,
            'email'    => $user->email,
            'role'     => $user->role,
            'phone'    => $profile?->phone,
            'location' => $profile?->location,
            'bio'      => $profile?->bio,
            'joined'   => $user->created_at->format('M Y'),
        ], 200);
    }

    public function update(Request $request): JsonResponse
    {
        $user = $this->authUser();

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:30',
            'location' => 'nullable|string|max:255',
            'bio'      => 'nullable|string|max:1000',
        ]);

        $user->update(['name' => $validated['name'], 'email' => $validated['email']]);

        $profileData = [
            'first_name' => explode(' ', $validated['name'])[0],
            'last_name'  => implode(' ', array_slice(explode(' ', $validated['name']), 1)) ?: null,
            'phone'      => $validated['phone'] ?? null,
            'location'   => $validated['location'] ?? null,
            'bio'        => $validated['bio'] ?? null,
        ];

        if ($user->profile) {
            $user->profile->update($profileData);
        } else {
            $user->profile()->create($profileData);
        }

        return ResponseHelper::jsonResponse(true, 'Profil berhasil disimpan.', [
            'name'     => $user->name,
            'email'    => $user->email,
            'phone'    => $user->fresh()->profile?->phone,
            'location' => $user->fresh()->profile?->location,
            'bio'      => $user->fresh()->profile?->bio,
        ], 200);
    }
}
