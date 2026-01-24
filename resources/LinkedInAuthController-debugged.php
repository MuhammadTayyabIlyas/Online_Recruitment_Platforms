<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;

class LinkedInAuthController extends Controller
{
    /**
     * Redirect to LinkedIn for authentication
     */
    public function redirectToLinkedIn(): RedirectResponse
    {
        return Socialite::driver('linkedin')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    /**
     * Handle LinkedIn callback
     */
    public function handleLinkedInCallback(Request $request): RedirectResponse
    {
        // Log incoming request for debugging
        Log::info('LinkedIn callback received', [
            'full_url' => $request->fullUrl(),
            'query_params' => $request->query(),
            'has_code' => $request->has('code'),
            'has_error' => $request->has('error'),
            'has_state' => $request->has('state'),
        ]);

        // Check if user denied authorization
        if ($request->has('error')) {
            $error = $request->input('error');
            $desc = $request->input('error_description');
            
            Log::warning('LinkedIn authorization denied or error', [
                'error' => $error,
                'error_description' => $desc,
                'error_uri' => $request->input('error_uri'),
            ]);
            
            return redirect()->route('login')
                ->with('error', "LinkedIn Error: $error - $desc. Please try again or use email login.");
        }

        // Check if code is missing
        if (!$request->has('code')) {
            Log::error('LinkedIn callback missing authorization code', [
                'query_params' => $request->query(),
                'all_params' => $request->all(),
            ]);
            
            return redirect()->route('login')
                ->with('error', 'LinkedIn authorization failed: missing code. Please try again or use email login.');
        }

        try {
            // Get user from LinkedIn
            $linkedInUser = Socialite::driver('linkedin')->user();
            
            // Log successful retrieval
            Log::info('LinkedIn user retrieved successfully', [
                'linkedin_id' => $linkedInUser->id,
                'email' => $linkedInUser->email,
                'name' => $linkedInUser->name,
            ]);
            
            // Find or create user
            $user = $this->findOrCreateUser($linkedInUser);
            
            // Log in the user
            Auth::login($user, true);
            
            // Update last login
            $user->update(['last_login_at' => now()]);
            
            // Log successful LinkedIn login
            Log::info('LinkedIn login successful', [
                'user_id' => $user->id,
                'email' => $user->email,
                'linkedin_id' => $linkedInUser->id,
            ]);
            
            // Always redirect to jobseeker dashboard
            session()->flash('success', 'Welcome! You have successfully logged in with LinkedIn.');
            return redirect('https://www.placemenet.net/jobseeker/dashboard');
            
        } catch (\Exception $e) {
            Log::error('LinkedIn login failed', [
                'error' => $e->getMessage(),
                'error_class' => get_class($e),
                'trace' => $e->getTraceAsString(),
                'request' => [
                    'url' => $request->fullUrl(),
                    'query' => $request->query(),
                ],
            ]);
            
            return redirect()->route('login')
                ->with('error', 'Unable to login with LinkedIn. Please try again or use email login.');
        }
    }

    /**
     * Find or create user from LinkedIn data
     */
    protected function findOrCreateUser($linkedInUser): User
    {
        // First, try to find user by LinkedIn ID
        $user = User::where('linkedin_id', $linkedInUser->id)->first();
        
        if ($user) {
            Log::info('Found existing user by LinkedIn ID', ['user_id' => $user->id]);
            return $user;
        }
        
        // Try to find user by email
        if ($linkedInUser->email) {
            $user = User::where('email', $linkedInUser->email)->first();
            
            if ($user) {
                Log::info('Found existing user by email, linking LinkedIn ID', ['user_id' => $user->id]);
                
                // Link LinkedIn account and verify email if not already verified
                $updateData = ['linkedin_id' => $linkedInUser->id];
                
                if (is_null($user->email_verified_at)) {
                    $updateData['email_verified_at'] = now();
                }
                
                $user->update($updateData);
                return $user;
            }
        }
        
        // Log what we're creating
        Log::info('Creating new LinkedIn user', [
            'email' => $linkedInUser->email,
            'name' => $linkedInUser->name,
            'linkedin_id' => $linkedInUser->id,
        ]);
        
        // Create new user
        $user = User::create([
            'name' => $linkedInUser->name ?? $linkedInUser->nickname ?? 'LinkedIn User',
            'email' => $linkedInUser->email,
            'password' => Hash::make(Str::random(24)),
            'user_type' => 'job_seeker',
            'is_active' => true,
            'email_verified_at' => now(),
            'linkedin_id' => $linkedInUser->id,
            'avatar' => $linkedInUser->avatar ?? null,
        ]);
        
        // Assign job_seeker role
        $user->assignRole('job_seeker');
        
        // Create empty profile
        $user->profile()->create([
            'bio' => '',
            'linkedin_url' => $linkedInUser->user['public_profile_url'] ?? null,
        ]);
        
        Log::info('New LinkedIn user created successfully', ['user_id' => $user->id]);
        
        return $user;
    }

    /**
     * Handle LinkedIn logout
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}
