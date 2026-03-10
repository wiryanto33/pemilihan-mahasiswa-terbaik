<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AcademicSetting extends Settings
{
    public int $min_toefl_d3;
    public int $min_toefl_s1;
    public int $min_toefl_s2;

    public static function group(): string
    {
        return 'academic';
    }
}
