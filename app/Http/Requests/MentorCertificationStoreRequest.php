<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MentorCertificationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:180',
            'certificate_file' => 'required|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
        ];
    }
}
