<?php

$base_path = defined('BASE_PATH') ? BASE_PATH : (Composer\InstalledVersions::getRootPackage()['install_path'] ?? null);

return [
    'enable' => true,

    'build' => [
        // Для PHAR
        'input_dir' => $base_path,
        'output_dir' => $base_path . DIRECTORY_SEPARATOR . 'build',

        'exclude_pattern' => '#^(?!.*(composer.json|/.github/|/.idea/|/.git/|/.setting/|/runtime/|/vendor-bin/|/build/))(.*)$#',
        'exclude_files' => [
            '.env', 'LICENSE', 'composer.json', 'composer.lock', 'triangle.phar', 'triangle'
        ],

        'phar_alias' => 'triangle',
        'phar_filename' => 'triangle.phar',
        'phar_stub' => 'master', // Файл для require. Относительный путь, от корня `input_dir`

        'signature_algorithm' => Phar::SHA256, // Phar::MD5, Phar::SHA1, Phar::SHA256, Phar::SHA512, Phar::OPENSSL.
        'private_key_file' => '', // Для Phar::OPENSSL

        // Для бинарной сборки:
        'php_version' => 8.3,
        'php_ini' => 'memory_limit = 256M',

        'bin_filename' => 'triangle',
    ],
];