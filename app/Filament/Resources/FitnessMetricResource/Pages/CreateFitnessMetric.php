<?php

namespace App\Filament\Resources\FitnessMetricResource\Pages;

use App\Filament\Resources\FitnessMetricResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFitnessMetric extends CreateRecord
{
    protected static string $resource = FitnessMetricResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
