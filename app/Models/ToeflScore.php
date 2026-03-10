<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToeflScore extends Model
{
    //

    protected $fillable = [
        'mahasiswa_id', 
        'score',
        'test_date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
