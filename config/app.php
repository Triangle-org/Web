<?php

/**
 * @package     Triangle Web
 * @link        https://github.com/Triangle-org
 *
 * @copyright   2018-2023 Localzet Group
 * @license     https://mit-license.org MIT
 */

use localzet\Server\Server;
use support\Request;

return [
    'debug' => true,
    'error_reporting' => E_ALL,
    'default_timezone' => 'Europe/Moscow',
    'request_class' => Request::class,
    'public_path' => base_path() . DIRECTORY_SEPARATOR . 'public',
    'runtime_path' => base_path(false) . DIRECTORY_SEPARATOR . 'runtime',
    'controller_suffix' => '',
    'controller_reuse' => true,

    // 'domain' => 'example.com',
    // 'src' => 'https://src.example.com',

    // 'name' => 'Название сайта',
    // 'description' => 'Описание',
    // 'keywords' => 'Ключевые слова',
    // 'viewport' => '',

    // 'logo' => 'URL логотипа',
    // 'og_image' => 'URL Изображения OpenGraph',

    // 'owner' => 'FirstName LastName (Nickname) <email>',
    // 'designer' => 'FirstName LastName (Nickname) <email>',
    // 'author' => 'FirstName LastName (Nickname) <email>',
    // 'copyright' => 'Company',
    // 'reply_to' => 'Email',

    'headers' => [
        'Content-Language' => 'ru',

        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Credentials' => 'true',
        'Access-Control-Allow-Methods' => '*',
        'Access-Control-Allow-Headers' => '*',

        'Server' => 'Localzet Server ' . Server::VERSION,
    ],
];
