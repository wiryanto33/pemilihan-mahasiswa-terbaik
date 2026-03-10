<?php

namespace App\Filament\Resources\ToeflScoreResource\Pages;

use App\Filament\Resources\ToeflScoreResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateToeflScore extends CreateRecord
{
    protected static string $resource = ToeflScoreResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
