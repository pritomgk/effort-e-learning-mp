<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPannelCommonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if (session()->get('role_id') == 1 && session()->get('status') == 1){
            return $next($request);
        }elseif (session()->get('role_id') == 2 && session()->get('status') == 1) {
            return $next($request);
        }elseif (session()->get('role_id') == 3 && session()->get('status') == 1) {
            return $next($request);
        }elseif (session()->get('role_id') == 4 && session()->get('status') == 1) {
            return $next($request);
        }elseif (session()->get('role_id') == 5 && session()->get('status') == 1) {
            return $next($request);
        }elseif (session()->get('role_id') == 6 && session()->get('status') == 1) {
            return $next($request);
        }elseif (session()->get('role_id') == 7 && session()->get('status') == 1) {
            return $next($request);
        }elseif (session()->get('role_id') == 8 && session()->get('status') == 1) {
            return $next($request);
        }elseif (session()->get('role_id') == 9 && session()->get('status') == 1) {
            return $next($request);
        }elseif (session()->get('role_id') == 10 && session()->get('status') == 1) {
            return $next($request);
        }elseif (empty(session()->get('role_id'))) {
            return redirect(route('home'))->with('error', 'Please log in first..!');
        }elseif (session()->get('status') !== 1) {
            return redirect(route('admin_deactive'));
        }else {
            return redirect(route('home'))->with('error', 'Log in problem detected..!');
        }
        
    }
}


