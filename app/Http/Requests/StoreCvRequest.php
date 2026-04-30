<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCvRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_lengkap'              => ['required', 'string', 'max:255'],
            'email'                     => ['required', 'email', 'max:255'],
            'telepon'                   => ['required', 'string', 'max:20'],
            'alamat'                    => ['nullable', 'string', 'max:255'],
            'linkedin'                  => ['nullable', 'string', 'max:255'],
            'ringkasan'                 => ['nullable', 'string', 'max:1000'],
            'skills'                    => ['nullable', 'string', 'max:5000'],
            'technical_skills'          => ['nullable', 'string', 'max:1000'],
            'soft_skills'               => ['nullable', 'string', 'max:1000'],

            // Repeatable education
            'pendidikan'                => ['nullable', 'array'],
            'pendidikan.*.institusi'    => ['required_with:pendidikan', 'string', 'max:255'],
            'pendidikan.*.gelar'        => ['required_with:pendidikan', 'string', 'max:255'],
            'pendidikan.*.tahun'        => ['required_with:pendidikan', 'string', 'max:20'],

            // Repeatable experience
            'pengalaman'                => ['nullable', 'array'],
            'pengalaman.*.posisi'       => ['required_with:pengalaman', 'string', 'max:255'],
            'pengalaman.*.perusahaan'   => ['required_with:pengalaman', 'string', 'max:255'],
            'pengalaman.*.deskripsi'    => ['nullable', 'string', 'max:2000'],
            'pengalaman.*.periode'      => ['required_with:pengalaman', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_lengkap.required'             => 'Nama lengkap wajib diisi.',
            'email.required'                    => 'Email wajib diisi.',
            'email.email'                       => 'Format email tidak valid.',
            'telepon.required'                  => 'Nomor telepon wajib diisi.',
            'pendidikan.*.institusi.required_with' => 'Nama institusi wajib diisi.',
            'pendidikan.*.gelar.required_with'  => 'Gelar wajib diisi.',
            'pendidikan.*.tahun.required_with'  => 'Tahun wajib diisi.',
            'pengalaman.*.posisi.required_with' => 'Posisi wajib diisi.',
            'pengalaman.*.perusahaan.required_with' => 'Nama perusahaan wajib diisi.',
            'pengalaman.*.periode.required_with' => 'Periode wajib diisi.',
        ];
    }
}
