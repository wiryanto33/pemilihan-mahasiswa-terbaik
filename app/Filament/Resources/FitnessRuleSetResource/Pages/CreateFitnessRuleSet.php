<?php
// app/Filament/Resources/FitnessRuleSetResource/Pages/CreateFitnessRuleSet.php
namespace App\Filament\Resources\FitnessRuleSetResource\Pages;

use App\Filament\Resources\FitnessRuleSetResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFitnessRuleSet extends CreateRecord
{
    protected static string $resource = FitnessRuleSetResource::class;
    protected static ?string $title = 'Buat Aturan Garjas';
}
