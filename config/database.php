<?php

/**
 * @package     Triangle Web
 * @link        https://github.com/Triangle-org/Web
 * 
 * @author      Ivan Zorin <creator@localzet.com>
 * @copyright   2018-2023 Localzet Group
 * @license     https://mit-license.org MIT
 */

return [
    'default'               => 'mysql',
    'connections' => [
        'mysql' => [
            'driver'        => 'mysql',
            'host'          => 'localhost',
            'port'          => 3306,
            'database'      => 'framex',
            'username'      => 'rootx',
            'password'      => 'rootx',
            'unix_socket'   => '',
            'charset'       => 'utf8',
            'collation'     => 'utf8_unicode_ci',
            'prefix'        => '',
            'strict'        => true,
            'engine'        => null,
        ],

        'sqlite' => [
            'driver'        => 'sqlite',
            'database'      => 'framex',
            'prefix'        => '',
        ],

        'pgsql' => [
            'driver'        => 'pgsql',
            'host'          => 'localhost',
            'port'          => 5432,
            'database'      => 'framex',
            'username'      => 'rootx',
            'password'      => 'rootx',
            'charset'       => 'utf8',
            'prefix'        => '',
            'schema'        => 'public',
            'sslmode'       => 'prefer',
        ],

        'sqlsrv' => [
            'driver'        => 'sqlsrv',
            'host'          => 'localhost',
            'port'          => 1433,
            'database'      => 'framex',
            'username'      => 'rootx',
            'password'      => 'rootx',
            'charset'       => 'utf8',
            'prefix'        => '',
        ],

        // Необходимо расширение:
        // apt install php-dev
        // sudo pecl install mongodb

        'mongodb' => [
            'driver'   => 'mongodb',
            'host'     => 'localhost',
            'port'     =>  27017,
            'database' => 'framex',
            // 'username' => null,
            // 'password' => null,
            'options' => [
                // здесь вы можете передать больше настроек в Mongo Driver Manager
                // https://www.php.net/manual/en/mongodb-driver-manager.construct.php в разделе «Uri Options» список полных параметров, которые вы можете использовать
            ],
        ],
    ],
];
