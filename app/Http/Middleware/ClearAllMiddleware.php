<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Cookie;

class ClearAllMiddleware
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
        // Clear session
        Session::flush();

        // Clear cache
        Cache::flush();

        // Clear cookies
        $response = $next($request);
        foreach ($request->cookies as $key => $value) {
            $response->headers->setCookie(new Cookie($key, '', time() - 3600));
        }

        return $response;
    }
}
