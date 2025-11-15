<?php

namespace App\Filament\Resources\FitnessAgeBracketResource\Pages;

use App\Filament\Resources\FitnessAgeBracketResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFitnessAgeBracket extends EditRecord
{
    protected static string $resource = FitnessAgeBracketResource::class;

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
