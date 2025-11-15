<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\{
    FitnessRuleSet,
    FitnessAgeBracket,
    FitnessMetric,
    FitnessThreshold,
    FitnessPostureBmiParam,
    FitnessPostureCategory
};

class FitnessRuleSeedFromConfigSeeder extends Seeder
{
    public function run(): void
    {
        $cfg = config('juklak_fitness'); // file: config/juklak_fitness.php
        $rule = FitnessRuleSet::firstOrCreate([
            'name' => 'Juklak 2020 baseline',
        ], [
            'effective_date' => '2020-07-30',
            'is_active' => true,
        ]);

        // helper metric maker
        $metric = fn($key, $direction, $unit = null) =>
        FitnessMetric::firstOrCreate(
            ['rule_set_id' => $rule->id, 'key' => $key],
            ['direction' => $direction, 'unit' => $unit]
        );

        $mRun   = $metric('run_12min', 'min', 'meter');
        $mPull  = $metric('pull_up', 'min', 'rep');
        $mSit   = $metric('sit_up', 'min', 'rep');
        $mPush  = $metric('push_up', 'min', 'rep');
        $mChin  = $metric('chinning', 'min', 'rep');
        $mMSit  = $metric('modified_sit_up', 'min', 'rep');
        $mMPush = $metric('modified_push_up', 'min', 'rep');
        $mShut  = $metric('shuttle_run', 'max', 'sec');
        $mSwim  = $metric('swim_50m', 'max', 'sec');
        $metric('posture_bmi_delta', null, 'bmi'); // untuk info saja
        $metric('posture_category',  null, null);

        // --- Run 12min
        foreach (['male', 'female'] as $g) {
            foreach (($cfg['run_12min'][$g] ?? []) as $block) {
                $br = FitnessAgeBracket::firstOrCreate([
                    'rule_set_id' => $rule->id,
                    'gender' => $g,
                    'age_min' => $block['age_min'],
                    'age_max' => $block['age_max'],
                ]);
                foreach ($block['table'] as $row) {
                    FitnessThreshold::create([
                        'age_bracket_id' => $br->id,
                        'metric_id' => $mRun->id,
                        'min_value' => $row['min_m'], // direction=min: value >= min_value
                        'max_value' => null,
                        'score' => $row['score'],
                    ]);
                }
            }
        }

        // --- Battery B
        foreach (['male', 'female'] as $g) {
            foreach (($cfg['battery_b'][$g] ?? []) as $block) {
                $br = FitnessAgeBracket::firstOrCreate([
                    'rule_set_id' => $rule->id,
                    'gender' => $g,
                    'age_min' => $block['age_min'],
                    'age_max' => $block['age_max'],
                ]);

                $items = $block['items'];
                $map = [
                    'pull_up' => $mPull->id,
                    'sit_up' => $mSit->id,
                    'push_up' => $mPush->id,
                    'chinning' => $mChin->id,
                    'modified_sit_up' => $mMSit->id,
                    'modified_push_up' => $mMPush->id,
                    'shuttle_run' => $mShut->id,
                ];
                foreach ($items as $key => $rows) {
                    $metricId = $map[$key] ?? null;
                    if (!$metricId) continue;
                    foreach ($rows as $row) {
                        $isTime = ($key === 'shuttle_run');
                        FitnessThreshold::create([
                            'age_bracket_id' => $br->id,
                            'metric_id' => $metricId,
                            'min_value' => $isTime ? null : $row['min_rep'],
                            'max_value' => $isTime ? $row['max_sec'] : null,
                            'score' => $row['score'],
                        ]);
                    }
                }
            }
        }

        // --- Swim 50m
        foreach (['male', 'female'] as $g) {
            foreach (($cfg['swim_50m'][$g] ?? []) as $block) {
                $br = FitnessAgeBracket::firstOrCreate([
                    'rule_set_id' => $rule->id,
                    'gender' => $g,
                    'age_min' => $block['age_min'],
                    'age_max' => $block['age_max'],
                ]);
                foreach ($block['table'] as $row) {
                    FitnessThreshold::create([
                        'age_bracket_id' => $br->id,
                        'metric_id' => $mSwim->id,
                        'min_value' => null,
                        'max_value' => $row['max_sec'],
                        'score' => $row['score'],
                    ]);
                }
            }
        }
    }
}
