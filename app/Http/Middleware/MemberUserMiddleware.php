<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->get('role_id') == 11 && session()->get('status') == 1) {
            return $next($request);
        }elseif (empty(session()->get('role_id'))) {
            return redirect(route('home'))->with('error', 'Please log in first..!');
        }elseif (session()->get('status') !== 1) {
            return redirect(route('member_deactive'));
        }else {
            return redirect(route('home'))->with('error', 'Log in problem detected..!');
        }
    }
}


