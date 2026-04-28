<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forum_comments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('forum_thread_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->text('body');
            $table->timestamps();

            $table->index(['forum_thread_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forum_comments');
    }
};
