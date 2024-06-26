<?php

namespace app\controller;

use support\{Request, Response};
use Throwable;

class Index
{
    /**
     * response() отобразит responseView() в браузере или responseJson() при запросе
     * @throws Throwable
     */
    public function index(Request $request): Response
    {
        return response('Добро пожаловать в Triangle Web!');
    }

    /**
     * responseJson() отобразит JSON
     */
    public function json(Request $request): Response
    {
        return responseJson('ok');
    }

    /**
     * view() отобразит шаблон
     */
    public function view(Request $request): Response
    {
        return view('index/view', ['name' => 'Triangle']);
    }
}
