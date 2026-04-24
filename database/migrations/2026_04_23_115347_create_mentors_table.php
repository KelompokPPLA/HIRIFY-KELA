<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mentors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('profile_picture')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('expertise');
            $table->integer('experience_years');
            $table->text('bio')->nullable();
            $table->string('education')->nullable();
            $table->json('skills')->nullable();
            $table->string('availability')->nullable();
            $table->decimal('price_per_session', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentors');
    }
};