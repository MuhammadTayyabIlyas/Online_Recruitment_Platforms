<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\Job;
use App\Enums\ApplicationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationsController extends Controller
{
    /**
     * Display a listing of all applications across the platform
     */
    public function index(Request $request)
    {
        $query = JobApplication::with(['job.company', 'user.profile']);

        // Filter by job
        if ($request->filled('job_id')) {
            $query->where('job_id', $request->job_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by company
        if ($request->filled('company_id')) {
            $query->whereHas('job', function($q) use ($request) {
                $q->where('company_id', $request->company_id);
            });
        }

        // Search by applicant name or email
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('applied_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('applied_at', '<=', $request->date_to);
        }

        $applications = $query->latest('applied_at')->paginate(20);

        // Get all jobs for filter dropdown
        $jobs = Job::with('company')
            ->select('id', 'title', 'company_id')
            ->orderBy('title')
            ->get();

        // Get statistics
        $stats = [
            'total' => JobApplication::count(),
            'pending' => JobApplication::where('status', 'pending')->count(),
            'under_review' => JobApplication::where('status', 'under_review')->count(),
            'shortlisted' => JobApplication::where('status', 'shortlisted')->count(),
            'accepted' => JobApplication::where('status', 'accepted')->count(),
            'rejected' => JobApplication::where('status', 'rejected')->count(),
        ];

        return view('admin.applications.index', compact('applications', 'jobs', 'stats'));
    }

    /**
     * Display the specified application details
     */
    public function show(JobApplication $application)
    {
        $application->load([
            'job.company',
            'user.profile',
            'user.education',
            'user.experience',
            'user.skills',
            'user.documents'
        ]);

        return view('admin.applications.show', compact('application'));
    }

    /**
     * Update application status (admin can override)
     */
    public function updateStatus(Request $request, JobApplication $application)
    {
        $request->validate([
            'status' => 'required|in:' . collect(ApplicationStatus::cases())->pluck('value')->implode(','),
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $application->update([
            'status' => $request->status,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        // Add admin notes if provided
        if ($request->filled('admin_notes')) {
            $currentNotes = $application->notes ? $application->notes . "\n\n" : '';
            $application->update([
                'notes' => $currentNotes . "[Admin " . now()->format('Y-m-d H:i') . "]: " . $request->admin_notes
            ]);
        }

        return back()->with('success', 'Application status updated successfully.');
    }

    /**
     * View applicant resume (inline)
     */
    public function viewResume(JobApplication $application)
    {
        if (!$application->resume_path) {
            abort(404, 'Resume not found');
        }

        $path = $application->resume_path;
        if (!Storage::disk('private')->exists($path)) {
            abort(404, 'Resume file not found');
        }

        return response(Storage::disk('private')->get($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="resume_' . $application->user->name . '_' . $application->id . '.pdf"'
        ]);
    }

    /**
     * Download applicant resume
     */
    public function downloadResume(JobApplication $application)
    {
        if (!$application->resume_path) {
            abort(404, 'Resume not found');
        }

        $path = $application->resume_path;
        if (!Storage::disk('private')->exists($path)) {
            abort(404, 'Resume file not found');
        }

        $safeName = 'resume_' . $application->user->name . '_' . $application->id . '.' . pathinfo($path, PATHINFO_EXTENSION);
        return Storage::disk('private')->download($path, $safeName);
    }

    /**
     * View applicant document (inline)
     */
    public function viewDocument($documentId)
    {
        $document = \App\Models\UserDocument::findOrFail($documentId);

        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'Document file not found');
        }

        $mimeType = Storage::disk('public')->mimeType($document->file_path);

        return response(Storage::disk('public')->get($document->file_path), 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $document->original_name . '"'
        ]);
    }

    /**
     * Download applicant document
     */
    public function downloadDocument($documentId)
    {
        $document = \App\Models\UserDocument::findOrFail($documentId);

        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'Document file not found');
        }

        return Storage::disk('public')->download($document->file_path, $document->original_name);
    }

    /**
     * Bulk status update
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'application_ids' => 'required|array',
            'application_ids.*' => 'exists:job_applications,id',
            'status' => 'required|in:' . collect(ApplicationStatus::cases())->pluck('value')->implode(','),
        ]);

        $applications = JobApplication::whereIn('id', $request->application_ids)->get();

        $updated = 0;
        foreach ($applications as $application) {
            $application->update([
                'status' => $request->status,
                'reviewed_at' => now(),
                'reviewed_by' => auth()->id(),
            ]);
            $updated++;
        }

        return back()->with('success', "{$updated} application(s) updated successfully.");
    }

    /**
     * Export applications to CSV
     */
    public function export(Request $request)
    {
        $query = JobApplication::with(['job.company', 'user']);

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('job_id')) {
            $query->where('job_id', $request->job_id);
        }

        $applications = $query->latest('applied_at')->get();

        $filename = 'applications_' . now()->format('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($applications) {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, [
                'Application ID',
                'Applicant Name',
                'Email',
                'Phone',
                'Job Title',
                'Company',
                'Status',
                'Applied Date',
                'Reviewed Date',
            ]);

            // Data
            foreach ($applications as $app) {
                fputcsv($file, [
                    $app->id,
                    $app->user->name,
                    $app->user->email,
                    $app->user->phone ?? 'N/A',
                    $app->job->title,
                    $app->job->company->company_name ?? 'N/A',
                    ucfirst(str_replace('_', ' ', $app->status)),
                    $app->applied_at->format('Y-m-d H:i:s'),
                    $app->reviewed_at ? $app->reviewed_at->format('Y-m-d H:i:s') : 'Not reviewed',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
