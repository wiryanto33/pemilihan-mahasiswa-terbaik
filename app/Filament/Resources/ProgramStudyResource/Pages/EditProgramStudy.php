<?php

namespace App\Filament\Resources\ProgramStudyResource\Pages;

use App\Filament\Resources\ProgramStudyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProgramStudy extends EditRecord
{
    protected static string $resource = ProgramStudyResource::class;

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
