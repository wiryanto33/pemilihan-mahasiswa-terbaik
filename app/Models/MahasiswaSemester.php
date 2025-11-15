<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MahasiswaSemester extends Model
{
    protected $fillable = [
        'mahasiswa_id',
        'semester_id',
        'ips',
        'ipk',
        'npa',  // Nilai Prestasi Akademik (0–100)
        'npk',  // Kepribadian (0–100)
        'npj',  // Jasmani (0–100) — bisa = NAJ
        'na',   // Nilai Akhir Peringkat (0–100)
        'eligible_next',
    ];

    // (Opsional) casting biar enak dihitung
    protected $casts = [
        'ips' => 'float',
        'ipk' => 'float',
        'npa' => 'float',
        'npk' => 'float',
        'npj' => 'float',
        'na'  => 'float',
        'eligible_next' => 'boolean',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    /**
     * Konversi IP (0–4) ke NPA (0–100).
     * Konvensi: NPA = IP * 25
     */
    public static function ipToNpa(?float $ip): ?float
    {
        if ($ip === null) return null;
        return round($ip * 25, 2);
    }

    /**
     * Hitung Nilai Akhir (NA) untuk peringkat:
     * NA = (7 * NPA + 2 * NPK + 1 * NPJ) / 10
     */
    public static function computeNa(?float $npa, ?float $npk, ?float $npj): ?float
    {
        if ($npa === null || $npk === null || $npj === null) return null;
        return round((7 * $npa + 2 * $npk + 1 * $npj) / 10, 2);
    }

    /**
     * Kelayakan lanjut semester/seleksi berikutnya.
     * Aturan contoh (silakan sesuaikan Juklak kampus Anda):
     *  - IPK minimal 2.50
     *  - Nilai jasmani (NPJ/NAJ) minimal 61 (ambang lulus jasmani)
     */
    public function computeEligibility(): bool
    {
        $ipk = (float) ($this->ipk ?? 0);
        $npj = (float) ($this->npj ?? 0);
        return $ipk >= 2.50 && $npj >= 61.0;
    }
}
