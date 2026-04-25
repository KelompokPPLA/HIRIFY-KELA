<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMentorBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        return [
            'mentor_id' => ['required', 'uuid', 'exists:mentors,id'],
            'mentor_availability_id' => ['nullable', 'uuid', 'exists:mentor_availabilities,id'],
            'scheduled_start' => ['nullable', 'date', 'after:now'],
            'duration_minutes' => ['nullable', 'integer', 'min:30', 'max:180'],
            'booking_notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'mentor_id.required' => 'Mentor wajib dipilih.',
            'mentor_id.exists' => 'Mentor tidak ditemukan.',
            'mentor_availability_id.exists' => 'Slot ketersediaan tidak valid.',
            'scheduled_start.after' => 'Waktu sesi harus di masa mendatang.',
        ];
    }
}
