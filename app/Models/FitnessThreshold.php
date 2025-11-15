<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FitnessThreshold extends Model
{
    //

    // add fillable
    protected $fillable = ['age_bracket_id', 'metric_id', 'min_value', 'max_value', 'score'];
    public function metric()
    {
        return $this->belongsTo(FitnessMetric::class, 'metric_id');
    }
    public function bracket()
    {
        return $this->belongsTo(FitnessAgeBracket::class, 'age_bracket_id');
    }
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
}
