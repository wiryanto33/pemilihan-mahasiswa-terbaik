<?php

namespace App\Filament\Resources\PhysicalTestResource\Pages;

use App\Filament\Resources\PhysicalTestResource;
use Filament\Resources\Pages\EditRecord;
use App\Support\Juklak\PhysicalScoring;
use App\Models\Mahasiswa;
use Carbon\Carbon;

class EditPhysicalTest extends EditRecord
{
    protected static string $resource = PhysicalTestResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // 1) Gender & umur
        $gender = 'male';
        $age    = 22;

        $testDate = !empty($data['test_date'])
            ? Carbon::parse($data['test_date'])
            : now();

        if (!empty($data['mahasiswa_id'])) {
            $mhs = Mahasiswa::find($data['mahasiswa_id']);

            if ($mhs?->gender) {
                $gender = $mhs->gender === 'Pria' ? 'male' : 'female';
            }
            if ($mhs?->birth_date) {
                $age = Carbon::parse($mhs->birth_date)->diffInYears($testDate);
            }
        }

        // 2) Postur (NP) - manual
        if (isset($data['posture_score']) && $data['posture_score'] !== null) {
            $data['posture_score'] = (float) $data['posture_score'];
        }

        // 3) Lari 12 menit (NA)
        $na = null;
        if (!empty($data['run_12min_meter'])) {
            $na = PhysicalScoring::scoreRun12Min(
                (int) $data['run_12min_meter'],
                $gender,
                $age
            );
        } elseif (!empty($data['garjas_a_score'])) {
            $na = (float) $data['garjas_a_score'];
        }
        $data['garjas_a_score'] = $na;

        // 4) Baterai B (NRB)
        $shuttle = $data['shuttle_run_sec'] ?? null;

        if ($gender === 'male') {
            $scores = PhysicalScoring::scoreBatteryBMale(
                $data['pull_up'] ?? null,
                $data['sit_up'] ?? null,
                $data['push_up'] ?? null,
                $shuttle ? (float) $shuttle : null,
                $age
            );
        } else {
            $scores = PhysicalScoring::scoreBatteryBFemale(
                $data['chinning'] ?? null,
                $data['modified_sit_up'] ?? null,
                $data['modified_push_up'] ?? null,
                $shuttle ? (float) $shuttle : null,
                $age
            );
        }

        $data['garjas_b_avg_score'] = !empty(array_filter($scores, fn($v) => $v !== null))
            ? PhysicalScoring::nrbAvg($scores)
            : null;

        // 5) NG
        $data['garjas_score'] = PhysicalScoring::ng(
            $data['garjas_a_score'],
            $data['garjas_b_avg_score']
        );

        // 6) Renang (NR)
        $nr = null;
        if (!empty($data['swim_50m_sec'])) {
            $nr = PhysicalScoring::scoreSwim50m(
                (float) $data['swim_50m_sec'],
                $gender,
                $age
            );
        } elseif (!empty($data['swim_score'])) {
            $nr = (float) $data['swim_score'];
        }
        $data['swim_score'] = $nr;

        // 7) NAJ
        $data['naj'] = PhysicalScoring::naj(
            $data['posture_score'],
            $data['garjas_score'],
            $data['swim_score']
        );

        return $data;
    }
}
