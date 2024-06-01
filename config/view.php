<?php

use Triangle\Engine\View\Blade;
use Triangle\Engine\View\Raw;
use Triangle\Engine\View\ThinkPHP;
use Triangle\Engine\View\Twig;

return [
    'handler' => match (env('VIEW_HANDLER', 'raw')) {
        'blade' => Blade::class,
        'raw' => Raw::class,
        'think' => ThinkPHP::class,
        'twig' => Twig::class,
    },
    'options' => [
        'view_suffix' => 'phtml',
        'vars' => [],
        'pre_renders' => [
//            [
//                'app' => null,
//                'plugin' => null,
//                'template' => 'index_header',
//                'vars' => [],
//            ],
        ],
        'post_renders' => [
//            [
//                'app' => null,
//                'plugin' => null,
//                'template' => 'index_footer',
//                'vars' => [],
//            ],
        ],
    ],
];
