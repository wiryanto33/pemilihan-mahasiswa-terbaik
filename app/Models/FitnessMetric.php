<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FitnessMetric extends Model
{
    //

    // add fillable
    protected $fillable = ['rule_set_id', 'key', 'direction', 'unit'];
    public function ruleSet()
    {
        return $this->belongsTo(FitnessRuleSet::class);
    }
    public function thresholds()
    {
        return $this->hasMany(FitnessThreshold::class, 'metric_id');
    }
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
}
