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

use support\Translation;
use Triangle\Engine\Config;
use Triangle\Engine\Environment;
use Triangle\Engine\Path;

$install_path = Composer\InstalledVersions::getRootPackage()['install_path'] ?? null;
define('BASE_PATH', str_starts_with($install_path, 'phar://') ? $install_path : realpath($install_path) ?? dirname(__DIR__));


/** TRANSLATION HELPERS */


/**
 * Translation
 * @param string $id
 * @param array $parameters
 * @param string|null $domain
 * @param string|null $locale
 * @return string
 */
function trans(string $id, array $parameters = [], string $domain = null, string $locale = null): string
{
    $res = Translation::trans($id, $parameters, $domain, $locale);
    return $res === '' ? $id : $res;
}

/**
 * Locale
 * @param string|null $locale
 * @return string
 */
function locale(string $locale = null): string
{
    if (!$locale) {
        return Translation::getLocale();
    }
    Translation::setLocale($locale);
    return $locale;
}


/** FORMATS HELPERS */

if (!function_exists('json')) {
    /**
     * @param $value
     * @param int $flags
     * @return string|false
     */
    function json($value, int $flags = JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR): false|string
    {
        return json_encode($value, $flags);
    }
}


/** SYSTEM HELPERS */

if (!function_exists('config')) {
    /**
     * @param string|null $key
     * * @param mixed|null $default
     * @return mixed
     */
    function config(string $key = null, mixed $default = null): mixed
    {
        return Config::get($key, $default);
    }
}

if (!function_exists('env')) {
    /**
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    function env(string $key = null, mixed $default = null): mixed
    {
        return Environment::get($key, $default);
    }
}

if (!function_exists('setEnv')) {
    /**
     * @param array $values
     * @return bool
     */
    function setEnv(array $values): bool
    {
        return Environment::set($values, config('server.env_file', '.env'));
    }
}

/** PATHS HELPERS */

/**
 * return the program execute directory
 * @param string $path
 * @return string
 */
function run_path(string $path = ''): string
{
    static $runPath = '';
    if (!$runPath) {
        $runPath = is_phar() ?
            dirname(Phar::running(false)) :
            base_path();
    }
    return path_combine($runPath, $path);
}

/**
 * @param false|string $path
 * @return string
 */
function base_path(false|string $path = ''): string
{
    return Path::basePath($path);
}

/**
 * @param string $path
 * @return string
 */
function app_path(string $path = ''): string
{
    return Path::appPath($path);
}

/**
 * @param string $path
 * @return string
 */
function config_path(string $path = ''): string
{
    return Path::configPath($path);
}

/**
 * @param string $path
 * @return string
 */
function public_path(string $path = ''): string
{
    return Path::publicPath($path);
}

/**
 * @param string $path
 * @return string
 */
function runtime_path(string $path = ''): string
{
    return Path::runtimePath($path);
}

/**
 * @param string $path
 * @return string
 */
function view_path(string $path = ''): string
{
    return path_combine(app_path('view'), $path);
}

/**
 * Generate paths based on given information
 * @param string $front
 * @param string $back
 * @return string
 */
function path_combine(string $front, string $back): string
{
    return $front . ($back ? (DIRECTORY_SEPARATOR . ltrim($back, DIRECTORY_SEPARATOR)) : $back);
}

/**
 * Get realpath
 * @param string $filePath
 * @return string|false
 */
function get_realpath(string $filePath): string|false
{
    if (str_starts_with($filePath, 'phar://')) {
        return $filePath;
    } else {
        return realpath($filePath);
    }
}

/** DIR HELPERS */

/**
 * Copy dir
 * @param string $source
 * @param string $dest
 * @param bool $overwrite
 * @return void
 */
function copy_dir(string $source, string $dest, bool $overwrite = false): void
{
    if (is_dir($source)) {
        if (!is_dir($dest)) {
            create_dir($dest);
        }
        $files = array_diff(scandir($source), ['.', '..']) ?: [];
        foreach ($files as $file) {
            copy_dir("$source/$file", "$dest/$file", $overwrite);
        }
    } else if (file_exists($source) && ($overwrite || !file_exists($dest))) {
        copy($source, $dest);
    }
}

/**
 * ScanDir.
 * @param string $basePath
 * @param bool $withBasePath
 * @return array
 */
function scan_dir(string $basePath, bool $withBasePath = true): array
{
    if (!is_dir($basePath)) {
        return [];
    }
    $paths = array_diff(scandir($basePath), ['.', '..']) ?: [];
    return $withBasePath ? array_map(fn($path) => $basePath . DIRECTORY_SEPARATOR . $path, $paths) : $paths;
}

/**
 * Remove dir
 * @param string $dir
 * @return bool
 */
function remove_dir(string $dir): bool
{
    if (is_link($dir) || is_file($dir)) {
        return file_exists($dir) && unlink($dir);
    }
    $files = array_diff(scandir($dir), ['.', '..']) ?: [];
    foreach ($files as $file) {
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        is_dir($path) && !is_link($path) ? remove_dir($path) : file_exists($path) && unlink($path);
    }
    return file_exists($dir) && rmdir($dir);
}

/**
 * Create directory
 * @param string $dir
 * @return bool
 */
function create_dir(string $dir): bool
{
    return mkdir($dir, 0777, true);
}

/**
 * Rename directory
 * @param string $oldName
 * @param string $newName
 * @return bool
 */
function rename_dir(string $oldName, string $newName): bool
{
    return rename($oldName, $newName);
}

/**
 * @return bool
 */
function is_phar(): bool
{
    return class_exists(Phar::class, false) && Phar::running();
}

/**
 * Генерация ID
 *
 * @return string
 */
function generateId(): string
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}
