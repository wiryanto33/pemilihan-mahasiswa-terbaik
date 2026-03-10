<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('academic.min_toefl_d3', 400);
        $this->migrator->add('academic.min_toefl_s1', 450);
        $this->migrator->add('academic.min_toefl_s2', 500);
    }
};
