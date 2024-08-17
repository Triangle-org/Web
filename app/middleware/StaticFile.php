<?php

namespace app\middleware;

use Throwable;
use Triangle\Http\{Request, Response};
use Triangle\Middleware\MiddlewareInterface;

/**
 * Class StaticFile
 */
class StaticFile implements MiddlewareInterface
{
    /**
     * @param Request $request
     * @param callable $handler
     * @return Response
     * @throws Throwable
     */
    public function process(Request $request, callable $handler): Response
    {
        return $handler($request);
    }
}
