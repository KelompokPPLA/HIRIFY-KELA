<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cvs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('telepon');
            $table->string('linkedin')->nullable();
            $table->text('ringkasan')->nullable();
            $table->text('skills')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });

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
                  ->onDelete('cascade');
        });

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
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
        Schema::dropIfExists('educations');
        Schema::dropIfExists('cvs');
    }
};
