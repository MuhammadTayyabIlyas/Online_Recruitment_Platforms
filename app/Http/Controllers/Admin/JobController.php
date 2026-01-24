<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with(['company', 'category', 'user'])->withTrashed();

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhereHas('company', fn($q) => $q->where('company_name', 'like', "%{$search}%"));
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'trashed') {
                $query->onlyTrashed();
            } else {
                $query->where('status', $request->status);
            }
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by featured/urgent
        if ($request->filled('featured')) {
            $query->where('is_featured', true);
        }
        if ($request->filled('urgent')) {
            $query->where('is_urgent', true);
        }

        $jobs = $query->latest()->paginate(20)->withQueryString();
        $categories = Category::active()->ordered()->get();

        return view('admin.jobs.index', compact('jobs', 'categories'));
    }

    public function show(Job $job)
    {
        $job->load(['company', 'category', 'user', 'applications', 'skills']);
        return view('admin.jobs.show', compact('job'));
    }

    public function edit($id)
    {
        $job = Job::withTrashed()->findOrFail($id);
        $categories = Category::active()->ordered()->get();
        $companies = Company::orderBy('company_name')->get();

        return view('admin.jobs.edit', compact('job', 'categories', 'companies'));
    }

    public function update(Request $request, $id)
    {
        $job = Job::withTrashed()->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published,closed,expired',
            'is_featured' => 'boolean',
            'is_urgent' => 'boolean',
            'is_remote' => 'boolean',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:published_at',
        ]);

        $job->update([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'location' => $validated['location'],
            'status' => $validated['status'],
            'is_featured' => $request->boolean('is_featured'),
            'is_urgent' => $request->boolean('is_urgent'),
            'is_remote' => $request->boolean('is_remote'),
            'published_at' => $validated['published_at'],
            'expires_at' => $validated['expires_at'],
        ]);

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job updated successfully.');
    }

    public function destroy($id)
    {
        $job = Job::withTrashed()->findOrFail($id);

        if ($job->trashed()) {
            // Permanently delete
            $job->forceDelete();
            return redirect()->route('admin.jobs.index')
                ->with('success', 'Job permanently deleted.');
        }

        // Soft delete
        $job->delete();
        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job moved to trash.');
    }

    public function restore($id)
    {
        $job = Job::withTrashed()->findOrFail($id);
        $job->restore();

        return back()->with('success', 'Job restored successfully.');
    }

    public function toggleFeatured($id)
    {
        $job = Job::withTrashed()->findOrFail($id);
        $job->update(['is_featured' => !$job->is_featured]);

        $status = $job->is_featured ? 'featured' : 'unfeatured';
        return back()->with('success', "Job marked as {$status}.");
    }

    public function toggleUrgent($id)
    {
        $job = Job::withTrashed()->findOrFail($id);
        $job->update(['is_urgent' => !$job->is_urgent]);

        $status = $job->is_urgent ? 'urgent' : 'normal';
        return back()->with('success', "Job marked as {$status}.");
    }

    public function updateStatus(Request $request, $id)
    {
        $job = Job::withTrashed()->findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:draft,published,closed,expired',
        ]);

        $job->update(['status' => $validated['status']]);

        return back()->with('success', 'Job status updated to ' . $validated['status'] . '.');
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:delete,restore,feature,unfeature,publish,close',
            'jobs' => 'required|array',
            'jobs.*' => 'exists:job_listings,id',
        ]);

        $jobs = Job::withTrashed()->whereIn('id', $validated['jobs']);

        switch ($validated['action']) {
            case 'delete':
                $jobs->get()->each->delete();
                $message = 'Selected jobs moved to trash.';
                break;
            case 'restore':
                $jobs->onlyTrashed()->get()->each->restore();
                $message = 'Selected jobs restored.';
                break;
            case 'feature':
                $jobs->update(['is_featured' => true]);
                $message = 'Selected jobs marked as featured.';
                break;
            case 'unfeature':
                $jobs->update(['is_featured' => false]);
                $message = 'Selected jobs unmarked as featured.';
                break;
            case 'publish':
                $jobs->update(['status' => 'published', 'published_at' => now()]);
                $message = 'Selected jobs published.';
                break;
            case 'close':
                $jobs->update(['status' => 'closed']);
                $message = 'Selected jobs closed.';
                break;
        }

        return back()->with('success', $message);
    }
}
