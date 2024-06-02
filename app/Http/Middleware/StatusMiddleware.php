<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->get('role_id') == 11 && session()->get('status') == 1) {
            return redirect(route('member.dashboard'));
        }elseif (session()->has('role_id') && session()->get('status') == 1) {
            return redirect(route('admin.dashboard'));

        }elseif (session()->get('status') !== 1) {
            return $next($request);
        }else {
            return redirect(route('home'));
        }
    }
}


