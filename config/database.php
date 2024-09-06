<?php

return [
    'default' => env('DB_CONNECTION', 'mysql'),
    'connections' => [
        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DB_SQLITE_URL', env('DB_URL')),
            'prefix' => env('DB_SQLITE_PREFIX', env('DB_PREFIX', '')),
            'database' => base_path(env('DB_SQLITE_DATABASE', env('DB_DATABASE', 'resources/database.sqlite'))),
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DB_MYSQL_URL', env('DB_URL')),
            'host' => env('DB_MYSQL_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('DB_MYSQL_PORT', env('DB_PORT', 3306)),
            'prefix' => env('DB_MYSQL_PREFIX', env('DB_PREFIX', '')),
            'database' => env('DB_MYSQL_DATABASE', env('DB_DATABASE', 'database')),
            'username' => env('DB_MYSQL_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('DB_MYSQL_PASSWORD', env('DB_PASSWORD', '')),
            'charset' => env('DB_MYSQL_CHARSET', env('DB_CHARSET', 'utf8mb4')),
            'unix_socket' => env('DB_MYSQL_SOCKET', env('DB_SOCKET', '')),
            'collation' => 'utf8mb4_unicode_ci',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DB_PGSQL_URL', env('DB_URL')),
            'host' => env('DB_PGSQL_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('DB_PGSQL_PORT', env('DB_PORT', 5432)),
            'prefix' => env('DB_PGSQL_PREFIX', env('DB_PREFIX', '')),
            'database' => env('DB_PGSQL_DATABASE', env('DB_DATABASE', 'database')),
            'username' => env('DB_PGSQL_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('DB_PGSQL_PASSWORD', env('DB_PASSWORD', '')),
            'charset' => env('DB_PGSQL_CHARSET', env('DB_CHARSET', 'utf8')),
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DB_SQLSRV_URL', env('DB_URL')),
            'host' => env('DB_SQLSRV_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('DB_SQLSRV_PORT', env('DB_PORT', 1433)),
            'prefix' => env('DB_SQLSRV_PREFIX', env('DB_PREFIX', '')),
            'database' => env('DB_SQLSRV_DATABASE', env('DB_DATABASE', 'database')),
            'username' => env('DB_SQLSRV_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('DB_SQLSRV_PASSWORD', env('DB_PASSWORD', '')),
            'charset' => env('DB_SQLSRV_CHARSET', env('DB_CHARSET', 'utf8')),
            'encrypt' => env('DB_SQLSRV_ENCRYPT', env('DB_ENCRYPT', 'yes')),
            'trust_server_certificate' => env('DB_SQLSRV_TRUST_SERVER_CERTIFICATE', 'false'),
            'prefix_indexes' => true,
        ],

        'mongodb' => [
            'driver' => 'mongodb',
            'url' => env('DB_MONGODB_URL', env('DB_URL')),
            'host' => env('DB_MONGODB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('DB_MONGODB_PORT', env('DB_PORT', 27017)),
            'database' => env('DB_MONGODB_DATABASE', env('DB_DATABASE', 'database')),
            'username' => env('DB_MONGODB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('DB_MONGODB_PASSWORD', env('DB_PASSWORD', '')),
            'options' => [
                'directConnection' => env('DB_MONGODB_DIRECT_CONNECTION', 'true'),
                'authSource' => env('DB_MONGODB_AUTH_SOURCE', 'admin'),
                'appname' => env('DB_MONGODB_APP_NAME', env('APP_NAME', 'Triangle App')),
            ],
        ],
    ],
];
