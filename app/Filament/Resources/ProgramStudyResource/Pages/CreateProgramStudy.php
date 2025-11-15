<?php

namespace App\Filament\Resources\ProgramStudyResource\Pages;

use App\Filament\Resources\ProgramStudyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProgramStudy extends CreateRecord
{
    protected static string $resource = ProgramStudyResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
