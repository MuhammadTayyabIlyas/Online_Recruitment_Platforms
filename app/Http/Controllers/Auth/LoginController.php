<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    protected int $maxAttempts = 5;
    protected int $decayMinutes = 15;

    public function showLoginForm(): View
    {
        $showCaptcha = RateLimiter::tooManyAttempts(
            $this->throttleKey(request()), 
            $this->maxAttempts / 2
        );

        return view('auth.login', ['showCaptcha' => $showCaptcha]);
    }

    public function login(Request $request): RedirectResponse
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        if ($this->shouldShowCaptcha($request) && !$this->validateCaptcha($request)) {
            return $this->sendFailedLoginResponse($request, ['captcha' => 'Please complete the security verification.']);
        }

        if ($this->attemptLogin($request)) {
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                
                $this->logSuspiciousActivity($request, $user, 'deactivated_account_login_attempt');
                
                throw ValidationException::withMessages([
                    'login' => ['Your account has been deactivated. Please contact support.'],
                ]);
            }

            $isNewDevice = $this->isNewDevice($request, $user);
            
            if ($this->isSuspiciousLogin($request, $user)) {
                $this->logSuspiciousActivity($request, $user, 'suspicious_login_detected');
            }

            $this->updateLoginInfo($request, $user);
            $this->logSuccessfulLogin($request, $user, $isNewDevice);

            if ($request->boolean('trust_device')) {
                $this->trustDevice($request, $user);
            }

            if ($isNewDevice) {
                $this->sendNewDeviceAlert($request, $user);
            }

            return $this->sendLoginResponse($request, $user, $isNewDevice);
        }

        $this->logFailedLogin($request);
        $this->incrementLoginAttempts($request);

        if ($this->shouldShowCaptcha($request)) {
            session()->flash('show_captcha', true);
        }

        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request): void
    {
        $request->validate([
            'login' => ['required', 'string', 'min:3'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'login.required' => 'Please enter your email or mobile number.',
            'password.required' => 'Please enter your password.',
            'password.min' => 'Your password must be at least 8 characters.',
        ]);
    }

    protected function attemptLogin(Request $request): bool
    {
        $login = $request->input('login');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        $fieldType = $this->detectLoginFieldType($login);
        
        $credentials = [
            'password' => $password,
        ];
        
        if ($fieldType === 'email') {
            $credentials['email'] = $login;
        } else {
            $credentials['phone'] = $this->normalizePhone($login);
        }

        return Auth::attempt($credentials, $remember);
    }

    protected function detectLoginFieldType(string $login): string
    {
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }
        
        $normalized = preg_replace('/[^0-9+]/', '', $login);
        if (preg_match('/^[0-9+]{10,15}$/', $normalized)) {
            return 'phone';
        }
        
        return 'email';
    }

    protected function normalizePhone(string $phone): string
    {
        $normalized = preg_replace('/[^0-9+]/', '', $phone);
        
        if (preg_match('/^[0-9]{10}$/', $normalized)) {
            $normalized = '+91' . $normalized;
        }
        
        return $normalized;
    }

    protected function shouldShowCaptcha(Request $request): bool
    {
        return RateLimiter::tooManyAttempts(
            $this->throttleKey($request), 
            $this->maxAttempts / 2
        ) || $request->session()->has('show_captcha');
    }

    protected function validateCaptcha(Request $request): bool
    {
        if (!config('services.recaptcha.enabled') || !config('services.recaptcha.site_key')) {
            return true;
        }

        $validator = Validator::make($request->all(), [
            'g-recaptcha-response' => 'required',
        ]);

        return !$validator->fails();
    }

    protected function updateLoginInfo(Request $request, $user): void
    {
        $user->timestamps = false;
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
            'last_login_user_agent' => $request->userAgent(),
        ]);
        $user->timestamps = true;
    }

    protected function isNewDevice(Request $request, $user): bool
    {
        if (!$user->last_login_user_agent || !$user->last_login_ip) {
            return false;
        }

        $isNewBrowser = $user->last_login_user_agent !== $request->userAgent();
        $isNewIp = $user->last_login_ip !== $request->ip();

        return $isNewBrowser || $isNewIp;
    }

    protected function isSuspiciousLogin(Request $request, $user): bool
    {
        $recentAttempts = User::where('id', $user->id)
            ->where('last_login_at', '>', now()->subMinutes(10))
            ->where('last_login_ip', '!=', $request->ip())
            ->exists();

        if ($recentAttempts) {
            return true;
        }

        return false;
    }

    protected function logSuccessfulLogin(Request $request, $user, bool $isNewDevice): void
    {
        Log::info('User logged in', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'new_device' => $isNewDevice,
            'trusted_device' => $request->boolean('trust_device'),
        ]);
    }

    protected function logFailedLogin(Request $request): void
    {
        Log::warning('Failed login attempt', [
            'login' => $request->input('login'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'attempts' => RateLimiter::attempts($this->throttleKey($request)),
        ]);
    }

    protected function logSuspiciousActivity(Request $request, $user, string $type): void
    {
        Log::alert('Suspicious activity detected', [
            'type' => $type,
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    protected function sendNewDeviceAlert(Request $request, $user): void
    {
        try {
            $deviceInfo = $this->getDeviceInfo($request);
            
            \Illuminate\Support\Facades\Mail::send('emails.new-device-alert', [
                'user' => $user,
                'device' => $deviceInfo,
                'ip' => $request->ip(),
                'time' => now()->format('M d, Y h:i A'),
            ], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('New Device Login Alert');
            });
        } catch (\Exception $e) {
            Log::error('Failed to send new device alert email: ' . $e->getMessage());
        }
    }

    protected function trustDevice(Request $request, $user): void
    {
        $deviceHash = $this->getDeviceHash($request);
        
        \DB::table('trusted_devices')->updateOrInsert(
            [
                'user_id' => $user->id,
                'device_hash' => $deviceHash,
            ],
            [
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'expires_at' => now()->addDays(30),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    protected function getDeviceInfo(Request $request): array
    {
        $agent = $request->userAgent();
        
        return [
            'browser' => 'Unknown',
            'os' => 'Unknown',
            'device' => 'Unknown',
            'platform' => 'Unknown',
        ];
    }

    protected function getDeviceHash(Request $request): string
    {
        return hash('sha256', $request->userAgent() . $request->ip());
    }

    protected function sendLoginResponse(Request $request, $user, bool $isNewDevice): RedirectResponse
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);

        \Illuminate\Support\Facades\Log::info('LoginController: User logged in', [
            'user_id' => $user->id,
            'email' => $user->email,
            'verified' => !is_null($user->email_verified_at),
            'new_device' => $isNewDevice,
        ]);

        Session::put('login_time', now());
        Session::put('device_trusted', $request->boolean('trust_device'));
        
        if (!$user->email_verified_at) {
            $this->sendVerificationEmail($user);
            session()->flash('info', 'Welcome! Please verify your email address. A verification email has been sent to your inbox.');
        } else {
            if ($isNewDevice) {
                session()->flash('info', 'We noticed a login from a new device. A security alert has been sent to your email.');
            } else {
                session()->flash('success', 'Welcome back! You have been successfully logged in.');
            }
        }

        return redirect()->intended($this->redirectPath());
    }

    protected function redirectPath(): string
    {
        $user = Auth::user();

        return match ($user->user_type) {
            'admin' => '/admin',
            'employer' => '/employer/dashboard',
            'job_seeker' => '/jobseeker/dashboard',
            default => '/dashboard',
        };
    }

    protected function sendFailedLoginResponse(Request $request, array $additionalErrors = []): never
    {
        $errors = ['login' => ['These credentials do not match our records.']];
        
        foreach ($additionalErrors as $field => $message) {
            $errors[$field] = (array) $message;
        }

        throw ValidationException::withMessages($errors);
    }

    public function logout(Request $request): RedirectResponse
    {
        $userId = Auth::id();
        Log::info('User logged out', ['user_id' => $userId]);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->flash('success', 'You have been logged out successfully.');
        return redirect('/');
    }

    protected function throttleKey(Request $request): string
    {
        $login = $request->input('login');
        return Str::transliterate(Str::lower($login) . '|' . $request->ip());
    }

    protected function hasTooManyLoginAttempts(Request $request): bool
    {
        return RateLimiter::tooManyAttempts(
            $this->throttleKey($request),
            $this->maxAttempts
        );
    }

    protected function incrementLoginAttempts(Request $request): void
    {
        RateLimiter::hit(
            $this->throttleKey($request),
            $this->decayMinutes * 60
        );
    }

    protected function clearLoginAttempts(Request $request): void
    {
        RateLimiter::clear($this->throttleKey($request));
    }

    protected function sendLockoutResponse(Request $request): never
    {
        $seconds = RateLimiter::availableIn($this->throttleKey($request));
        Log::warning('Account locked due to too many failed attempts', [
            'login' => $request->input('login'),
            'ip' => $request->ip(),
            'lockout_duration' => $seconds,
        ]);

        throw ValidationException::withMessages([
            'login' => [trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ])],
        ])->status(429);
    }

    protected function sendVerificationEmail($user): void
    {
        try {
            if ($user->email_verified_at) {
                return;
            }

            if (empty($user->verification_token)) {
                $user->verification_token = \Illuminate\Support\Str::random(64);
                $user->save();
            }

            $originalQueue = config('queue.default');
            config(['queue.default' => 'sync']);

            \Illuminate\Support\Facades\Mail::send('emails.verify', 
                ['token' => $user->verification_token, 'user' => $user], 
                function ($message) use ($user) {
                    $message->to($user->email);
                    $message->subject('Verify Your Email Address');
                }
            );

            config(['queue.default' => $originalQueue]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send verification email: ' . $e->getMessage());
        }
    }
}
