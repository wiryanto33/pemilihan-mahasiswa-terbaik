<?php

namespace App\Filament\Resources\FitnessMetricResource\Pages;

use App\Filament\Resources\FitnessMetricResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFitnessMetric extends EditRecord
{
    protected static string $resource = FitnessMetricResource::class;

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
