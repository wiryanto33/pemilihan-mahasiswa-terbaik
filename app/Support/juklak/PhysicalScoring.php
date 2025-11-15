<?php

namespace App\Support\Juklak;

use App\Models\{
    FitnessRuleSet,
    FitnessAgeBracket,
    FitnessMetric,
    FitnessThreshold,
    FitnessPostureBmiParam,
    FitnessPostureCategory
};

class PhysicalScoring
{
    /* ====================== Util Umum ====================== */

    protected static function activeRule(): ?FitnessRuleSet
    {
        return FitnessRuleSet::where('is_active', true)
            ->orderByDesc('effective_date')->first();
    }

    protected static function pickBracketDb(string $gender, int $age): ?FitnessAgeBracket
    {
        $rule = self::activeRule();
        if (!$rule) return null;
        return FitnessAgeBracket::where('rule_set_id', $rule->id)
            ->where('gender', $gender)
            ->where('age_min', '<=', $age)
            ->where('age_max', '>=', $age)
            ->first();
    }

    protected static function metric(string $key): ?FitnessMetric
    {
        $rule = self::activeRule();
        if (!$rule) return null;
        return FitnessMetric::where('rule_set_id', $rule->id)->where('key', $key)->first();
    }

    protected static function scoreByThresholdDb(?float $val, string $metricKey, string $gender, int $age): ?float
    {
        if ($val === null) return null;

        $br = self::pickBracketDb($gender, $age);
        $m  = self::metric($metricKey);
        if (!$br || !$m) return null;

        if ($m->direction === null) return null;

        $q = FitnessThreshold::where('age_bracket_id', $br->id)
            ->where('metric_id', $m->id);

        if ($m->direction === 'min') {
            $row = $q->whereNotNull('min_value')->where('min_value', '<=', $val)
                ->orderByDesc('min_value')->first();
            return $row ? (float)$row->score : null;
        }

        if ($m->direction === 'max') {
            $row = $q->whereNotNull('max_value')->where('max_value', '>=', $val)
                ->orderBy('max_value')->first();
            return $row ? (float)$row->score : null;
        }

        return null;
    }


    /* ====================== Postur ====================== */

    public static function bmi(float $heightCm, float $weightKg): float
    {
        $m = $heightCm / 100.0;
        return $weightKg / max($m * $m, 0.000001);
    }

    public static function scorePosture(?float $heightCm, ?float $weightKg): ?float
    {
        if (!$heightCm || !$weightKg) return null;

        // DB first
        if ($rule = self::activeRule()) {
            if ($param = $rule->postureBmi) {
                $bmi   = self::bmi($heightCm, $weightKg);
                $delta = abs($bmi - (float)$param->ideal);
                $score = (float)$param->base_score - ($delta * (float)$param->scale_per_point);
                $score = max((float)$param->min_score, min((float)$param->max_score, round($score, 2)));
                return $score;
            }
            // jika pakai kategori
            if ($rule->postureCategories()->exists()) {
                $bmi = self::bmi($heightCm, $weightKg);
                $cat = self::bmiCategoryToJuklak($bmi); // mapping sama seperti sebelumnya
                $row = $rule->postureCategories()->where('category_key', $cat)->first();
                if ($row) return (float)$row->score;
            }
        }

        // fallback config
        return self::scorePosture_config($heightCm, $weightKg);
    }

    protected static function bmiCategoryToJuklak(float $bmi): string
    {
        // Placeholder mapping, silakan selaraskan ke Juklak kalau ada
        if ($bmi >= 21 && $bmi <= 23) return 'ideal';
        if ($bmi > 23 && $bmi <= 25)  return 'harmonis_atas';
        if ($bmi >= 19 && $bmi < 21)  return 'harmonis_bawah';
        if ($bmi > 25 && $bmi <= 27)  return 'normal_atas';
        if ($bmi >= 17 && $bmi < 19)  return 'normal_bawah';
        if ($bmi > 27 && $bmi <= 29)  return 'limit_atas';
        if ($bmi >= 15 && $bmi < 17)  return 'limit_bawah';
        if ($bmi > 29)                return 'luar_limit_atas';
        return 'luar_limit_bawah';
    }

    /* ====================== Lari 12 Menit (Baterai A) ====================== */

    public static function scoreRun12Min(?int $meters, string $gender, int $age): ?float
    {
        $score = self::scoreByThresholdDb($meters, 'run_12min', $gender, $age);
        if ($score !== null) return (float)$score;

        // fallback ke config lama
        return self::scoreRun12Min_config($meters, $gender, $age);
    }

    /* ====================== Baterai B (usia-aware) ====================== */

