<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skill_courses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description');
            $table->string('category');
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->string('thumbnail_emoji', 10)->default('📚');
            $table->string('instructor_name');
            $table->unsignedSmallInteger('estimated_hours')->default(1);
            $table->boolean('is_free')->default(true);
            $table->timestamps();

            $table->index(['category', 'level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skill_courses');
    }
};
