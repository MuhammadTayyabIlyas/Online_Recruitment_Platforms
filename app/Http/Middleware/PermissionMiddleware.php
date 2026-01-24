<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$permissions
     */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        // Check if user is authenticated
        if (!$request->user()) {
            Log::warning('Unauthenticated user attempted to access permission-protected route', [
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
            Log::warning('Inactive user attempted to access permission-protected route', [
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

        // Check if user has any of the required permissions
        if (!$request->user()->hasAnyPermission($permissions)) {
            Log::warning('User attempted to access unauthorized permission-protected route', [
                'user_id' => $request->user()->id,
                'email' => $request->user()->email,
                'required_permissions' => $permissions,
                'user_permissions' => $request->user()->getAllPermissions()->pluck('name')->toArray(),
                'url' => $request->fullUrl(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to perform this action.',
                    'required_permissions' => $permissions,
                ], 403);
            }

            return redirect()->back()
                ->with('error', 'You do not have permission to perform this action.');
        }

        return $next($request);
    }
}
