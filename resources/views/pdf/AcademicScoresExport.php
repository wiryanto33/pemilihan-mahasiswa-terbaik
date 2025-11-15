<?php

namespace App\Exports;

use App\Models\AcademicScors;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AcademicScoresExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(public int $mahasiswaId) {}

    public function collection()
    {
        return AcademicScors::with(['matakuliah', 'semester'])
            ->where('mahasiswa_id', $this->mahasiswaId)
            ->orderByDesc('semester_id')
            ->get();
    }

    public function headings(): array
    {
        return ['Mata Kuliah', 'Semester', 'Quiz', 'UTS', 'UAS', 'Nilai Akhir', 'Grade'];
    }

    public function map($row): array
    {
        return [
            $row->matakuliah?->name,
            $row->semester?->code,
            $row->nu,
            $row->uts,
            $row->uas,
            $row->final_numeric,
            $row->final_letter,
        ];
    }
}
