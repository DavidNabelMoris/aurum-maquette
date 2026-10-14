<?php

return [
    'name' => 'Aurum',
    'label' => 'Maquette',
    'url' => getenv('APP_URL') ?: 'http://localhost:8000',
    'base_url' => '',
    'debug' => getenv('APP_DEBUG') === '1',
    'force_https' => getenv('APP_FORCE_HTTPS') === '1',
    'trust_proxy' => getenv('TRUST_PROXY') === '1',
    'demo' => getenv('DEMO_MODE') === '1',

    'contact' => [
        'email' => 'contact@example.com',
        'address' => null,
    ],

    'analytics' => [
        'gtm_id' => getenv('GTM_ID') ?: null,
    ],

    'vendors' => [
        'lucide' => [
            'src' => 'https://unpkg.com/lucide@0.454.0/dist/umd/lucide.min.js',
            'integrity' => 'sha384-m/CoPp6wBQz6MoZXP+VveuxfvSx0NGXiQyyakzXVOVHgG1fP5bM/UiO4pSNPV6PT',
        ],
        'chartjs' => [
            'src' => 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js',
            'integrity' => 'sha384-bs/nf9FbdNouRbMiFcrcZfLXYPKiPaGVGplVbv7dLGECccEXDW+S3zjqSKR5ZEaD',
        ],
    ],

    'site_nav' => [
        ['label' => 'Rachat', 'href' => '/#rachat'],
        ['label' => 'Comment vendre', 'href' => '/#vendre'],
        ['label' => 'Tournées', 'href' => '/#tournees'],
        ['label' => 'Agences', 'href' => '/#agences'],
        ['label' => 'Change', 'href' => '/#change'],
    ],

    'legal_nav' => [
        ['label' => 'À propos', 'href' => '/a-propos'],
        ['label' => 'Mentions légales', 'href' => '/mentions-legales'],
        ['label' => 'Confidentialité', 'href' => '/confidentialite'],
        ['label' => "Conditions d'utilisation", 'href' => '/cgu'],
    ],

    'admin_nav' => [
        ['id' => 'dashboard', 'label' => 'Tableau de bord', 'icon' => 'layout-dashboard', 'tone' => 'primary', 'href' => '/admin'],
        ['id' => 'tours', 'label' => 'Tournées', 'icon' => 'map-pin', 'tone' => 'info', 'href' => null],
        ['id' => 'appointments', 'label' => 'Rendez-vous', 'icon' => 'calendar-check', 'tone' => 'orange', 'href' => null],
        ['id' => 'estimations', 'label' => 'Estimations', 'icon' => 'file-search', 'tone' => 'red', 'href' => null],
        ['id' => 'agencies', 'label' => 'Agences', 'icon' => 'store', 'tone' => 'green', 'href' => null],
        ['id' => 'metals', 'label' => 'Cours métaux', 'icon' => 'coins', 'tone' => 'yellow', 'href' => null],
    ],
];
