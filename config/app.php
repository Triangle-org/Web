<?php

return [
    'error_reporting' => E_ALL,
    'request_class' => support\Request::class,

    'app_path' => base_path('app'),
    'public_path' => run_path('public'),
    'runtime_path' => run_path('runtime'),

    'default_timezone' => env('APP_TIMEZONE', 'Europe/Moscow'),

    'controller_suffix' => env('CONTROLLER_SUFFIX', ''),
    'controller_reuse' => env('CONTROLLER_REUSE', true),

    'debug' => (bool)env('APP_DEBUG', false),
    'name' => env('APP_NAME', 'Triangle App'),

    'url' => env('APP_URL', 'http://localhost'),
    'asset_url' => env('ASSET_URL'),

    'headers' => [
        'Content-Language' => 'ru',
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Credentials' => 'true',
        'Access-Control-Allow-Methods' => '*',
        'Access-Control-Allow-Headers' => '*',
        'X-Powered-By' => 'Triangle-Core/' . Composer\InstalledVersions::getVersion('triangle/engine'),
    ],
];