    public static function scoreBatteryBMale(?int $pullUp, ?int $sitUp, ?int $pushUp, ?float $shuttle, int $age): array
    {
        $g = 'male';
        $out = [
            'pull_up' => self::scoreByThresholdDb($pullUp, 'pull_up', $g, $age),
            'sit_up'  => self::scoreByThresholdDb($sitUp,  'sit_up',  $g, $age),
            'push_up' => self::scoreByThresholdDb($pushUp, 'push_up', $g, $age),
            'shuttle_run' => self::scoreByThresholdDb($shuttle, 'shuttle_run', $g, $age),
        ];
        // fallback jika semua null (data DB kosong)
        if (!array_filter($out, fn($v) => $v !== null)) {
            return self::scoreBatteryBMale_config($pullUp, $sitUp, $pushUp, $shuttle, $age);
        }
        return $out;
    }

    public static function scoreBatteryBFemale(?int $chinning, ?int $modSitUp, ?int $modPushUp, ?float $shuttle, int $age): array
    {
        $g = 'female';
        $out = [
            'chinning' => self::scoreByThresholdDb($chinning, 'chinning', $g, $age),
            'modified_sit_up' => self::scoreByThresholdDb($modSitUp, 'modified_sit_up', $g, $age),
            'modified_push_up' => self::scoreByThresholdDb($modPushUp, 'modified_push_up', $g, $age),
            'shuttle_run' => self::scoreByThresholdDb($shuttle, 'shuttle_run', $g, $age),
        ];
        if (!array_filter($out, fn($v) => $v !== null)) {
            return self::scoreBatteryBFemale_config($chinning, $modSitUp, $modPushUp, $shuttle, $age);
        }
        return $out;
    }

    protected static function scoreBatteryBGeneric(string $gender, array $raws, int $age): array
    {
        $blocks = self::cfg("battery_b.$gender");
        if (!$blocks) return array_fill_keys(array_keys($raws), null);

        $br = self::pickBracket($blocks, $age);
        if (!$br) return array_fill_keys(array_keys($raws), null);

        $items = $br['items'] ?? [];
        $out = [];
        foreach ($raws as $key => $val) {
            if ($val === null) {
                $out[$key] = null;
                continue;
            }

            // Pilih metode threshold sesuai item
            if ($key === 'shuttle_run') {
                $out[$key] = self::scoreByMaxThreshold($val, $items[$key] ?? [], 'max_sec');
            } else {
                $out[$key] = self::scoreByMinThreshold($val, $items[$key] ?? [], 'min_rep');
            }
        }
        return $out;
    }

    public static function nrbAvg(array $scores): ?float
    {
        $vals = array_values(array_filter($scores, fn($v) => $v !== null));
        if (count($vals) === 0) return null;
        return round(array_sum($vals) / count($vals), 2);
    }

    public static function ng(?float $na, ?float $nrb): ?float
    {
        if ($na === null || $nrb === null) return null;
        return round(($na + $nrb) / 2, 2);
    }

    /* ====================== Renang 50m ====================== */

    public static function scoreSwim50m(?float $sec, string $gender, int $age): ?float
    {
        $score = self::scoreByThresholdDb($sec, 'swim_50m', $gender, $age);
        if ($score !== null) return (float)$score;
        return self::scoreSwim50m_config($sec, $gender, $age);
    }

    /* ====================== NAJ ====================== */

    public static function naj(?float $np, ?float $ng, ?float $nr): ?float
    {
        if ($np === null || $ng === null || $nr === null) return null;
        // NAJ = (NP×2 + NG×5 + NR×3) / 10
        return round((($np * 2) + ($ng * 5) + ($nr * 3)) / 10, 2);
    }

    //////////////////// HELPER (versi config) ////////////////////

    protected static function cfg(string $key, $default = null)
    {
        return config("juklak_fitness.$key", $default);
    }

    /** Pilih bracket umur dari array config. */
    protected static function pickBracket(array $blocks, int $age): ?array
    {
        foreach ($blocks as $b) {
            if (
                $age >= ($b['age_min'] ?? 0) &&
                $age <= ($b['age_max'] ?? 200)
            ) {
                return $b;
            }
        }
        return $blocks[0] ?? null;
    }

    /** Threshold "semakin BESAR semakin baik" (>= min). */
    protected static function scoreByMinThreshold(int|float $value, array $table, string $fieldMin): ?float
    {
        // diasumsikan table dari nilai min terbesar ke terkecil (boleh tidak urut; kita urutkan di sini)
        usort($table, fn($a, $b) => ($b[$fieldMin] ?? 0) <=> ($a[$fieldMin] ?? 0));
        foreach ($table as $row) {
            if ($value >= ($row[$fieldMin] ?? PHP_INT_MAX * -1)) {
                return isset($row['score']) ? (float)$row['score'] : null;
            }
        }
        return null;
    }

