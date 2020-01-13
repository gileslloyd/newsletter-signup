<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->headers->get('x-api-key') !== getenv('API_KEY')) {
            $response = new Response();
            $response->setStatusCode(401);

            return $response;
        }

        return $next($request);
    }
}
