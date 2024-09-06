<?php

return [
    'debug' => (bool)env('APP_DEBUG', false),
    'name' => env('APP_NAME', 'Triangle App'),

    'plugin_alias' => env('APP_PLUGIN_ALIAS', 'plugin'),
    'plugin_uri' => env('APP_PLUGIN_URI', 'app'),

    'controller_suffix' => env('CONTROLLER_SUFFIX', ''),
    'controller_reuse' => env('CONTROLLER_REUSE', true),

    'headers' => [
        'Content-Language' => 'ru',
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Credentials' => 'true',
        'Access-Control-Allow-Methods' => '*',
        'Access-Control-Allow-Headers' => '*',
        'X-Powered-By' => 'Triangle-Core/' . Composer\InstalledVersions::getVersion('triangle/engine'),
    ],
];
