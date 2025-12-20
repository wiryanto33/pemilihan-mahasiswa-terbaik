<?php

namespace App\Filament\Resources\PhysicalTestResource\Pages;

use App\Filament\Resources\PhysicalTestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPhysicalTests extends ListRecords
{
    protected static string $resource = PhysicalTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Nilai Samapta'),
        ];
    }
}
