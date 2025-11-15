<?php

namespace App\Filament\Resources\FitnessPostureBmiParamResource\Pages;

use App\Filament\Resources\FitnessPostureBmiParamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFitnessPostureBmiParams extends ListRecords
{
    protected static string $resource = FitnessPostureBmiParamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
