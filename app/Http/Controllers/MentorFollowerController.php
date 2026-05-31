<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\MentorFollower;
use Illuminate\Http\Request;

class MentorFollowerController extends Controller
{
    public function follow(Request $request, Mentor $mentor)
    {
        $user = $request->user();

        $exists = MentorFollower::where('user_id', $user->id)
            ->where('mentor_id', $mentor->id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Sudah mengikuti mentor'], 200);
        }

        MentorFollower::create([
            'user_id' => $user->id,
            'mentor_id' => $mentor->id,
        ]);

        return response()->json(['message' => 'Berhasil mengikuti mentor'], 201);
    }

    public function unfollow(Request $request, Mentor $mentor)
    {
        $user = $request->user();

        $deleted = MentorFollower::where('user_id', $user->id)
            ->where('mentor_id', $mentor->id)
            ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Berhasil berhenti mengikuti mentor'], 200);
        }

        return response()->json(['message' => 'Anda tidak mengikuti mentor ini'], 404);
    }

    public function listFollowed(Request $request)
    {
        $user = $request->user();

        $mentorIds = MentorFollower::where('user_id', $user->id)->pluck('mentor_id');

        $mentors = Mentor::whereIn('id', $mentorIds)->get();

        return response()->json(['data' => $mentors], 200);
    }
}
