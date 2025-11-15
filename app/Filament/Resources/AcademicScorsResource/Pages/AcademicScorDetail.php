<?php

namespace App\Filament\Resources\AcademicScorsResource\Pages;

use App\Models\AcademicScors;
use App\Models\Mahasiswa;
use Filament\Pages\Page;

class AcademicScorDetail extends Page
{
    protected static string $view = 'filament.pages.academic-scor-detail';
    protected static ?string $title = 'Detail Nilai Akademik';

    public $mahasiswa;
    public $scores;

    public function mount($mahasiswa_id)
    {
        $this->mahasiswa = Mahasiswa::with('programStudy')->findOrFail($mahasiswa_id);
        $this->scores = AcademicScors::with(['matakuliah', 'semester'])
            ->where('mahasiswa_id', $mahasiswa_id)
            ->get();
    }
}
