<?php

namespace app\middleware;

use Throwable;
use Triangle\Http\{Request, Response};
use Triangle\Middleware\MiddlewareInterface;

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
