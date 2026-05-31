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
        Schema::create('mentor_reviews', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('mentor_booking_id')->unique();
            $table->uuid('mentor_id');
            $table->uuid('jobseeker_user_id');
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('mentor_booking_id')
                  ->references('id')
                  ->on('mentor_bookings')
                  ->cascadeOnDelete();

            $table->foreign('mentor_id')
                  ->references('id')
                  ->on('mentors')
                  ->cascadeOnDelete();

            $table->foreign('jobseeker_user_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentor_reviews');
    }
};
