<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'telepon',
        'alamat',
        'tanggal_lahir',
        'institusi',
        'jurusan',
        'ipk',
        'tahun_mulai_pendidikan',
        'tahun_selesai_pendidikan',
        'posisi_kerja',
        'perusahaan',
        'periode_mulai_kerja',
        'periode_selesai_kerja',
        'deskripsi_kerja',
        'skills',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}