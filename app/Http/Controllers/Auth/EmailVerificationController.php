<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class EmailVerificationController extends Controller
{
    /**
     * Send verification email to user
     */
    public function sendVerificationEmail(Request $request)
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Check if email is already verified
            if ($user->email_verified_at) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email already verified'
                ], 400);
            }

            // Generate unique verification token
            $verificationToken = Str::random(64);

            // Save token to user record
            $user->verification_token = $verificationToken;
            $user->save();

            // Send verification email

            // Send verification email immediately (synchronously)
            $originalQueue = config('queue.default');
            config(['queue.default' => 'sync']);

            Mail::send('emails.verify', ['token' => $verificationToken, 'user' => $user], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Verify Your Email Address');
            });

            config(['queue.default' => $originalQueue]);

            return response()->json([
                'success' => true,
                'message' => 'Verification email sent successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Email verification error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to send verification email'
            ], 500);
        }
    }

    /**
     * Verify email using token
     */
    public function verifyEmail($token)
    {
        try {
            // Find user by verification token
            $user = User::where('verification_token', $token)->first();

            // Check if user exists and token is valid
            if (!$user) {
                return view('emails.verify_failed', [
                    'message' => 'Invalid verification token'
                ]);
            }

            // Check if email is already verified
            if ($user->email_verified_at) {
                // Auto-login and redirect to dashboard
                auth()->login($user);
                return redirect()->route('dashboard')->with('success', 'Your email is already verified. Welcome back!');
            }

            // Update email_verified_at and clear verification token
            $user->email_verified_at = now();
            $user->verification_token = null;
            $user->save();

            // Auto-login the user after successful verification
            auth()->login($user);

            // Redirect to dashboard with success message
            return redirect()->route('dashboard')->with('success', 'Email verified successfully! Your account is now fully activated.');

        } catch (\Exception $e) {
            Log::error('Email verification error: ' . $e->getMessage());

            return view('emails.verify_failed', [
                'message' => 'An error occurred during verification'
            ]);
        }
    }

    /**
    /**
     * Resend verification email
     */
    public function resendVerification(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Please login to continue.');
        }

        if ($user->email_verified_at) {
            return redirect()->route('dashboard')
                ->with('info', 'Your email is already verified.');
        }

        try {
            // Generate new token if needed
            if (empty($user->verification_token)) {
                $user->verification_token = Str::random(64);
                $user->save();
            }

            // Temporarily use sync queue
            $originalQueue = config('queue.default');
            config(['queue.default' => 'sync']);

            // Send verification email
            Mail::send('emails.verify', ['token' => $user->verification_token, 'user' => $user], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Verify Your Email Address');
            });

            config(['queue.default' => $originalQueue]);

            Log::info('Verification email resent', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);

            return redirect()->route('verification.notice')
                ->with('success', 'A new verification email has been sent to your inbox. Please check your email.');

        } catch (\Exception $e) {
            Log::error('Failed to resend verification email: ' . $e->getMessage());

            return redirect()->route('verification.notice')
                ->with('error', 'Failed to send verification email. Please try again later.');
        }
    }
}
