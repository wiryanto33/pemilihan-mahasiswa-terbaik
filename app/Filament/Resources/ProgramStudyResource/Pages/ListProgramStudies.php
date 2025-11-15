<?php

namespace App\Filament\Resources\ProgramStudyResource\Pages;

use App\Filament\Resources\ProgramStudyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProgramStudies extends ListRecords
{
    protected static string $resource = ProgramStudyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
