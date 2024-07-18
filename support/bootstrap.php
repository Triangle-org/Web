<?php declare(strict_types=1);

/**
 * @package     Triangle Engine (FrameX Project)
 * @link        https://github.com/Triangle-org/Engine Triangle Engine (v2+)
 * @link        https://github.com/localzet-archive/FrameX-Public FrameX (v1-2)
 *
 * @author      Ivan Zorin <creator@localzet.com>
 * @copyright   Copyright (c) 2023-2024 Triangle Framework Team
 * @license     https://www.gnu.org/licenses/agpl-3.0 GNU Affero General Public License v3.0
 *
 *              This program is free software: you can redistribute it and/or modify
 *              it under the terms of the GNU Affero General Public License as published
 *              by the Free Software Foundation, either version 3 of the License, or
 *              (at your option) any later version.
 *
 *              This program is distributed in the hope that it will be useful,
 *              but WITHOUT ANY WARRANTY; without even the implied warranty of
 *              MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *              GNU Affero General Public License for more details.
 *
 *              You should have received a copy of the GNU Affero General Public License
 *              along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 *              For any questions, please contact <support@localzet.com>
 */

use Triangle\Engine\Autoloader;
use Triangle\Engine\Bootstrap\BootstrapLoader;
use Triangle\Engine\Config;
use Triangle\Engine\Environment;
use Triangle\Engine\Events\EventLoader;
use Triangle\Engine\Middleware\MiddlewareLoader;
use Triangle\Engine\Router;

$server = $server ?? null;

// Установка обработчика ошибок
set_error_handler(fn($level, $message, $file = '', $line = 0) => (error_reporting() & $level) ? throw new ErrorException($message, 0, $level, $file, $line) : true);

// Регистрация функции завершения работы
if ($server) {
    register_shutdown_function(fn($start_time) => (time() - $start_time <= 1) ? sleep(1) : true, time());
}

// Загрузка переменных окружения из файла .env
Environment::loadAll();

// Очистка конфигурации
Config::clear();
Config::loadAll(['route']);

// Установка часового пояса по умолчанию
date_default_timezone_set(config('app.default_timezone', 'Europe/Moscow'));


/***********************************************
 *              Autoload
 **********************************************/

Autoloader::loadAll();

/***********************************************
 *              Middleware
 **********************************************/

MiddlewareLoader::loadAll();


/***********************************************
 *              Events
 **********************************************/

EventLoader::loadAll();

/***********************************************
 *              Bootstrap
 **********************************************/

BootstrapLoader::loadAll($server);

// Загрузка маршрутов из папок конфигурации плагинов
$paths = [config_path()];
foreach (scan_dir(base_path('plugin')) as $path) {
    if (is_dir($path = "$path/config")) {
        $paths[] = $path;
    }
}
Router::load($paths);
