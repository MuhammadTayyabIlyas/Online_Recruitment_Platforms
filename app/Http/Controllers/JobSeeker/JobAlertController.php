<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\EmploymentType;
use App\Models\JobAlert;
use App\Models\JobType;
use Illuminate\Http\Request;

class JobAlertController extends Controller
{
    public function index()
    {
        $alerts = auth()->user()->jobAlerts()->with(['category', 'jobType', 'employmentType'])->latest()->get();
        return view('jobseeker.job-alerts.index', compact('alerts'));
    }

    public function create()
    {
        return view('jobseeker.job-alerts.create', [
            'categories' => Category::active()->ordered()->get(),
            'jobTypes' => JobType::active()->get(),
            'employmentTypes' => EmploymentType::active()->get(),
        ]);
    }

    public function edit(JobAlert $alert)
    {
        abort_if($alert->user_id !== auth()->id(), 403);

        return view('jobseeker.job-alerts.edit', [
            'alert' => $alert,
            'categories' => Category::active()->ordered()->get(),
            'jobTypes' => JobType::active()->get(),
            'employmentTypes' => EmploymentType::active()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'keywords' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'location' => 'nullable|string|max:255',
            'job_type_id' => 'nullable|exists:job_types,id',
            'employment_type_id' => 'nullable|exists:employment_types,id',
            'min_salary' => 'nullable|numeric|min:0',
            'frequency' => 'required|in:daily,weekly',
        ]);

        auth()->user()->jobAlerts()->create($request->all());

        return redirect()->route('jobseeker.alerts.index')->with('success', 'Job alert created.');
    }

    public function update(Request $request, JobAlert $alert)
    {
        abort_if($alert->user_id !== auth()->id(), 403);

        // Allow lightweight toggle updates (is_active only) or full updates from edit form
        $isToggle = $request->has('is_active')
            && ! $request->hasAny(['name', 'keywords', 'category_id', 'location', 'job_type_id', 'employment_type_id', 'min_salary', 'frequency']);
        if ($isToggle) {
            $request->validate(['is_active' => 'boolean']);
            $alert->update(['is_active' => $request->boolean('is_active')]);
            return back()->with('success', 'Alert updated.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'keywords' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'location' => 'nullable|string|max:255',
            'job_type_id' => 'nullable|exists:job_types,id',
            'employment_type_id' => 'nullable|exists:employment_types,id',
            'min_salary' => 'nullable|numeric|min:0',
            'frequency' => 'required|in:daily,weekly',
            'is_active' => 'boolean',
        ]);

        $alert->update($request->all());

        return back()->with('success', 'Alert updated.');
    }

    public function destroy(JobAlert $alert)
    {
        abort_if($alert->user_id !== auth()->id(), 403);
        $alert->delete();
        return back()->with('success', 'Alert deleted.');
    }

    public function toggle(JobAlert $alert)
    {
        abort_if($alert->user_id !== auth()->id(), 403);
        $alert->update(['is_active' => !$alert->is_active]);

        return back()->with('success', 'Alert status updated.');
    }
}
