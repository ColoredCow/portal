<?php

namespace App\Http\Middleware;

use App\Facades\Tenant;
use Closure;

class TenantMiddleware
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
        if (app()->environment('testing')) {
            return $next($request);
        }

        if (!Tenant::check()) {
            return redirect()->to(Tenant::getFullUrl());
        }

        return $next($request);
    }
}
