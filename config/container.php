<?php

/**
 * @package     Triangle Web
 * @link        https://github.com/Triangle-org
 *
 * @copyright   2018-2024 Localzet Group
 * @license     https://mit-license.org MIT
 */

// Простой контейнер
return new Triangle\Engine\Container;

// Подключаем сервисы
// composer require psr/container ^1.1.1 php-di/php-di ^6 doctrine/annotations ^1.14

//use DI\ContainerBuilder;
//
//$builder = new ContainerBuilder();
//$builder->addDefinitions(config('dependence', []));
//$builder->useAutowiring(true);
//$builder->useAnnotations(true);
//return $builder->build();
