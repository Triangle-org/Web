<?php

/**
 * @package     Triangle Web
 * @link        https://github.com/Triangle-org
 *
 * @copyright   2018-2024 Localzet Group
 * @license     https://mit-license.org MIT
 */

if (env('APP_SERVICES', false) && class_exists('DI\ContainerBuilder')) {
    // Подключаем сервисы
    // composer require psr/container ^1.1.1 php-di/php-di ^6 doctrine/annotations ^1.14

    $builder = new DI\ContainerBuilder();
    $builder->addDefinitions(config('dependence', []));
    $builder->useAutowiring(true);
    $builder->useAnnotations(true);
    return $builder->build();
} else {
    if (env('APP_SERVICES', false)) {
        localzet\Server::log('Для подключения сервисов необходимо выполнить `composer require psr/container ^1.1.1 php-di/php-di ^6 doctrine/annotations ^1.14`');
    }

    // Простой контейнер
    return new Triangle\Engine\Container;
}