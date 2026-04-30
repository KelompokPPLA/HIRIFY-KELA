<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ================================================================
        // TABLE: cvs
        // ================================================================
        Schema::create('cvs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('telepon');
            $table->string('alamat')->nullable();
            $table->string('linkedin')->nullable();
            $table->text('ringkasan')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
        });

        // ================================================================
        // TABLE: educations (menggunakan field bahasa Indonesia agar konsisten dengan model)
        // ================================================================
        Schema::create('educations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cv_id');
            $table->string('institusi');
            $table->string('gelar');
            $table->string('tahun');
            $table->timestamps();

            $table->foreign('cv_id')
                  ->references('id')
                  ->on('cvs')
                  ->cascadeOnDelete();
        });

        // ================================================================
        // TABLE: experiences
        // ================================================================
        Schema::create('experiences', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cv_id');
            $table->string('posisi');
            $table->string('perusahaan');
            $table->text('deskripsi')->nullable();
            $table->string('periode');
            $table->timestamps();

            $table->foreign('cv_id')
                  ->references('id')
                  ->on('cvs')
                  ->cascadeOnDelete();
        });

        // ================================================================
        // TABLE: skills
        // ================================================================
        Schema::create('skills', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cv_id');
            $table->string('nama_skill');
            $table->enum('tipe', ['technical', 'soft'])->default('technical');
            $table->timestamps();

            $table->foreign('cv_id')
                  ->references('id')
                  ->on('cvs')
                  ->cascadeOnDelete();

            $table->index('cv_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
        Schema::dropIfExists('experiences');
        Schema::dropIfExists('educations');
        Schema::dropIfExists('cvs');
    }
};
