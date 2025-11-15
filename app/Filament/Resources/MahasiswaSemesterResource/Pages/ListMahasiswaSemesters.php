<?php

namespace App\Filament\Resources\MahasiswaSemesterResource\Pages;

use App\Filament\Resources\MahasiswaSemesterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMahasiswaSemesters extends ListRecords
{
    protected static string $resource = MahasiswaSemesterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
