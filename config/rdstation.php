<?php


return [
    'http' => [
        'base_uri' => env('RDSTATION_BASE_URI', 'https://api.tallos.com.br/v2/'),
        'timeout'  => (int) env('RDSTATION_TIMEOUT', 10),
        'retries'  => [
            'max' => (int) env('RDSTATION_RETRY_MAX', 3),
            'retry_on_codes' => [429, 500, 502, 503, 504],
            'base_ms' => (int) env('RDSTATION_RETRY_BASE_MS', 250),
        ],
        'user_agent' => env('RDSTATION_USER_AGENT', 'laravel-rdstation/1.x'),
    ],

    'auth' => [
        'driver'   => 'token',
        'header'   => env('RDSTATION_AUTH_HEADER', 'Authorization'),
        'prefix'   => env('RDSTATION_AUTH_PREFIX', 'Bearer '),
        'token'    => env('RDSTATION_API_TOKEN'),
    ],
];
