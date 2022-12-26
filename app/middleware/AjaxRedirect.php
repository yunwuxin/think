<?php

namespace app\middleware;

use Closure;
use think\Request;
use think\Response;
use think\response\Redirect;

class AjaxRedirect
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);

        if ($response instanceof Redirect && request()->type() == 'json') {
            $response = json(['location' => $response->getData()], 201);
        }

        return $response;
    }
}
