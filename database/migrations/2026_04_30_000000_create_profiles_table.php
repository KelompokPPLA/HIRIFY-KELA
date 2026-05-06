<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {

            // UUID FK (HARUS SAMA DENGAN users.id)
            $table->uuid('id')->primary();

                // Relasi ke user
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('nama_lengkap')->nullable();
            $table->string('telepon')->nullable();
            $table->string('photo')->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('institusi')->nullable();
            $table->string('jurusan')->nullable();
            $table->decimal('ipk', 5, 2)->nullable();
            $table->integer('tahun_mulai_pendidikan')->nullable();
            $table->integer('tahun_selesai_pendidikan')->nullable();
            $table->string('posisi_kerja')->nullable();
            $table->string('perusahaan')->nullable();
            $table->string('periode_mulai_kerja')->nullable();
            $table->string('periode_selesai_kerja')->nullable();
            $table->text('deskripsi_kerja')->nullable();
            $table->text('skills')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};