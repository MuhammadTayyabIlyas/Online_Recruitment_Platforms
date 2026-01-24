<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Job;
use App\Models\Company;
use App\Models\JobApplication;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Overall Statistics
        $stats = [
            'total_users' => User::count(),
            'total_jobs' => Job::count(),
            'total_companies' => Company::count(),
            'total_applications' => JobApplication::count(),
            'total_categories' => Category::count(),

            // User breakdown
            'admin_users' => User::where('user_type', 'admin')->count(),
            'employers' => User::where('user_type', 'employer')->count(),
            'job_seekers' => User::where('user_type', 'job_seeker')->count(),

            // Active vs Inactive
            'active_users' => User::where('is_active', true)->count(),
            'inactive_users' => User::where('is_active', false)->count(),
        ];

        // Job Statistics
        $jobStats = [
            'published' => Job::where('status', 'published')->count(),
            'draft' => Job::where('status', 'draft')->count(),
            'closed' => Job::where('status', 'closed')->count(),
            'expired' => Job::where('status', 'expired')->count(),
            'featured' => Job::where('is_featured', true)->count(),
            'urgent' => Job::where('is_urgent', true)->count(),
            'remote' => Job::where('is_remote', true)->count(),
        ];

        // Application Statistics
        $applicationStats = [
            'pending' => JobApplication::where('status', 'pending')->count(),
            'reviewing' => JobApplication::where('status', 'reviewing')->count(),
            'shortlisted' => JobApplication::where('status', 'shortlisted')->count(),
            'rejected' => JobApplication::where('status', 'rejected')->count(),
        ];

        // Recent Activity
        $recentUsers = User::latest()->take(5)->get();
        $recentJobs = Job::with('company')->latest()->take(5)->get();
        $recentApplications = JobApplication::with(['user', 'job'])->latest()->take(5)->get();

        // Top Categories by Job Count
        $topCategories = Category::withCount('jobs')
            ->orderBy('jobs_count', 'desc')
            ->take(5)
            ->get();

        // Monthly trends (last 6 months)
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyData[] = [
                'month' => $date->format('M Y'),
                'users' => User::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'jobs' => Job::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'applications' => JobApplication::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        }

        return view('admin.dashboard', compact(
            'stats',
            'jobStats',
            'applicationStats',
            'recentUsers',
            'recentJobs',
            'recentApplications',
            'topCategories',
            'monthlyData'
        ));
    }
}
