<?php

namespace App\Filament\Resources\FitnessPostureCategoryResource\Pages;

use App\Filament\Resources\FitnessPostureCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFitnessPostureCategory extends CreateRecord
{
    protected static string $resource = FitnessPostureCategoryResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
