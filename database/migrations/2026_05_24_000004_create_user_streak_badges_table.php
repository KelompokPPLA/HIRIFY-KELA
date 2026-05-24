<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_streak_badges', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->uuid('streak_badge_id');
            $table->foreign('streak_badge_id')->references('id')->on('streak_badges')->cascadeOnDelete();
            $table->timestamp('earned_at')->comment('Waktu badge diperoleh');
            $table->timestamps();

            // Satu user hanya bisa mendapatkan satu badge yang sama sekali
            $table->unique(['user_id', 'streak_badge_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_streak_badges');
    }
};
