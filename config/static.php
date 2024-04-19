<?php

/**
 * @package     Triangle Web
 * @link        https://github.com/Triangle-org
 *
 * @copyright   2018-2024 Localzet Group
 * @license     https://mit-license.org MIT
 */

return [
    'enable' => env('STATIC_ENABLE', true),
    'middleware' => [
        app\middleware\StaticFile::class,
    ],
    'forbidden' => [
        '/.',
    ]
];
