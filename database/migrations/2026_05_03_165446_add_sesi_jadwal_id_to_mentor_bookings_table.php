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
        Schema::table('mentor_bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('sesi_jadwal_id')->nullable()->after('mentor_availability_id');
            $table->foreign('sesi_jadwal_id')->references('id')->on('sesiJadwal')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('mentor_bookings', function (Blueprint $table) {
            $table->dropForeign(['sesi_jadwal_id']);
            $table->dropColumn('sesi_jadwal_id');
        });
    }
};
