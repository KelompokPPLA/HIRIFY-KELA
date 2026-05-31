<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCvRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Prepare data sebelum validasi: buang array pendidikan/pengalaman yang kosong
     * agar entri kosong dari JS tidak trigger validasi required_with.
     */
    protected function prepareForValidation(): void
    {
        // Bersihkan array pendidikan — buang entri yang institusinya kosong
        if ($this->has('pendidikan') && is_array($this->pendidikan)) {
            $cleaned = array_values(array_filter(
                $this->pendidikan,
                fn ($item) => ! empty(trim($item['institusi'] ?? ''))
            ));
            $this->merge(['pendidikan' => $cleaned ?: null]);
        }

        // Bersihkan array pengalaman — buang entri yang posisinya kosong
        if ($this->has('pengalaman') && is_array($this->pengalaman)) {
            $cleaned = array_values(array_filter(
                $this->pengalaman,
                fn ($item) => ! empty(trim($item['posisi'] ?? ''))
            ));
            $this->merge(['pengalaman' => $cleaned ?: null]);
        }

        // Bersihkan skill string yang hanya whitespace
        if ($this->has('technical_skills')) {
            $this->merge(['technical_skills' => trim($this->technical_skills ?? '')]);
        }
        if ($this->has('soft_skills')) {
            $this->merge(['soft_skills' => trim($this->soft_skills ?? '')]);
        }
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

            // Skills (input sebagai string, dipisah koma) — opsional
            'technical_skills'          => ['nullable', 'string', 'max:2000'],
            'soft_skills'               => ['nullable', 'string', 'max:2000'],

            // Pendidikan (array opsional — sudah dibersihkan di prepareForValidation)
            'pendidikan'                => ['nullable', 'array'],
            'pendidikan.*.institusi'    => ['required_with:pendidikan', 'string', 'max:255'],
            'pendidikan.*.gelar'        => ['required_with:pendidikan', 'string', 'max:255'],
            'pendidikan.*.tahun'        => ['required_with:pendidikan', 'string', 'max:20'],

            // Pengalaman (array opsional — sudah dibersihkan di prepareForValidation)
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
