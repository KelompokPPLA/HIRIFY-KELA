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
            'name' => 'required|string|min:10|max:60',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user()->id,
            'phone_number' => 'required|string|min:10|max:13',
            'expertise' => 'required|string|max:255',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'bio' => 'nullable|string|max:150',
            'education' => 'nullable|string|max:255',

            'skills' => 'nullable|array|max:30',
            'skills.*' => 'string|max:60',
            'certifications' => 'nullable|array|max:30',
            'certifications.*' => 'string|max:180',
        ];
    }
}
