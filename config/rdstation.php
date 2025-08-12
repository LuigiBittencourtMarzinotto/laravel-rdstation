<?php

use LuigiBittencourtMarzinotto\RDStation\Models\ConnectedAccount;

return [
    'oauth' => [
        'client_id' => env('RDSTATION_CLIENT_ID'),
        'client_secret' => env('RDSTATION_CLIENT_SECRET'),
        'redirect_uri' => env('RDSTATION_REDIRECT_URI', url('/rdstation/oauth/callback')),
        'default_scopes' => ['contacts', 'deals'], // opcional
    ],

    'http' => [
        'base_uri' => env('RDSTATION_BASE_URI', 'https://api.rd.services'),
        'timeout' => (int) env('RDSTATION_TIMEOUT', 10),
        'retries' => [
            'max' => (int) env('RDSTATION_RETRY_MAX', 3),
            'retry_on_codes' => [429, 500, 502, 503, 504],
            'base_ms' => (int) env('RDSTATION_RETRY_BASE_MS', 250),
        ],
        'user_agent' => env('RDSTATION_USER_AGENT', 'laravel-rdstation/1.x'),
    ],

    'webhook' => [
        'path' => env('RDSTATION_WEBHOOK_PATH', '/rdstation/webhooks'),
        'secret' => env('RDSTATION_WEBHOOK_SECRET'),
        'signature_header' => env('RDSTATION_SIGNATURE_HEADER', 'X-RDStation-Signature'),
        'middleware' => ['api'],
        'idempotency_ttl' => (int) env('RDSTATION_WEBHOOK_IDEMP_TTL', 60),
    ],

    'models' => [
        'connected_account' => ConnectedAccount::class,
        'table' => 'rd_connected_accounts',
    ],

    'token_store' => [
        'driver' => env('RDSTATION_TOKEN_STORE', 'database'),
    ],

    'queue' => [
        'connection' => env('RDSTATION_QUEUE_CONNECTION', env('QUEUE_CONNECTION', 'sync')),
        'name' => env('RDSTATION_QUEUE', 'rdstation'),
        'tries' => (int) env('RDSTATION_JOB_TRIES', 3),
        'backoff' => (int) env('RDSTATION_JOB_BACKOFF', 5),
    ],
    'throttle' => [
        'key_prefix' => 'rdstation:',
        'max_per_minute' => (int) env('RDSTATION_THROTTLE_PER_MIN', 120),
    ],

    'log' => [
        'channel' => env('RDSTATION_LOG_CHANNEL', env('LOG_CHANNEL', 'stack')),
        'http_payload' => (bool) env('RDSTATION_LOG_HTTP', false),
        'mask_fields' => ['access_token', 'refresh_token'],
    ],

    'features' => [
        'contacts' => true,
        'deals' => true,
        'events' => true,
        'webhooks' => true,
    ],
];
