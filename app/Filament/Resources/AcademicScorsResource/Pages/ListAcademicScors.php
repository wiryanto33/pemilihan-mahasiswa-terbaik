<?php

namespace App\Filament\Resources\AcademicScorsResource\Pages;

use App\Filament\Resources\AcademicScorsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAcademicScors extends ListRecords
{
    protected static string $resource = AcademicScorsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    
}
