<?php

namespace Database\Seeders;

use App\Models\{AcademicScors, Matakuliah, PersonalityAssessment, PhysicalTest, Semester, Mahasiswa, MahasiswaSemester};
use Illuminate\Database\Seeder;

class ScoreSeeder extends Seeder
{
    public function run(): void
    {
        $sem   = Semester::where('code', '2023-Ganjil')->first();
        $mk    = Matakuliah::whereIn('code', ['IF101', 'IF102', 'IF103', 'IF104'])->get()->keyBy('code');
        $mhs   = Mahasiswa::whereIn('nrp', ['NRP001', 'NRP002', 'NRP003'])->get()->keyBy('nrp');

        // === Nilai Akademik (NU/UTS/UAS) ===
        $setAkademik = [
            'NRP001' => [
                ['code' => 'IF101', 'nu' => 78, 'uts' => 82, 'uas' => 88],
                ['code' => 'IF102', 'nu' => 80, 'uts' => 81, 'uas' => 85],
                ['code' => 'IF103', 'nu' => 70, 'uts' => 75, 'uas' => 80],
                ['code' => 'IF104', 'nu' => 76, 'uts' => 80, 'uas' => 84],
            ],
            'NRP002' => [
                ['code' => 'IF101', 'nu' => 85, 'uts' => 88, 'uas' => 90],
                ['code' => 'IF102', 'nu' => 84, 'uts' => 86, 'uas' => 89],
                ['code' => 'IF103', 'nu' => 78, 'uts' => 80, 'uas' => 82],
                ['code' => 'IF104', 'nu' => 82, 'uts' => 84, 'uas' => 87],
            ],
            'NRP003' => [
                ['code' => 'IF101', 'nu' => 70, 'uts' => 72, 'uas' => 74],
                ['code' => 'IF102', 'nu' => 68, 'uts' => 70, 'uas' => 72],
                ['code' => 'IF103', 'nu' => 65, 'uts' => 66, 'uas' => 70],
                ['code' => 'IF104', 'nu' => 60, 'uts' => 65, 'uas' => 69],
            ],
        ];

        foreach ($setAkademik as $nrp => $rows) {
            foreach ($rows as $r) {
                $score = AcademicScors::updateOrCreate([
                    'mahasiswa_id'  => $mhs[$nrp]->id,
                    'matakuliah_id'   => $mk[$r['code']]->id,
                    'semester_id' => $sem->id,
                ], [
                    'nu' => $r['nu'],
                    'uts' => $r['uts'],
                    'uas' => $r['uas'],
                ]);
                $score->final_numeric = $score->computeFinalNumeric();
                $score->final_letter  = $score->toLetter();
                $score->save();
            }
        }

        // === Kepribadian (Direktur 20%, Korsis 50%, Kaprodi 30%) ===
        $setNPK = [
            'NRP001' => ['director' => 78, 'korsis' => 82, 'kaprodi' => 80],
            'NRP002' => ['director' => 88, 'korsis' => 90, 'kaprodi' => 86],
            'NRP003' => ['director' => 72, 'korsis' => 74, 'kaprodi' => 70],
        ];
        foreach ($setNPK as $nrp => $r) {
            $p = PersonalityAssessment::updateOrCreate([
                'mahasiswa_id'  => $mhs[$nrp]->id,
                'semester_id' => $sem->id,
            ], [
                'director_score' => $r['director'],
                'korsis_score'   => $r['korsis'],
                'kaprodi_score'  => $r['kaprodi'],
            ]);
            $p->npk_final = $p->computeNpk();
            $p->save();
        }

        // === Jasmani (postur, garjas, renang, NAJ) ===
        $setJasmani = [
            'NRP001' => ['postur' => 80, 'ng' => 78, 'renang' => 82],
            'NRP002' => ['postur' => 86, 'ng' => 88, 'renang' => 90],
            'NRP003' => ['postur' => 65, 'ng' => 62, 'renang' => 60],
        ];
        foreach ($setJasmani as $nrp => $r) {
            $pt = PhysicalTest::updateOrCreate([
                'mahasiswa_id'  => $mhs[$nrp]->id,
                'semester_id' => $sem->id,
            ], [
                'posture_score' => $r['postur'],
                'garjas_score'  => $r['ng'],     // N.G
                'swim_score'    => $r['renang'], // N.R
            ]);
            $pt->naj = $pt->computeNaj(); // NP*2 + NG*5 + NR*3 / 10
            $pt->save();
        }

        // Rekap per mahasiswa (IPS, IPK, NPA, NPK, NPJ, NA)
        foreach ($mhs as $s) {
            // IPS/IPK
            $scores = $s->academicScores()->where('semester_id', $sem->id)->with('matakuliah')->get();
            $sksTot = 0;
            $bobotTot = 0;
            foreach ($scores as $sc) {
                $sksTot += $sc->matakuliah->sks;
                $bobotTot += $sc->matakuliah->sks * $sc->toIp();
            }
            $ips = $sksTot ? round($bobotTot / $sksTot, 2) : 0.0;

            $ipk = $s->computeIpk(); // kumulatif semua semester

            // NPA = IP (0–4) x 25 -> pakai IPK biar konsisten peringkat
            $npa = \App\Models\MahasiswaSemester::ipToNpa($ipk);

            $npk = optional($s->personalityAssessments()->where('semester_id', $sem->id)->first())->npk_final ?? 0;
            $npj = optional($s->physicalTests()->where('semester_id', $sem->id)->first())->naj ?? 0; // pakai NAJ

            $na  = \App\Models\MahasiswaSemester::computeNa($npa, $npk, $npj);

            $rec = MahasiswaSemester::updateOrCreate([
                'mahasiswa_id'  => $s->id,
                'semester_id' => $sem->id,
            ], [
                'ips' => $ips,
                'ipk' => $ipk,
                'npa' => $npa,
                'npk' => $npk,
                'npj' => $npj,
                'na'  => $na,
            ]);
            $rec->eligible_next = $rec->computeEligibility();
            $rec->save();
        }
    }
}
