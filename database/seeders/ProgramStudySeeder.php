<?php

namespace Database\Seeders;

use App\Models\ProgramStudy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProgramStudy::updateOrCreate(['code' => 'D3-TI'], ['name' => 'Teknik Informatika ', 'level' => 'D3']);
        ProgramStudy::updateOrCreate(['code' => 'D3-TM'], ['name' => 'Teknik Mesin ', 'level' => 'D3']);
        ProgramStudy::updateOrCreate(['code' => 'D3-TE'], ['name' => 'Teknik Elektro ', 'level' => 'D3']);
        ProgramStudy::updateOrCreate(['code' => 'D3-HO'], ['name' => 'Teknik Hidrooseanografi ', 'level' => 'D3']);
        ProgramStudy::updateOrCreate(['code' => 'S1-TE'], ['name' => 'Teknik Elektro ', 'level' => 'S1']);
        ProgramStudy::updateOrCreate(['code' => 'S1-TM'], ['name' => 'Teknik Mesin ', 'level' => 'S1']);
        ProgramStudy::updateOrCreate(['code' => 'S1-HO'], ['name' => 'Teknik Hidrooseanografi ', 'level' => 'S1']);
        ProgramStudy::updateOrCreate(['code' => 'S1-TMI'], ['name' => 'Teknik Management Industri ', 'level' => 'S1']);
        ProgramStudy::updateOrCreate(['code' => 'S2-ASRO'], ['name' => 'Analisis Sistem Riset dan Operasi ', 'level' => 'S2']);
    }
}
