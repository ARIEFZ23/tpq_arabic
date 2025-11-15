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
            // Cek jika kolom belum ada
            if (!Schema::hasColumn('users', 'total_games_completed')) {
                // Tambahkan kolom setelah 'total_score' agar rapi
                $table->integer('total_games_completed')->default(0)->after('total_score');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek jika kolom ada sebelum dihapus
            if (Schema::hasColumn('users', 'total_games_completed')) {
                $table->dropColumn('total_games_completed');
            }
        });
    }
};