<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfRegister
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
        if ($request->is('register')) {
            return redirect('/login');
        }
        return $next($request);
    }
}
