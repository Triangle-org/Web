<?php

use Triangle\Engine\App;

/**
 * @param string $path
 * @return string
 */
function app_path(string $path = ''): string
{
    $appPath = App::appPath();
    return path_combine($appPath != '' ? $appPath : (BASE_PATH . DIRECTORY_SEPARATOR . 'app'), $path);
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
 * @param string $path
 * @return string
 */
function public_path(string $path = ''): string
{
//    static $publicPath = '';
//    if (!$publicPath) {
//        $publicPath = config('app.public_path') ?: run_path('public');
//    }
    $publicPath = App::publicPath();
    return path_combine($publicPath != '' ? $publicPath : (config('app.public_path') ?: run_path('public')), $path);
}

/**
 * @param string $path
 * @return string
 */
function config_path(string $path = ''): string
{
    return path_combine(base_path('config'), $path);
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