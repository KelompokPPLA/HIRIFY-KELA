<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Ubah kolom activity_type dari ENUM ke VARCHAR
 * dan migrasi data 'assessment' → 'self_assessment'.
 *
 * Alasan:
 * - ENUM tidak fleksibel untuk menambah tipe baru.
 * - Tipe 'assessment' distandarisasi menjadi 'self_assessment'.
 * - Tipe baru yang didukung: training, self_assessment, mentorship, portofolio, cv.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Ubah kolom dari ENUM ke string (VARCHAR 50)
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->string('activity_type', 50)
                  ->comment('Jenis aktivitas: training, self_assessment, mentorship, portofolio, cv')
                  ->change();
        });

        // Migrasikan data lama: 'assessment' → 'self_assessment'
        DB::table('activity_logs')
            ->where('activity_type', 'assessment')
            ->update(['activity_type' => 'self_assessment']);
    }

    public function down(): void
    {
        // Kembalikan data 'self_assessment' → 'assessment' sebelum revert kolom
        DB::table('activity_logs')
            ->where('activity_type', 'self_assessment')
            ->update(['activity_type' => 'assessment']);

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->enum('activity_type', ['training', 'assessment', 'mentorship'])
                  ->comment('Jenis aktivitas: pelatihan, self assessment, atau mentorship')
                  ->change();
        });
    }
};
