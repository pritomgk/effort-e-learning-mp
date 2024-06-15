<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailVerifyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->get('email_verified') == 0 && session()->get('role_id') == 11) {
            return redirect()->route('member.token_verify');
        }elseif (session()->get('email_verified') == 0 && session()->get('role_id') !== 11) {
            return redirect()->route('admin_user.token_verify');
        }else {
            return $next($request);
        }
    }
}


