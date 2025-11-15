<?php

namespace App\Filament\Resources\MahasiswaSemesterResource\Pages;

use App\Filament\Resources\MahasiswaSemesterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMahasiswaSemester extends EditRecord
{
    protected static string $resource = MahasiswaSemesterResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
