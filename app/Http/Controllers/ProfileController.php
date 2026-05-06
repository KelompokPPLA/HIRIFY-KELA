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

    public function edit()
    {
        $user    = Auth::user();
        $profile = $user->profile;
        return view('profile.edit', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'                     => 'required|string|max:255',
            'email'                    => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'                    => 'nullable|string|max:30',
            'location'                 => 'nullable|string|max:255',
            'bio'                      => 'nullable|string|max:1000',
            'photo'                    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pendidikan'               => 'nullable|array',
            'pendidikan.*.institusi'   => 'required_with:pendidikan|string|max:255',
            'pendidikan.*.gelar'       => 'required_with:pendidikan|string|max:255',
            'pendidikan.*.tahun'       => 'required_with:pendidikan|string|max:50',
            'pengalaman'               => 'nullable|array',
            'pengalaman.*.posisi'      => 'required_with:pengalaman|string|max:255',
            'pengalaman.*.perusahaan'  => 'required_with:pengalaman|string|max:255',
            'pengalaman.*.periode'     => 'required_with:pengalaman|string|max:50',
            'pengalaman.*.deskripsi'   => 'nullable|string|max:1000',
            'skills'                   => 'nullable|array',
            'skills.*'                 => 'required|string|max:100',
        ], [
            'name.required'                    => 'Nama lengkap wajib di isi.',
            'email.required'                   => 'Email wajib di isi.',
            'email.email'                      => 'Format email tidak valid.',
            'email.unique'                     => 'Email sudah digunakan.',
            'pendidikan.*.institusi.required_with' => 'Institusi pendidikan wajib di isi.',
            'pendidikan.*.gelar.required_with'     => 'Gelar pendidikan wajib di isi.',
            'pendidikan.*.tahun.required_with'     => 'Tahun pendidikan wajib di isi.',
            'pengalaman.*.posisi.required_with'    => 'Posisi wajib di isi.',
            'pengalaman.*.perusahaan.required_with'=> 'Perusahaan wajib di isi.',
            'pengalaman.*.periode.required_with'   => 'Periode kerja wajib di isi.',
            'skills.*.required'                   => 'Skill wajib di isi.',
            'skills.*.max'                        => 'Nama skill tidak boleh lebih dari 100 karakter.',
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
            'education'  => $request->input('pendidikan', []),
            'experience' => $request->input('pengalaman', []),
            'skills'     => $request->input('skills', []),
        ];

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $profileData['photo'] = $photoPath;
        }

        if ($user->profile) {
            $user->profile->update($profileData);
        } else {
            $user->profile()->create($profileData);
        }

        return redirect()->route('profile.index')->with('success', 'Profil berhasil disimpan.');
    }
}
