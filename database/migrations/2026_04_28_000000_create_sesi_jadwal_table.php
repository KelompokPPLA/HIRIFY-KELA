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
        Schema::create('sesiJadwal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('mentor_id');
            $table->string('topic');
            $table->date('date');
            $table->time('time');
            $table->integer('duration');
            $table->string('platform')->nullable();
            $table->enum('status', ['Pending', 'Confirmed', 'Completed', 'Cancelled'])->default('Pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('mentor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesiJadwal');
    }
};
