<?php

return [
    'enable' => env('STATIC_ENABLE', true),
    'middleware' => [
        app\middleware\StaticFile::class,
    ],
    'forbidden' => [
        '/.',
    ]
];
