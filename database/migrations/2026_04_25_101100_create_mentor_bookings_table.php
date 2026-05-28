<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mentor_bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('mentor_id');
            $table->uuid('jobseeker_user_id');
            $table->uuid('mentor_availability_id')->nullable();
            $table->dateTime('scheduled_start');
            $table->dateTime('scheduled_end');
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled', 'rejected'])->default('pending');
            $table->decimal('price_per_session', 10, 2)->nullable();
            $table->text('booking_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->string('meeting_url')->nullable();
            $table->timestamps();

            $table->foreign('mentor_id')->references('id')->on('mentors')->onDelete('cascade');
            $table->foreign('jobseeker_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('mentor_availability_id')->references('id')->on('mentor_availabilities')->onDelete('set null');

            $table->index(['jobseeker_user_id', 'status']);
            $table->index(['mentor_id', 'status']);
            $table->index('scheduled_start');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentor_bookings');
    }
};
