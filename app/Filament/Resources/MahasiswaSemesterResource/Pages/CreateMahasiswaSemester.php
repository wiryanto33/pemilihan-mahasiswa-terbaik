<?php

namespace App\Filament\Resources\MahasiswaSemesterResource\Pages;

use App\Filament\Resources\MahasiswaSemesterResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMahasiswaSemester extends CreateRecord
{
    protected static string $resource = MahasiswaSemesterResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    // public function getRedirectUrl(): string
    // {
    //     return $this->getResource()::getUrl('index');
    // }
}
