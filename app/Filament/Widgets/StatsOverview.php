<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Job;
use App\Models\Company;
use App\Models\JobApplication;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        // Total users
        $totalUsers = User::count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Job seekers
        $totalJobSeekers = User::where('user_type', 'job_seeker')->count();
        $newJobSeekersThisMonth = User::where('user_type', 'job_seeker')
            ->whereMonth('created_at', now()->month)
            ->count();

        // Employers
        $totalEmployers = User::where('user_type', 'employer')->count();
        $newEmployersThisMonth = User::where('user_type', 'employer')
            ->whereMonth('created_at', now()->month)
            ->count();

        // Active jobs
        $activeJobs = Job::where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->count();
        $newJobsThisMonth = Job::whereMonth('created_at', now()->month)->count();

        // Companies
        $totalCompanies = Company::count();
        $verifiedCompanies = Company::where('is_verified', true)->count();

        // Applications
        $totalApplications = JobApplication::count();
        $applicationsThisMonth = JobApplication::whereMonth('created_at', now()->month)->count();

        return [
            Stat::make('Total Users', number_format($totalUsers))
                ->description($newUsersThisMonth . ' new this month')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary')
                ->chart($this->getUserChartData()),

            Stat::make('Job Seekers', number_format($totalJobSeekers))
                ->description($newJobSeekersThisMonth . ' new this month')
                ->descriptionIcon('heroicon-m-user')
                ->color('success'),

            Stat::make('Employers', number_format($totalEmployers))
                ->description($newEmployersThisMonth . ' new this month')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('info'),

            Stat::make('Active Jobs', number_format($activeJobs))
                ->description($newJobsThisMonth . ' posted this month')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('warning')
                ->chart($this->getJobChartData()),

            Stat::make('Companies', number_format($totalCompanies))
                ->description($verifiedCompanies . ' verified')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('gray'),

            Stat::make('Applications', number_format($totalApplications))
                ->description($applicationsThisMonth . ' this month')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('danger')
                ->chart($this->getApplicationChartData()),
        ];
    }

    protected function getUserChartData(): array
    {
        return User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();
    }

    protected function getJobChartData(): array
    {
        return Job::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();
    }

    protected function getApplicationChartData(): array
    {
        return JobApplication::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();
    }
}
