<?php

/**
 * @package     Triangle Web
 * @link        https://github.com/Triangle-org
 *
 * @copyright   2018-2024 Localzet Group
 * @license     https://mit-license.org MIT
 */

// Для подключения баз данных выполни:
// composer require -W illuminate/database

// Для пагинации и событий:
// composer require -W illuminate/pagination illuminate/events symfony/var-dumper

// Для MongoDB:
// composer require -W mongodb/laravel-mongodb

return [
    'default' => 'mysql',
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'port' => 3306,
            'database' => 'database',
            'username' => 'username',
            'password' => 'password',
            'unix_socket' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => 'database',
            'prefix' => '',
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => 'localhost',
            'port' => 5432,
            'database' => 'database',
            'username' => 'username',
            'password' => 'password',
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => 'localhost',
            'port' => 1433,
            'database' => 'database',
            'username' => 'username',
            'password' => 'password',
            'charset' => 'utf8',
            'prefix' => '',
        ],

        'mongodb' => [
            'driver' => 'mongodb',
            'host' => 'localhost',
            'port' => 27017,
            'database' => 'database',
            'username' => 'username',
            'password' => 'username',
            'options' => [
                'appname' => 'Triangle App'
            ],
        ],
    ],
];
