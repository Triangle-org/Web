<?php

namespace app\middleware;

use Throwable;
use Triangle\Engine\Http\{Request, Response};
use Triangle\Engine\Interface\MiddlewareInterface;

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
        // В static.forbidden прописан массив запрещённых частей адреса
        foreach (config('static.forbidden') as $needle) {
            if (str_contains($request->path(), $needle)) {
                return response('Недостаточно прав доступа', 403);
            }
        }

        return $handler($request);
    }
}
