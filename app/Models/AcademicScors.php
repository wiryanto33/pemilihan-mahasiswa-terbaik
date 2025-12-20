<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicScors extends Model
{
    // protected static ?string $label = 'Nilai Akademik';

    // protected static ?string $pluralLabel = 'Nilai Akademik';

    protected $fillable = [
        'mahasiswa_id',
        'matakuliah_id',
        'semester_id',
        'nu',
        'uts',
        'uas',
        'final_numeric',
        'final_letter',
    ];

    protected $casts = [
        'nu'            => 'float',
        'uts'           => 'float',
        'uas'           => 'float',
        'final_numeric' => 'float',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function matakuliah(): BelongsTo
    {
        return $this->belongsTo(Matakuliah::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    protected static function booted(): void
    {
        // Isi otomatis final_numeric & final_letter bila kosong
        static::saving(function (self $m) {
            if ($m->final_numeric === null) {
                $m->final_numeric = $m->computeFinalNumeric();
            }
            if (!$m->final_letter) {
                $m->final_letter = $m->toLetter($m->final_numeric);
            }
        });

        // Recompute agregat semester setiap ada perubahan/hapus
        static::saved(function (self $model) {
            \App\Services\SemesterAggregator::recompute($model->mahasiswa_id, $model->semester_id);
        });
        static::deleted(function (self $model) {
            \App\Services\SemesterAggregator::recompute($model->mahasiswa_id, $model->semester_id);
        });
    }

    /**
     * Hitung nilai akhir numerik (0–100) dari NU/UTS/UAS.
     * Rumus default: (2*NU + 3*UTS + 5*UAS) / 10.
     * Jika NU null, pakai (4*UTS + 6*UAS) / 10.
     */
    public function computeFinalNumeric(): ?float
    {
        $nu  = $this->nu;
        $uts = $this->uts;
        $uas = $this->uas;

        if ($uts === null || $uas === null) {
            return null;
        }

        if ($nu !== null) {
            return round((2 * $nu + 3 * $uts + 5 * $uas) / 10, 2);
        }

        return round((4 * $uts + 6 * $uas) / 10, 2);
    }

    /**
     * Konversi nilai numerik (0–100) ke huruf.
     */
    public function toLetter(?float $n = null): ?string
    {
        $n = $n ?? $this->final_numeric ?? $this->computeFinalNumeric();
        if ($n === null) return null;

        return match (true) {
            $n >= 85 => 'A',
            $n >= 80 => 'B+',
            $n >= 70 => 'B',
            $n >= 65 => 'C+',
            $n >= 55 => 'C',
            $n >= 40 => 'D',
            default  => 'E',
        };
    }

    /**
     * Konversi ke bobot IP (0–4) untuk perhitungan IPS/IPK.
     * Prioritas pakai huruf; fallback dari numerik (n/25).
     */
    public function toIp(?string $letter = null, ?float $numeric = null): ?float
    {
        $letter  = $letter  ?? $this->final_letter ?? $this->toLetter();
        $numeric = $numeric ?? $this->final_numeric ?? $this->computeFinalNumeric();

        if ($letter) {
            $map = [
                'A'  => 4.0,
                'B+' => 3.5,
                'B'  => 3.0,
                'C+' => 2.5,
                'C'  => 2.0,
                'D'  => 1.0,
                'E'  => 0.0,
            ];
            return $map[$letter] ?? null;
        }

        return $numeric !== null ? round($numeric / 25, 2) : null;
    }

    public static function ipOf(string|float|int|null $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Jika string huruf nilai
        if (is_string($value)) {
            $letter = strtoupper(trim($value));
            $map = [
                'A'  => 4.0,
                'B+' => 3.5,
                'B'  => 3.0,
                'C+' => 2.5,
                'C'  => 2.0,
                'D'  => 1.0,
                'E'  => 0.0,
            ];
            return $map[$letter] ?? null;
        }

        // Jika numerik 0–100 → 0–4
        $n = (float) $value;
        return round($n / 25, 2);
    }
}
