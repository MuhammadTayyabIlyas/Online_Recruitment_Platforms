<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Allowed user types for public registration.
     * Admin accounts should be created through a separate secure process.
     */
    protected const ALLOWED_USER_TYPES = ['employer', 'job_seeker', 'student', 'educational_institution'];

    /**
     * Show the registration form.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request): RedirectResponse
    {
        // Rate limiting for registration
        $key = 'register:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Too many registration attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        RateLimiter::hit($key, 3600); // 1 hour decay

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-\']+$/u'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'user_type' => ['required', 'string', 'in:' . implode(',', self::ALLOWED_USER_TYPES)],
        ]);

        $user = $this->create($validated);

        event(new Registered($user));

        Auth::login($user);


        // Send verification email immediately after registration
        config(['queue.default' => 'sync']);
        $user->sendEmailVerificationNotification();
        // Clear rate limiter on successful registration
        RateLimiter::clear($key);

        session()->flash('success', 'Registration successful! Please verify your email address.');

        return redirect($this->redirectPath($user));
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'user_type' => $data['user_type'],
                'is_active' => true,
            ]);

            // Assign Spatie role based on user_type
            $user->assignRole($data['user_type']);

            UserProfile::create([
                'user_id' => $user->id,
            ]);

            return $user;
        });
    }

    /**
     */
    protected function redirectPath(User $user): string
    {
        // All new users must verify email first
        return '/verify-email';
    }
}
