<?php

namespace App\Livewire\Institution;

use App\Models\Country;
use App\Models\Degree;
use App\Models\Program;
use App\Models\Subject;
use App\Models\University;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class ProgramWizard extends Component
{
    public $currentStep = 1;
    public $totalSteps = 3;

    // Step 1: Basic Information
    public $title = '';
    public $university_id = '';
    public $country_id = '';

    // Step 2: Academic Details
    public $degree_id = '';
    public $subject_id = '';
    public $language = 'English';
    public $study_mode = 'On-campus';

    // Step 3: Fees & Admissions
    public $tuition_fee = '';
    public $duration = '';
    public $intake = '';
    public $application_deadline = '';
    public $program_url = '';
    public $description = '';

    protected function rules()
    {
        return [
            // Step 1
            'title' => ['required', 'string', 'max:255'],
            'university_id' => ['required', 'exists:universities,id'],
            'country_id' => ['required', 'exists:countries,id'],
            // Step 2
            'degree_id' => ['required', 'exists:degrees,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'language' => ['required', 'string', 'max:50'],
            'study_mode' => ['required', 'in:On-campus,Online,Hybrid'],
            // Step 3
            'tuition_fee' => ['nullable', 'numeric', 'min:0'],
            'duration' => ['nullable', 'string', 'max:100'],
            'intake' => ['nullable', 'string', 'max:100'],
            'application_deadline' => ['nullable', 'date'],
            'program_url' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
        ];
    }

    protected $messages = [
        'university_id.required' => 'Please select an institution.',
        'country_id.required' => 'Please select a country.',
        'degree_id.required' => 'Please select a degree level.',
        'subject_id.required' => 'Please select a subject/field.',
    ];

    public function nextStep()
    {
        \Log::info('NextStep called. Current step: ' . $this->currentStep);
        \Log::info('Form data: ', [
            'title' => $this->title,
            'university_id' => $this->university_id,
            'country_id' => $this->country_id,
        ]);

        // Validate current step
        $this->validateCurrentStep();

        // Move to next step
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
            \Log::info('Successfully moved to step: ' . $this->currentStep);

            // Dispatch event to notify step changed
            $this->dispatch('step-changed', step: $this->currentStep);
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function goToStep($step)
    {
        if ($step > 0 && $step <= $this->totalSteps && $step < $this->currentStep) {
            $this->currentStep = $step;
        }
    }

    protected function validateCurrentStep()
    {
        $rules = [];

        if ($this->currentStep == 1) {
            $rules = [
                'title' => $this->rules()['title'],
                'university_id' => $this->rules()['university_id'],
                'country_id' => $this->rules()['country_id'],
            ];
        } elseif ($this->currentStep == 2) {
            $rules = [
                'degree_id' => $this->rules()['degree_id'],
                'subject_id' => $this->rules()['subject_id'],
                'language' => $this->rules()['language'],
                'study_mode' => $this->rules()['study_mode'],
            ];
        }

        $this->validate($rules);
    }

    public function submit()
    {
        $this->validate();

        Program::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title . '-' . Str::random(6)),
            'university_id' => $this->university_id,
            'country_id' => $this->country_id,
            'degree_id' => $this->degree_id,
            'subject_id' => $this->subject_id,
            'language' => $this->language,
            'study_mode' => $this->study_mode,
            'tuition_fee' => $this->tuition_fee ?: null,
            'currency' => 'EUR',
            'duration' => $this->duration,
            'intake' => $this->intake,
            'application_deadline' => $this->application_deadline ?: null,
            'program_url' => $this->program_url,
            'description' => $this->description,
            'created_by' => Auth::id(),
            'is_featured' => false,
        ]);

        session()->flash('status', 'Program created successfully! 🎉');

        return redirect()->route('institution.programs.index');
    }

    public function render()
    {
        return view('livewire.institution.program-wizard', [
            'countries' => Country::orderBy('name')->get(),
            'degrees' => Degree::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
            'universities' => University::orderBy('name')->get(),
        ]);
    }
}
