<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
use App\Http\Controllers\CetakPengesahanController;

use App\Http\Controllers\AcademicScoreExportController;

Route::middleware(['auth']) // sesuaikan middleware panelmu
    ->prefix('admin')       // sesuaikan prefix panelmu
    ->group(function () {
        Route::get('/exports/academic-scores/{mahasiswa}/excel', [AcademicScoreExportController::class, 'excel'])
            ->name('exports.academic-scores.excel');

        Route::get('/exports/academic-scores/{mahasiswa}/pdf', [AcademicScoreExportController::class, 'pdf'])
            ->name('pdf.academic-scores.pdf');
    });


Route::get(
    '/mahasiswa-semesters/{mahasiswaSemester}/pengesahan.pdf',
    [CetakPengesahanController::class, 'pengesahan']
)->name('ms.pengesahan');
