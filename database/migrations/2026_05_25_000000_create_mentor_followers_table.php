<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMentorFollowersTable extends Migration
{
    public function up()
    {
        Schema::create('mentor_followers', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->uuid('mentor_id');
            $table->timestamps();
            $table->unique(['user_id', 'mentor_id']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('mentor_id')->references('id')->on('mentors')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mentor_followers');
    }
}
