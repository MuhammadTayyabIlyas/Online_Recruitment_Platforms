<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramApplication;
use App\Models\University;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Get statistics
        $programsCount = Program::where('created_by', $userId)->count();
        $featuredCount = Program::where('created_by', $userId)->where('is_featured', true)->count();
        $activeCount = Program::where('created_by', $userId)
            ->where(function ($q) {
                $q->whereNull('application_deadline')
                  ->orWhere('application_deadline', '>=', now());
            })
            ->count();

        // Get applications count
        $programIds = Program::where('created_by', $userId)->pluck('id');
        $applicationsCount = ProgramApplication::whereIn('program_id', $programIds)->count();
        $newApplicationsCount = ProgramApplication::whereIn('program_id', $programIds)
            ->where('status', 'pending')
            ->count();

        // Check if user has a university/institution profile
        $hasUniversity = University::whereHas('programs', function ($q) use ($userId) {
            $q->where('created_by', $userId);
        })->exists();

        // Calculate completion percentage
        $completionSteps = 0;
        $totalSteps = 3;

        if ($hasUniversity) $completionSteps++;
        if ($programsCount > 0) $completionSteps++;
        if ($applicationsCount > 0) $completionSteps++;

        $completionPercentage = round(($completionSteps / $totalSteps) * 100);
        $onboardingComplete = $completionPercentage >= 100;

        // Get recent programs
        $recentPrograms = Program::with(['degree', 'university'])
            ->where('created_by', $userId)
            ->latest()
            ->take(5)
            ->get();

        // Get recent applications
        $recentApplications = ProgramApplication::with(['user', 'program'])
            ->whereIn('program_id', $programIds)
            ->latest()
            ->take(5)
            ->get();

        // Mock total views (you can implement actual view tracking later)
        $totalViews = $programsCount * rand(50, 200);

        return view('institution.dashboard', compact(
            'programsCount',
            'featuredCount',
            'activeCount',
            'applicationsCount',
            'newApplicationsCount',
            'hasUniversity',
            'completionPercentage',
            'onboardingComplete',
            'recentPrograms',
            'recentApplications',
            'totalViews'
        ));
    }
}
