<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonalityAssessment extends Model
{
    //

    // add fillable
    protected $fillable = [
        'mahasiswa_id',
        'semester_id',
        'director_score',
        'korsis_score',
        'kaprodi_score',
        'npk_final'
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    // Bobot: Dan Korsis 50%, Kaprodi 30%, Direktur 20%:contentReference[oaicite:13]{index=13}
    public function computeNpk(): ?float
    {
        if (is_null($this->director_score) || is_null($this->korsis_score) || is_null($this->kaprodi_score)) return null;
        return round((0.20 * $this->director_score) + (0.50 * $this->korsis_score) + (0.30 * $this->kaprodi_score), 2);
    }

    protected static function booted(): void
    {
        static::saved(function (self $m) {
            \App\Services\SemesterAggregator::recompute($m->mahasiswa_id, $m->semester_id);
        });
        static::deleted(function (self $m) {
            \App\Services\SemesterAggregator::recompute($m->mahasiswa_id, $m->semester_id);
        });
    }
}
