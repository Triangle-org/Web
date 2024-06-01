<?php

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
            'host' => env('SESSION_MONGO_HOST', '127.0.0.1'),
            'port' => env('SESSION_MONGO_PORT', 27017),
            'database' => env('SESSION_MONGO_DATABASE', 'default'),
            'username' => env('SESSION_MONGO_USER', 'root'),
            'password' => env('SESSION_MONGO_PASS'),
            'collection' => env('SESSION_MONGO_COLLECTION', 'sessions'),
            'options' => [
                'directConnection' => env('MONGO_DIRECT_CONNECTION', 'true'),
                'authSource' => env('MONGO_AUTH_SOURCE', 'admin'),
                'appname' => env('APP_NAME', 'Triangle App'),
            ],
        ],
        'redis' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'port' => env('REDIS_PORT', '6379'),
            'auth' => env('REDIS_PASSWORD'),
            'database' => env('REDIS_DB_SESSION', '2'),
            'timeout' => 2,
            'prefix' => env('REDIS_PREFIX_SESSION', 'triangle_session_'),
        ],
        'redis_cluster' => [
            'host' => ['127.0.0.1:7000', '127.0.0.1:7001', '127.0.0.1:7001'],
            'auth' => env('REDIS_PASSWORD'),
            'timeout' => 2,
            'prefix' => env('REDIS_PREFIX_SESSION', 'triangle_session_'),
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
