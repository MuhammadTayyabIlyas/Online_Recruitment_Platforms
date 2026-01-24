<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ProgramApplication;
use App\Models\StudentDocument;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get or create profile
        $profile = StudentProfile::firstOrCreate(
            ['user_id' => $user->id],
            ['profile_completion' => 0]
        );

        // Calculate profile completion if needed
        if ($profile->profile_completion == 0) {
            $profile->calculateCompletion();
        }

        // Get statistics
        $documentsCount = StudentDocument::where('user_id', $user->id)->count();
        $applicationsCount = ProgramApplication::where('user_id', $user->id)->count();
        $pendingApplications = ProgramApplication::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        // Get recent applications
        $recentApplications = ProgramApplication::with(['program.university', 'program.country'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Get recent documents
        $recentDocuments = StudentDocument::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Check onboarding steps
        $hasProfile = $profile->profile_completion >= 50;
        $hasDocuments = $documentsCount >= 3;
        $hasApplied = $applicationsCount > 0;

        $completionSteps = 0;
        if ($hasProfile) $completionSteps++;
        if ($hasDocuments) $completionSteps++;
        if ($hasApplied) $completionSteps++;

        $onboardingPercentage = round(($completionSteps / 3) * 100);
        $onboardingComplete = $onboardingPercentage >= 100;

        return view('student.dashboard', compact(
            'profile',
            'documentsCount',
            'applicationsCount',
            'pendingApplications',
            'recentApplications',
            'recentDocuments',
            'hasProfile',
            'hasDocuments',
            'hasApplied',
            'onboardingPercentage',
            'onboardingComplete'
        ));
    }
}