    /** Threshold "semakin KECIL semakin baik" (<= max). */
    protected static function scoreByMaxThreshold(int|float $value, array $table, string $fieldMax): ?float
    {
        // urutkan dari max terkecil ke terbesar
        usort($table, fn($a, $b) => ($a[$fieldMax] ?? PHP_INT_MAX) <=> ($b[$fieldMax] ?? PHP_INT_MAX));
        foreach ($table as $row) {
            if ($value <= ($row[$fieldMax] ?? PHP_INT_MAX)) {
                return isset($row['score']) ? (float)$row['score'] : null;
            }
        }
        return null;
    }

    //////////////////// FALLBACK (baca dari config) //////////////

    /** POSTUR (fallback config) */
    protected static function scorePosture_config(?float $heightCm, ?float $weightKg): ?float
    {
        if (!$heightCm || !$weightKg) return null;

        $cfg = self::cfg('posture', []);
        $mode = $cfg['mode'] ?? 'by_bmi_delta';

        if ($mode === 'by_category') {
            $bmi = self::bmi($heightCm, $weightKg);
            $cat = self::bmiCategoryToJuklak($bmi);
            return isset($cfg['by_category'][$cat]) ? (float)$cfg['by_category'][$cat] : null;
        }

        // by_bmi_delta
        $bmi   = self::bmi($heightCm, $weightKg);
        $ideal = (float)($cfg['bmi']['ideal'] ?? 22.0);
        $scale = (float)($cfg['bmi']['scale_per_point'] ?? 2.5);
        $base  = (float)($cfg['bmi']['base_score'] ?? 96);
        $min   = (float)($cfg['bmi']['min_score'] ?? 0);
        $max   = (float)($cfg['bmi']['max_score'] ?? 100);

        $delta = abs($bmi - $ideal);
        $score = $base - ($delta * $scale);
        return max($min, min($max, round($score, 2)));
    }

    /** Lari 12 menit (fallback config) */
    protected static function scoreRun12Min_config(?int $meters, string $gender, int $age): ?float
    {
        if ($meters === null) return null;
        $blocks = self::cfg("run_12min.$gender");
        if (!$blocks) return null;

        $br = self::pickBracket($blocks, $age);
        if (!$br) return null;

        return self::scoreByMinThreshold($meters, $br['table'] ?? [], 'min_m');
    }

    /** Baterai B pria (fallback config) */
    protected static function scoreBatteryBMale_config(?int $pullUp, ?int $sitUp, ?int $pushUp, ?float $shuttle, int $age): array
    {
        return self::scoreBatteryBGeneric_config('male', [
            'pull_up' => $pullUp,
            'sit_up'  => $sitUp,
            'push_up' => $pushUp,
            'shuttle_run' => $shuttle,
        ], $age);
    }

    /** Baterai B wanita (fallback config) */
    protected static function scoreBatteryBFemale_config(?int $chinning, ?int $modSitUp, ?int $modPushUp, ?float $shuttle, int $age): array
    {
        return self::scoreBatteryBGeneric_config('female', [
            'chinning' => $chinning,
            'modified_sit_up' => $modSitUp,
            'modified_push_up' => $modPushUp,
            'shuttle_run' => $shuttle,
        ], $age);
    }

    /** Generic baterai B (fallback config) */
    protected static function scoreBatteryBGeneric_config(string $gender, array $raws, int $age): array
    {
        $blocks = self::cfg("battery_b.$gender");
        if (!$blocks) return array_fill_keys(array_keys($raws), null);

        $br = self::pickBracket($blocks, $age);
        if (!$br) return array_fill_keys(array_keys($raws), null);

        $items = $br['items'] ?? [];
        $out = [];
        foreach ($raws as $key => $val) {
            if ($val === null) {
                $out[$key] = null;
                continue;
            }
            if ($key === 'shuttle_run') {
                $out[$key] = self::scoreByMaxThreshold($val, $items[$key] ?? [], 'max_sec');
            } else {
                $out[$key] = self::scoreByMinThreshold($val, $items[$key] ?? [], 'min_rep');
            }
        }
        return $out;
    }

    /** Renang 50m (fallback config) */
    protected static function scoreSwim50m_config(?float $sec, string $gender, int $age): ?float
    {
        if ($sec === null) return null;
        $blocks = self::cfg("swim_50m.$gender");
        if (!$blocks) return null;

        $br = self::pickBracket($blocks, $age);
        if (!$br) return null;

        return self::scoreByMaxThreshold($sec, $br['table'] ?? [], 'max_sec');
    }
}


