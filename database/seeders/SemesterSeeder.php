<?php

namespace Database\Seeders;

use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * D3  = 6 semester (3 tahun)
     * S1  = 4 semester (2 tahun)
     * S2  = 4 semester (2 tahun)
     * Semua program mulai tahun 2022 agar cukup semester.
     */
    public function run(): void
    {
        $semesters = [
            // Semester 1 - Ganjil 2022
            [
                'code'       => '2022-Ganjil',
                'year'       => 2022,
                'term'       => 'Ganjil',
                'start_date' => '2022-08-01',
                'end_date'   => '2022-12-31',
            ],
            // Semester 2 - Genap 2023
            [
                'code'       => '2023-Genap',
                'year'       => 2023,
                'term'       => 'Genap',
                'start_date' => '2023-01-02',
                'end_date'   => '2023-06-30',
            ],
            // Semester 3 - Ganjil 2023
            [
                'code'       => '2023-Ganjil',
                'year'       => 2023,
                'term'       => 'Ganjil',
                'start_date' => '2023-08-01',
                'end_date'   => '2023-12-31',
            ],
            // Semester 4 - Genap 2024
            [
                'code'       => '2024-Genap',
                'year'       => 2024,
                'term'       => 'Genap',
                'start_date' => '2024-01-02',
                'end_date'   => '2024-06-30',
            ],
            // Semester 5 - Ganjil 2024 (khusus D3)
            [
                'code'       => '2024-Ganjil',
                'year'       => 2024,
                'term'       => 'Ganjil',
                'start_date' => '2024-08-01',
                'end_date'   => '2024-12-31',
            ],
            // Semester 6 - Genap 2025 (khusus D3)
            [
                'code'       => '2025-Genap',
                'year'       => 2025,
                'term'       => 'Genap',
                'start_date' => '2025-01-02',
                'end_date'   => '2025-06-30',
            ],
        ];

        foreach ($semesters as $sem) {
            Semester::updateOrCreate(
                ['code' => $sem['code']],
                [
                    'year'       => $sem['year'],
                    'term'       => $sem['term'],
                    'start_date' => Carbon::parse($sem['start_date']),
                    'end_date'   => Carbon::parse($sem['end_date']),
                ]
            );
        }
    }
}
