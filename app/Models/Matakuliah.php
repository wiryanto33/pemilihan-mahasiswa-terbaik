<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matakuliah extends Model
{
    //

    // add fillable
    protected $fillable = ['program_study_id', 'code', 'name', 'sks'];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function programStudy(): BelongsTo
    {
        return $this->belongsTo(ProgramStudy::class);
    }
    public function academicScores(): HasMany
    {
        return $this->hasMany(AcademicScors::class);
    }
}
