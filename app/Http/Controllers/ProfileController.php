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
            'name'                     => 'required|string|min:2|max:60|regex:/^[a-zA-Z\s]+$/',
            'email'                    => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'                    => 'required|string|min:10|max:13|regex:/^08[0-9]{8,11}$/',
            'location'                 => 'nullable|string|max:50',
            'bio'                      => 'nullable|string|max:500',
            'photo'                    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pendidikan'               => 'nullable|array',
            'pendidikan.*.institusi'   => 'required_with:pendidikan|string|max:100',
            'pendidikan.*.gelar'       => 'required_with:pendidikan|string|max:100',
            'pendidikan.*.tahun'       => 'required_with:pendidikan|string|regex:/^\d{4}-\d{4}$/',
            'pengalaman'               => 'nullable|array',
            'pengalaman.*.posisi'      => 'required_with:pengalaman|string|max:100',
            'pengalaman.*.perusahaan'  => 'required_with:pengalaman|string|max:100',
            'pengalaman.*.periode'     => 'required_with:pengalaman|string|regex:/^[a-zA-Z]{3} \d{4} - [a-zA-Z]{3} \d{4}$/',
            'pengalaman.*.deskripsi'   => 'nullable|string|max:500',
            'skills'                   => 'nullable|array',
            'skills.*'                 => 'required|string|max:100',
        ], [
            'name.required'                    => 'Nama lengkap wajib di isi.',
            'name.min'                         => 'Nama minimal 2 karakter.',
            'name.max'                         => 'Nama lengkap maksimal 60 karakter.',
            'name.regex'                       => 'Nama hanya boleh mengandung huruf.',
            'email.required'                   => 'Email wajib di isi.',
            'email.email'                      => 'Format email tidak valid.',
            'email.unique'                     => 'Email sudah digunakan.',
            'phone.required'                   => 'Nomor handphone tidak boleh kosong.',
            'phone.min'                        => 'Nomor telepon minimal 10 digit.',
            'phone.max'                        => 'Nomor telepon maksimal 13 digit.',
            'phone.regex'                      => 'Nomor telepon harus diawali dengan 08 dan hanya terdiri dari angka.',
            'location.max'                     => 'Lokasi maksimal 50 karakter.',
            'bio.max'                          => 'Bio maksimal 500 karakter.',
            'photo.image'                      => 'Foto profil harus berupa gambar.',
            'photo.mimes'                      => 'Format foto profil harus JPG, JPEG, atau PNG.',
            'photo.max'                        => 'Ukuran foto maksimal 2MB',
            'pendidikan.*.institusi.required_with' => 'Institusi pendidikan wajib di isi.',
            'pendidikan.*.institusi.max'           => 'Nama institusi maksimal 100 karakter.',
            'pendidikan.*.gelar.required_with'     => 'Gelar pendidikan wajib di isi.',
            'pendidikan.*.gelar.max'               => 'Nama gelar maksimal 100 karakter.',
            'pendidikan.*.tahun.required_with'     => 'Tahun pendidikan wajib di isi.',
            'pendidikan.*.tahun.regex'             => 'Format periode pendidikan harus YYYY-YYYY (contoh: 2019-2023).',
            'pengalaman.*.posisi.required_with'    => 'Posisi wajib di isi.',
            'pengalaman.*.posisi.max'              => 'Nama posisi maksimal 100 karakter.',
            'pengalaman.*.perusahaan.required_with'=> 'Perusahaan wajib di isi.',
            'pengalaman.*.perusahaan.max'          => 'Nama perusahaan maksimal 100 karakter.',
            'pengalaman.*.periode.required_with'   => 'Periode kerja wajib di isi.',
            'pengalaman.*.periode.regex'           => 'Format periode kerja harus MMM YYYY - MMM YYYY (contoh: Jun 2022 - Jul 2026).',
            'pengalaman.*.deskripsi.max'           => 'Deskripsi pekerjaan maksimal 500 karakter.',
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
