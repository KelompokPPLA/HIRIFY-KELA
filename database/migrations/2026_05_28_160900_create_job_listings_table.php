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
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('company_name');
            $table->string('company_logo')->nullable();
            $table->string('location');
            $table->enum('job_type', ['full-time', 'part-time', 'internship', 'remote', 'contract'])->default('full-time');
            $table->enum('level', ['entry', 'mid', 'senior', 'lead'])->default('entry');
            $table->string('category');
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->string('salary_min')->nullable();
            $table->string('salary_max')->nullable();
            $table->boolean('salary_visible')->default(true);
            $table->date('deadline')->nullable();
            $table->string('apply_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['category', 'job_type', 'level']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
