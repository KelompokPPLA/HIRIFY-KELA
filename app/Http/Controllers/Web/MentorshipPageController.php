<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\MentorBookingResource;
use App\Models\MentorBooking;
use Illuminate\Http\Request;

class MentorshipPageController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $bookings = MentorBooking::with(['mentor.user'])
            ->where('jobseeker_user_id', $user->id)
            ->orderByDesc('scheduled_start')
            ->limit(12)
            ->get()
            ->map(fn($b) => (new MentorBookingResource($b))->toArray($request))
            ->all();

        // Map bookings by mentor id for quick lookup in the view
        $bookingsByMentor = collect($bookings)->groupBy(fn($b) => $b['mentor']['id'] ?? null)->map(fn($group) => $group->first())->all();

        $summary = [
            'total_completed' => MentorBooking::where('jobseeker_user_id', $user->id)->where('status', 'completed')->count(),
            'total_upcoming' => MentorBooking::where('jobseeker_user_id', $user->id)->whereIn('status', ['pending', 'confirmed'])->count(),
        ];

        return view('jobseeker.mentorship', [
            'initialBookings' => $bookings,
            'bookingsSummary' => $summary,
            'bookingsByMentor' => $bookingsByMentor,
        ]);
    }
}
