<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\MentorBooking;
use App\Models\SesiJadwal;
use App\Models\User;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $feedbacks = Feedback::with(['mentee', 'session'])
            ->where('mentor_id', auth()->id())
            ->when($search, function ($q, $search) {
                $q->whereHas('mentee', function ($qq) use ($search) {
                    $qq->where('name', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('created_at')
            ->get();

        $mentorProfile = auth()->user()->mentorProfile;
        $mentorProfileId = $mentorProfile->id ?? null;

        $mentees = User::whereIn('id', function ($query) use ($mentorProfileId) {
            $query->select('jobseeker_user_id')
                  ->from('mentor_bookings')
                  ->when($mentorProfileId, function ($q) use ($mentorProfileId) {
                      $q->where('mentor_id', $mentorProfileId);
                  });
        })->get();

        $sessions = SesiJadwal::where('mentor_id', auth()->id())->get();

        return view('mentor.feedback.index', compact('feedbacks', 'mentees', 'sessions', 'search'));
    }

    public function create()
    {
        return redirect()->route('mentor.feedback.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'mentee_id' => ['required'],
            'session_id' => ['required'],
            'rating' => ['required','integer','between:1,5'],
            'strength' => ['required','string'],
            'improvement' => ['required','string'],
            'recommendation' => ['required','string'],
        ]);

        $session = SesiJadwal::find($data['session_id']);
        if (!$session || (string)$session->mentor_id !== (string)auth()->id()) {
            return back()->with('error', 'Invalid session selected.');
        }

        $mentorProfile = auth()->user()->mentorProfile;
        $mentorProfileId = $mentorProfile->id ?? null;

        $bookingExists = MentorBooking::where('mentor_id', $mentorProfileId)
            ->where('jobseeker_user_id', $data['mentee_id'])
            ->exists();

        if (!$bookingExists) {
            return back()->with('error', 'Selected mentee has no prior booking with you.');
        }

        Feedback::create([
            'mentor_id' => auth()->id(),
            'mentee_id' => $data['mentee_id'],
            'session_id' => $data['session_id'],
            'rating' => $data['rating'],
            'strength' => $data['strength'],
            'improvement' => $data['improvement'],
            'recommendation' => $data['recommendation'],
        ]);

        return redirect()->route('mentor.feedback.index')->with('success', 'Feedback berhasil disimpan.');
    }
}
