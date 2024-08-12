<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeveloperMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (session()->get('email') == 'pritomguha62@gmail.com'){
            return $next($request);
        }elseif (session()->get('email') == 'holy.it01@gmail.com'){
            return $next($request);
        // }elseif (session()->get('email') == 'mukaddasluvan@gmail.com'){
        //     return $next($request);
        // }elseif (session()->get('email') == 'priyaakter01749@gmail.com'){
        //     return $next($request);
        }else{
            return redirect()->back();
        }

    }
}


