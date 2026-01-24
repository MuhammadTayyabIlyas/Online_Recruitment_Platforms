<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\EmploymentType;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::active()->with(['company', 'category', 'jobType', 'employmentType']);

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->q}%")
                  ->orWhere('description', 'like', "%{$request->q}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('location')) {
            $query->where(function ($q) use ($request) {
                $q->where('city', 'like', "%{$request->location}%")
                  ->orWhere('country', 'like', "%{$request->location}%")
                  ->orWhere('location', 'like', "%{$request->location}%");
            });
        }

        if ($request->filled('job_type')) {
            $query->where('job_type_id', $request->job_type);
        }

        if ($request->filled('employment_type')) {
            $query->where('employment_type_id', $request->employment_type);
        }

        if ($request->filled('experience')) {
            $query->where('experience_level', $request->experience);
        }

        if ($request->filled('remote') && $request->remote) {
            $query->where('is_remote', true);
        }

        if ($request->filled('min_salary')) {
            $query->where('max_salary', '>=', $request->min_salary);
        }

        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'oldest' => $query->oldest('published_at'),
            'popular' => $query->orderByDesc('views_count'),
            'salary_high' => $query->orderByDesc('max_salary'),
            'salary_low' => $query->orderBy('min_salary'),
            default => $query->latest('published_at'),
        };

        $jobs = $query->paginate(20)->withQueryString();

        return view('jobs.index', [
            'jobs' => $jobs,
            'categories' => Category::active()->withCount('jobs')->ordered()->get(),
            'jobTypes' => JobType::active()->get(),
            'employmentTypes' => EmploymentType::active()->get(),
        ]);
    }

    public function search(Request $request)
    {
        // Redirect to index with same query parameters
        return redirect()->route('jobs.index', $request->query());
    }

    public function show(Job $job)
    {
        if ($job->status !== 'published') {
            abort(404);
        }

        $job->increment('views_count');
        $job->load(['company', 'category', 'skills', 'questions', 'jobType', 'employmentType']);

        $similarJobs = Job::active()
            ->where('id', '!=', $job->id)
            ->where(function ($q) use ($job) {
                $q->where('category_id', $job->category_id)
                  ->orWhere('company_id', $job->company_id);
            })
            ->limit(5)
            ->get();

        return view('jobs.show', compact('job', 'similarJobs'));
    }
}
