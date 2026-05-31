<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CvPresentationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profile = $user->profile;
        
        // Ambil CV ATS terakhir milik user
        $latestCv = $user->cvs()
                         ->with(['educations', 'experiences', 'skills'])
                         ->latest()
                         ->first();

        // Experiences: prefer CV relation, fall back to Profile JSON array
        $experiences = [];
        if ($latestCv && $latestCv->experiences->count()) {
            $experiences = $latestCv->experiences->map(fn($e) => [
                'posisi'     => $e->posisi     ?? $e->position    ?? '',
                'perusahaan' => $e->perusahaan ?? $e->company     ?? '',
                'periode'    => $e->periode    ?? $e->period      ?? '',
                'deskripsi'  => $e->deskripsi  ?? $e->description ?? '',
            ])->toArray();
        } elseif ($profile && !empty($profile->experience)) {
            $experiences = collect($profile->experience)->map(fn($e) => [
                'posisi'     => $e['posisi']     ?? $e['position']    ?? '',
                'perusahaan' => $e['perusahaan'] ?? $e['company']     ?? '',
                'periode'    => $e['periode']    ?? $e['period']      ?? '',
                'deskripsi'  => $e['deskripsi']  ?? $e['description'] ?? '',
            ])->toArray();
        }

        // Educations: prefer CV relation, fall back to Profile JSON array
        $educations = [];
        if ($latestCv && $latestCv->educations->count()) {
            $educations = $latestCv->educations->map(fn($e) => [
                'institusi' => $e->institusi  ?? $e->institution ?? '',
                'gelar'     => $e->gelar      ?? $e->degree      ?? '',
                'tahun'     => $e->tahun      ?? $e->year        ?? '',
            ])->toArray();
        } elseif ($profile && !empty($profile->education)) {
            $educations = collect($profile->education)->map(fn($e) => [
                'institusi' => $e['institusi']  ?? $e['institution'] ?? '',
                'gelar'     => $e['gelar']      ?? $e['degree']      ?? '',
                'tahun'     => $e['tahun']      ?? $e['year']        ?? '',
            ])->toArray();
        }

        // Skills: prefer CV relation, fall back to Profile JSON array
        $skills = [];
        if ($latestCv && $latestCv->skills->count()) {
            $skills = $latestCv->skills->map(fn($s) => ['nama_skill' => $s->nama_skill ?? $s->skill ?? ''])->toArray();
        } elseif ($profile && !empty($profile->skills)) {
            $skills = collect($profile->skills)->map(fn($s) => ['nama_skill' => is_string($s) ? $s : ($s['nama_skill'] ?? $s['skill'] ?? '')])->toArray();
        }

        $profileData = [
            'first_name'  => $profile?->first_name ?? $user->name,
            'last_name'   => $profile?->last_name  ?? '',
            'email'       => $user->email,
            'phone'       => $profile?->phone       ?? ($latestCv?->telepon   ?? ''),
            'location'    => $profile?->location    ?? ($latestCv?->alamat    ?? ''),
            'linkedin'    => $latestCv?->linkedin   ?? '',
            'bio'         => $profile?->bio         ?? ($latestCv?->ringkasan ?? ''),
            'photo'       => $profile?->photo ? asset('storage/' . $profile->photo) : null,
            'experiences' => $experiences,
            'educations'  => $educations,
            'skills'      => $skills,
        ];

        return view('jobseeker.buat-cv-presentasi', compact('profileData'));
    }
}
