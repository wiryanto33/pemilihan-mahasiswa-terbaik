<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FitnessRuleSet extends Model
{
    //

    protected $fillable = ['name', 'effective_date', 'is_active'];
    public function brackets()
    {
        return $this->hasMany(FitnessAgeBracket::class, 'rule_set_id');
    }
    public function metrics()
    {
        return $this->hasMany(FitnessMetric::class, 'rule_set_id');
    }

 
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
}
