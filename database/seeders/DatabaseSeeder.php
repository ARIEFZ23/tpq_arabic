<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Memanggil UserSeeder (Admin, Ustadz, Santri, kuza@com, dll)
        // 2. Memanggil Seeder Soal Bawaan (20 soal Survival Quiz)
        $this->call([
            UserSeeder::class,
            SurvivalQuestionsSeeder::class,
        ]);
    }
}
