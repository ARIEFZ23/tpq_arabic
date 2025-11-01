<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin TPQ',
            'email' => 'admin@tpq.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'class_id' => null,
        ]);

        // Ustadz
        User::create([
            'name' => 'Ustadz Ahmad',
            'email' => 'ustadz@tpq.com',
            'password' => Hash::make('password'),
            'role' => 'ustadz',
            'class_id' => null,
        ]);

        // Ustadzah
        User::create([
            'name' => 'Ustadzah Fatimah',
            'email' => 'ustadzah@tpq.com',
            'password' => Hash::make('password'),
            'role' => 'ustadzah',
            'class_id' => null,
        ]);

        // Santri Putra
        User::create([
            'name' => 'Muhammad Ali',
            'email' => 'ali@tpq.com',
            'password' => Hash::make('password'),
            'role' => 'santri_putra',
            'class_id' => 'Kelas A',
        ]);

        // Santri Putri
        User::create([
            'name' => 'Aisyah Zahra',
            'email' => 'aisyah@tpq.com',
            'password' => Hash::make('password'),
            'role' => 'santri_putri',
            'class_id' => 'Kelas A',
        ]);
    }
}