<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MentorProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user()->id,
            'phone_number' => 'nullable|string|max:30',
            'expertise' => 'required|string|max:255',
            'experience_years' => 'nullable|integer|min:0|max:60',
            'bio' => 'nullable|string|max:2000',
            'education' => 'nullable|string|max:255',

            'skills' => 'nullable|array|max:30',
            'skills.*' => 'string|max:60',
            'certifications' => 'nullable|array|max:30',
            'certifications.*' => 'string|max:180',
        ];
    }
}
