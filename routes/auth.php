<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| These routes handle user authentication for the Job Placement Platform.
| All POST routes are automatically protected by CSRF middleware.
|
*/

// Guest routes - accessible only to unauthenticated users
Route::middleware('guest')->group(function () {

    // Registration routes
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])
        ->name('register');

    Route::post('register', [RegisterController::class, 'register'])
        ->name('register.store');

    // Login routes
    Route::get('login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('login', [LoginController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.store');

    // LinkedIn OAuth routes
    Route::get('auth/linkedin', [\App\Http\Controllers\Auth\LinkedInAuthController::class, 'redirectToLinkedIn'])
        ->name('linkedin.login');

    Route::get('auth/linkedin/callback', [\App\Http\Controllers\Auth\LinkedInAuthController::class, 'handleLinkedInCallback'])
        ->name('linkedin.callback');

    // Password reset request routes
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('password.email');

    // Password reset routes (with token from email)
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('password.update');
});

// Authenticated routes - accessible only to authenticated users
Route::middleware('auth')->group(function () {

    // Logout route (POST only for CSRF protection)
    Route::post('logout', [LoginController::class, 'logout'])
        ->name('logout');

    // Email verification notice page
    Route::get('verify-email', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    // Email verification link handler
    Route::get('verify-email/{id}/{hash}', function ($id, $hash) {
        $user = \App\Models\User::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            throw new \Illuminate\Auth\Access\AuthorizationException;
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new \Illuminate\Auth\Events\Verified($user));
        }

        // Auto-login and redirect to dashboard
        auth()->login($user);
        return redirect()->route('dashboard')->with('success', 'Email verified successfully! Your account is now fully activated.');
    })->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

    // Resend verification email
    Route::post('email/verification-notification', function () {
        request()->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware('throttle:6,1')->name('verification.send');

    // Custom email verification - send verification email
    Route::post('send-verification-email', [EmailVerificationController::class, 'sendVerificationEmail'])
        ->middleware('throttle:6,1')
        ->name('verification.custom.send');

    // Custom email verification - resend verification email
    Route::post('resend-verification', [EmailVerificationController::class, 'resendVerification'])
        ->middleware('throttle:6,1')
        ->name('verification.custom.resend');
});

// Custom email verification route - verify email with token (public route)
Route::get('email-verify/{token}', [EmailVerificationController::class, 'verifyEmail'])
    ->name('verification.custom.verify');

/*
|--------------------------------------------------------------------------
| Verified User Routes
|--------------------------------------------------------------------------
|
| Routes below require both authentication and email verification.
|
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard routes will be added here
});
