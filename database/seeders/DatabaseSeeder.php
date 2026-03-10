<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User admin default tanpa factory
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        // Seeder berurutan (dependency order)
        $this->call([
            ShieldSeeder::class,            // Permission & Roles
            ProgramStudySeeder::class,      // Prodi (D3/S1/S2)
            SemesterSeeder::class,          // 6 semester (2022-Ganjil s/d 2025-Genap)
            FitnessRuleSeedFromConfigSeeder::class, // Aturan fitness jasmani
            MatakuliahSeeder::class,        // MK per prodi per semester
            MahasiswaSeeder::class,         // Mahasiswa D3 & S1
            ScoreSeeder::class,             // Nilai: akademik, kepribadian, jasmani, rekap
        ]);
    }
}
