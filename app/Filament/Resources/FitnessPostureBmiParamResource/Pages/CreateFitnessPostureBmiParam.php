<?php

namespace App\Filament\Resources\FitnessPostureBmiParamResource\Pages;

use App\Filament\Resources\FitnessPostureBmiParamResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFitnessPostureBmiParam extends CreateRecord
{
    protected static string $resource = FitnessPostureBmiParamResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
