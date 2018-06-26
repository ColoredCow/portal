<?php

namespace App\Http\Middleware;

use Closure;
use App\Facades\Domain;

class DomainAuthenticationMiddleware
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
       if(!Domain::check()) {
            return redirect()->to(Domain::getFullUrl());
       }
       
       return $next($request);
    }
}
