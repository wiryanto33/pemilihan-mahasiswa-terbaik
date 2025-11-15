<?php

namespace App\Filament\Widgets;

use App\Models\PhysicalTest;
use App\Models\Mahasiswa;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PhysicalTestStats extends BaseWidget
{
    protected ?string $heading = 'Ringkasan Tes Jasmani';
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totalPeserta = PhysicalTest::count();
        $avgNaj = round(PhysicalTest::avg('naj'), 2);
        $avgMale = round(PhysicalTest::whereHas('mahasiswa', fn($q) => $q->where('gender', 'Pria'))->avg('naj'), 2);
        $avgFemale = round(PhysicalTest::whereHas('mahasiswa', fn($q) => $q->where('gender', 'Wanita'))->avg('naj'), 2);

        return [
            Stat::make('Total Peserta Tes', $totalPeserta)
                ->description('Mahasiswa yang sudah mengikuti tes jasmani')
                ->icon('heroicon-o-user-group'),

            Stat::make('Rata-rata NAJ', $avgNaj)
                ->description('Nilai Akhir Jasmani semua mahasiswa')
                ->icon('heroicon-o-chart-bar'),

            Stat::make('Rata-rata Pria', $avgMale)
                ->description('Rata-rata NAJ untuk mahasiswa pria')
                ->icon('heroicon-o-academic-cap')
                ->color('info'),

            Stat::make('Rata-rata Wanita', $avgFemale)
                ->description('Rata-rata NAJ untuk mahasiswa wanita')
                ->icon('heroicon-o-academic-cap')
                ->color('warning'),
        ];
    }
}
