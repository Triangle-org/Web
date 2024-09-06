<?php

/**
 * @package     Triangle Session Component
 * @link        https://github.com/Triangle-org/Session
 *
 * @author      Ivan Zorin <creator@localzet.com>
 * @copyright   Copyright (c) 2023-2024 Triangle Framework Team
 * @license     https://www.gnu.org/licenses/agpl-3.0 GNU Affero General Public License v3.0
 *
 *              This program is free software: you can redistribute it and/or modify
 *              it under the terms of the GNU Affero General Public License as published
 *              by the Free Software Foundation, either version 3 of the License, or
 *              (at your option) any later version.
 *
 *              This program is distributed in the hope that it will be useful,
 *              but WITHOUT ANY WARRANTY; without even the implied warranty of
 *              MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *              GNU Affero General Public License for more details.
 *
 *              You should have received a copy of the GNU Affero General Public License
 *              along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 *              For any questions, please contact <triangle@localzet.com>
 */

return [
    'type' => env('SESSION_TYPE', 'file'),
    'handler' => match (env('SESSION_TYPE', 'file')) {
        'file' => Triangle\Session\Handlers\FileSessionHandler::class,
        'mongo' => Triangle\Session\Handlers\MongoSessionHandler::class,
        'redis' => Triangle\Session\Handlers\RedisSessionHandler::class,
        'redis_cluster' => Triangle\Session\Handlers\RedisClusterSessionHandler::class,
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
    'lifetime' => (int)env('SESSION_LIFETIME', 7 * 24 * 60 * 60),
    'session_name' => env('SESSION_COOKIE_NAME', 'PHPSID'),
    'cookie_lifetime' => (int)env('SESSION_COOKIE_LIFETIME', 365 * 24 * 60 * 60),
    'cookie_path' => env('SESSION_COOKIE_PATH', '/'),
    'domain' => env('SESSION_COOKIE_DOMAIN', ''),
    'http_only' => env('SESSION_COOKIE_HTTP_ONLY', true),
    'secure' => env('SESSION_COOKIE_SECURE', false),
    'same_site' => env('SESSION_COOKIE_SAME_SITE', ''),
    'gc_probability' => [1, 1000],
];
