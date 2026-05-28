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
        Schema::create('training_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_number', 50)->unique();
            $table->string('verification_code', 20)->unique();
            // users.id dan skill_courses.id menggunakan UUID (konsisten dengan migration lain)
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('skill_course_id')->constrained()->cascadeOnDelete();
            $table->string('user_name');
            $table->string('course_title');
            $table->string('instructor_name')->nullable();
            $table->date('issued_at');
            $table->timestamps();

            $table->index('user_id');
            $table->index('verification_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_certificates');
    }
};
