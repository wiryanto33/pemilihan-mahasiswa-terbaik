<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhysicalTest extends Model
{
    protected $fillable = [
        'mahasiswa_id',
        'semester_id',
        'height_cm',
        'weight_kg',
        'posture_score',
        'run_12min_meter',
        'garjas_a_score',
        // Pria
        'pull_up',
        'sit_up',
        'push_up',
        // Wanita
        'chinning',
        'modified_sit_up',
        'modified_push_up',
        // Umum
        'shuttle_run_sec',
        'garjas_b_avg_score',
        'garjas_score',
        'swim_50m_sec',
        'swim_score',
        'naj'
    ];

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'height_cm' => 'float',
        'weight_kg' => 'float',
        'posture_score' => 'float',
        'run_12min_meter' => 'integer',
        'garjas_a_score' => 'float',
        'pull_up' => 'integer',
        'sit_up' => 'integer',
        'push_up' => 'integer',
        'chinning' => 'integer',
        'modified_sit_up' => 'integer',
        'modified_push_up' => 'integer',
        'shuttle_run_sec' => 'float',
        'garjas_b_avg_score' => 'float',
        'garjas_score' => 'float',
        'swim_50m_sec' => 'float',
        'swim_score' => 'float',
        'naj' => 'float',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    // Helper method to get gender from mahasiswa
    public function getGenderAttribute(): ?string
    {
        return $this->mahasiswa?->gender;
    }

    // NAJ = (NP*2 + NG*5 + NR*3)/10
    public function computeNaj(): ?float
    {
        if (is_null($this->posture_score) || is_null($this->garjas_score) || is_null($this->swim_score)) {
            return null;
        }
        return round(((2 * $this->posture_score) + (5 * $this->garjas_score) + (3 * $this->swim_score)) / 10, 2);
    }

    protected static function booted(): void
    {
        static::saving(function (self $model) {
            // Auto-compute NAJ before saving
            if ($model->posture_score && $model->garjas_score && $model->swim_score) {
                $model->naj = $model->computeNaj();
            }
        });

        static::saved(function (self $m) {
            \App\Services\SemesterAggregator::recompute($m->mahasiswa_id, $m->semester_id);
        });

        static::deleted(function (self $m) {
            \App\Services\SemesterAggregator::recompute($m->mahasiswa_id, $m->semester_id);
        });
    }
}
