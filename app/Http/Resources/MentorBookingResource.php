<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MentorBookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $mentor = $this->mentor;
        $statusLabels = [
            'pending' => 'Menunggu konfirmasi',
            'confirmed' => 'Terkonfirmasi',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'rejected' => 'Ditolak',
        ];

        return [
            'id' => $this->id,
            'status' => $this->status,
            'status_label' => $statusLabels[$this->status] ?? ucfirst($this->status),
            'scheduled_start' => $this->scheduled_start?->toIso8601String(),
            'scheduled_end' => $this->scheduled_end?->toIso8601String(),
            'display_date' => $this->scheduled_start?->locale('id')->translatedFormat('D, d M Y'),
            'display_time' => $this->scheduled_start?->format('H:i') . ' - ' . $this->scheduled_end?->format('H:i'),
            'booking_notes' => $this->booking_notes,
            'rejection_reason' => $this->rejection_reason,
            'meeting_url' => $this->meeting_url,
            'price_per_session' => (float) ($this->price_per_session ?? 0),
            'mentor' => [
                'id' => $mentor?->id,
                'name' => $mentor?->user?->name,
                'expertise' => $mentor?->expertise,
                'avatar_url' => $mentor?->profile_picture ? Storage::url($mentor->profile_picture) : null,
            ],
            'availability_id' => $this->mentor_availability_id,
            'sesi_jadwal_id' => $this->sesi_jadwal_id,
            'session_topic' => $this->sesiJadwal?->topic,
            'platform' => $this->sesiJadwal?->platform,
            'material_url' => $this->sesiJadwal?->material_file ? Storage::url($this->sesiJadwal->material_file) : null,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
