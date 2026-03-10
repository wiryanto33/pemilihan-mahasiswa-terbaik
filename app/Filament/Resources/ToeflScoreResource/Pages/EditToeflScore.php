<?php

namespace App\Filament\Resources\ToeflScoreResource\Pages;

use App\Filament\Resources\ToeflScoreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditToeflScore extends EditRecord
{
    protected static string $resource = ToeflScoreResource::class;

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
