<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Degree;
use App\Models\StudentProfile;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = StudentProfile::firstOrCreate(
            ['user_id' => Auth::id()],
            ['profile_completion' => 0]
        );

        $countries = Country::orderBy('name')->get();
        $degrees = Degree::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();

        return view('student.profile.edit', compact('profile', 'countries', 'degrees', 'subjects'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female,other'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'country_of_residence' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'current_education_level' => ['nullable', 'string', 'max:100'],
            'field_of_study' => ['nullable', 'string', 'max:200'],
            'institution_name' => ['nullable', 'string', 'max:200'],
            'gpa' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'gpa_scale' => ['nullable', 'string', 'max:10'],
            'expected_graduation' => ['nullable', 'integer', 'min:2020', 'max:2040'],
            'english_test_type' => ['nullable', 'string', 'max:50'],
            'english_test_score' => ['nullable', 'string', 'max:50'],
            'preferred_start_date' => ['nullable', 'string', 'max:50'],
            'budget_min' => ['nullable', 'numeric', 'min:0'],
            'budget_max' => ['nullable', 'numeric', 'min:0'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'achievements' => ['nullable', 'string', 'max:2000'],
            'extracurricular' => ['nullable', 'string', 'max:2000'],
            'work_experience' => ['nullable', 'string', 'max:2000'],
        ]);

        $profile = StudentProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            $data
        );

        $profile->calculateCompletion();

        return redirect()->route('student.profile.edit')
            ->with('status', 'Profile updated successfully!');
    }
}
