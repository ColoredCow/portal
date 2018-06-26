<?php

namespace App\Http\Middleware;

use Closure;
use App\Facades\Tenant;

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
       if(!Tenant::check()) {
            return redirect()->to(Tenant::getFullUrl());
       }
       
       return $next($request);
    }
}
