<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mahasiswa extends Model
{
    //

    // add fillable
    protected $fillable = [
        'program_study_id',
        'foto',
        'nrp',
        'name',
        'pangkat',
        'korps',
        'angkatan',
        'gender',
        'birth_date',
        'active'
    ];

    public function programStudy(): BelongsTo
    {
        return $this->belongsTo(ProgramStudy::class);
    }
    public function academicScores(): HasMany
    {
        return $this->hasMany(AcademicScors::class);
    }
    public function personalityAssessments(): HasMany
    {
        return $this->hasMany(PersonalityAssessment::class);
    }
    public function physicalTests(): HasMany
    {
        return $this->hasMany(PhysicalTest::class);
    }
    public function mahasiswaSemesters(): HasMany
    {
        return $this->hasMany(MahasiswaSemester::class);
    }
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    // Hitung IPK kumulatif on-the-fly (opsional)
    public function computeIps(int $semesterId): float
    {
        $scores = $this->academicScores()
            ->where('semester_id', $semesterId)
            ->with('matakuliah:id,sks')
            ->get();

        $sksTotal = 0;
        $bobotTotal = 0.0;

        foreach ($scores as $s) {
            $n = $s->final_numeric ?? $s->computeFinalNumeric() ?? 0;
            $ip = \App\Models\AcademicScors::ipOf($n);
            $sks = $s->matakuliah?->sks ?? 0;
            $sksTotal += $sks;
            $bobotTotal += $sks * $ip;
        }

        return $sksTotal ? round($bobotTotal / $sksTotal, 2) : 0.0;
    }

    public function computeIpk(): float
    {
        $scores = $this->academicScores()->with('matakuliah:id,sks')->get();
        $sksTotal = 0;
        $bobotTotal = 0.0;

        foreach ($scores as $s) {
            $n = $s->final_numeric ?? $s->computeFinalNumeric() ?? 0;
            $ip = \App\Models\AcademicScors::ipOf($n);
            $sks = $s->matakuliah?->sks ?? 0;
            $sksTotal += $sks;
            $bobotTotal += $sks * $ip;
        }

        return $sksTotal ? round($bobotTotal / $sksTotal, 2) : 0.0;
    }
}
