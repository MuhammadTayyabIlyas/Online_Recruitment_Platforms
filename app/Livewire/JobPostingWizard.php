<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\EmploymentType;
use App\Models\Industry;
use App\Models\Job;
use App\Models\JobType;
use App\Models\Skill;
use Illuminate\Support\Str;
use Livewire\Component;

class JobPostingWizard extends Component
{
    public int $step = 1;
    public int $totalSteps = 6;

    // Step 1: Basic Info
    public string $title = '';
    public ?int $category_id = null;
    public ?int $industry_id = null;
    public ?int $job_type_id = null;
    public ?int $employment_type_id = null;
    public string $location = '';
    public string $city = '';
    public string $country = '';
    public bool $is_remote = false;

    // Step 2: Details
    public string $description = '';
    public string $responsibilities = '';
    public string $requirements = '';
    public ?string $experience_level = null;
    public ?string $education_level = null;

    // Step 3: Compensation
    public ?float $min_salary = null;
    public ?float $max_salary = null;
    public string $salary_currency = 'USD';
    public string $salary_period = 'yearly';
    public bool $hide_salary = false;
    public array $benefits = [];

    // Step 4: Application
    public string $apply_type = 'internal';
    public ?string $external_apply_url = null;
    public ?string $apply_email = null;

    // Step 5: Skills
    public array $selected_skills = [];

    // Step 6: Questions
    public array $questions = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'category_id' => 'nullable|exists:categories,id',
        'description' => 'required|string|min:100',
    ];

    public function nextStep()
    {
        $this->validateStep();
        if ($this->step < $this->totalSteps) {
            $this->step++;
        }
    }

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    protected function validateStep()
    {
        match ($this->step) {
            1 => $this->validate(['title' => 'required|max:255']),
            2 => $this->validate(['description' => 'required|min:50']),
            default => null,
        };
    }

    public function addQuestion()
    {
        $this->questions[] = ['question' => '', 'type' => 'text', 'is_required' => false, 'options' => []];
    }

    public function removeQuestion($index)
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
    }

    public function saveDraft()
    {
        return $this->save('draft');
    }

    public function publish()
    {
        return $this->save('published');
    }

    protected function save($status)
    {
        $job = Job::create([
            'uuid' => Str::uuid(),
            'title' => $this->title,
            'slug' => Str::slug($this->title) . '-' . Str::random(6),
            'company_id' => auth()->user()->company->id,
            'user_id' => auth()->id(),
            'category_id' => $this->category_id,
            'industry_id' => $this->industry_id,
            'job_type_id' => $this->job_type_id,
            'employment_type_id' => $this->employment_type_id,
            'description' => $this->description,
            'responsibilities' => $this->responsibilities,
            'requirements' => $this->requirements,
            'experience_level' => $this->experience_level,
            'education_level' => $this->education_level,
            'min_salary' => $this->min_salary,
            'max_salary' => $this->max_salary,
            'salary_currency' => $this->salary_currency,
            'salary_period' => $this->salary_period,
            'hide_salary' => $this->hide_salary,
            'benefits' => $this->benefits,
            'location' => $this->location,
            'city' => $this->city,
            'country' => $this->country,
            'is_remote' => $this->is_remote,
            'apply_type' => $this->apply_type,
            'external_apply_url' => $this->external_apply_url,
            'apply_email' => $this->apply_email,
            'status' => $status,
            'published_at' => $status === 'published' ? now() : null,
            'expires_at' => $status === 'published' ? now()->addDays(30) : null,
        ]);

        $job->skills()->sync($this->selected_skills);

        foreach ($this->questions as $index => $q) {
            if (!empty($q['question'])) {
                $job->questions()->create([
                    'question' => $q['question'],
                    'type' => $q['type'],
                    'is_required' => $q['is_required'],
                    'options' => $q['options'] ?? [],
                    'sort_order' => $index,
                ]);
            }
        }

        session()->flash('success', $status === 'published' ? 'Job published!' : 'Draft saved!');
        return redirect()->route('employer.jobs.show', $job);
    }

    public function render()
    {
        return view('livewire.job-posting-wizard', [
            'categories' => Category::active()->ordered()->get(),
            'industries' => Industry::active()->ordered()->get(),
            'jobTypes' => JobType::active()->ordered()->get(),
            'employmentTypes' => EmploymentType::active()->ordered()->get(),
            'skills' => Skill::active()->ordered()->get(),
        ]);
    }
}
