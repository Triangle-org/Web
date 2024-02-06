<?php

/**
 * @package     Triangle Web
 * @link        https://github.com/Triangle-org
 *
 * @copyright   2018-2024 Localzet Group
 * @license     https://mit-license.org MIT
 */

use Triangle\Engine\View\Raw;

return [
    'handler' => Raw::class,
    'options' => [
        'view_suffix' => 'phtml',
        'pre_renders' => [],
        'post_renders' => [],
        'vars' => [],
    ],
//    'templates' => [
//        'system' => [
//            'success' => '',
//            'error' => '',
//        ]
//    ]
];
