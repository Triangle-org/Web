<?php

namespace app\controller;

use support\Request;
use Throwable;
use Triangle\Http\Response;

class Index
{
    /**
     * @param Request $request
     * @return Response
     * @throws Throwable
     */
    public function index(Request $request): Response
    {
        return response('Добро пожаловать в Triangle Web!');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function json(Request $request): Response
    {
        return responseJson('ok');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function view(Request $request): Response
    {
        return view('index/view', ['name' => 'Triangle']);
    }
}
