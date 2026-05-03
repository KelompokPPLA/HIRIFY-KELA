<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreMentorBookingRequest;
use App\Http\Resources\MentorAvailabilityResource;
use App\Http\Resources\MentorBookingResource;
use App\Http\Resources\MentorMarketplaceResource;
use App\Models\Mentor;
use App\Models\MentorAvailability;
use App\Models\MentorBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MentorshipController extends Controller
{
    public function mentors(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $expertise = trim((string) $request->query('expertise', ''));
        $sort = (string) $request->query('sort', 'recommended');
        $perPage    = max(6, min((int) $request->query('per_page', 8), 24));
        $priceFilter = $request->filled('is_free') ? (bool) $request->query('is_free') : null;

        $query = Mentor::query()
            ->with('user')
            ->withCount([
                'availabilities as open_slots_count' => fn ($q) => $q
                    ->where('is_booked', false)
                    ->where('start_at', '>', now()),
                'bookings as session_count' => fn ($q) => $q
                    ->whereIn('status', ['confirmed', 'completed']),
                'bookings as completed_session_count' => fn ($q) => $q
                    ->where('status', 'completed'),
            ]);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%');
                })->orWhere('expertise', 'like', '%' . $search . '%')
                    ->orWhere('bio', 'like', '%' . $search . '%');
            });
        }

        if ($expertise !== '') {
            $query->where('expertise', 'like', '%' . $expertise . '%');
        }

        if ($request->filled('price_min')) {
            $query->where('price_per_session', '>=', (float) $request->query('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price_per_session', '<=', (float) $request->query('price_max'));
        }

        if ($priceFilter !== null) {
            $query->where(function ($q) use ($priceFilter) {
                $priceFilter
                    ? $q->whereNull('price_per_session')->orWhere('price_per_session', 0)
                    : $q->where('price_per_session', '>', 0);
            });
        }

        switch ($sort) {
            case 'price_low':
                $query->orderByRaw('COALESCE(price_per_session, 0) asc');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(price_per_session, 0) desc');
                break;
            case 'experience':
                $query->orderByDesc('experience_years');
                break;
            case 'slots':
                $query->orderByDesc('open_slots_count');
                break;
            default:
                $query->orderByDesc('session_count')->orderByDesc('experience_years');
                break;
        }

        $paginator = $query->paginate($perPage);

        $items = $paginator->getCollection()->map(function (Mentor $mentor) {
            $mentor->rating = $mentor->session_count > 0
                ? min(5, round(4.5 + ($mentor->session_count / 200), 1))
                : 4.8;

            return (new MentorMarketplaceResource($mentor))->toArray(request());
        })->all();

        return ResponseHelper::jsonResponse(true, 'Daftar mentor berhasil diambil.', [
            'items' => $items,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
        ], 200);
    }

    public function mentorDetail(string $id)
    {
        $mentor = Mentor::with(['user', 'certifications'])
            ->withCount([
                'availabilities as open_slots_count' => fn ($q) => $q
                    ->where('is_booked', false)
                    ->where('start_at', '>', now()),
                'bookings as session_count' => fn ($q) => $q
                    ->whereIn('status', ['confirmed', 'completed']),
            ])
            ->find($id);

        if (! $mentor) {
            return ResponseHelper::jsonResponse(false, 'Profil mentor tidak ditemukan.', null, 404);
        }

        $mentor->rating = $mentor->session_count > 0
            ? min(5, round(4.5 + ($mentor->session_count / 200), 1))
            : 4.8;

        $slots = MentorAvailability::query()
            ->where('mentor_id', $mentor->id)
            ->where('is_booked', false)
            ->where('start_at', '>', now())
            ->orderBy('start_at')
            ->limit(20)
            ->get();

        $slotItems = $slots->map(fn ($item) => (new MentorAvailabilityResource($item))->toArray(request()))->all();

        return ResponseHelper::jsonResponse(true, 'Detail mentor berhasil diambil.', [
            'mentor' => (new MentorMarketplaceResource($mentor))->toArray(request()),
            'certifications' => $mentor->certifications->map(fn ($item) => [
                'id' => $item->id,
                'title' => $item->title,
                'file_url' => $item->file_path ? asset('storage/' . $item->file_path) : null,
            ])->values()->all(),
            'availability_slots' => $slotItems,
        ], 200);
    }

    public function mentorAvailability(string $id)
    {
        $mentor = Mentor::find($id);

        if (! $mentor) {
            return ResponseHelper::jsonResponse(false, 'Mentor tidak ditemukan.', null, 404);
        }

        $slots = MentorAvailability::query()
            ->where('mentor_id', $mentor->id)
            ->where('is_booked', false)
            ->where('start_at', '>', now())
            ->orderBy('start_at')
            ->limit(30)
            ->get();

        $slotItems = $slots->map(fn ($item) => (new MentorAvailabilityResource($item))->toArray(request()))->all();

        return ResponseHelper::jsonResponse(true, 'Jadwal mentor berhasil diambil.', [
            'slots'       => $slotItems,
            'total_slots' => count($slotItems),
            'has_slots'   => count($slotItems) > 0,
        ], 200);
    }

    public function createBooking(StoreMentorBookingRequest $request)
    {
        $validated = $request->validated();
        $user = $request->user();

        $mentor = Mentor::with('user')->find($validated['mentor_id']);

        if (! $mentor) {
            return ResponseHelper::jsonResponse(false, 'Mentor tidak ditemukan.', null, 404);
        }

        if ($mentor->user_id === $user->id) {
            return ResponseHelper::jsonResponse(false, 'Anda tidak dapat memesan sesi dengan diri sendiri.', null, 422);
        }

        try {
            $booking = DB::transaction(function () use ($validated, $mentor, $user) {
                $slot = null;
                $start = null;
                $end = null;

                if (! empty($validated['mentor_availability_id'])) {
                    $slot = MentorAvailability::where('id', $validated['mentor_availability_id'])
                        ->where('mentor_id', $mentor->id)
                        ->lockForUpdate()
                        ->first();

                    if (! $slot) {
                        throw new \RuntimeException('Slot jadwal tidak valid untuk mentor ini.');
                    }

                    if ($slot->is_booked || $slot->start_at->isPast()) {
                        throw new \RuntimeException('Slot jadwal sudah tidak tersedia.');
                    }

                    $start = $slot->start_at->copy();
                    $end = $slot->end_at->copy();
                } else {
                    if (empty($validated['scheduled_start'])) {
                        throw new \RuntimeException('Pilih slot jadwal atau isi jadwal manual.');
                    }

                    $duration = (int) ($validated['duration_minutes'] ?? 60);
                    $start = Carbon::parse($validated['scheduled_start']);
                    $end = (clone $start)->addMinutes($duration);

                    $hasOverlap = MentorBooking::query()
                        ->where('mentor_id', $mentor->id)
                        ->whereIn('status', ['pending', 'confirmed', 'completed'])
                        ->where(function ($q) use ($start, $end) {
                            $q->whereBetween('scheduled_start', [$start, $end])
                                ->orWhereBetween('scheduled_end', [$start, $end])
                                ->orWhere(function ($nested) use ($start, $end) {
                                    $nested->where('scheduled_start', '<=', $start)
                                        ->where('scheduled_end', '>=', $end);
                                });
                        })
                        ->exists();

                    if ($hasOverlap) {
                        throw new \RuntimeException('Jadwal bentrok dengan sesi lain. Pilih waktu yang berbeda.');
                    }
                }

                $booking = MentorBooking::create([
                    'mentor_id' => $mentor->id,
                    'jobseeker_user_id' => $user->id,
                    'mentor_availability_id' => $slot?->id,
                    'scheduled_start' => $start,
                    'scheduled_end' => $end,
                    'status' => 'pending',
                    'price_per_session' => $mentor->price_per_session,
                    'booking_notes' => $validated['booking_notes'] ?? null,
                ]);

                if ($slot) {
                    $slot->update(['is_booked' => true]);
                }

                return $booking;
            });
        } catch (\RuntimeException $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 422);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, 'Gagal membuat booking sesi.', null, 500);
        }

        $booking->load(['mentor.user']);

        return ResponseHelper::jsonResponse(
            true,
            'Booking sesi berhasil dibuat dan menunggu konfirmasi mentor.',
            (new MentorBookingResource($booking))->toArray(request()),
            201
        );
    }

    public function myBookings(Request $request)
    {
        $user = $request->user();
        $limit = max(5, min((int) $request->query('per_page', 10), 50));
        $statusFilter = collect(explode(',', (string) $request->query('status')))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();

        $validStatuses = ['pending', 'confirmed', 'completed', 'cancelled', 'rejected'];
        $statusFilter = array_values(array_intersect($statusFilter, $validStatuses));

        $query = MentorBooking::query()
            ->with(['mentor.user'])
            ->where('jobseeker_user_id', $user->id)
            ->orderByDesc('scheduled_start');

        if (! empty($statusFilter)) {
            $query->whereIn('status', $statusFilter);
        }

        $paginator = $query->paginate($limit);

        $items = $paginator->getCollection()
            ->map(fn ($item) => (new MentorBookingResource($item))->toArray(request()))
            ->all();

        $totalCompleted = MentorBooking::where('jobseeker_user_id', $user->id)
            ->where('status', 'completed')
            ->count();
        $totalUpcoming = MentorBooking::where('jobseeker_user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        return ResponseHelper::jsonResponse(true, 'Riwayat booking berhasil diambil.', [
            'items' => $items,
            'summary' => [
                'total_completed' => $totalCompleted,
                'total_upcoming'  => $totalUpcoming,
            ],
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
        ], 200);
    }

    public function cancelBooking(Request $request, string $id)
    {
        $request->validate([
            'cancellation_reason' => 'nullable|string|max:500',
        ]);

        $user = $request->user();

        $booking = MentorBooking::with('availability')
            ->where('id', $id)
            ->where('jobseeker_user_id', $user->id)
            ->first();

        if (! $booking) {
            return ResponseHelper::jsonResponse(false, 'Booking tidak ditemukan.', null, 404);
        }

        if (in_array($booking->status, ['cancelled', 'rejected', 'completed'], true)) {
            return ResponseHelper::jsonResponse(false, 'Status booking ini tidak bisa dibatalkan lagi.', null, 422);
        }

        if ($booking->scheduled_start && $booking->scheduled_start->isPast()) {
            return ResponseHelper::jsonResponse(false, 'Sesi yang sudah dimulai tidak bisa dibatalkan.', null, 422);
        }

        $cancellationReason = $request->input('cancellation_reason');

        DB::transaction(function () use ($booking, $cancellationReason) {
            $booking->update([
                'status'           => 'cancelled',
                'rejection_reason' => $cancellationReason,
            ]);

            if ($booking->availability) {
                $booking->availability->update([
                    'is_booked' => false,
                ]);
            }
        });

        $booking->refresh()->load(['mentor.user']);

        return ResponseHelper::jsonResponse(
            true,
            'Booking berhasil dibatalkan.',
            (new MentorBookingResource($booking))->toArray(request()),
            200
        );
    }
}
