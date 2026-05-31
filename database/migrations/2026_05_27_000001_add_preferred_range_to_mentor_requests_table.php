<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mentor_requests', function (Blueprint $table) {
            $table->time('preferred_start')->nullable()->after('preferred_at');
            $table->time('preferred_end')->nullable()->after('preferred_start');
        });
    }

    public function down()
    {
        Schema::table('mentor_requests', function (Blueprint $table) {
            $table->dropColumn(['preferred_start', 'preferred_end']);
        });
    }
};
