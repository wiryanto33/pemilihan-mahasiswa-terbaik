<?php

namespace App\Filament\Resources\FitnessThresholdResource\Pages;

use App\Filament\Resources\FitnessThresholdResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFitnessThreshold extends CreateRecord
{
    protected static string $resource = FitnessThresholdResource::class;
    protected static bool $canCreateAnother = true;
    protected static ?string $title = 'Tambah Nilai Garjas';

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
