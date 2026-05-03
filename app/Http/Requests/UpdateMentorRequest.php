<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMentorRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && $this->user()->hasRole('admin');
    }

    public function rules()
    {
        $mentorId = $this->route('mentor') ? $this->route('mentor')->id : null;

        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:mentors,email,' . $mentorId,
            'expertise' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ];
    }
}
