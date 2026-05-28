<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mentor_availabilities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('mentor_id');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->string('timezone')->default('Asia/Jakarta');
            $table->boolean('is_booked')->default(false);
            $table->string('label')->nullable();
            $table->timestamps();

            $table->foreign('mentor_id')->references('id')->on('mentors')->onDelete('cascade');
            $table->index(['mentor_id', 'start_at']);
            $table->index(['is_booked', 'start_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentor_availabilities');
    }
};
