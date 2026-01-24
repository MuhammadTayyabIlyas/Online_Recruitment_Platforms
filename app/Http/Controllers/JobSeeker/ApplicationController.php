<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobSeeker\StoreApplicationRequest;
use App\Models\JobApplication;
use App\Models\Job;
use App\Enums\ApplicationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationReceived;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the user's job applications.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $applications = JobApplication::with(['job.company'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('jobseeker.applications.index', compact('applications'));
    }

    /**
     * Display the specified application details.
     *
     * @param  \App\Models\JobApplication  $application
     * @return \Illuminate\View\View
     */
    public function show(JobApplication $application)
    {
        $this->authorizeApplication($application);

        $application->load(['job.company', 'job.questions']);

        return view('jobseeker.applications.show', compact('application'));
    }

    /**
     * Show the application form for a job.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\View\View
     */
    public function create(Job $job)
    {
        // Check if already applied
        $existingApplication = JobApplication::where('user_id', Auth::id())
            ->where('job_id', $job->id)
            ->first();

        if ($existingApplication) {
            return redirect()
                ->route('jobseeker.applications.show', $existingApplication)
                ->with('info', 'You have already applied for this job.');
        }

        // Check if job is still accepting applications
        if ($job->status !== 'published' || ($job->expires_at && $job->expires_at->isPast())) {
            return back()->with('error', 'This job is no longer accepting applications.');
        }

        $job->load('questions');

        return view('jobseeker.applications.create', compact('job'));
    }

    /**
     * Store a new job application.
     *
     * @param  \App\Http\Requests\JobSeeker\StoreApplicationRequest  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreApplicationRequest $request, Job $job)
    {
        // Check if job is still accepting applications
        if ($job->status !== 'published' || ($job->expires_at && $job->expires_at->isPast())) {
            return back()->with('error', 'This job is no longer accepting applications.');
        }

        $resumePath = null;

        try {
            return DB::transaction(function () use ($request, $job, &$resumePath) {
                // Check for existing application with lock to prevent race condition
                $existingApplication = JobApplication::where('user_id', Auth::id())
                    ->where('job_id', $job->id)
                    ->lockForUpdate()
                    ->first();

                if ($existingApplication) {
                    return back()->with('error', 'You have already applied for this job.');
                }

                // Handle resume upload to private storage
                $resumePath = $request->file('resume')->store(
                    'resumes/' . Auth::id() . '/' . uniqid(),
                    'private'
                );

                // Sanitize and prepare answers (model has array cast, so pass array directly)
                $answers = null;
                if ($request->has('answers') && is_array($request->answers)) {
                    $answers = array_map(function ($answer) {
                        return strip_tags(trim($answer));
                    }, $request->answers);
                }

                // Sanitize cover letter
                $coverLetter = strip_tags($request->cover_letter);

                // Create application
                $application = JobApplication::create([
                    'user_id' => Auth::id(),
                    'job_id' => $job->id,
                    'cover_letter' => $coverLetter,
                    'resume_path' => $resumePath,
                    'answers' => $answers,
                    'status' => ApplicationStatus::PENDING->value,
                    'applied_at' => now(),
                ]);

                // Send Application Received Email
                try {
                    Mail::to(Auth::user())->send(new ApplicationReceived($application));
                } catch (\Exception $e) {
                    Log::error('Failed to send application received email', [
                        'application_id' => $application->id,
                        'error' => $e->getMessage()
                    ]);
                }

                Log::info('Application submitted', [
                    'application_id' => $application->id,
                    'user_id' => Auth::id(),
                    'job_id' => $job->id,
                ]);

                return redirect()
                    ->route('jobseeker.applications.show', $application)
                    ->with('success', 'Application submitted successfully!');
            });

        } catch (QueryException $e) {
            // Handle duplicate key violation (race condition fallback)
            if ($e->errorInfo[1] === 1062) {
                return back()->with('error', 'You have already applied for this job.');
            }

            Log::error('Database error during application submission', [
                'user_id' => Auth::id(),
                'job_id' => $job->id,
                'error' => $e->getMessage(),
            ]);

            $this->cleanupResume($resumePath);

            return back()
                ->withInput()
                ->with('error', 'Failed to submit application. Please try again.');

        } catch (\Exception $e) {
            Log::error('Failed to submit application', [
                'user_id' => Auth::id(),
                'job_id' => $job->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->cleanupResume($resumePath);

            return back()
                ->withInput()
                ->with('error', 'Failed to submit application. Please try again.');
        }
    }

    /**
     * Withdraw the specified application.
     *
     * @param  \App\Models\JobApplication  $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function withdraw(JobApplication $application)
    {
        $this->authorizeApplication($application);

        $withdrawableStatuses = [
            ApplicationStatus::PENDING->value,
            ApplicationStatus::UNDER_REVIEW->value,
        ];

        if (!in_array($application->status, $withdrawableStatuses, true)) {
            return back()->with('error', 'This application cannot be withdrawn at this stage.');
        }

        try {
            $application->update([
                'status' => ApplicationStatus::WITHDRAWN->value,
                'withdrawn_at' => now(),
            ]);

            Log::info('Application withdrawn', [
                'application_id' => $application->id,
                'user_id' => Auth::id(),
            ]);

            return back()->with('success', 'Application withdrawn successfully.');

        } catch (\Exception $e) {
            Log::error('Failed to withdraw application', [
                'application_id' => $application->id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Failed to withdraw application. Please try again.');
        }
    }

    /**
     * Download the resume file.
     *
     * @param  \App\Models\JobApplication  $application
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadResume(JobApplication $application)
    {
        $this->authorizeApplication($application);

        $filePath = $application->resume_path;

        if (empty($filePath) || !Storage::disk('private')->exists($filePath)) {
            abort(404, 'Resume file not found.');
        }

        // Generate a safe filename for download
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $safeFilename = 'resume_' . $application->id . '.' . $extension;

        return Storage::disk('private')->download($filePath, $safeFilename);
    }

    /**
     * Authorize that the current user owns the application.
     *
     * @param  \App\Models\JobApplication  $application
     * @return void
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    private function authorizeApplication(JobApplication $application): void
    {
        if ($application->user_id !== Auth::id()) {
            Log::warning('Unauthorized application access attempt', [
                'application_id' => $application->id,
                'application_owner' => $application->user_id,
                'attempted_by' => Auth::id(),
            ]);
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Clean up uploaded resume file.
     *
     * @param  string|null  $resumePath
     * @return void
     */
    private function cleanupResume(?string $resumePath): void
    {
        if ($resumePath && Storage::disk('private')->exists($resumePath)) {
            Storage::disk('private')->delete($resumePath);
        }
    }
}
