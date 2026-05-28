<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\JobSkill;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = JobListing::with('skills')->active();

        if ($search = $request->query('search')) {
            $query->search($search);
        }

        if ($category = $request->query('category')) {
            $query->where('category', $category);
        }

        if ($location = $request->query('location')) {
            $query->where('location', 'like', "%{$location}%");
        }

        if ($level = $request->query('level')) {
            $query->where('level', $level);
        }

        if ($jobType = $request->query('job_type')) {
            $query->where('job_type', $jobType);
        }

        $jobs       = $query->orderByDesc('created_at')->paginate(12)->withQueryString();
        $categories = JobListing::active()->distinct()->pluck('category')->sort()->values();
        $locations  = JobListing::active()->distinct()->pluck('location')->sort()->values();

        // Rekomendasi berdasarkan skill pengguna
        $recommended = collect();
        if (Auth::check()) {
            $userSkills = Skill::where('user_id', Auth::id())->pluck('name')->toArray();
            if (! empty($userSkills)) {
                $recommended = JobListing::with('skills')
                    ->active()
                    ->whereHas('skills', fn ($q) => $q->whereIn('skill_name', $userSkills))
                    ->orderByDesc('created_at')
                    ->limit(6)
                    ->get();
            }
        }

        return view('jobs.index', compact('jobs', 'categories', 'locations', 'recommended'));
    }

    public function show(int $id)
    {
        $job = JobListing::with('skills')->active()->findOrFail($id);

        // Lowongan serupa berdasarkan kategori
        $similar = JobListing::with('skills')
            ->active()
            ->where('category', $job->category)
            ->where('id', '!=', $id)
            ->limit(4)
            ->get();

        // Cek apakah skill pengguna cocok
        $matchScore = 0;
        if (Auth::check()) {
            $userSkills  = Skill::where('user_id', Auth::id())->pluck('name')->map(fn ($s) => strtolower($s))->toArray();
            $jobSkills   = $job->skills->pluck('skill_name')->map(fn ($s) => strtolower($s))->toArray();
            $matches     = array_intersect($userSkills, $jobSkills);
            $matchScore  = count($jobSkills) > 0 ? round((count($matches) / count($jobSkills)) * 100) : 0;
        }

        return view('jobs.show', compact('job', 'similar', 'matchScore'));
    }
}
