<?php

return [
    'error_reporting' => E_ALL,
    'default_timezone' => env('APP_TIMEZONE', 'Europe/Moscow'),

    // Для основного сервера
    'name' => env('APP_NAME', 'Triangle App'),
    'count' => env('SERVER_COUNT', cpu_count() * 4),

    'listen' => env('SERVER_LISTEN', 'http://127.0.0.1:8000'),
    'context' => [],

    'user' => env('SERVER_USER', ''),
    'group' => env('SERVER_GROUP', ''),

    'reloadable' => env('SERVER_RELOADABLE', true),
    'reusePort' => env('SERVER_REUSE_PORT', false),

    'handler' => Triangle\Http\App::class,
    'constructor' => [
        'requestClass' => Triangle\Request::class,
        'logger' => support\Log::channel(),
        'basePath' =>       run_path(),
        'appPath' =>        run_path('app'),
        'configPath' =>     run_path('config'),
        'publicPath' =>     run_path('public'),
        'runtimePath' =>    run_path('runtime'),
    ],

    // Для мастер-процесса
    'master' => [
        // Все пути относительны внутри runtime_path()
        'pidFile' => env('SERVER_FILE_PID', 'triangle.pid'),
        'statusFile' => env('SERVER_FILE_STATUS', 'triangle.status'),
        'stdoutFile' => env('SERVER_FILE_STDOUT', 'logs/stdout.log'),
        'logFile' => env('SERVER_FILE_LOG', 'logs/server.log'),
        'stopTimeout' => env('SERVER_STOP_TIMEOUT', 2),
    ]
];
