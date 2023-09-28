<?php

/**
 * @package     Triangle Web
 * @link        https://github.com/Triangle-org
 *
 * @copyright   2018-2023 Localzet Group
 * @license     https://mit-license.org MIT
 */

namespace app\middleware;

use Throwable;
use Triangle\Engine\MiddlewareInterface;
use Triangle\Engine\Http\{Response, Request};

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
