<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('streak_badges', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->comment('Nama badge, misal: Streak Pemula');
            $table->string('description')->comment('Deskripsi pencapaian badge');
            $table->unsignedSmallInteger('milestone_days')->comment('Jumlah streak hari untuk mendapatkan badge');
            $table->string('icon', 10)->default('🏅')->comment('Emoji/icon badge');
            $table->string('color', 30)->default('amber')->comment('Warna tema badge');
            $table->timestamps();

            $table->unique('milestone_days');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('streak_badges');
    }
};
