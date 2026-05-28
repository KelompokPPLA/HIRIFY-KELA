<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MentorMarketplaceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->user?->name,
            'email' => $this->user?->email,
            'avatar_url' => $this->profile_picture ? Storage::url($this->profile_picture) : null,
            'expertise' => $this->expertise,
            'experience_years' => (int) ($this->experience_years ?? 0),
            'bio' => $this->bio,
            'education' => $this->education,
            'skills' => $this->skills ?? [],
            'availability_text' => $this->availability,
            'price_per_session' => (float) ($this->price_per_session ?? 0),
            'open_slots_count' => (int) ($this->open_slots_count ?? 0),
            'session_count' => (int) ($this->session_count ?? 0),
            'rating' => (float) ($this->rating ?? 4.8),
        ];
    }
}
