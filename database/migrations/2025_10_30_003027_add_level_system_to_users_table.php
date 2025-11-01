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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('level')->default(1)->after('role');
            $table->integer('experience_points')->default(0)->after('level');
            $table->integer('total_games_completed')->default(0)->after('experience_points');
            $table->string('current_badge')->nullable()->after('total_games_completed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['level', 'experience_points', 'total_games_completed', 'current_badge']);
        });
    }
};