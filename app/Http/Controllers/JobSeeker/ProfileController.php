<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\UserEducation;
use App\Models\UserExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load(['profile', 'education', 'experience', 'skills', 'languages', 'certifications', 'resumes']);
        $profileCompletion = $this->calculateCompletion($user);
        return view('jobseeker.profile.index', compact('user', 'profileCompletion'));
    }

    public function edit()
    {
        $user = auth()->user()->load('profile');
        return view('jobseeker.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'country_code' => 'nullable|string|max:5',
            'bio' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:2',
            'country_iso' => 'nullable|string|max:2',
            'province' => 'nullable|string|max:10',
            'province_state_code' => 'nullable|string|max:10',
            'passport_number' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'avatar' => 'nullable|image|max:2048',
        ]);

        // Update user data (name, phone, country_code, avatar are on users table)
        $userData = ['name' => $request->name];

        if ($request->filled('phone')) {
            $userData['phone'] = $request->phone;
        }

        if ($request->filled('country_code')) {
            $userData['country_code'] = strtoupper($request->country_code);
        }

        if ($request->hasFile('avatar')) {
            $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        auth()->user()->update($userData);

        // Get country and province data from config
        $countriesData = config('countries_provinces');

        // Get country name
        $countryName = null;
        if ($request->filled('country_iso') && isset($countriesData[$request->country_iso])) {
            $countryName = $countriesData[$request->country_iso]['name'];
        }

        // Get province/state name from code
        $provinceName = null;
        if ($request->filled('country_iso') && $request->filled('province_state_code')) {
            $countryCode = $request->country_iso;
            $provinceCode = $request->province_state_code;

            if (isset($countriesData[$countryCode]['provinces'][$provinceCode])) {
                $provinceName = $countriesData[$countryCode]['provinces'][$provinceCode];
            }
        }

        // Build location string: City, Province/State, Country
        $locationParts = array_filter([
            $request->city,
            $provinceName,
            $countryName,
        ]);
        $location = !empty($locationParts) ? implode(', ', $locationParts) : null;

        // Profile data (bio, location, address fields are on user_profiles table)
        $profileData = [
            'bio' => $request->bio,
            'location' => $location,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'country_iso' => $request->filled('country_iso') ? strtoupper($request->country_iso) : null,
            'province_state' => $provinceName,
            'province_state_code' => $request->filled('province_state_code') ? strtoupper($request->province_state_code) : null,
            'passport_number' => $request->passport_number,
            'date_of_birth' => $request->date_of_birth,
        ];

        auth()->user()->profile()->updateOrCreate(['user_id' => auth()->id()], $profileData);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function storeEducation(Request $request)
    {
        $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
        ]);

        auth()->user()->education()->create($request->all());
        return back()->with('success', 'Education added.');
    }

    public function storeExperience(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
        ]);

        auth()->user()->experience()->create($request->all());
        return back()->with('success', 'Experience added.');
    }

    public function uploadResume(Request $request)
    {
        $request->validate(['resume' => 'required|mimes:pdf,doc,docx|max:5120']);

        $path = $request->file('resume')->store('resumes/' . auth()->id(), 'public');

        auth()->user()->resumes()->create([
            'file_path' => $path,
            'file_name' => $request->file('resume')->getClientOriginalName(),
            'file_size' => $request->file('resume')->getSize(),
            'is_primary' => auth()->user()->resumes()->count() === 0,
        ]);

        return back()->with('success', 'Resume uploaded.');
    }

    protected function calculateCompletion($user): int
    {
        $score = 0;
        if ($user->profile?->bio) $score += 10;
        if ($user->phone) $score += 5;  // phone is on users table
        if ($user->profile?->location) $score += 10;  // location is on profile
        if ($user->profile?->date_of_birth) $score += 5;
        if ($user->avatar) $score += 5;  // avatar is on users table
        if ($user->education()->count() > 0) $score += 20;
        if ($user->experience()->count() > 0) $score += 20;
        if ($user->skills()->count() >= 3) $score += 15;
        if ($user->resumes()->count() > 0) $score += 10;
        return min(100, $score);
    }
}
