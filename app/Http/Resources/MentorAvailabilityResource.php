<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MentorAvailabilityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'start_at' => $this->start_at?->toIso8601String(),
            'end_at' => $this->end_at?->toIso8601String(),
            'timezone' => $this->timezone,
            'label' => $this->label,
            'is_booked' => (bool) $this->is_booked,
            'display_date' => $this->start_at?->locale('id')->translatedFormat('D, d M Y'),
            'display_time' => $this->start_at?->format('H:i') . ' - ' . $this->end_at?->format('H:i'),
        ];
    }
}
