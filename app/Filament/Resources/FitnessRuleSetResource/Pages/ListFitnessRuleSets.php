<?php
// app/Filament/Resources/FitnessRuleSetResource/Pages/ListFitnessRuleSets.php
namespace App\Filament\Resources\FitnessRuleSetResource\Pages;

use App\Filament\Resources\FitnessRuleSetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFitnessRuleSets extends ListRecords
{
    protected static string $resource = FitnessRuleSetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Aturan'),
        ];
    }
}
