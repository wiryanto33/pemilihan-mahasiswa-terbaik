<?php

namespace Database\Seeders;

use App\Models\Matakuliah;
use App\Models\ProgramStudy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MatakuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $d3Ti = ProgramStudy::where('code', 'D3-TI')->first();
        Matakuliah::updateOrCreate(['code' => 'IF101'], ['program_study_id' => $d3Ti->id, 'name' => 'Algoritma', 'sks' => 3]);
        Matakuliah::updateOrCreate(['code' => 'IF102'], ['program_study_id' => $d3Ti->id, 'name' => 'Struktur Data', 'sks' => 3]);
        Matakuliah::updateOrCreate(['code' => 'IF103'], ['program_study_id' => $d3Ti->id, 'name' => 'Basis Data', 'sks' => 2]);
        Matakuliah::updateOrCreate(['code' => 'IF104'], ['program_study_id' => $d3Ti->id, 'name' => 'Jaringan Komputer', 'sks' => 2]);

        $d3Tm = ProgramStudy::where('code', 'D3-TM')->first();
        Matakuliah::updateOrCreate(['code' => 'TM101'], ['program_study_id' => $d3Tm->id, 'name' => 'Mesin', 'sks' => 3]);
        Matakuliah::updateOrCreate(['code' => 'TM102'], ['program_study_id' => $d3Tm->id, 'name' => 'Fluida', 'sks' => 3]);
        Matakuliah::updateOrCreate(['code' => 'TM103'], ['program_study_id' => $d3Tm->id, 'name' => 'Kompresi', 'sks' => 2]);
        Matakuliah::updateOrCreate(['code' => 'TM104'], ['program_study_id' => $d3Tm->id, 'name' => 'Mekatronika', 'sks' => 2]);
    }
}
