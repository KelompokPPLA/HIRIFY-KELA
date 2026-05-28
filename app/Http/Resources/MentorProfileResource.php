<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MentorProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $avatarUrl = null;

        if ($this->profile_picture) {
            $avatarUrl = Storage::url($this->profile_picture);
        }

        return [
            'id' => $this->id,
            'name' => $this->user?->name,
            'email' => $this->user?->email,
            'profile_picture' => $this->profile_picture,
            'avatar_url' => $avatarUrl,
            'phone_number' => $this->phone_number,
            'expertise' => $this->expertise,
            'experience_years' => $this->experience_years,
            'bio' => $this->bio,
            'education' => $this->education,
            'availability' => $this->availability,
            'price_per_session' => (float) ($this->price_per_session ?? 0),
            'skills' => $this->skills ?? [],
            'certifications' => $this->certifications
                ->pluck('title')
                ->filter()
                ->values()
                ->all(),
        ];
    }
}
