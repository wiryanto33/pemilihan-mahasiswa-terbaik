<?php

namespace App\Filament\Resources\FitnessPostureBmiParamResource\Pages;

use App\Filament\Resources\FitnessPostureBmiParamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFitnessPostureBmiParam extends EditRecord
{
    protected static string $resource = FitnessPostureBmiParamResource::class;

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
