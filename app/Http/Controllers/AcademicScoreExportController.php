<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\AcademicScors;
use App\Exports\AcademicScoresExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AcademicScoreExportController extends Controller
{
    public function excel(Mahasiswa $mahasiswa)
    {
        $file = 'nilai-' . $mahasiswa->nrp . '-' . $mahasiswa->name . '.xlsx';
        return Excel::download(new AcademicScoresExport($mahasiswa->id), $file);
    }

    public function pdf(Mahasiswa $mahasiswa)
    {
        $scores = AcademicScors::with(['matakuliah', 'semester'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->orderByDesc('semester_id')
            ->get();

        $pdf = Pdf::loadView('pdf.academic-scor-pdf', [
            'mhs'    => $mahasiswa->load('programStudy'),
            'scores' => $scores,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('nilai-' . $mahasiswa->nrp . '-' . $mahasiswa->name . '.pdf');
    }
}
