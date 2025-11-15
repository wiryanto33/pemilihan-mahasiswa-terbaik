<?php

namespace App\Filament\Resources\FitnessPostureCategoryResource\Pages;

use App\Filament\Resources\FitnessPostureCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFitnessPostureCategory extends EditRecord
{
    protected static string $resource = FitnessPostureCategoryResource::class;

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
