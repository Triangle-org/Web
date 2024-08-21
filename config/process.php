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
                glob(base_path() . '/plugin/*/app'),
                glob(base_path() . '/plugin/*/autoload'),
                glob(base_path() . '/plugin/*/config'),
                glob(base_path() . '/plugin/*/api')
            ),
            'monitorExtensions' => [
                'php', 'phtml', 'html', 'htm', 'env', 'zconf', 'json'
            ],
            'options' => [
                'enable_file_monitor' => DIRECTORY_SEPARATOR === '/'
                    && env('PROCESS_FILE_MONITOR', true)
                    && !localzet\Server::$daemonize,
                'enable_memory_monitor' => DIRECTORY_SEPARATOR === '/',
            ]
        ]
    ]
];
