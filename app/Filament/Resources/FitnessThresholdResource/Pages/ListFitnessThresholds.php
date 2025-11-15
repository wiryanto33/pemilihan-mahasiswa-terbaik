<?php

namespace App\Filament\Resources\FitnessThresholdResource\Pages;

use App\Filament\Resources\FitnessThresholdResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFitnessThresholds extends ListRecords
{
    protected static string $resource = FitnessThresholdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
