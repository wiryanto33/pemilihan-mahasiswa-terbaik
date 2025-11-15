<?php

namespace App\Filament\Resources\AcademicScorsResource\Pages;

use App\Filament\Resources\AcademicScorsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAcademicScors extends CreateRecord
{
    protected static string $resource = AcademicScorsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Guardrail server-side (ikut juklak)
        $nu  = isset($data['nu'])  && $data['nu']  !== '' ? (float) $data['nu']  : null;
        $uts = isset($data['uts']) && $data['uts'] !== '' ? (float) $data['uts'] : null;
        $uas = isset($data['uas']) && $data['uas'] !== '' ? (float) $data['uas'] : null;

        if ($uts !== null && $uas !== null) {
            $final = $nu !== null
                ? round((2 * $nu + 3 * $uts + 5 * $uas) / 10, 2)
                : round((4 * $uts + 6 * $uas) / 10, 2);

            $data['final_numeric'] = $final;
            $data['final_letter']  = match (true) {
                $final >= 85 => 'A',
                $final >= 80 => 'B+',
                $final >= 70 => 'B',
                $final >= 65 => 'C+',
                $final >= 55 => 'C',
                $final >= 40 => 'D',
                default      => 'E',
            };
        } else {
            $data['final_numeric'] = null;
            $data['final_letter']  = null;
        }

        return $data;
    }
}
