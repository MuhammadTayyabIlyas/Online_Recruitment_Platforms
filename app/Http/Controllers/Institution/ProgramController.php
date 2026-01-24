<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Degree;
use App\Models\Program;
use App\Models\Subject;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::with(['university', 'degree'])
            ->where('created_by', Auth::id())
            ->latest()
            ->paginate(15);

        return view('institution.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('institution.programs.create-wizard', [
            'countries' => Country::orderBy('name')->get(),
            'degrees' => Degree::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
            'universities' => University::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
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

        Program::create(array_merge($data, [
            'created_by' => Auth::id(),
            'slug' => Str::slug($data['title'] . '-' . Str::random(6)),
            'currency' => 'EUR',
        ]));

        return redirect()->route('institution.programs.index')->with('status', 'Program created successfully.');
    }

    public function edit(Program $program)
    {
        $this->authorizeOwner($program);

        return view('institution.programs.edit', [
            'program' => $program,
            'countries' => Country::orderBy('name')->get(),
            'degrees' => Degree::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
            'universities' => University::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Program $program)
    {
        $this->authorizeOwner($program);

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

        return redirect()->route('institution.programs.index')->with('status', 'Program updated.');
    }

    public function destroy(Program $program)
    {
        $this->authorizeOwner($program);
        $program->delete();

        return redirect()->route('institution.programs.index')->with('status', 'Program removed.');
    }

    protected function authorizeOwner(Program $program): void
    {
        abort_unless($program->created_by === Auth::id() || Auth::user()->hasRole('admin'), 403);
    }
}
