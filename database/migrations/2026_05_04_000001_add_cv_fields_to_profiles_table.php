<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('profiles', 'education')) {
                $table->json('education')->nullable()->after('photo');
            }
            if (!Schema::hasColumn('profiles', 'experience')) {
                $table->json('experience')->nullable()->after('education');
            }
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (Schema::hasColumn('profiles', 'experience')) {
                $table->dropColumn('experience');
            }
            if (Schema::hasColumn('profiles', 'education')) {
                $table->dropColumn('education');
            }
        });
    }
};