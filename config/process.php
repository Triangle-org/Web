<?php

return [
    'monitor' => [
        'handler' => process\Monitor::class,
        'reloadable' => false,
        'constructor' => [
            'monitorDir' => array_merge(
                [
                    app_path(),
                    config_path(),
                    base_path() . '/autoload',
                    base_path() . '/process',
                    base_path() . '/support',
                    base_path() . '/resource',
                    base_path() . '/.env',
                ],
                glob(base_path() . '/' . config('app.plugin_alias', 'plugin') . '/*/app'),
                glob(base_path() . '/' . config('app.plugin_alias', 'plugin') . '/*/config'),
                glob(base_path() . '/' . config('app.plugin_alias', 'plugin') . '/*/autoload'),
                glob(base_path() . '/' . config('app.plugin_alias', 'plugin') . '/*/support'),
                glob(base_path() . '/' . config('app.plugin_alias', 'plugin') . '/*/resource'),
                glob(base_path() . '/' . config('app.plugin_alias', 'plugin') . '/*/api')
            ),
            'monitorExtensions' => [
                'php', 'phtml', 'html', 'htm', 'env', 'zconf', 'json'
            ],
            'options' => [
                'enable_file_monitor' =>
                    is_unix() && !is_phar()
                    && env('PROCESS_FILE_MONITOR', true)
                    && !localzet\Server::$daemonize,
                'enable_memory_monitor' => is_unix() && !is_phar(),
            ]
        ]
    ]
];
