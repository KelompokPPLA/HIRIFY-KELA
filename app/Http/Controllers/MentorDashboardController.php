<?php

namespace App\Http\Controllers;

use App\Models\MentorAvailability;
use App\Models\MentorBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MentorDashboardController extends Controller
{
    // Show dashboard with availabilities and bookings
    public function index()
    {
        $user = Auth::user();
        $mentor = $user ? ($user->mentorProfile ?? null) : null;

        $availabilities = collect();
        $pendingBookings = collect();
        $acceptedBookings = collect();

        if ($mentor) {
            $availabilities = MentorAvailability::where('mentor_id', $mentor->id)
                ->orderBy('start_at')
                ->get();

            $pendingBookings = MentorBooking::where('mentor_id', $mentor->id)
                ->where('status', 'pending')
                ->with('jobseeker', 'availability')
                ->orderBy('scheduled_start')
                ->get();

            $acceptedBookings = MentorBooking::where('mentor_id', $mentor->id)
                ->where('status', 'confirmed')
                ->with('jobseeker', 'availability')
                ->orderBy('scheduled_start')
                ->get();
        }

        return view('mentor.dashboard', compact('availabilities', 'pendingBookings', 'acceptedBookings'));
    }

    // Store a new availability slot
    public function storeAvailability(Request $request)
    {
        $request->validate([
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'label' => 'nullable|string|max:255',
        ]);

        $mentor = Auth::user()->mentorProfile;

        MentorAvailability::create([
            'mentor_id' => $mentor->id,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'timezone' => $request->timezone ?? config('app.timezone'),
            'is_booked' => false,
            'label' => $request->label,
        ]);

        return back()->with('success', 'Slot ketersediaan berhasil ditambahkan.');
    }

    // Update an availability slot
    public function updateAvailability(Request $request, $id)
    {
        $request->validate([
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'label' => 'nullable|string|max:255',
        ]);

        $mentor = Auth::user()->mentorProfile;

        $slot = MentorAvailability::where('mentor_id', $mentor->id)->findOrFail($id);

        $slot->update([
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'label' => $request->label,
        ]);

        return back()->with('success', 'Slot diperbarui.');
    }

    // Delete availability slot
    public function destroyAvailability($id)
    {
        $mentor = Auth::user()->mentorProfile;

        $slot = MentorAvailability::where('mentor_id', $mentor->id)->findOrFail($id);
        if ($slot->is_booked) {
            return back()->with('error', 'Tidak dapat menghapus slot yang sudah dibooking.');
        }
        $slot->delete();

        return back()->with('success', 'Slot dihapus.');
    }

    // Accept booking
    public function acceptBooking(Request $request, $id)
    {
        $mentor = Auth::user()->mentor;
        $booking = MentorBooking::where('mentor_id', $mentor->id)->findOrFail($id);

        $booking->update(['status' => 'confirmed']);

        // mark availability as booked
        if ($booking->mentor_availability_id) {
            $availability = MentorAvailability::find($booking->mentor_availability_id);
            if ($availability) {
                $availability->update(['is_booked' => true]);
            }
        }

        return back()->with('success', 'Booking diterima.');
    }

    // Reject booking
    public function rejectBooking(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $mentor = Auth::user()->mentor;
        $booking = MentorBooking::where('mentor_id', $mentor->id)->findOrFail($id);

        $booking->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Booking ditolak.');
    }
}
