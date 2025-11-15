<?php
return [
    'posture' => [
        'mode' => 'by_bmi_delta',
        'bmi' => [
            'ideal' => 22.0,
            'scale_per_point' => 2.5,
            'base_score' => 96,
            'min_score' => 0,
            'max_score' => 100,
        ],
        'by_category' => [
            'ideal' => 96,
            'harmonis_atas' => 86,
            'harmonis_bawah' => 78,
            'normal_atas' => 68,
            'normal_bawah' => 58,
            'limit_atas' => 48,
            'limit_bawah' => 38,
            'luar_limit_atas' => 28,
            'luar_limit_bawah' => 18,
        ],
    ],

    // ===== Lari 12 menit (sudah usia-aware) =====
    'run_12min' => [
        'male' => [
            [
                'age_min' => 18,
                'age_max' => 25,
                'table' => [
                    ['min_m' => 3500, 'score' => 100],
                    ['min_m' => 3300, 'score' => 90],
                    ['min_m' => 3000, 'score' => 80],
                    ['min_m' => 2700, 'score' => 70],
                    ['min_m' => 2400, 'score' => 60],
                    ['min_m' => 0,    'score' => 40],
                ],
            ],
            [
                'age_min' => 26,
                'age_max' => 30,
                'table' => [
                    ['min_m' => 3400, 'score' => 100],
                    ['min_m' => 3200, 'score' => 90],
                    ['min_m' => 2900, 'score' => 80],
                    ['min_m' => 2600, 'score' => 70],
                    ['min_m' => 2300, 'score' => 60],
                    ['min_m' => 0,    'score' => 40],
                ],
            ],
        ],
        'female' => [
            [
                'age_min' => 18,
                'age_max' => 25,
                'table' => [
                    ['min_m' => 3200, 'score' => 100],
                    ['min_m' => 3000, 'score' => 90],
                    ['min_m' => 2700, 'score' => 80],
                    ['min_m' => 2400, 'score' => 70],
                    ['min_m' => 2100, 'score' => 60],
                    ['min_m' => 0,    'score' => 40],
                ],
            ],
            [
                'age_min' => 26,
                'age_max' => 30,
                'table' => [
                    ['min_m' => 3100, 'score' => 100],
                    ['min_m' => 2900, 'score' => 90],
                    ['min_m' => 2600, 'score' => 80],
                    ['min_m' => 2350, 'score' => 70],
                    ['min_m' => 2050, 'score' => 60],
                    ['min_m' => 0,    'score' => 40],
                ],
            ],
        ],
    ],

    // ===== Baterai B dengan bracket usia =====
    'battery_b' => [
        'male' => [
            [
                'age_min' => 18,
                'age_max' => 25,
                'items' => [
                    'pull_up' => [
                        ['min_rep' => 18, 'score' => 100],
                        ['min_rep' => 15, 'score' => 90],
                        ['min_rep' => 12, 'score' => 80],
                        ['min_rep' => 0,  'score' => 40],
                    ],
                    'sit_up' => [
                        ['min_rep' => 60, 'score' => 100],
                        ['min_rep' => 50, 'score' => 80],
                        ['min_rep' => 0,  'score' => 40],
                    ],
                    'push_up' => [
                        ['min_rep' => 60, 'score' => 100],
                        ['min_rep' => 45, 'score' => 80],
                        ['min_rep' => 0,  'score' => 40],
                    ],
                    'shuttle_run' => [
                        ['max_sec' => 15.9, 'score' => 100],
                        ['max_sec' => 16.5, 'score' => 90],
                        ['max_sec' => 18.0, 'score' => 70],
                        ['max_sec' => 999,  'score' => 40],
                    ],
                ],
            ],
            [
                'age_min' => 26,
                'age_max' => 30,
                'items' => [
                    'pull_up' => [
                        ['min_rep' => 17, 'score' => 100],
                        ['min_rep' => 14, 'score' => 90],
                        ['min_rep' => 11, 'score' => 80],
                        ['min_rep' => 0,  'score' => 40],
                    ],
                    'sit_up' => [
                        ['min_rep' => 58, 'score' => 100],
                        ['min_rep' => 48, 'score' => 80],
                        ['min_rep' => 0,  'score' => 40],
                    ],
                    'push_up' => [
                        ['min_rep' => 58, 'score' => 100],
                        ['min_rep' => 43, 'score' => 80],
                        ['min_rep' => 0,  'score' => 40],
                    ],
                    'shuttle_run' => [
                        ['max_sec' => 16.2, 'score' => 100],
                        ['max_sec' => 16.8, 'score' => 90],
                        ['max_sec' => 18.3, 'score' => 70],
                        ['max_sec' => 999,  'score' => 40],
                    ],
                ],
            ],
        ],
        'female' => [
            [
                'age_min' => 18,
                'age_max' => 25,
                'items' => [
                    'chinning' => [
                        ['min_rep' => 12, 'score' => 100],
                        ['min_rep' => 8,  'score' => 80],
                        ['min_rep' => 0,  'score' => 40],
                    ],
                    'modified_sit_up' => [
                        ['min_rep' => 55, 'score' => 100],
                        ['min_rep' => 45, 'score' => 80],
                        ['min_rep' => 0,  'score' => 40],
                    ],
                    'modified_push_up' => [
                        ['min_rep' => 50, 'score' => 100],
                        ['min_rep' => 40, 'score' => 80],
                        ['min_rep' => 0,  'score' => 40],
                    ],
                    'shuttle_run' => [
                        ['max_sec' => 16.5, 'score' => 100],
                        ['max_sec' => 17.5, 'score' => 90],
                        ['max_sec' => 19.0, 'score' => 70],
                        ['max_sec' => 999,  'score' => 40],
                    ],
                ],
            ],
            [
                'age_min' => 26,
                'age_max' => 30,
                'items' => [
                    'chinning' => [
                        ['min_rep' => 11, 'score' => 100],
                        ['min_rep' => 7,  'score' => 80],
                        ['min_rep' => 0,  'score' => 40],
                    ],
                    'modified_sit_up' => [
                        ['min_rep' => 53, 'score' => 100],
                        ['min_rep' => 43, 'score' => 80],
                        ['min_rep' => 0,  'score' => 40],
                    ],
                    'modified_push_up' => [
                        ['min_rep' => 48, 'score' => 100],
                        ['min_rep' => 38, 'score' => 80],
                        ['min_rep' => 0,  'score' => 40],
                    ],
                    'shuttle_run' => [
                        ['max_sec' => 16.8, 'score' => 100],
                        ['max_sec' => 17.8, 'score' => 90],
                        ['max_sec' => 19.3, 'score' => 70],
                        ['max_sec' => 999,  'score' => 40],
                    ],
                ],
            ],
        ],
    ],

    // ===== Renang 50m (usia-aware) =====
    'swim_50m' => [
        'male' => [
            [
                'age_min' => 18,
                'age_max' => 25,
                'table' => [
                    ['max_sec' => 35, 'score' => 100],
                    ['max_sec' => 40, 'score' => 95],
                    ['max_sec' => 45, 'score' => 90],
                    ['max_sec' => 50, 'score' => 85],
                    ['max_sec' => 55, 'score' => 80],
                    ['max_sec' => 60, 'score' => 70],
                    ['max_sec' => 70, 'score' => 50],
                    ['max_sec' => 80, 'score' => 30],
                    ['max_sec' => 90, 'score' => 10],
                ],
            ],
            [
                'age_min' => 26,
                'age_max' => 30,
                'table' => [
                    ['max_sec' => 36, 'score' => 100],
                    ['max_sec' => 41, 'score' => 95],
                    ['max_sec' => 46, 'score' => 90],
                    ['max_sec' => 51, 'score' => 85],
                    ['max_sec' => 56, 'score' => 80],
                    ['max_sec' => 61, 'score' => 70],
                    ['max_sec' => 71, 'score' => 50],
                    ['max_sec' => 81, 'score' => 30],
                    ['max_sec' => 91, 'score' => 10],
                ],
            ],
        ],
        'female' => [
            [
                'age_min' => 18,
                'age_max' => 25,
                'table' => [
                    ['max_sec' => 38, 'score' => 100],
                    ['max_sec' => 43, 'score' => 95],
                    ['max_sec' => 48, 'score' => 90],
                    ['max_sec' => 53, 'score' => 85],
                    ['max_sec' => 58, 'score' => 80],
                    ['max_sec' => 63, 'score' => 70],
                    ['max_sec' => 73, 'score' => 50],
                    ['max_sec' => 83, 'score' => 30],
                    ['max_sec' => 93, 'score' => 10],
                ],
            ],
            [
                'age_min' => 26,
                'age_max' => 35,
                'table' => [
                    ['max_sec' => 39, 'score' => 100],
                    ['max_sec' => 44, 'score' => 95],
                    ['max_sec' => 49, 'score' => 90],
                    ['max_sec' => 54, 'score' => 85],
                    ['max_sec' => 59, 'score' => 80],
                    ['max_sec' => 64, 'score' => 70],
                    ['max_sec' => 74, 'score' => 50],
                    ['max_sec' => 84, 'score' => 30],
                    ['max_sec' => 94, 'score' => 10],
                ],
            ],
        ],
    ],
];
