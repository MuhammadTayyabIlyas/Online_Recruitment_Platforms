<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Degree;
use App\Models\Program;
use App\Models\ProgramApplication;
use App\Models\Subject;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = Program::with(['university', 'degree', 'subject', 'country', 'creator'])
            ->withCount('applications');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('university', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Degree filter
        if ($request->filled('degree')) {
            $query->where('degree_id', $request->degree);
        }

        // Subject filter
        if ($request->filled('subject')) {
            $query->where('subject_id', $request->subject);
        }

        // Country filter
        if ($request->filled('country')) {
            $query->where('country_id', $request->country);
        }

        // Study mode filter
        if ($request->filled('study_mode')) {
            $query->where('study_mode', $request->study_mode);
        }

        $programs = $query->latest()->paginate(20)->withQueryString();

        // Get filter options
        $degrees = Degree::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();
        $studyModes = ['On-campus', 'Online', 'Hybrid'];

        // Statistics
        $stats = [
            'total' => Program::count(),
            'with_applications' => Program::has('applications')->count(),
            'by_degree' => Program::select('degree_id')
                ->groupBy('degree_id')
                ->get()
                ->count(),
            'by_country' => Program::select('country_id')
                ->groupBy('country_id')
                ->get()
                ->count(),
        ];

        return view('admin.programs.index', compact(
            'programs',
            'degrees',
            'subjects',
            'countries',
            'studyModes',
            'stats'
        ));
    }

    public function show(Program $program)
    {
        $program->load([
            'university',
            'degree',
            'subject',
            'country',
            'creator',
            'applications.user'
        ]);

        return view('admin.programs.show', compact('program'));
    }

    public function edit(Program $program)
    {
        return view('admin.programs.edit', [
            'program' => $program,
            'countries' => Country::orderBy('name')->get(),
            'degrees' => Degree::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
            'universities' => University::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Program $program)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'university_id' => ['required', 'exists:universities,id'],
            'country_id' => ['required', 'exists:countries,id'],
            'degree_id' => ['required', 'exists:degrees,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'language' => ['required', 'string', 'max:50'],
            'tuition_fee' => ['nullable', 'numeric', 'min:0'],
            'duration' => ['nullable', 'string', 'max:100'],
            'intake' => ['nullable', 'string', 'max:100'],
            'study_mode' => ['required', 'string', 'max:30'],
            'program_url' => ['nullable', 'url', 'max:255'],
            'application_deadline' => ['nullable', 'date'],
        ]);

        $program->update(array_merge($data, [
            'slug' => $program->slug ?: Str::slug($data['title'] . '-' . Str::random(6)),
        ]));

        return redirect()->route('admin.programs.index')
            ->with('status', 'Program updated successfully.');
    }

    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->route('admin.programs.index')
            ->with('status', 'Program deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => ['required', 'in:delete'],
            'program_ids' => ['required', 'array'],
            'program_ids.*' => ['exists:programs,id'],
        ]);

        $programs = Program::whereIn('id', $request->program_ids);

        switch ($request->action) {
            case 'delete':
                $programs->delete();
                $message = 'Selected programs deleted successfully.';
                break;
            default:
                $message = 'Invalid action.';
        }

        return redirect()->route('admin.programs.index')
            ->with('status', $message);
    }

    public function showApplication(Program $program, ProgramApplication $application)
    {
        // Verify the application belongs to this program
        if ($application->program_id !== $program->id) {
            abort(404);
        }

        $application->load(['user', 'program.university', 'program.degree', 'program.subject']);

        return view('admin.programs.application-show', compact('program', 'application'));
    }

    public function updateApplicationStatus(Request $request, Program $program, ProgramApplication $application)
    {
        $request->validate([
            'status' => ['required', 'in:pending,under_review,accepted,rejected'],
        ]);

        // Verify the application belongs to this program
        if ($application->program_id !== $program->id) {
            abort(404);
        }

        $oldStatus = $application->status;
        $application->update([
            'status' => $request->status,
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.programs.show', $program)
            ->with('status', "Application status updated from " . ucfirst(str_replace('_', ' ', $oldStatus)) . " to " . ucfirst(str_replace('_', ' ', $request->status)) . ".");
    }

    public function updateApplicationNotes(Request $request, Program $program, ProgramApplication $application)
    {
        $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        // Verify the application belongs to this program
        if ($application->program_id !== $program->id) {
            abort(404);
        }

        $application->update([
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.programs.application.show', [$program, $application])
            ->with('status', 'Admin notes updated successfully.');
    }
}
