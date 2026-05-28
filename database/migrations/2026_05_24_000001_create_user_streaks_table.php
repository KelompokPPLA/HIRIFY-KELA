<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_streaks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unsignedSmallInteger('current_streak')->default(0)->comment('Streak hari beruntun saat ini');
            $table->unsignedSmallInteger('longest_streak')->default(0)->comment('Rekor streak terpanjang sepanjang waktu');
            $table->date('last_activity_date')->nullable()->comment('Tanggal aktivitas terakhir tercatat');
            $table->unsignedInteger('total_activity_days')->default(0)->comment('Total hari aktif sepanjang waktu');
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_streaks');
    }
};
