<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\SavedJob;
use App\Models\JobAlert;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get counts
        $applicationCount = JobApplication::where('user_id', $user->id)->count();
        $savedJobsCount = SavedJob::where('user_id', $user->id)->count();
        $alertsCount = JobAlert::where('user_id', $user->id)->count();

        // Calculate profile completion percentage
        $profileCompletion = $this->calculateProfileCompletion($user);

        // Get recent applications
        $recentApplications = JobApplication::with(['job.company'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Get uploaded documents
        $documents = $user->documents()->latest()->take(5)->get();
        $documentsCount = $user->documents()->count();

        return view('jobseeker.dashboard', compact(
            'applicationCount',
            'savedJobsCount',
            'alertsCount',
            'profileCompletion',
            'recentApplications',
            'documents',
            'documentsCount'
        ));
    }

    private function calculateProfileCompletion($user): int
    {
        $fields = 0;
        $completed = 0;

        // Check user fields
        $userFields = ['name', 'email'];
        foreach ($userFields as $field) {
            $fields++;
            if (!empty($user->$field)) {
                $completed++;
            }
        }

        // Check profile fields if profile exists
        if ($user->profile) {
            $profileFields = ['phone', 'bio', 'address', 'city', 'country', 'date_of_birth', 'avatar'];
            foreach ($profileFields as $field) {
                $fields++;
                if (!empty($user->profile->$field)) {
                    $completed++;
                }
            }
        } else {
            // Add profile fields to total but not completed
            $fields += 7;
        }

        return $fields > 0 ? round(($completed / $fields) * 100) : 0;
    }
}
