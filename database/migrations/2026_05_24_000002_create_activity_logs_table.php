<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->enum('activity_type', ['training', 'assessment', 'mentorship'])
                  ->comment('Jenis aktivitas: pelatihan, self assessment, atau mentorship');
            $table->date('activity_date')->comment('Tanggal aktivitas dilakukan (tanpa jam)');
            $table->uuid('reference_id')->nullable()->comment('ID entitas terkait: lesson/assessment/booking');
            $table->string('description')->nullable()->comment('Deskripsi singkat aktivitas');
            $table->timestamps();

            // Index untuk query streak harian yang efisien
            $table->index(['user_id', 'activity_date']);
            $table->index(['user_id', 'activity_type', 'activity_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
