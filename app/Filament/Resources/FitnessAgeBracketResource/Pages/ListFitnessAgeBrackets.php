<?php

namespace App\Filament\Resources\FitnessAgeBracketResource\Pages;

use App\Filament\Resources\FitnessAgeBracketResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFitnessAgeBrackets extends ListRecords
{
    protected static string $resource = FitnessAgeBracketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
