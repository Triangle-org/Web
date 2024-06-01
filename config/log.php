<?php

/**
 * @package     Triangle Web
 * @link        https://github.com/Triangle-org
 *
 * @copyright   2018-2024 Localzet Group
 * @license     https://mit-license.org MIT
 */

return [
    'default' => [
        'handlers' => [
            [
                'class' => Monolog\Handler\RotatingFileHandler::class,
                'constructor' => [
                    runtime_path(env('LOG_FILE_NAME', 'triangle.log')),
                    (int)env('LOG_FILE_COUNT', 7),
                    env('LOG_FILE_LEVEL', Monolog\Logger::DEBUG),
                ],
                'formatter' => [
                    'class' => Monolog\Formatter\LineFormatter::class,
                    'constructor' => [
                        env('LOG_FILE_FORMAT'),
                        env('LOG_FILE_DATE_FORMAT', 'Y-m-d H:i:s'),
                        env('LOG_FILE_INLINE_BREAKS', true)
                    ],
                ],
            ],
        ],
    ],
];
