<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cv;

class GenerateController extends Controller
{
    public function store(Request $request)
    {
        $cv = Cv::create([
            'user_id' => auth()->id() ?? 1,

            // dari form
            'summary' => $request->summary,
            'job_title' => $request->job_title,
            'target_role' => $request->target_role,
            'skills' => $request->skills,

            // default (biar gak error validation)
            'nama_lengkap' => 'Auto Generated',
            'email' => 'auto@mail.com'
        ]);

        return response()->json([
            'data' => [
                'id' => $cv->id
            ]
        ]);
    }
}