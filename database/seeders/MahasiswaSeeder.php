<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\ProgramStudy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $d3Ti = ProgramStudy::where('code', 'D3-TI')->first();

        Mahasiswa::updateOrCreate(['nrp' => 'NRP001'], [
            'program_study_id' => $d3Ti->id,
            'name' => 'Asep Hidayat',
            'pangkat' => 'Sertu',
            'korps' => 'E',
            'angkatan' => '2023',
            'gender' => 'Pria'
        ]);
        Mahasiswa::updateOrCreate(['nrp' => 'NRP002'], [
            'program_study_id' => $d3Ti->id,
            'name' => 'Bunga Lestari',
            'pangkat' => 'Serda',
            'korps' => 'E',
            'angkatan' => '2023',
            'gender' => 'Wanita'
        ]);
        Mahasiswa::updateOrCreate(['nrp' => 'NRP003'], [
            'program_study_id' => $d3Ti->id,
            'name' => 'Cahyo Pranata',
            'pangkat' => 'Sertu',
            'korps' => 'T',
            'angkatan' => '2023',
            'gender' => 'Pria'
        ]);
    }
}
