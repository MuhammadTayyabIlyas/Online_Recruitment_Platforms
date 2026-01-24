<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequireEmailVerification
{
    /**
     * Routes that should be excluded from email verification requirement.
     *
     * @var array
     */
    protected $except = [
        'verify-email',
        'email-verify/*',
        'logout',
        'login',
        'register',
        'forgot-password',
        'reset-password/*',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip for guest users and certain routes
        if (!Auth::check() || $this->inExceptArray($request)) {
            return $next($request);
        }

        $user = Auth::user();

        // Check if user is verified
        if (!$user->hasVerifiedEmail()) {
            // Send verification email if not sent yet
            if (empty($user->verification_token)) {
                $user->sendEmailVerificationNotification();
            }

            // Redirect to verification notice
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }

    /**
     * Determine if the request has a URI that should pass through.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->is($except) || $request->routeIs($except)) {
                return true;
            }
        }

        return false;
    }
}
