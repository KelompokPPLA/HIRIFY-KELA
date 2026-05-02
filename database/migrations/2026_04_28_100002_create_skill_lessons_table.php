<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skill_lessons', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('skill_course_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->longText('content');
            $table->unsignedSmallInteger('order_number')->default(1);
            $table->unsignedSmallInteger('duration_minutes')->default(10);
            $table->timestamps();

            $table->index(['skill_course_id', 'order_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skill_lessons');
    }
};
