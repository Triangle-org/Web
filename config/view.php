<?php

/**
 * @package     Triangle Web
 * @link        https://github.com/Triangle-org
 *
 * @copyright   2018-2023 Localzet Group
 * @license     https://mit-license.org MIT
 */

use Triangle\Engine\View\Raw;

return [
    'handler' => Raw::class,
    'options' => [
        'view_suffix' => 'phtml',
        'view_global' => true,   // true - шаблоны view_head и view_footer будут забираться из "\app_path() . '/view/' . config('view.options.view_...')"
        // 'view_head' => '',
        // 'view_footer' => '',
    ]

];
