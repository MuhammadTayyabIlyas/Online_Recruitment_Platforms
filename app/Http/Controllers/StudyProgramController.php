<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\ProgramApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StudyProgramController extends Controller
{
    public function show($country, $slug)
    {
        $program = Program::where('slug', $slug)
            ->with(['university', 'country', 'degree', 'subject'])
            ->firstOrFail();

        $expectedCountrySlug = Str::slug($program->country->name);
        if ($country !== $expectedCountrySlug) {
            return redirect()->route('study-programs.show', [$expectedCountrySlug, $program->slug], 301);
        }

        $metaDescription = Str::limit(
            strip_tags($program->description ?? ($program->title . ' at ' . $program->university->name)),
            155
        );

        $existingApplication = null;
        if (Auth::check()) {
            $existingApplication = ProgramApplication::where('program_id', $program->id)
                ->where('user_id', Auth::id())
                ->first();
        }

        return view('study-programs.show', [
            'program' => $program,
            'metaDescription' => $metaDescription,
            'existingApplication' => $existingApplication,
        ]);
    }

    public function apply(Request $request, $country, $slug)
    {
        $request->validate([
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        $program = Program::where('slug', $slug)->firstOrFail();

        if (!Auth::check() || !Auth::user()->hasAnyRole(['student', 'job_seeker'])) {
            return redirect()->route('login')->with('status', 'Please sign in as a student to apply.');
        }

        ProgramApplication::firstOrCreate(
            [
                'program_id' => $program->id,
                'user_id' => Auth::id(),
            ],
            [
                'message' => $request->input('message'),
            ]
        );

        return back()->with('status', 'Application submitted successfully.');
    }
}
