<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Check if user is authenticated
        if (!$request->user()) {
            Log::warning('Unauthenticated user attempted to access role-protected route', [
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated. Please log in to access this resource.',
                ], 401);
            }

            return redirect()->route('login')
                ->with('error', 'Please log in to access this page.');
        }

        // Check if user is active
        if (!$request->user()->is_active) {
            Log::warning('Inactive user attempted to access role-protected route', [
                'user_id' => $request->user()->id,
                'email' => $request->user()->email,
                'url' => $request->fullUrl(),
            ]);

            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your account has been deactivated. Please contact support.',
                ], 403);
            }

            return redirect()->route('login')
                ->with('error', 'Your account has been deactivated. Please contact support.');
        }

        // Check if user has any of the required roles
        if (!$request->user()->hasAnyRole($roles)) {
            Log::warning('User attempted to access unauthorized role-protected route', [
                'user_id' => $request->user()->id,
                'email' => $request->user()->email,
                'required_roles' => $roles,
                'user_roles' => $request->user()->getRoleNames()->toArray(),
                'url' => $request->fullUrl(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to access this resource.',
                    'required_roles' => $roles,
                ], 403);
            }

            // Redirect to home to avoid loops, not back()
            return redirect('/')
                ->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
