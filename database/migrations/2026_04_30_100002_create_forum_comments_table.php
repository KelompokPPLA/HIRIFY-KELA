<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('forum_comments')) {
            Schema::create('forum_comments', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('forum_thread_id');
                $table->foreign('forum_thread_id')->references('id')->on('forum_threads')->onDelete('cascade');
                $table->uuid('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->text('body');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('forum_comments');
    }
};
