<?php

namespace app\middleware;

use Triangle\Engine\MiddlewareInterface;
use Triangle\Engine\Http\Response;
use Triangle\Engine\Http\Request;

/**
 * Class StaticFile
 */
class StaticFile implements MiddlewareInterface
{
    public function process(Request $request, callable $next): Response
    {
        // В static.forbidden прописан массив запрещённых частей адреса
        foreach (config('static.forbidden') as $needle) {
            if (strpos($request->path(), $needle) !== false) {
                return response('Недостаточно прав доступа', 403);
            }
        }

        /** @var Response $response */
        $response = $next($request);

        if (config('plugin.framex.cors.app.enable', false) === true) {
            $response->withHeaders(config('plugin.framex.cors.app.headers', []));
        }
        return $response;
    }
}
