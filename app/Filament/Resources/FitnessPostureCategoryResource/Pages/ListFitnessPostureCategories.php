<?php

namespace App\Filament\Resources\FitnessPostureCategoryResource\Pages;

use App\Filament\Resources\FitnessPostureCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFitnessPostureCategories extends ListRecords
{
    protected static string $resource = FitnessPostureCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
