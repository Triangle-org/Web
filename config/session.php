<?php

/**
 * @package     Triangle Web
 * @link        https://github.com/Triangle-org
 *
 * @copyright   2018-2024 Localzet Group
 * @license     https://mit-license.org MIT
 */

use Triangle\Engine\Session\FileSessionHandler;
use Triangle\Engine\Session\MongoSessionHandler;
use Triangle\Engine\Session\RedisClusterSessionHandler;
use Triangle\Engine\Session\RedisSessionHandler;

return [
    'type' => env('SESSION_TYPE', 'file'),
    'handler' => match (env('SESSION_TYPE', 'file')) {
        'file' => FileSessionHandler::class,
        'mongo' => MongoSessionHandler::class,
        'redis' => RedisSessionHandler::class,
        'redis_cluster' => RedisClusterSessionHandler::class,
    },
    'config' => [
        'file' => [
            'save_path' => runtime_path('sessions'),
        ],
        'mongo' => [
            'uri' => 'mongodb://' . env('SESSION_MONGO_HOST', 'localhost') . ':' . env('SESSION_MONGO_PORT', '27017') . '/?directConnection=true',
            'database' => 'default',
            'collection' => 'sessions',
        ],
        'redis' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'port' => env('REDIS_PORT', '6379'),
            'auth' => '',
            'timeout' => 2,
            'database' => env('REDIS_CACHE_DB', '2'),
            'prefix' => 'triangle_session_',
        ],
        'redis_cluster' => [
            'host' => ['127.0.0.1:7000', '127.0.0.1:7001', '127.0.0.1:7001'],
            'timeout' => 2,
            'auth' => '',
            'prefix' => 'triangle_session_',
        ]
    ],
    'auto_update_timestamp' => env('SESSION_AUTO_UPDATE', false),
    'lifetime' => env('SESSION_LIFETIME', 7 * 24 * 60 * 60),
    'session_name' => env('SESSION_COOKIE_NAME', 'PHPSID'),
    'cookie_lifetime' => env('SESSION_COOKIE_LIFETIME', 365 * 24 * 60 * 60),
    'cookie_path' => env('SESSION_COOKIE_PATH', '/'),
    'domain' => env('SESSION_COOKIE_DOMAIN', ''),
    'http_only' => env('SESSION_COOKIE_HTTP_ONLY', true),
    'secure' => env('SESSION_COOKIE_SECURE', false),
    'same_site' => env('SESSION_COOKIE_SAME_SITE', ''),
    'gc_probability' => [1, 1000],
];
