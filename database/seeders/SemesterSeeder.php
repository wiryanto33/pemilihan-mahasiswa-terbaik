<?php

namespace Database\Seeders;

use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Semester::updateOrCreate(
            ['code' => '2023-Ganjil'],
            ['year' => 2023, 'term' => 'Ganjil', 'start_date' => Carbon::parse('2023-08-01'), 'end_date' => Carbon::parse('2023-12-31')],
            ['code' => '2024-Genap'],
            ['year' => 2024, 'term' => 'Ganjil', 'start_date' => Carbon::parse('2024-01-01'), 'end_date' => Carbon::parse('2023-06-31')]
        );
    }
}
