<?php

namespace App\Http\Middleware;

use Closure;

class HttpsRedirect
{
    public function handle($request, Closure $next)
    {
        if (!$request->secure() && config('app.env') == 'production') {
            return redirect()->secure($request->getRequestUri());
        }
        return $next($request);
    }
}
