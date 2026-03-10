<?php

namespace App\Filament\Resources\ToeflScoreResource\Pages;

use App\Filament\Resources\ToeflScoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListToeflScores extends ListRecords
{
    protected static string $resource = ToeflScoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
