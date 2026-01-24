<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\SavedJob;
use Illuminate\Http\Request;

class SavedJobController extends Controller
{
    public function index()
    {
        $savedJobs = auth()->user()->savedJobs()->with(['job.company', 'job.category'])->latest()->paginate(20);
        return view('jobseeker.saved-jobs.index', compact('savedJobs'));
    }

    public function store(Job $job)
    {
        $exists = SavedJob::where('user_id', auth()->id())->where('job_id', $job->id)->exists();

        if (!$exists) {
            SavedJob::create(['user_id' => auth()->id(), 'job_id' => $job->id]);
            return back()->with('success', 'Job saved successfully.');
        }

        return back()->with('info', 'Job already saved.');
    }

    public function destroy(Job $job)
    {
        SavedJob::where('user_id', auth()->id())->where('job_id', $job->id)->delete();
        return back()->with('success', 'Job removed from saved.');
    }

    public function toggle(Job $job)
    {
        $saved = SavedJob::where('user_id', auth()->id())->where('job_id', $job->id)->first();

        if ($saved) {
            $saved->delete();
            return response()->json(['saved' => false, 'message' => 'Job unsaved']);
        }

        SavedJob::create(['user_id' => auth()->id(), 'job_id' => $job->id]);
        return response()->json(['saved' => true, 'message' => 'Job saved']);
    }
}
