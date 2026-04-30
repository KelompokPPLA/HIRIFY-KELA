<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCvRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            // Data diri
            'nama_lengkap'              => ['required', 'string', 'max:255'],
            'email'                     => ['required', 'email', 'max:255'],
            'telepon'                   => ['required', 'string', 'max:20'],
            'alamat'                    => ['nullable', 'string', 'max:255'],
            'linkedin'                  => ['nullable', 'string', 'max:255'],
            'ringkasan'                 => ['nullable', 'string', 'max:2000'],

            // Skills (input sebagai string, dipisah koma)
            'technical_skills'          => ['nullable', 'string', 'max:2000'],
            'soft_skills'               => ['nullable', 'string', 'max:2000'],

            // Pendidikan (array)
            'pendidikan'                => ['nullable', 'array'],
            'pendidikan.*.institusi'    => ['required_with:pendidikan', 'string', 'max:255'],
            'pendidikan.*.gelar'        => ['required_with:pendidikan', 'string', 'max:255'],
            'pendidikan.*.tahun'        => ['required_with:pendidikan', 'string', 'max:20'],

            // Pengalaman (array)
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
            'nama_lengkap.required'                  => 'Nama lengkap wajib diisi.',
            'email.required'                         => 'Email wajib diisi.',
            'email.email'                            => 'Format email tidak valid.',
            'telepon.required'                       => 'Nomor telepon wajib diisi.',
            'pendidikan.*.institusi.required_with'   => 'Nama institusi wajib diisi.',
            'pendidikan.*.gelar.required_with'       => 'Gelar wajib diisi.',
            'pendidikan.*.tahun.required_with'       => 'Tahun pendidikan wajib diisi.',
            'pengalaman.*.posisi.required_with'      => 'Posisi pekerjaan wajib diisi.',
            'pengalaman.*.perusahaan.required_with'  => 'Nama perusahaan wajib diisi.',
            'pengalaman.*.periode.required_with'     => 'Periode kerja wajib diisi.',
        ];
    }
}
