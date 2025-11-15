<?php

namespace App\Services;

use App\Models\Mahasiswa;
use App\Models\AcademicScors;
use App\Models\PersonalityAssessment;
use App\Models\PhysicalTest;
use App\Models\MahasiswaSemester;
use Illuminate\Support\Facades\DB;

class SemesterAggregator
{
    /** Hitung & upsert satu mahasiswa + satu semester */
    public static function recompute(int $mahasiswaId, int $semesterId): void
    {
        /** @var Mahasiswa $m */
        $m = Mahasiswa::find($mahasiswaId);
        if (!$m) return;

        // === 1) NILAI AKADEMIK ===
        // IPS: (Σ SKS * IP) / Σ SKS (hanya semester ini)
        // NPA (nilai akademik skala 0-100): rata-rata berbobot final_numeric
        $scores = $m->academicScores()
            ->where('semester_id', $semesterId)
            ->with('matakuliah:id,sks')
            ->get();

        $sksSem  = 0;
        $bobotIpSem = 0.0;
        $bobotNumSem = 0.0;
        foreach ($scores as $s) {
            $n = $s->final_numeric ?? $s->computeFinalNumeric() ?? 0.0; // 0-100
            $ip = $s->toIp(); // 0-4, sudah ada di modelmu
            $sks = (int) ($s->matakuliah?->sks ?? 0);

            $sksSem       += $sks;
            $bobotIpSem   += $sks * $ip;
            $bobotNumSem  += $sks * $n;
        }

        $ips = $sksSem ? round($bobotIpSem / $sksSem, 2) : 0.0;
        $npa = $sksSem ? round($bobotNumSem / $sksSem, 2) : 0.0; // 0-100

        // IPK kumulatif
        $all = $m->academicScores()->with('matakuliah:id,sks')->get();
        $sksAll = 0;
        $bobotIpAll = 0.0;
        foreach ($all as $s) {
            $n  = $s->final_numeric ?? $s->computeFinalNumeric() ?? 0.0;
            $ip = $s->toIp();
            $sks = (int) ($s->matakuliah?->sks ?? 0);
            $sksAll   += $sks;
            $bobotIpAll += $sks * $ip;
        }
        $ipk = $sksAll ? round($bobotIpAll / $sksAll, 2) : 0.0;

        // === 2) NILAI KEPRIBADIAN (NPK) ===
        // Ambil skor 0-100 dari tabel kepribadian untuk semester terkait.
        // Silakan sesuaikan field-nya (contoh: 'total_score')
        $pa = PersonalityAssessment::where('mahasiswa_id', $mahasiswaId)
            ->where('semester_id', $semesterId)
            ->first();

        $npk = $pa?->npk_final ?? $pa?->computeNpk() ?? 0.0;


        // === 3) NILAI JASMANI (NPJ) ===
        // Ambil NAJ (0-100) dari PhysicalTest semester ini
        $npj = PhysicalTest::query()
            ->where('mahasiswa_id', $mahasiswaId)
            ->where('semester_id', $semesterId)
            ->value('naj') ?? 0.0;

        // === 4) NILAI AKHIR (NA) ===
        // Bobot bisa kamu ubah lewat config('scores.weights') atau .env
        $weights = config('scores.weights', [
            'academic'    => 0.7, // NPA (0-100) → 70%
            'personality' => 0.2, // NPK (0-100) → 20%
            'physical'    => 0.1, // NPJ (0-100) → 10%
        ]);
        $na = round(
            ($npa * $weights['academic']) +
                ($npk * $weights['personality']) +
                ($npj * $weights['physical']),
            2
        );

        // === 5) UPSERT KE TABEL mahasiswa_semesters ===
        MahasiswaSemester::updateOrCreate(
            ['mahasiswa_id' => $mahasiswaId, 'semester_id' => $semesterId],
            [
                'ips'           => $ips,
                'ipk'           => $ipk,
                'npa'           => $npa,
                'npk'           => $npk,
                'npj'           => $npj,
                'na'            => $na,
                // 'eligible_next' => ... // biarkan manual / aturanmu sendiri
            ]
        );
    }
}
