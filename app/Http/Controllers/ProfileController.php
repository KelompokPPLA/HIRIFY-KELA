<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ensure profile exists
        $profile = $user->profile ?? \App\Models\Profile::create(['user_id' => $user->id]);

        return view('profile.index', compact('user', 'profile'));
    }

    public function edit()
    {
        $user = Auth::user();
        
        // Ensure profile exists
        $profile = $user->profile ?? \App\Models\Profile::create(['user_id' => $user->id]);

        return view('profile.edit', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'institusi' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'ipk' => 'nullable|numeric',
            'tahun_mulai_pendidikan' => 'nullable|integer',
            'tahun_selesai_pendidikan' => 'nullable|integer',
            'posisi_kerja' => 'nullable|string|max:255',
            'perusahaan' => 'nullable|string|max:255',
            'periode_mulai_kerja' => 'nullable|string|max:100',
            'periode_selesai_kerja' => 'nullable|string|max:100',
            'deskripsi_kerja' => 'nullable|string',
            'skills' => 'nullable|string',
        ]);

        $user = Auth::user();
        
        $user->email = $validated['email'];
        $user->save();

        $profile = $user->profile ?? new \App\Models\Profile();
        $profile->user_id = $user->id;
        $profile->fill($validated);
        $profile->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
