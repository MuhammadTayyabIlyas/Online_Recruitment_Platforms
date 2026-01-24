<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Notifications\CustomApplicationStatus;
use App\Enums\ApplicationStatus;
use App\Models\Job;
use App\Models\JobApplication;
use App\Notifications\ApplicationStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicantsController extends Controller
{
    public function index(Request $request)
    {
        $jobs = auth()->user()->jobs()->pluck('id');

        $query = JobApplication::with(['job', 'user.profile'])
            ->whereIn('job_id', $jobs);

        if ($request->filled('job_id')) {
            $query->where('job_id', $request->job_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%"));
        }

        $applications = $query->latest('applied_at')->paginate(20);
        $employerJobs = auth()->user()->jobs;

        return view('employer.applicants.index', compact('applications', 'employerJobs'));
    }

    public function show(JobApplication $application)
    {
        $this->authorize('view', $application);
        $application->load(['job', 'user.profile', 'user.education', 'user.experience', 'user.skills', 'user.documents']);
        return view('employer.applicants.show', compact('application'));
    }

    public function updateStatus(Request $request, JobApplication $application)
    {
        $this->authorize('update', $application);

        $request->validate([
            'status' => 'required|in:' . collect(ApplicationStatus::cases())->pluck('value')->implode(','),
            'message' => 'nullable|string|max:2000',
            'channels' => 'nullable|array',
            'channels.*' => 'in:email,whatsapp,viber',
        ]);

        $application->update([
            'status' => $request->status,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        $application->user->notify(new ApplicationStatusChanged($application));

        $contactLinks = $this->sendStatusNotifications($application, $request->input('channels', []), $request->input('message'));

        return back()
            ->with('success', 'Application status updated.')
            ->with('contact_links', $contactLinks);
    }

    public function updateRating(Request $request, JobApplication $application)
    {
        $this->authorize('update', $application);

        $request->validate(['rating' => 'required|integer|min:1|max:5']);
        $application->update(['rating' => $request->rating]);

        return back()->with('success', 'Rating updated.');
    }

    public function updateNotes(Request $request, JobApplication $application)
    {
        $this->authorize('update', $application);

        $request->validate(['notes' => 'nullable|string|max:2000']);
        $application->update(['notes' => $request->notes]);

        return back()->with('success', 'Notes saved.');
    }

    public function addNote(Request $request, JobApplication $application)
    {
        // Route alias to match existing POST route name
        return $this->updateNotes($request, $application);
    }

    public function downloadResume(JobApplication $application)
    {
        $this->authorize('view', $application);

        if (!$application->resume_path) {
            abort(404, 'Resume not found');
        }

        $path = $application->resume_path;
        if (!Storage::disk('private')->exists($path)) {
            abort(404, 'Resume not found');
        }

        $safeName = 'resume_' . $application->id . '.' . pathinfo($path, PATHINFO_EXTENSION);
        return Storage::disk('private')->download($path, $safeName);
    }

    public function bulkStatus(Request $request)
    {
        $request->validate([
            'application_ids' => 'required|array',
            'application_ids.*' => 'exists:job_applications,id',
            'status' => 'required|in:' . collect(ApplicationStatus::cases())->pluck('value')->implode(','),
            'message' => 'nullable|string|max:2000',
            'channels' => 'nullable|array',
            'channels.*' => 'in:email,whatsapp,viber',
        ]);

        $jobIds = auth()->user()->jobs()->pluck('id');
        $applications = JobApplication::whereIn('id', $request->application_ids)
            ->whereIn('job_id', $jobIds)
            ->get();

        $updated = 0;
        foreach ($applications as $application) {
            $application->update([
                'status' => $request->status,
                'reviewed_at' => now(),
                'reviewed_by' => auth()->id(),
            ]);
            $application->user->notify(new ApplicationStatusChanged($application));
            $this->sendStatusNotifications($application, $request->input('channels', []), $request->input('message'));
            $updated++;
        }

        return back()->with('success', "{$updated} application(s) updated.");
    }

    /**
     * Send optional custom messaging and generate quick contact links.
     */
    protected function sendStatusNotifications(JobApplication $application, array $channels, ?string $message): array
    {
        $links = [];
        $candidate = $application->user;

        if (in_array('email', $channels, true)) {
            $candidate->notify(new CustomApplicationStatus($application, $message));
        }

        $phone = $candidate->phone ? preg_replace('/\D+/', '', $candidate->phone) : null;
        if ($phone && $message) {
            if (in_array('whatsapp', $channels, true)) {
                $links['whatsapp'] = 'https://wa.me/' . $phone . '?text=' . urlencode($message);
            }
            if (in_array('viber', $channels, true)) {
                $links['viber'] = 'viber://chat?number=' . $phone . '&text=' . urlencode($message);
            }
        }

        return $links;
    }
}
