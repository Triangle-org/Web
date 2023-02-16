<?php

/**
 * @package     Triangle Web
 * @link        https://github.com/Triangle-org/Web
 * 
 * @author      Ivan Zorin <creator@localzet.com>
 * @copyright   2018-2023 Localzet Group
 * @license     https://mit-license.org MIT
 */

// Простой контейнер
return new Triangle\Engine\Container;

// Подключаем сервисы
// $builder = new \DI\ContainerBuilder();
// $builder->addDefinitions(config('dependence', []));
// $builder->useAutowiring(true);
// $builder->useAnnotations(true);
// return $builder->build();
