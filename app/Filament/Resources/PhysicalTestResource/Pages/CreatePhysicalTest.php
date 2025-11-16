<?php

namespace App\Filament\Resources\PhysicalTestResource\Pages;

use App\Filament\Resources\PhysicalTestResource;
use Filament\Resources\Pages\CreateRecord;
use App\Support\Juklak\PhysicalScoring;
use App\Models\Mahasiswa;
use Carbon\Carbon;

class CreatePhysicalTest extends CreateRecord
{
    protected static string $resource = PhysicalTestResource::class;
    protected static bool $canCreateAnother = false;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // =========================
        // 1) Tentukan gender & age
        // =========================
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
                // gunakan umur bulat (tahun penuh) sesuai tabel usia Juklak
                $age = Carbon::parse($mhs->birth_date)->diffInYears($testDate);
            }
        }

        // =========================
        // 2) Postur (NP) - manual
        // =========================
        if (isset($data['posture_score']) && $data['posture_score'] !== null) {
            $data['posture_score'] = (float) $data['posture_score'];
        }

        // =========================
        // 3) Lari 12 menit (NA)
        // =========================
        $na = $data['garjas_a_score'] ?? null;
        if ($na === null && !empty($data['run_12min_meter'])) {
            $na = PhysicalScoring::scoreRun12Min(
                (int) $data['run_12min_meter'],
                $gender,
                $age
            );
        }
        $data['garjas_a_score'] = $na;

        // =========================
        // 4) Baterai B (NRB)
        // =========================
        $shuttle = isset($data['shuttle_run_sec']) ? (float) $data['shuttle_run_sec'] : null;

        if ($gender === 'male') {
            $scores = PhysicalScoring::scoreBatteryBMale(
                isset($data['pull_up']) ? (int) $data['pull_up'] : null,
                isset($data['sit_up']) ? (int) $data['sit_up'] : null,
                isset($data['push_up']) ? (int) $data['push_up'] : null,
                $shuttle,
                $age
            );
        } else {
            $scores = PhysicalScoring::scoreBatteryBFemale(
                isset($data['chinning']) ? (int) $data['chinning'] : null,
                isset($data['modified_sit_up']) ? (int) $data['modified_sit_up'] : null,
                isset($data['modified_push_up']) ? (int) $data['modified_push_up'] : null,
                $shuttle,
                $age
            );
        }

        $data['garjas_b_avg_score'] = !empty(array_filter($scores, fn($v) => $v !== null))
            ? PhysicalScoring::nrbAvg($scores)
            : null;

        // =========================
        // 5) NG = (NA + NRB)/2
        // =========================
        $data['garjas_score'] = PhysicalScoring::ng(
            $data['garjas_a_score'],
            $data['garjas_b_avg_score']
        );

        // =========================
        // 6) Renang 50m (NR)
        // =========================
        $nr = $data['swim_score'] ?? null;
        if ($nr === null && !empty($data['swim_50m_sec'])) {
            $nr = PhysicalScoring::scoreSwim50m(
                (float) $data['swim_50m_sec'],
                $gender,
                $age
            );
        }
        $data['swim_score'] = $nr;

        // =========================
        // 7) NAJ = (NP×2 + NG×5 + NR×3) / 10
        // =========================
        $data['naj'] = PhysicalScoring::naj(
            $data['posture_score'],
            $data['garjas_score'],
            $data['swim_score']
        );

        return $data;
    }
}
