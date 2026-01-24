<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfEmailNotVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && 
            !Auth::user()->email_verified_at && 
            !$request->is('verify-email*') && 
            !$request->is('email-verify/*') && 
            !$request->is('logout')) {
            
            // Send verification email if no token exists
            if (empty(Auth::user()->verification_token)) {
                Auth::user()->sendEmailVerificationNotification();
            }
            
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
