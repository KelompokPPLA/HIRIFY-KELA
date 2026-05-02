<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class JobseekerFeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with(['mentor', 'session'])
            ->where('mentee_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('jobseeker.feedback', compact('feedbacks'));
    }
}
