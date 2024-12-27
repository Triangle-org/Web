<?php

namespace app\middleware;

use Throwable;
use Triangle\Middleware\MiddlewareInterface;
use Triangle\Request;
use Triangle\Response;

class StaticFile implements MiddlewareInterface
{
    /**
     * @param Request $request
     * @param callable $handler
     * @return Response
     * @throws Throwable
     */
    public function process($request, callable $handler): Response
    {
        return $handler($request);
    }
}
