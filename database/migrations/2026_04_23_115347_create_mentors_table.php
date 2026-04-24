<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mentors', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relasi ke user
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('profile_picture')->nullable();
            $table->string('phone_number')->nullable();

            // Informasi Profesional
            $table->string('expertise'); // UI/UX, Frontend, dll
            $table->integer('experience_years'); // 8 tahun
            $table->text('bio')->nullable();

            // Pendidikan & Sertifikasi
            $table->string('education')->nullable();

            // Skills (multi value)
            $table->json('skills')->nullable();

            // Ketersediaan & Tarif
            $table->string('availability')->nullable(); // Senin - Jumat, 18:00 - 21:00
            $table->decimal('price_per_session', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentors');
    }
};