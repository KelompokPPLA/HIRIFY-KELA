<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roadmaps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('career_field');
            $table->string('step_title');
            $table->text('description')->nullable();
            $table->json('skills')->nullable();
            $table->json('tools')->nullable();
            $table->json('activities')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->integer('step_order')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roadmaps');
    }
};
