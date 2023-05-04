<?php

/**
 * @package     Triangle Web
 * @link        https://github.com/Triangle-org
 *
 * @copyright   2018-2023 Localzet Group
 * @license     https://mit-license.org MIT
 */

namespace app\controller;

use support\Request;

class Index
{
    /**
     * response() отобразит responseView() в браузере или responseJson() при запросе
     */
    public function index(Request $request)
    {
        return response('hello FrameX');
    }

    /**
     * responseJson() отобразит JSON
     */
    public function json(Request $request)
    {
        return responseJson('ok');
    }

    /**
     * view() отобразит шаблон
     */
    public function view(Request $request)
    {
        return view('index/view', ['name' => 'FrameX']);
    }
}
