<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email:rfc,dns'],
        ]);

        // Rate limiting for password reset requests
        $key = 'password-reset:' . $request->ip() . ':' . $request->input('email');

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);

            Log::warning('Password reset rate limit exceeded', [
                'email' => $request->input('email'),
                'ip' => $request->ip(),
            ]);

            throw ValidationException::withMessages([
                'email' => ["Too many password reset attempts. Please try again in {$seconds} seconds."],
            ]);
        }

        RateLimiter::hit($key, 3600); // 1 hour decay

        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Log the password reset request
        if ($status === Password::RESET_LINK_SENT) {
            Log::info('Password reset link sent', [
                'email' => $request->input('email'),
                'ip' => $request->ip(),
            ]);
        }

        // Always return success message to prevent email enumeration
        return back()->with('status', __('If an account exists with this email, you will receive a password reset link shortly.'));
    }
}
