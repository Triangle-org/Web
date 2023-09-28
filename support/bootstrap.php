<?php

/**
 * @package     Triangle Engine (FrameX Project)
 * @link        https://github.com/localzet/FrameX      FrameX Project v1-2
 * @link        https://github.com/Triangle-org/Engine  Triangle Engine v2+
 *
 * @author      Ivan Zorin <creator@localzet.com>
 * @copyright   Copyright (c) 2018-2023 Localzet Group
 * @license     https://www.gnu.org/licenses/agpl AGPL-3.0 license
 *
 *              This program is free software: you can redistribute it and/or modify
 *              it under the terms of the GNU Affero General Public License as
 *              published by the Free Software Foundation, either version 3 of the
 *              License, or (at your option) any later version.
 *
 *              This program is distributed in the hope that it will be useful,
 *              but WITHOUT ANY WARRANTY; without even the implied warranty of
 *              MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *              GNU Affero General Public License for more details.
 *
 *              You should have received a copy of the GNU Affero General Public License
 *              along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

use Dotenv\Dotenv;
use support\Container;
use support\Event;
use support\Log;
use Triangle\Engine\Bootstrap;
use Triangle\Engine\Config;
use Triangle\Engine\Middleware;
use Triangle\Engine\Route;
use Triangle\Engine\Util;

$server = $server ?? null;

// Установка обработчика ошибок
set_error_handler(
/**
 * @throws ErrorException
 */
    function ($level, $message, $file = '', $line = 0) {
        if (error_reporting() & $level) {
            throw new ErrorException($message, 0, $level, $file, $line);
        }
    }
);

// Регистрация функции завершения работы
if ($server) {
    register_shutdown_function(
        function ($start_time) {
            if (time() - $start_time <= 1) {
                sleep(1);
            }
        },
        time()
    );
}

// Загрузка переменных окружения из файла .env
if (class_exists('Dotenv\Dotenv') && file_exists(base_path() . '/.env')) {
    if (method_exists('Dotenv\Dotenv', 'createUnsafeMutable')) {
        Dotenv::createUnsafeMutable(base_path())->load();
    } else {
        Dotenv::createMutable(base_path())->load();
    }
}

// Очистка конфигурации
Config::clear();
support\App::loadAllConfig(['route']);

// Установка часового пояса по умолчанию
date_default_timezone_set(config('app.default_timezone', 'Europe/Moscow'));


/***********************************************
 *              Autoload
 **********************************************/

// Загрузка файлов автозагрузки системы
foreach (config('autoload.files', []) as $file) {
    include_once $file;
}

// Загрузка файлов автозагрузки из папки autoload
foreach (glob(base_path() . '/autoload/*.php') as $file) {
    include_once($file);
}

// Загрузка файлов автозагрузки из подпапок папки autoload
foreach (glob(base_path() . '/autoload/*/*/*.php') as $file) {
    include_once($file);
}

// Загрузка файлов автозагрузки плагинов
foreach (config('plugin', []) as $firm => $projects) {
    foreach ($projects as $name => $project) {
        if (!is_array($project)) {
            continue;
        }
        foreach ($project['autoload']['files'] ?? [] as $file) {
            include_once $file;
        }
    }
    foreach ($projects['autoload']['files'] ?? [] as $file) {
        include_once $file;
    }
}


/***********************************************
 *              Middleware
 **********************************************/

// Загрузка системных middleware
Middleware::load(config('middleware', []));
Middleware::load(['__static__' => config('static.middleware', [])]);

// Загрузка middleware плагинов
foreach (config('plugin', []) as $firm => $projects) {
    // Middleware плагинов-дополнений
    foreach ($projects as $name => $project) {
        if (!is_array($project) || $name === 'static') {
            continue;
        }
        Middleware::load($project['middleware'] ?? []);
        Middleware::load(['__static__' => config("plugin.$firm.$name.static.middleware", [])]);
    }

    // Middleware плагинов-приложений
    Middleware::load($projects['middleware'] ?? [], $firm);
    Middleware::load(['__static__' => config("plugin.$firm.static.middleware", [])], $firm);

    // Middleware::load($projects['global_middleware'] ?? []);
}


/***********************************************
 *              Events
 **********************************************/

/**
 * Преобразует колбэк(и) в массив колбэков
 *
 * @param mixed $callbacks
 * @return array
 */
function convertCallable($callbacks): array
{
    if (is_array($callbacks)) {
        $callback = array_values($callbacks);
        if (isset($callback[1]) && is_string($callback[0]) && class_exists($callback[0])) {
            return [Container::get($callback[0]), $callback[1]];
        }
    }
    return $callback ?? [];
}

$rawEvents = config('event', []);
$allEvents = [];

// Загрузка событий из плагинов
foreach (config('plugin', []) as $firm => $projects) {
    foreach ($projects as $name => $project) {
        if (is_array($project) && isset($project['event'])) {
            $rawEvents += $project['event'];
        }
    }

    if (isset($projects['event'])) {
        $rawEvents += $projects['event'];
    }
}

// Обработка событий и регистрация обработчиков
foreach ($rawEvents as $eventName => $callbacks) {
    $callbacks = convertCallable($callbacks);
    if (is_callable($callbacks)) {
        $allEvents[$eventName][] = [$callbacks];
        continue;
    }
    ksort($callbacks, SORT_NATURAL);
    foreach ($callbacks as $id => $callback) {
        $callback = convertCallable($callback);
        if (is_callable($callback)) {
            $allEvents[$eventName][$id][] = $callback;
            continue;
        }
        $msg = "Событие: $eventName => " . var_export($callback, true) . " не вызываемый\n";
        echo $msg;
        Log::error($msg);
    }
}

// Регистрация обработчиков событий
foreach ($allEvents as $name => $events) {
    ksort($events, SORT_NATURAL);
    foreach ($events as $callbacks) {
        foreach ($callbacks as $callback) {
            Event::on($name, $callback);
        }
    }
}


/***********************************************
 *              Bootstrap
 **********************************************/

// Запуск системных bootstrap
foreach (config('bootstrap', []) as $className) {
    if (!class_exists($className)) {
        $log = "Warning: Class $className setting in config/bootstrap.php not found\r\n";
        echo $log;
        Log::error($log);
        continue;
    }
    /** @var Bootstrap $className */
    $className::start($server);
}

// Запуск bootstrap плагинов
foreach (config('plugin', []) as $firm => $projects) {
    foreach ($projects as $name => $project) {
        if (!is_array($project)) {
            continue;
        }
        foreach ($project['bootstrap'] ?? [] as $className) {
            if (!class_exists($className::class)) {
                $log = "Warning: Class " . $className::class . " setting in config/plugin/$firm/$name/bootstrap.php not found\r\n";
                echo $log;
                Log::error($log);
                continue;
            }
            /** @var Bootstrap $className */
            $className::start($server);
        }
    }
    foreach ($projects['bootstrap'] ?? [] as $className) {
        if (!class_exists($className::class)) {
            $log = "Warning: Class " . $className::class . " setting in plugin/$firm/config/bootstrap.php not found\r\n";
            echo $log;
            Log::error($log);
            continue;
        }
        /** @var Bootstrap $className */
        $className::start($server);
    }
}

$directory = base_path() . '/plugin';
$paths = [config_path()];

// Загрузка маршрутов из папок конфигурации плагинов
foreach (Util::scanDir($directory) as $path) {
    if (is_dir($path = "$path/config")) {
        $paths[] = $path;
    }
}
Route::load($paths);
