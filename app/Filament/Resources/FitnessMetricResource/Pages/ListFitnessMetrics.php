<?php

namespace App\Filament\Resources\FitnessMetricResource\Pages;

use App\Filament\Resources\FitnessMetricResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFitnessMetrics extends ListRecords
{
    protected static string $resource = FitnessMetricResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
