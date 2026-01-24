<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $company = $user->company;

        // Redirect educational institutions to setup page if missing profile
        if ($user->hasRole('educational_institution') && !$company) {
            return redirect()->route('institution.setup');
        }

        $activeJobs = 0;
        $totalApplications = 0;
        $pendingApplications = 0;
        $recentApplications = collect();

        if ($company) {
            $activeJobs = Job::where('company_id', $company->id)
                ->where('status', 'published')
                ->count();

            $jobIds = Job::where('company_id', $company->id)->pluck('id');

            $totalApplications = JobApplication::whereIn('job_id', $jobIds)->count();

            $pendingApplications = JobApplication::whereIn('job_id', $jobIds)
                ->where('status', 'pending')
                ->count();

            $recentApplications = JobApplication::whereIn('job_id', $jobIds)
                ->with(['user', 'job'])
                ->latest()
                ->take(5)
                ->get();
        }

        // CV views left (from subscription if implemented)
        $cvViewsLeft = 0;

        return view('employer.dashboard', compact(
            'activeJobs',
            'totalApplications',
            'pendingApplications',
            'cvViewsLeft',
            'recentApplications'
        ));
    }
}
