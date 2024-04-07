<?php

/**
 * @package     Triangle Web
 * @link        https://github.com/Triangle-org
 *
 * @copyright   2018-2024 Localzet Group
 * @license     https://mit-license.org MIT
 */

use Triangle\Engine\View\Raw;
use Triangle\Engine\View\Twig;
use Triangle\Engine\View\Blade;
use Triangle\Engine\View\ThinkPHP;

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
