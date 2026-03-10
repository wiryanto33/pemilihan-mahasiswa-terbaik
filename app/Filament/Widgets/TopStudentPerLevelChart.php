<?php

namespace App\Filament\Widgets;

use App\Models\MahasiswaSemester;
use App\Models\ProgramStudy;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TopStudentPerLevelChart extends ChartWidget
{
    protected static ?string $heading = 'Mahasiswa Terbaik per Prodi & Level';
    
    // Default column span full so it's wide
    protected int | string | array $columnSpan = 'full';

    // The sort setting: widget order
    protected static ?int $sort = 2; // e.g. put it after TopStudentPerProdiAngkatan

    protected function getData(): array
    {
        $levels = ['D3', 'S1', 'S2'];
        
        // Setup colors for each level
        $colors = [
            'D3' => 'rgba(54, 162, 235, 0.5)',
            'S1' => 'rgba(75, 192, 192, 0.5)',
            'S2' => 'rgba(153, 102, 255, 0.5)',
        ];
        $borderColors = [
            'D3' => 'rgb(54, 162, 235)',
            'S1' => 'rgb(75, 192, 192)',
            'S2' => 'rgb(153, 102, 255)',
        ];

        // Fetch prodis ordered by level and code so they group nicely
        $prodis = ProgramStudy::orderBy('level')->orderBy('code')->get();
        $settings = app(\App\Settings\AcademicSetting::class);
        
        $labels = [];
        $d3Data = [];
        $s1Data = [];
        $s2Data = [];

        foreach ($prodis as $prodi) {
            $minScore = 0;
            if ($prodi->level === 'D3') {
                $minScore = $settings->min_toefl_d3;
            } elseif ($prodi->level === 'S1') {
                $minScore = $settings->min_toefl_s1;
            } elseif ($prodi->level === 'S2') {
                $minScore = $settings->min_toefl_s2;
            }

            // Find the best NA score for this prodi from MahasiswaSemester
            $topRecord = MahasiswaSemester::whereHas('mahasiswa', function ($q) use ($prodi, $minScore) {
                    $q->where('program_study_id', $prodi->id)
                      ->whereHas('toeflScores', function ($q2) use ($minScore) {
                          $q2->where('score', '>=', $minScore);
                      });
                })
                ->with('mahasiswa')
                ->orderByDesc('na')
                ->orderByDesc('updated_at')
                ->first();

            if ($topRecord && $topRecord->na > 0) {
                // e.g. D3-TI (Citra)
                $firstName = strtok($topRecord->mahasiswa->name, ' ');
                $label = $prodi->code . " (" . $firstName . ")";
                $na = $topRecord->na;
            } else {
                $label = $prodi->code . " (Belum ada)";
                $na = 0;
            }
            
            $labels[] = $label;

            // Map the score to the respective array based on the prodi's level
            if ($prodi->level === 'D3') {
                $d3Data[] = $na;
                $s1Data[] = 0;
                $s2Data[] = 0;
            } elseif ($prodi->level === 'S1') {
                $d3Data[] = 0;
                $s1Data[] = $na;
                $s2Data[] = 0;
            } elseif ($prodi->level === 'S2') {
                $d3Data[] = 0;
                $s1Data[] = 0;
                $s2Data[] = $na;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Level D3',
                    'data' => $d3Data,
                    'backgroundColor' => $colors['D3'],
                    'borderColor' => $borderColors['D3'],
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Level S1',
                    'data' => $s1Data,
                    'backgroundColor' => $colors['S1'],
                    'borderColor' => $borderColors['S1'],
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Level S2',
                    'data' => $s2Data,
                    'backgroundColor' => $colors['S2'],
                    'borderColor' => $borderColors['S2'],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
    
    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'x',
            'scales' => [
                'x' => [
                    'stacked' => true,
                ],
                'y' => [
                    'stacked' => true,
                    'beginAtZero' => true,
                    'max' => 100,
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
        ];
    }
}
