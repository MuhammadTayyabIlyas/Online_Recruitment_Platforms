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
    public function handleLinkedInCallback(): RedirectResponse
    {
        try {
            $linkedInUser = Socialite::driver('linkedin')->user();
            
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
                'trace' => $e->getTraceAsString(),
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
            return $user;
        }
        
        // Try to find user by email
        if ($linkedInUser->email) {
            $user = User::where('email', $linkedInUser->email)->first();
            
            if ($user) {
                // Link LinkedIn account to existing user
                $user->update(['linkedin_id' => $linkedInUser->id]);
                return $user;
            }
        }
        
        // Create new user
        $user = User::create([
            'name' => $linkedInUser->name ?? $linkedInUser->nickname ?? 'LinkedIn User',
            'email' => $linkedInUser->email,
            'password' => Hash::make(Str::random(24)), // Random password, not used
            'user_type' => 'job_seeker', // Always job_seeker for LinkedIn logins
            'is_active' => true,
            'email_verified_at' => now(), // LinkedIn provides verified emails
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
        
        Log::info('New LinkedIn user created', [
            'user_id' => $user->id,
            'email' => $user->email,
            'linkedin_id' => $linkedInUser->id,
        ]);
        
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
