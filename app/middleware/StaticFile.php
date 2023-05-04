<?php

/**
 * @package     Triangle Web
 * @link        https://github.com/Triangle-org
 *
 * @copyright   2018-2023 Localzet Group
 * @license     https://mit-license.org MIT
 */

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

        return $next($request);
    }
}
