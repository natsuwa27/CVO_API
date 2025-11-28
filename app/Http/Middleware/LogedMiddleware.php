<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class LogedMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::guard('web')->check()){
            return redirect('/home')->with('errors', 'Ya has iniciado sesión');
        }
        else{
            return $next($request);
        }
    }
}
