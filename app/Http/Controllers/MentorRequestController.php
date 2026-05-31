<?php

namespace App\Http\Controllers;

use App\Models\MentorRequest;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MentorRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'mentor_id' => ['required', 'string'],
            'message' => ['nullable', 'string'],
            'preferred_date' => ['nullable', 'date'],
            'preferred_time' => ['nullable', 'date_format:H:i'],
            'preferred_at' => ['nullable', 'date'],
            'preferred_start' => ['nullable', 'date_format:H:i'],
            'preferred_end' => ['nullable', 'date_format:H:i'],
        ]);

        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $preferredAt = $request->input('preferred_at');
        if (!$preferredAt && $request->filled('preferred_date') && $request->filled('preferred_time')) {
            $preferredAt = $request->input('preferred_date') . ' ' . $request->input('preferred_time');
        }

        // Support preferred_start / preferred_end (time range on preferred_date)
        $preferredStart = $request->input('preferred_start');
        $preferredEnd = $request->input('preferred_end');
        $preferredStartAt = null;
        $preferredEndAt = null;
        if ($request->filled('preferred_date') && $preferredStart) {
            $preferredStartAt = $request->input('preferred_date') . ' ' . $preferredStart;
        }
        if ($request->filled('preferred_date') && $preferredEnd) {
            $preferredEndAt = $request->input('preferred_date') . ' ' . $preferredEnd;
        }

        $mentorRequest = MentorRequest::create([
            'id' => (string) Str::uuid(),
            'user_id' => $user->id,
            'mentor_id' => $request->input('mentor_id'),
            'message' => $request->input('message'),
            'status' => 'pending',
            'preferred_at' => $preferredAt,
            'preferred_start' => $preferredStartAt ? date('H:i:s', strtotime($preferredStartAt)) : null,
            'preferred_end' => $preferredEndAt ? date('H:i:s', strtotime($preferredEndAt)) : null,
        ]);

        // Create notifications so the request shows up in the Notifikasi page
        try {
            // Notify the requester (confirmation)
            UserNotification::create([
                'user_id' => $user->id,
                'type' => 'jadwal',
                'title' => 'Permintaan jadwal terkirim',
                'message' => 'Permintaan jadwal berhasil dikirim ke mentor. Tunggu konfirmasi dari mentor.',
                'action_url' => '/mentorship',
                'data' => ['mentor_request_id' => $mentorRequest->id, 'status' => 'pending'],
            ]);

            // Notify the mentor
            $mentorId = $request->input('mentor_id');
            if ($mentorId) {
                UserNotification::create([
                    'user_id' => $mentorId,
                    'type' => 'jadwal',
                    'title' => 'Permintaan jadwal baru',
                    'message' => ($user->name ?? 'Seorang user') . ' mengirim permintaan jadwal. Cek halaman dashboard mentor untuk konfirmasi.',
                    'action_url' => '/mentor/dashboard',
                    'data' => ['mentor_request_id' => $mentorRequest->id, 'jobseeker_user_id' => $user->id],
                ]);
            }
        } catch (\Throwable $e) {
            // Non-fatal: ignore notification errors
        }

        return response()->json(['data' => $mentorRequest], 201);
    }
}
