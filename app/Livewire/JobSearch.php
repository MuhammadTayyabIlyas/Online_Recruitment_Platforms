<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\EmploymentType;
use App\Models\Job;
use App\Models\JobType;
use Livewire\Component;
use Livewire\WithPagination;

class JobSearch extends Component
{
    use WithPagination;

    // Search Parameters
    public $search = '';
    public $location = '';
    public $category = '';
    public $jobType = '';
    public $employmentType = '';
    public $experience = '';
    public $isRemote = false;
    public $minSalary = '';
    public $sort = 'latest';

    // Query String Handling
    protected $queryString = [
        'search' => ['except' => ''],
        'location' => ['except' => ''],
        'category' => ['except' => ''],
        'jobType' => ['except' => ''],
        'employmentType' => ['except' => ''],
        'experience' => ['except' => ''],
        'isRemote' => ['except' => false],
        'minSalary' => ['except' => ''],
        'sort' => ['except' => 'latest'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingLocation()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Job::active()->with(['company', 'category', 'jobType', 'employmentType']);

        // Keyword Search
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%")
                  ->orWhereHas('company', function ($q) {
                      $q->where('company_name', 'like', "%{$this->search}%");
                  });
            });
        }

        // Location Search
        if (!empty($this->location)) {
            $query->where(function ($q) {
                $q->where('city', 'like', "%{$this->location}%")
                  ->orWhere('country', 'like', "%{$this->location}%");
            });
        }

        // Filters
        if (!empty($this->category)) {
            $query->where('category_id', $this->category);
        }

        if (!empty($this->jobType)) {
            $query->where('job_type_id', $this->jobType);
        }

        if (!empty($this->employmentType)) {
            $query->where('employment_type_id', $this->employmentType);
        }

        if (!empty($this->experience)) {
            $query->where('experience_level', $this->experience);
        }

        if ($this->isRemote) {
            $query->where('is_remote', true);
        }

        if (!empty($this->minSalary)) {
            $query->where('max_salary', '>=', $this->minSalary);
        }

        // Sorting
        match ($this->sort) {
            'oldest' => $query->oldest('published_at'),
            'popular' => $query->orderByDesc('views_count'),
            'salary_high' => $query->orderByDesc('max_salary'),
            'salary_low' => $query->orderBy('min_salary'),
            default => $query->latest('published_at'),
        };

        return view('livewire.job-search', [
            'jobs' => $query->paginate(12),
            'categories' => Category::active()->withCount('jobs')->ordered()->get(),
            'jobTypes' => JobType::active()->get(),
            'employmentTypes' => EmploymentType::active()->get(),
        ]);
    }

    public function selectJobType($value)
    {
        // If clicking the same value, deselect it (set to empty)
        if ($this->jobType == $value && $value !== '') {
            $this->jobType = '';
        } else {
            $this->jobType = $value;
        }
        $this->resetPage();
    }

    public function selectCategory($value)
    {
        // If clicking the same value, deselect it (set to empty)
        if ($this->category == $value && $value !== '') {
            $this->category = '';
        } else {
            $this->category = $value;
        }
        $this->resetPage();
    }

    public function selectExperience($value)
    {
        // If clicking the same value, deselect it (set to empty)
        if ($this->experience == $value && $value !== '') {
            $this->experience = '';
        } else {
            $this->experience = $value;
        }
        $this->resetPage();
    }

    public function clearFilters()
    {
        // Reset all filter properties to their default values (empty string or false)
        $this->search = '';
        $this->location = '';
        $this->category = '';
        $this->jobType = '';
        $this->employmentType = '';
        $this->experience = '';
        $this->isRemote = false;
        $this->minSalary = '';
        $this->sort = 'latest';

        // Reset pagination to page 1
        $this->resetPage();

        // Dispatch browser event to ensure radio buttons are visually unchecked
        $this->dispatch('filters-cleared');
    }
}
