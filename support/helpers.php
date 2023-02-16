<?php

/**
 * @package     Triangle Web
 * @link        https://github.com/Triangle-org/Web
 * 
 * @author      Ivan Zorin <creator@localzet.com>
 * @copyright   2018-2023 Localzet Group
 * @license     https://mit-license.org MIT
 */

use support\Db;
use support\Request;
use support\Response;
use support\Container;
use support\Translation;
use support\database\MySQL;
use support\view\Blade;
use support\view\Raw;
use support\view\ThinkPHP;
use support\view\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Triangle\Engine\App;
use Triangle\Engine\Config;
use Triangle\Engine\Route;
use localzet\Server\Server;


define('BASE_PATH', dirname(__DIR__));

/** 
 * @param string|null $connection
 * @param string|null $collection
 * @return \support\mongodb\Connection|\support\mongodb\Query\Builder
 */
function MongoDB(string $connection = NULL, string $collection = NULL)
{
    if (empty($connection)) {
        $connection = config('database.default', 'default');
    }

    if (!in_array($connection, array_keys(config('database.connections'))) || config("database.connections.$connection.driver") != 'mongodb') {
        throw new Exception("MongoDB соединения не существует в конфигурации");
    }

    /** @var \support\mongodb\Connection $db */
    $db = Db::connection($connection);
    return empty($collection) ? $db : $db->collection($collection);
}

/** 
 * @param string|null $connection
 * @return \support\database\MySQL
 */
function MySQL(string $connection = NULL)
{
    if (empty($connection)) {
        $connection = config('database.default', 'default');
    }

    if (!in_array($connection, array_keys(config('database.connections'))) || config("database.connections.$connection.driver") != 'mysql') {
        throw new Exception("MySQL соединения не существует в конфигурации");
    }

    $db = new MySQL();
    return $db->connection($connection);
}

/**
 * return the program execute directory
 * @param string $path
 * @return string
 */
function run_path(string $path = ''): string
{
    static $runPath = '';
    if (!$runPath) {
        $runPath = is_phar() ? dirname(Phar::running(false)) : BASE_PATH;
    }
    return path_combine($runPath, $path);
}

/**
 * @param string|false $path
 * @return string
 */
function base_path($path = ''): string
{
    if (false === $path) {
        return run_path();
    }
    return path_combine(BASE_PATH, $path);
}

/**
 * @param string $path
 * @return string
 */
function app_path(string $path = ''): string
{
    return path_combine(BASE_PATH . DIRECTORY_SEPARATOR . 'app', $path);
}

/**
 * @param string $path
 * @return string
 */
function public_path(string $path = ''): string
{
    static $publicPath = '';
    if (!$publicPath) {
        $publicPath = config('app.public_path') ?: run_path('public');
    }
    return path_combine($publicPath, $path);
}

/**
 * @param string $path
 * @return string
 */
function config_path(string $path = ''): string
{
    return path_combine(BASE_PATH . DIRECTORY_SEPARATOR . 'config', $path);
}

/**
 * @param string $path
 * @return string
 */
