<?php

return [
    'env_file' => '.env',
    'app_path' => base_path('app'),
    'public_path' => run_path('public'),
    'runtime_path' => run_path('runtime'),

    'error_reporting' => E_ALL,
    'default_timezone' => env('APP_TIMEZONE', 'Europe/Moscow'),

    // Для основного сервера
    'name' => env('APP_NAME', 'Triangle App'),
    'count' => env('SERVER_COUNT', cpu_count() * 4),
    'listen' => env('SERVER_LISTEN', 'http://0.0.0.0:8000'),
    'context' => [],
    'user' => env('SERVER_USER', ''),
    'group' => env('SERVER_GROUP', ''),
    'reloadable' => env('SERVER_RELOADABLE', true),
    'reusePort' => env('SERVER_REUSE_PORT', false),

    'handler' => Triangle\Http\App::class,
    'constructor' => [
        'requestClass' => support\Request::class,
        'logger' => support\Log::channel(),
    ],

    // Для мастер-процесса
    'pid_file' => runtime_path(env('SERVER_FILE_PID', 'triangle.pid')),
    'status_file' => runtime_path(env('SERVER_FILE_STATUS', 'triangle.status')),
    'stdout_file' => runtime_path(env('SERVER_FILE_STDOUT', 'logs/stdout.log')),
    'log_file' => runtime_path(env('SERVER_FILE_LOG', 'logs/server.log')),
    'stop_timeout' => env('SERVER_STOP_TIMEOUT', 2),
    'max_package_size' => 10 * 1024 * 1024,
];
