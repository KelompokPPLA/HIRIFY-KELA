<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user    = Auth::user();
        $profile = $user->profile;
        return view('profile.index', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:30',
            'location' => 'nullable|string|max:255',
            'bio'      => 'nullable|string|max:1000',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        $profileData = [
            'first_name' => explode(' ', $request->name)[0],
            'last_name'  => implode(' ', array_slice(explode(' ', $request->name), 1)) ?: null,
            'phone'      => $request->phone,
            'location'   => $request->location,
            'bio'        => $request->bio,
        ];

        if ($user->profile) {
            $user->profile->update($profileData);
        } else {
            $user->profile()->create($profileData);
        }

        return back()->with('success', 'Profil berhasil disimpan.');
    }
}
