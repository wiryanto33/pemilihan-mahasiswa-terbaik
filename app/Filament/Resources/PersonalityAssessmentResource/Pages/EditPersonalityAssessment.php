<?php

namespace App\Filament\Resources\PersonalityAssessmentResource\Pages;

use App\Filament\Resources\PersonalityAssessmentResource;
use Filament\Resources\Pages\EditRecord;

class EditPersonalityAssessment extends EditRecord
{
    protected static string $resource = PersonalityAssessmentResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $dir = isset($data['director_score']) ? (float) $data['director_score'] : null;
        $kor = isset($data['korsis_score'])   ? (float) $data['korsis_score']   : null;
        $kap = isset($data['kaprodi_score'])  ? (float) $data['kaprodi_score']  : null;

        if ($dir !== null && $kor !== null && $kap !== null) {
            $data['npk_final'] = round((0.20 * $dir) + (0.50 * $kor) + (0.30 * $kap), 2);
        } else {
            $data['npk_final'] = null;
        }

        return $data;
    }
}
