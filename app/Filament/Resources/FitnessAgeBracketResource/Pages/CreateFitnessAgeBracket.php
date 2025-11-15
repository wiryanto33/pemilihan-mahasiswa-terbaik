<?php

namespace App\Filament\Resources\FitnessAgeBracketResource\Pages;

use App\Filament\Resources\FitnessAgeBracketResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFitnessAgeBracket extends CreateRecord
{
    protected static string $resource = FitnessAgeBracketResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
