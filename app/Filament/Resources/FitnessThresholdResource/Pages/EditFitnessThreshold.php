<?php

namespace App\Filament\Resources\FitnessThresholdResource\Pages;

use App\Filament\Resources\FitnessThresholdResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFitnessThreshold extends EditRecord
{
    protected static string $resource = FitnessThresholdResource::class;

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
