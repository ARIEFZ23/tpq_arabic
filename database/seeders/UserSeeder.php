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
        // Password default untuk semua user (sesuai rangkuman)
        $defaultPassword = Hash::make('password'); // Anda bisa ganti 'password' jika mau

        // Admin
        User::create([
            'name' => 'Admin TPQ',
            'email' => 'admin@tpq.com',
            'password' => $defaultPassword,
            'role' => 'admin',
            'class_id' => null,
        ]);

        // Ustadz
        User::create([
            'name' => 'Ustadz Ahmad',
            'email' => 'ustadz@tpq.com',
            'password' => $defaultPassword,
            'role' => 'ustadz',
            'class_id' => null,
        ]);

        // Ustadzah
        User::create([
            'name' => 'Ustadzah Fatimah',
            'email' => 'ustadzah@tpq.com',
            'password' => $defaultPassword,
            'role' => 'ustadzah',
            'class_id' => null,
        ]);

        // Santri Putra
        User::create([
            'name' => 'Muhammad Ali',
            'email' => 'ali@tpq.com',
            'password' => $defaultPassword,
            'role' => 'santri_putra',
            'class_id' => 'Kelas A',
        ]);

        // Santri Putri
        User::create([
            'name' => 'Aisyah Zahra',
            'email' => 'aisyah@tpq.com',
            'password' => $defaultPassword,
            'role' => 'santri_putri',
            'class_id' => 'Kelas A',
        ]);

        // 1. DITAMBAHKAN: Santri Putra (qoizo)
        User::create([
            'name' => 'qoizo',
            'email' => 'qoizo@com',
            'password' => $defaultPassword,
            'role' => 'santri_putra',
            'class_id' => 'Kelas B',
        ]);

        // 2. DITAMBAHKAN: Santri Putra (kuza)
        User::create([
            'name' => 'kuza',
            'email' => 'kuza@com',
            'password' => $defaultPassword,
            'role' => 'santri_putra',
            'class_id' => 'Kelas B',
        ]);
    }
}
