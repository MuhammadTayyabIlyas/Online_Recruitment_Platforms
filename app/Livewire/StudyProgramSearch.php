<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\Degree;
use App\Models\Program;
use App\Models\SavedSearch;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class StudyProgramSearch extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCountry = '';
    public $selectedDegree = '';
    public $selectedSubject = '';
    public $selectedStudyMode = '';
    public $selectedLanguage = '';
    public $selectedIntake = '';
    public $subjectSearch = '';
    public $minFee = null;
    public $maxFee = null;
    public $feeSort = '';

    // Saved search properties
    public $showSaveSearchModal = false;
    public $searchName = '';
    public $savedSearches = [];

    public function mount(): void
    {
        // Country is required; default to first available country if none selected.
        if (empty($this->selectedCountry)) {
            $this->selectedCountry = $this->defaultCountryId() ?? '';
        }
    }

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCountry' => ['except' => '', 'as' => 'country'],
        'selectedDegree' => ['except' => '', 'as' => 'degree'],
        'selectedSubject' => ['except' => '', 'as' => 'subject'],
        'selectedStudyMode' => ['except' => '', 'as' => 'mode'],
        'selectedLanguage' => ['except' => '', 'as' => 'lang'],
        'selectedIntake' => ['except' => '', 'as' => 'intake'],
        'minFee' => ['except' => null, 'as' => 'min_fee'],
        'maxFee' => ['except' => null, 'as' => 'max_fee'],
        'feeSort' => ['except' => '', 'as' => 'sort_fee'],
    ];

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'selectedCountry' => ['required', 'integer', 'exists:countries,id'],
            'selectedDegree' => ['nullable', 'integer', 'exists:degrees,id'],
            'selectedSubject' => ['nullable', 'integer', 'exists:subjects,id'],
            'selectedStudyMode' => ['nullable', Rule::in(['On-campus', 'Online', 'Hybrid'])],
            'selectedLanguage' => ['nullable', 'string', 'max:50'],
            'selectedIntake' => ['nullable', 'string', 'max:50'],
            'subjectSearch' => ['nullable', 'string', 'max:50'],
            'minFee' => ['nullable', 'numeric', 'min:0'],
            'maxFee' => ['nullable', 'numeric', 'min:0'],
            'feeSort' => ['nullable', Rule::in(['', 'low_high', 'high_low'])],
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updated($propertyName)
    {
        if (array_key_exists($propertyName, $this->rules())) {
            $this->validateOnly($propertyName);
            $this->resetPage();
        }
    }

    public function applyFilters(): void
    {
        $this->validate();
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset([
            'search',
            'selectedCountry',
            'selectedDegree',
            'selectedSubject',
            'selectedStudyMode',
            'selectedLanguage',
            'selectedIntake',
            'subjectSearch',
            'minFee',
            'maxFee',
            'feeSort',
        ]);

        $this->selectedCountry = $this->defaultCountryId() ?? '';

        $this->resetPage();
    }

    protected function normalizeId($value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        $value = (int) $value;

        return $value > 0 ? $value : null;
    }

    protected function normalizeFee($value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        $fee = filter_var($value, FILTER_VALIDATE_FLOAT);

        return $fee === false ? null : max(0, (float) $fee);
    }

    public function saveSearch(): void
    {
        if (!Auth::check()) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'Please log in to save searches']);
            return;
        }

        $this->validate([
            'searchName' => ['required', 'string', 'max:100'],
        ]);

        SavedSearch::create([
            'user_id' => Auth::id(),
            'name' => $this->searchName,
            'search_type' => 'programs',
            'filters' => [
                'search' => $this->search,
                'selectedCountry' => $this->selectedCountry,
                'selectedDegree' => $this->selectedDegree,
                'selectedSubject' => $this->selectedSubject,
                'selectedStudyMode' => $this->selectedStudyMode,
                'selectedLanguage' => $this->selectedLanguage,
                'selectedIntake' => $this->selectedIntake,
                'minFee' => $this->minFee,
                'maxFee' => $this->maxFee,
                'feeSort' => $this->feeSort,
            ],
        ]);

        $this->showSaveSearchModal = false;
        $this->searchName = '';
        $this->loadSavedSearches();
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Search saved successfully']);
    }

    public function loadSearch($savedSearchId): void
    {
        if (!Auth::check()) {
            return;
        }

        $savedSearch = SavedSearch::where('id', $savedSearchId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$savedSearch) {
            return;
        }

        $filters = $savedSearch->filters;
        $this->search = $filters['search'] ?? '';
        $this->selectedCountry = $filters['selectedCountry'] ?? '';
        $this->selectedDegree = $filters['selectedDegree'] ?? '';
        $this->selectedSubject = $filters['selectedSubject'] ?? '';
        $this->selectedStudyMode = $filters['selectedStudyMode'] ?? '';
        $this->selectedLanguage = $filters['selectedLanguage'] ?? '';
        $this->selectedIntake = $filters['selectedIntake'] ?? '';
        $this->minFee = $filters['minFee'] ?? null;
        $this->maxFee = $filters['maxFee'] ?? null;
        $this->feeSort = $filters['feeSort'] ?? '';

        $this->resetPage();
    }

    public function deleteSavedSearch($savedSearchId): void
    {
        if (!Auth::check()) {
            return;
        }

        SavedSearch::where('id', $savedSearchId)
            ->where('user_id', Auth::id())
            ->delete();

        $this->loadSavedSearches();
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Saved search deleted']);
    }

    protected function loadSavedSearches(): void
    {
        if (Auth::check()) {
            $this->savedSearches = SavedSearch::where('user_id', Auth::id())
                ->where('search_type', 'programs')
                ->orderBy('created_at', 'desc')
                ->get()
                ->toArray();
        }
    }

    public function render()
    {
        $this->loadSavedSearches();

        $query = Program::query()
            ->with(['university', 'country', 'degree', 'subject']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhereHas('university', function ($u) {
                      $u->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->selectedCountry) {
            if ($countryId = $this->normalizeId($this->selectedCountry)) {
                $query->where('country_id', $countryId);
            }
        }

        if ($this->selectedDegree) {
            if ($degreeId = $this->normalizeId($this->selectedDegree)) {
                $query->where('degree_id', $degreeId);
            }
        }

        if ($this->selectedSubject) {
            if ($subjectId = $this->normalizeId($this->selectedSubject)) {
                $query->where('subject_id', $subjectId);
            }
        }

        if ($this->selectedStudyMode) {
            $query->where('study_mode', $this->selectedStudyMode);
        }

        if ($this->selectedLanguage) {
            $query->where('language', $this->selectedLanguage);
        }

        if ($this->selectedIntake) {
            $query->where('intake', 'like', '%' . $this->selectedIntake . '%');
        }

        $minFee = $this->normalizeFee($this->minFee);
        $maxFee = $this->normalizeFee($this->maxFee);

        if (!is_null($minFee) && !is_null($maxFee) && $maxFee >= $minFee) {
            $query->whereBetween('tuition_fee', [$minFee, $maxFee]);
        } elseif (!is_null($minFee)) {
            $query->where('tuition_fee', '>=', $minFee);
        } elseif (!is_null($maxFee)) {
            $query->where('tuition_fee', '<=', $maxFee);
        }

        if ($this->feeSort === 'low_high') {
            $query->orderBy('tuition_fee')->orderByDesc('created_at');
        } elseif ($this->feeSort === 'high_low') {
            $query->orderByDesc('tuition_fee')->orderByDesc('created_at');
        } else {
            $query->latest();
        }

        return view('livewire.study-program-search', [
            'programs' => $query->paginate(12),
            'countries' => Country::orderBy('name')->get(),
            'degrees' => Degree::orderBy('name')->get(),
            'subjects' => Subject::when($this->subjectSearch, function ($q) {
                    $q->where('name', 'like', '%' . $this->subjectSearch . '%');
                })
                ->orderBy('name')
                ->limit(100)
                ->get(),
            'languages' => Program::whereNotNull('language')->select('language')->distinct()->orderBy('language')->pluck('language'),
        ]);
    }

    protected function defaultCountryId(): ?int
    {
        return Country::orderBy('name')->value('id');
    }
}
