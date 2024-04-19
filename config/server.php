<?php

/**
 * @package     Triangle Web
 * @link        https://github.com/Triangle-org
 *
 * @copyright   2018-2024 Localzet Group
 * @license     https://mit-license.org MIT
 */

return [
    'listen' => env('SERVER_LISTEN', 'http://0.0.0.0:8000'),
    'transport' => 'tcp',
    'context' => [],
    'name' => env('APP_NAME', 'Triangle App'),
    'count' => env('SERVER_COUNT', cpu_count() * 4),
    'user' => env('SERVER_USER', ''),
    'group' => env('SERVER_GROUP', ''),
    'reusePort' => env('SERVER_GROUP', false),
    'stop_timeout' => env('SERVER_STOP_TIMEOUT', 2),
    'pid_file' => runtime_path(env('SERVER_FILE_PID', 'triangle.pid')),
    'status_file' => runtime_path(env('SERVER_FILE_STATUS', 'triangle.status')),
    'stdout_file' => runtime_path(env('SERVER_FILE_STDOUT', 'logs/stdout.log')),
    'log_file' => runtime_path(env('SERVER_FILE_LOG', 'logs/server.log')),
    'max_package_size' => 10 * 1024 * 1024
];