function runtime_path(string $path = ''): string
{
    static $runtimePath = '';
    if (!$runtimePath) {
        $runtimePath = config('app.runtime_path') ?: run_path('runtime');
    }
    return path_combine($runtimePath, $path);
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
 * @param int $status
 * @param array $headers
 * @param string $body
 * @return Response
 */
function response(string $body = '', int $status = 200, array $headers = [], $http_status = false, $onlyJson = false): Response
{
    $headers = $headers;
    $body = [
        'debug' => config('app.debug'),
        'status' => $status,
        'data' => $body
    ];
    $status = ($http_status === true) ? $status : 200;

    if (request()->expectsJson() || $onlyJson) {
        return responseJson($body, $status, $headers);
    } else {
        return responseView($body, $status, $headers);
    }
}

/**
 * @param string $blob
 * @return Response
 */
function responseBlob($blob, $type = 'image/png')
{
    return new Response(
        200,
        [
            'Content-Type' => $type,
            'Content-Length' => strlen($blob)
        ],
        $blob
    );
}

/**
 * @param $data
 * @param int $status
 * @param array $headers
 * @param int $options
 * @return Response
 */
function responseJson($data, $status = 200, $headers = [], $options = JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR)
{
    $headers = ['Content-Type' => 'application/json'] + $headers;
    $body = json($data, $options);

    return new Response($status, $headers, $body);
}

/**
 * @param $data
 * @param int $status
 * @param array $headers
 * @return Response
 */
function responseView(array $data, $status = null, $headers = [])
{
    if (($status == 200 || $status == 500) && (!empty($data['status']) && is_numeric($data['status']))) {
        $status = ($data['status'] >= 300) ? $data['status'] : $status + $data['status'];
    }
    $template = ($status == 200) ? 'success' : 'error';

    return new Response($status, $headers, Raw::renderSys($template, $data));
}

/**
 * @param $value
 * @param int $flags
 * @return string|false
 */
function json($value, int $flags = JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR)
{
    return json_encode($value, $flags);
}

/**
 * @param $xml
 * @return Response
 */
function xml($xml): Response
{
    if ($xml instanceof SimpleXMLElement) {
        $xml = $xml->asXML();
    }
    return new Response(200, ['Content-Type' => 'text/xml'], $xml);
}

/**
 * @param $data
 * @param string $callbackName
 * @return Response
 */
function jsonp($data, string $callbackName = 'callback'): Response
{
    if (!is_scalar($data) && null !== $data) {
        $data = json_encode($data);
    }
    return new Response(200, [], "$callbackName($data)");
}

/**
 * @param string $location
 * @param int $status
 * @param array $headers
 * @return Response
 */
function redirect(string $location, int $status = 302, array $headers = []): Response
{
    $response = new Response($status, ['Location' => $location]);
    if (!empty($headers)) {
        $response->withHeaders($headers);
    }
    return $response;
}

/**
 * @param string $template
 * @param array $vars
 * @param string|null $app
 * @param int $http_code
 * @return Response
 */
function view(string $template, array $vars = [], string $app = null, int $http_code = 200): Response
{
    $request = \request();
    $plugin = $request->plugin ?? '';
    $handler = config($plugin ? "plugin.$plugin.view.handler" : 'view.handler');
    return new Response($http_code, [], $handler::render($template, $vars, $app));
}

/**
 * @param string $template
 * @param array $vars
 * @param string|null $app
 * @return Response
 * @throws Throwable
 */
function raw_view(string $template, array $vars = [], string $app = null): Response
{
    return new Response(200, [], Raw::render($template, $vars, $app));
}

/**
 * @param string $template
 * @param array $vars
 * @param string|null $app
 * @return Response
 */
function blade_view(string $template, array $vars = [], string $app = null): Response
{
    return new Response(200, [], Blade::render($template, $vars, $app));
}

/**
 * @param string $template
 * @param array $vars
 * @param string|null $app
 * @return Response
 */
function think_view(string $template, array $vars = [], string $app = null): Response
{
    return new Response(200, [], ThinkPHP::render($template, $vars, $app));
}

/**
 * @param string $template
 * @param array $vars
 * @param string|null $app
 * @return Response
 * @throws LoaderError
 * @throws RuntimeError
 * @throws SyntaxError
 */
function twig_view(string $template, array $vars = [], string $app = null): Response
{
    return new Response(200, [], Twig::render($template, $vars, $app));
}

/**
 * @return \Triangle\Engine\Http\Request|Request|null
 */
function request()
{
    return App::request();
}

/**
 * @param string|null $key
 * @param $default
 * @return array|mixed|null
 */
function config(string $key = null, $default = null)
{
    return Config::get($key, $default);
}

/**
 * @param string $name
 * @param ...$parameters
 * @return string
 */
function route(string $name, ...$parameters): string
{
    $route = Route::getByName($name);
    if (!$route) {
        return '';
    }

    if (!$parameters) {
        return $route->url();
    }

    if (is_array(current($parameters))) {
        $parameters = current($parameters);
    }

    return $route->url($parameters);
}

/**
 * @param mixed $key
 * @param mixed $default
 * @return mixed
 */
function session($key = null, $default = null)
{
    $session = \request()->session();
    if (null === $key) {
        return $session;
    }
    if (is_array($key)) {
        $session->put($key);
        return null;
    }
    if (strpos($key, '.')) {
        $keyArray = explode('.', $key);
        $value = $session->all();
        foreach ($keyArray as $index) {
            if (!isset($value[$index])) {
                return $default;
            }
            $value = $value[$index];
        }
        return $value;
    }
    return $session->get($key, $default);
}

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

/**
 * 404 not found
 *
 * @return Response
 */
function not_found(): Response
{
    return response('Ничего не найдено', 404);
}

/**
 * Copy dir
 * @param string $source
 * @param string $dest
 * @param bool $overwrite
 * @return void
 */
function copy_dir(string $source, string $dest, bool $overwrite = false)
{
    if (is_dir($source)) {
        if (!is_dir($dest)) {
            mkdir($dest);
        }
        $files = scandir($source);
        foreach ($files as $file) {
            if ($file !== "." && $file !== "..") {
                copy_dir("$source/$file", "$dest/$file");
            }
        }
    } else if (file_exists($source) && ($overwrite || !file_exists($dest))) {
        copy($source, $dest);
    }
}

/**
 * Remove dir
 * @param string $dir
 * @return bool
 */
function remove_dir(string $dir): bool
{
    if (is_link($dir) || is_file($dir)) {
        return unlink($dir);
    }
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file") && !is_link($dir)) ? remove_dir("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}

/**
 * @param $server
 * @param $class
 */
function server_bind($server, $class)
{
    $callbackMap = [
        'onConnect',
        'onMessage',
        'onClose',
        'onError',
        'onBufferFull',
        'onBufferDrain',
        'onServerStop',
        'onWebSocketConnect'
    ];
    foreach ($callbackMap as $name) {
        if (method_exists($class, $name)) {
            $server->$name = [$class, $name];
        }
    }
    if (method_exists($class, 'onServerStart')) {
        call_user_func([$class, 'onServerStart'], $server);
    }
}

/**
 * @param $processName
 * @param $config
 * @return void
 */
function server_start($processName, $config)
{
    $server = new Server($config['listen'] ?? null, $config['context'] ?? []);
    $propertyMap = [
        'count',
        'user',
        'group',
        'reloadable',
        'reusePort',
        'transport',
        'protocol',
    ];
    $server->name = $processName;
    foreach ($propertyMap as $property) {
        if (isset($config[$property])) {
            $server->$property = $config[$property];
        }
    }

    $server->onServerStart = function ($server) use ($config) {
        require_once base_path('/support/bootstrap.php');

        // foreach ($config['services'] ?? [] as $server) {
        //     if (!class_exists($server['handler'])) {
        //         echo "process error: class {$server['handler']} not exists\r\n";
        //         continue;
        //     }
        //     $listen = new Server($server['listen'] ?? null, $server['context'] ?? []);
        //     if (isset($server['listen'])) {
        //         echo "listen: {$server['listen']}\n";
        //     }
        //     $instance = Container::make($server['handler'], $server['constructor'] ?? []);
        //     server_bind($listen, $instance);
        //     $listen->listen();
        // }

        if (isset($config['handler'])) {
            if (!class_exists($config['handler'])) {
                echo "process error: class {$config['handler']} not exists\r\n";
                return;
            }

            $instance = Container::make($config['handler'], $config['constructor'] ?? []);
            server_bind($server, $instance);
        }
    };
}

/**
 * Get realpath
 * @param string $filePath
 * @return string
 */
function get_realpath(string $filePath): string
{
    if (strpos($filePath, 'phar://') === 0) {
        return $filePath;
    } else {
        return realpath($filePath);
    }
}

/**
 * @return bool
 */
function is_phar(): bool
{
    return class_exists(Phar::class, false) && Phar::running();
}

/**
 * @return int
 */
function cpu_count(): int
{
    // Винда опять не поддерживает это
    if (DIRECTORY_SEPARATOR === '\\') {
        return 1;
    }
    $count = 4;
    if (is_callable('shell_exec')) {
        if (strtolower(PHP_OS) === 'darwin') {
            $count = (int)shell_exec('sysctl -n machdep.cpu.core_count');
        } else {
            $count = (int)shell_exec('nproc');
        }
    }
    return $count > 0 ? $count : 4;
}

/**
 * Получение IP-адреса
 *
 * @return string IP-адрес
 */
function getRequestIp()
{
    if (!empty(request()->header('x-real-ip')) && validate_ip(request()->header('x-real-ip'))) {
        $ip = request()->header('x-real-ip');
    } elseif (!empty(request()->header('x-forwarded-for')) && validate_ip(request()->header('x-forwarded-for'))) {
        $ip = request()->header('x-forwarded-for');
    } elseif (!empty(request()->header('client-ip')) && validate_ip(request()->header('client-ip'))) {
        $ip = request()->header('client-ip');
    } elseif (!empty(request()->header('remote-addr')) && validate_ip(request()->header('remote-addr'))) {
        $ip = request()->header('remote-addr');
    } else {
        $ip = null;
    }

    return $ip;
}

/**
 * Валидация IP-адреса
 *
 * @param string $ip IP-адрес
 *
 * @return boolean
 */
function validate_ip(string $ip)
{
    if (strtolower($ip) === 'unknown')
        return false;
    $ip = ip2long($ip);
    if ($ip !== false && $ip !== -1) {
        $ip = sprintf('%u', $ip);
        if ($ip >= 0 && $ip <= 50331647)
            return false;
        if ($ip >= 167772160 && $ip <= 184549375)
            return false;
        if ($ip >= 2130706432 && $ip <= 2147483647)
            return false;
        if ($ip >= 2851995648 && $ip <= 2852061183)
            return false;
        if ($ip >= 2886729728 && $ip <= 2887778303)
            return false;
        if ($ip >= 3221225984 && $ip <= 3221226239)
            return false;
        if ($ip >= 3232235520 && $ip <= 3232301055)
            return false;
        if ($ip >= 4294967040)
            return false;
    }
    return true;
}

/**
 * Получение данных
 *
 * @return array(
 *      'userAgent',
 *      'name',
 *      'version',
 *      'platform'
 *  )
 */
function getBrowser()
{
    $u_agent = request()->header('user-agent');
    // echo $u_agent;
    $bname = 'Неизвестно';
    $ub = "Неизвестно";
    $platform = 'Неизвестно';
    $version = "";

    if (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    } elseif (preg_match('/iphone|IPhone/i', $u_agent)) {
        $platform = 'IPhone Web';
    } elseif (preg_match('/android|Android/i', $u_agent)) {
        $platform = 'Android Web';
    } else if (preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $u_agent)) {
        $platform = 'Mobile';
    } else if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }

    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    preg_match_all($pattern, $u_agent, $matches);

    // if (!empty($matches['browser'])) {
    $i = count($matches['browser']);
    // }
    // if (!empty($matches['version'])) {
    if ($i != 1) {
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }
    // }

    if ($version == null || $version == "") {
        $version = "?";
    }
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform
    );
}

// class Methods

/**
 * Генерация ID
 *
 * @return string
 */
function generateId()
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

/**
 * Окончание по числу
 *
 * @param int $num Количество
 * @param string $nominative 1
 * @param string $genitive_singular 2, 3, 4
 * @param string $genitive_plural 5, 6, 7, 8, 9, 0
 *
 * @return string
 */
function getNumEnding(int $num, string $nominative, string $genitive_singular, string $genitive_plural)
{
    if ($num > 10 && (floor(($num % 100) / 10)) == 1) {
        return $genitive_plural;
    } else {
        switch ($num % 10) {
            case 1:
                return $nominative; // 1 день
            case 2:
            case 3:
            case 4:
                return $genitive_singular; // 2, 3, 4 дня
            case 5:
            case 6:
            case 7:
            case 8:
            case 9:
            case 0:
                return $genitive_plural; // 5, 6, 7, 8, 9, 0 дней
        }
    }
}
