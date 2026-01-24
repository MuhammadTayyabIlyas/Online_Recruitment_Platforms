<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\ProgramApplication;
use Illuminate\Support\Facades\Auth;

class ProgramApplicationController extends Controller
{
    public function index()
    {
        $applications = ProgramApplication::with(['program', 'user'])
            ->whereHas('program', fn ($q) => $q->where('created_by', Auth::id()))
            ->latest()
            ->paginate(20);

        return view('institution.applications.index', compact('applications'));
    }

    public function show(ProgramApplication $application)
    {
        $this->authorizeOwner($application);

        return view('institution.applications.show', compact('application'));
    }

    public function updateStatus(ProgramApplication $application)
    {
        $this->authorizeOwner($application);

        request()->validate([
            'status' => ['required', 'in:pending,reviewing,accepted,rejected'],
        ]);

        $application->update(['status' => request('status')]);

        return back()->with('status', 'Application status updated.');
    }

    protected function authorizeOwner(ProgramApplication $application): void
    {
        abort_unless($application->program->created_by === Auth::id() || Auth::user()->hasRole('admin'), 403);
    }
}
