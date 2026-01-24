<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Category;
use App\Models\JobType;
use App\Models\EmploymentType;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobController extends Controller
{
    public function index()
    {
        $company = Auth::user()->company;

        if (!$company) {
            return redirect()->route('employer.company.create')
                ->with('warning', 'Please create a company profile first.');
        }

        $jobs = Job::where('company_id', $company->id)
            ->with(['category', 'jobType'])
            ->withCount('applications')
            ->latest()
            ->paginate(10);

        return view('employer.jobs.index', compact('jobs'));
    }

    public function create()
    {
        if (!Auth::user()->company) {
            return redirect()->route('employer.company.create')
                ->with('warning', 'Please create a company profile first.');
        }

        // Check if user can post a job
        if (!$this->canPostJob()) {
            return redirect()->route('employer.packages')
                ->with('warning', 'You have reached your job posting limit. Please upgrade to a package to post more jobs.');
        }

        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $jobTypes = JobType::where('is_active', true)->orderBy('name')->get();
        $employmentTypes = EmploymentType::where('is_active', true)->orderBy('name')->get();
        $skills = Skill::where('is_active', true)->orderBy('name')->get();

        return view('employer.jobs.create', compact('categories', 'jobTypes', 'employmentTypes', 'skills'));
    }

    public function store(Request $request)
    {
        $company = Auth::user()->company;

        if (!$company) {
            return redirect()->route('employer.company.create')
                ->with('warning', 'Please create a company profile first.');
        }

        // Check if user can post a job
        if (!$this->canPostJob()) {
            return redirect()->route('employer.packages')
                ->with('warning', 'You have reached your job posting limit. Please upgrade to a package to post more jobs.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'job_type_id' => 'required|exists:job_types,id',
            'employment_type_id' => 'nullable|exists:employment_types,id',
            'location' => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'min_salary' => 'nullable|numeric|min:0',
            'max_salary' => 'nullable|numeric|min:0|gte:min_salary',
            'hide_salary' => 'boolean',
            'expires_at' => 'nullable|date|after:today',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
            'is_remote' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $job = Job::create([
                'company_id' => $company->id,
                'user_id' => Auth::id(),
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']) . '-' . uniqid(),
                'category_id' => $validated['category_id'],
                'job_type_id' => $validated['job_type_id'],
                'employment_type_id' => $validated['employment_type_id'] ?? null,
                'location' => $validated['location'],
                'description' => $validated['description'],
                'requirements' => $validated['requirements'] ?? null,
                'benefits' => $validated['benefits'] ?? null,
                'min_salary' => $validated['min_salary'] ?? null,
                'max_salary' => $validated['max_salary'] ?? null,
                'hide_salary' => (bool)($validated['hide_salary'] ?? false),
                'expires_at' => $validated['expires_at'] ?? null,
                'is_remote' => $validated['is_remote'] ?? false,
                'is_featured' => $validated['is_featured'] ?? false,
                'status' => 'published',
                'published_at' => now(),
            ]);

            // Attach skills
            if (!empty($validated['skills'])) {
                $job->skills()->attach($validated['skills']);
            }

            DB::commit();

            return redirect()->route('employer.jobs.show', $job)
                ->with('success', 'Job posted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to create job. Please try again.');
        }
    }

    public function show(Job $job)
    {
        $this->authorizeJob($job);
        $job->load(['company', 'category', 'jobType', 'skills', 'questions']);
        $job->loadCount('applications');

        return view('employer.jobs.show', compact('job'));
    }

    public function edit(Job $job)
    {
        $this->authorizeJob($job);

        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $jobTypes = JobType::where('is_active', true)->orderBy('name')->get();
        $employmentTypes = EmploymentType::where('is_active', true)->orderBy('name')->get();
        $skills = Skill::where('is_active', true)->orderBy('name')->get();

        return view('employer.jobs.edit', compact('job', 'categories', 'jobTypes', 'employmentTypes', 'skills'));
    }

    public function update(Request $request, Job $job)
    {
        $this->authorizeJob($job);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'job_type_id' => 'required|exists:job_types,id',
            'employment_type_id' => 'nullable|exists:employment_types,id',
            'location' => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'min_salary' => 'nullable|numeric|min:0',
            'max_salary' => 'nullable|numeric|min:0|gte:min_salary',
            'hide_salary' => 'boolean',
            'expires_at' => 'nullable|date|after:today',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
            'is_remote' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $job->update([
                'title' => $validated['title'],
                'category_id' => $validated['category_id'],
                'job_type_id' => $validated['job_type_id'],
                'employment_type_id' => $validated['employment_type_id'] ?? null,
                'location' => $validated['location'],
                'description' => $validated['description'],
                'requirements' => $validated['requirements'] ?? null,
                'benefits' => $validated['benefits'] ?? null,
                'min_salary' => $validated['min_salary'] ?? null,
                'max_salary' => $validated['max_salary'] ?? null,
                'hide_salary' => (bool)($validated['hide_salary'] ?? false),
                'expires_at' => $validated['expires_at'] ?? null,
                'is_remote' => $validated['is_remote'] ?? false,
            ]);

            // Sync skills
            $job->skills()->sync($validated['skills'] ?? []);

            DB::commit();

            return redirect()->route('employer.jobs.show', $job)
                ->with('success', 'Job updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to update job. Please try again.');
        }
    }

    public function updateStatus(Request $request, Job $job)
    {
        $this->authorizeJob($job);

        $validated = $request->validate([
            'status' => 'required|in:draft,published,closed,paused',
        ]);

        $job->update([
            'status' => $validated['status'],
            'is_active' => $validated['status'] === 'published',
            'published_at' => $validated['status'] === 'published' && !$job->published_at ? now() : $job->published_at,
        ]);

        return back()->with('success', 'Job status updated successfully.');
    }

    public function destroy(Job $job)
    {
        $this->authorizeJob($job);
        $job->delete();
        return redirect()->route('employer.jobs.index')->with('success', 'Job deleted successfully.');
    }

    public function duplicate(Job $job)
    {
        $this->authorizeJob($job);

        $newJob = $job->replicate();
        $newJob->title = $job->title . ' (Copy)';
        $newJob->slug = Str::slug($newJob->title) . '-' . uniqid();
        $newJob->status = 'draft';
        $newJob->is_active = false;
        $newJob->published_at = null;
        $newJob->views_count = 0;
        $newJob->save();

        // Copy skills
        $newJob->skills()->attach($job->skills->pluck('id'));

        return redirect()->route('employer.jobs.edit', $newJob)
            ->with('success', 'Job duplicated successfully. You can now edit the copy.');
    }

    private function authorizeJob(Job $job): void
    {
        $company = Auth::user()->company;

        if (!$company || $job->company_id !== $company->id) {
            abort(403, 'Unauthorized action.');
        }
    }

    private function canPostJob(): bool
    {
        $company = Auth::user()->company;
        
        if (!$company) {
            return false;
        }

        // Check active subscription first
        $activeSubscription = Auth::user()->activeSubscription;
        if ($activeSubscription) {
            $jobsCount = Job::where('company_id', $company->id)
                ->where('status', '!=', 'draft')
                ->count();
            return $jobsCount < $activeSubscription->package->job_posts_limit;
        }

        // No subscription - check if they have posted less than 1 job
        $jobsCount = Job::where('company_id', $company->id)
            ->where('status', '!=', 'draft')
            ->count();
        
        return $jobsCount < 1; // Free tier: 1 job limit
    }
}
