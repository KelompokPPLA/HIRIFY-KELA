<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('profiles') && !Schema::hasColumn('profiles', 'skills')) {
            Schema::table('profiles', function (Blueprint $table) {
                $table->json('skills')->nullable()->after('experience');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('profiles') && Schema::hasColumn('profiles', 'skills')) {
            Schema::table('profiles', function (Blueprint $table) {
                $table->dropColumn('skills');
            });
        }
    }
};
