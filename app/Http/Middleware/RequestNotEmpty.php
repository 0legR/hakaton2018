<?php

namespace App\Http\Middleware;

use Closure;

class RequestNotEmpty
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
        if ($request->all()) {
            return $next($request);
        }
        return response(config('constants.responseStatuses.emptyRequest'), config('constants.responseStatuses.unauthorized'));
    }
}
