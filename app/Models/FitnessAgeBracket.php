<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FitnessAgeBracket extends Model
{
    //

    protected $fillable = ['rule_set_id', 'gender', 'age_min', 'age_max'];
    public function ruleSet()
    {
        return $this->belongsTo(FitnessRuleSet::class);
    }
    public function thresholds()
    {
        return $this->hasMany(FitnessThreshold::class, 'age_bracket_id');
    }
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
}
