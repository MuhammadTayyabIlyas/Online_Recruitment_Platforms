<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\User;
use App\Notifications\EmployerContactNotification;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CvSearchController extends Controller
{
    public function __construct(protected SubscriptionService $subscriptionService)
    {
        // Middleware is applied in routes
    }

    public function index(Request $request)
    {
        // Check if company is approved for CV access
        if (!auth()->user()->company?->is_cv_access_approved) {
            return redirect()->route('employer.packages')
                ->with('error', 'You need an active subscription to access candidate profiles. Please choose a package below.');
        }

        $query = User::where('user_type', 'job_seeker')
            ->whereHas('profile', fn($q) => $q->where('is_searchable', true))
            ->with(['profile', 'skills', 'experience']);

        if ($request->filled('q')) {
            $query->where(fn($q) => $q->where('name', 'like', "%{$request->q}%")
                ->orWhereHas('profile', fn($p) => $p->where('bio', 'like', "%{$request->q}%")));
        }

        if ($request->filled('skills')) {
            $query->whereHas('skills', fn($q) => $q->whereIn('skills.id', $request->skills));
        }

        if ($request->filled('experience_level')) {
            $query->whereHas('experience', fn($q) => $q->selectRaw('count(*)')->having('count(*)', '>=', match($request->experience_level) {
                'entry' => 0, 'mid' => 2, 'senior' => 5, 'executive' => 10, default => 0
            }));
        }

        if ($request->filled('location')) {
            $query->whereHas('profile', fn($q) => $q->where('city', 'like', "%{$request->location}%")
                ->orWhere('country', 'like', "%{$request->location}%"));
        }

        $candidates = $query->paginate(20)->withQueryString();
        $skills = Skill::active()->popular(30)->get();

        return view('employer.cv-search.index', compact('candidates', 'skills'));
    }

    public function showCandidate(User $candidate)
    {
        // Check if company is approved for CV access
        if (!auth()->user()->company?->is_cv_access_approved) {
            return redirect()->route('employer.packages')
                ->with('error', 'You need an active subscription to view candidate profiles. Please choose a package below.');
        }

        if ($candidate->user_type !== 'job_seeker' || !$candidate->profile?->is_searchable) {
            abort(404);
        }

        // Check CV access credits
        $viewedKey = "cv_viewed_{$candidate->id}";
        if (!session()->has($viewedKey)) {
            if (!$this->subscriptionService->canAccessCv(auth()->user())) {
                return back()->with('error', 'No CV access credits remaining. Please upgrade your package.');
            }
            $this->subscriptionService->useCvCredit(auth()->user());
            session()->put($viewedKey, true);
        }

        $candidate->load(['profile', 'education', 'experience', 'skills', 'languages', 'certifications']);
        $hideContact = $candidate->profile?->hide_contact_info;

        return view('employer.cv-search.show', compact('candidate', 'hideContact'));
    }

    public function downloadResume(User $candidate)
    {
        if (!auth()->user()->company?->is_cv_access_approved) {
            return redirect()->route('employer.packages')
                ->with('error', 'You need an active subscription to download candidate resumes.');
        }

        if ($candidate->user_type !== 'job_seeker' || !$candidate->profile?->is_searchable) {
            abort(404);
        }

        $resume = $candidate->primaryResume;
        if (!$resume || !$resume->file_path) {
            abort(404, 'Resume not available.');
        }

        $viewedKey = "cv_viewed_{$candidate->id}";
        if (!session()->has($viewedKey)) {
            if (!$this->subscriptionService->canAccessCv(auth()->user())) {
                return back()->with('error', 'No CV access credits remaining. Please upgrade your package.');
            }
            $this->subscriptionService->useCvCredit(auth()->user());
            session()->put($viewedKey, true);
        }

        if (!Storage::disk('public')->exists($resume->file_path)) {
            abort(404, 'Resume not found.');
        }

        $safeName = 'resume_' . $candidate->id . '.' . pathinfo($resume->file_path, PATHINFO_EXTENSION);
        return Storage::disk('public')->download($resume->file_path, $safeName);
    }

    public function contact(Request $request, User $candidate)
    {
        $request->validate(['message' => 'required|string|max:2000']);

        $candidate->notify(new EmployerContactNotification(auth()->user(), $request->message));

        return back()->with('success', 'Message sent to candidate.');
    }
}
