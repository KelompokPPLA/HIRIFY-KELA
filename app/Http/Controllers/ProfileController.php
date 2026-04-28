<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Auth::user()->profile()->create($data);
        return redirect()->back()->with('success', 'Profile berhasil dibuat');
    }

    public function update(Request $request)
    {
        $profile = Auth::user()->profile;
        $profile->update($request->all());
        return redirect()->back()->with('success', 'Profile berhasil diupdate');
    }


}
