<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use App\Models\Company;
use App\Models\Job;
use App\Models\Industry;
use App\Models\JobType;
use App\Models\Category;
use App\Models\EmploymentType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BulkImport extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-tray';
    protected static ?string $navigationLabel = 'Bulk Import';
    // protected static ?string $navigationGroup = 'Settings';
    
    protected static string $view = 'filament.pages.bulk-import';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Import Companies')
                    ->description('Upload a CSV file to import companies.')
                    ->schema([
                        FileUpload::make('company_file')
                            ->label('Companies CSV')
                            ->acceptedFileTypes(['text/csv', 'application/csv', 'application/vnd.ms-excel', 'text/plain'])
                            ->disk('public')
                            ->directory('imports')
                            ->visibility('private')
                            ->required(false),
                    ])
                    ->headerActions([
                        \Filament\Forms\Components\Actions\Action::make('downloadCompanySample')
                            ->label('Download Sample')
                            ->icon('heroicon-m-arrow-down-tray')
                            ->action(fn () => $this->downloadCompanySample()),
                    ]),

                Section::make('Import Jobs')
                    ->description('Upload a CSV file to import jobs.')
                    ->schema([
                        FileUpload::make('job_file')
                            ->label('Jobs CSV')
                            ->acceptedFileTypes(['text/csv', 'application/csv', 'application/vnd.ms-excel', 'text/plain'])
                            ->disk('public')
                            ->directory('imports')
                            ->visibility('private')
                            ->required(false),
                    ])
                    ->headerActions([
                        \Filament\Forms\Components\Actions\Action::make('downloadJobSample')
                            ->label('Download Sample')
                            ->icon('heroicon-m-arrow-down-tray')
                            ->action(fn () => $this->downloadJobSample()),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        
        $companyFiles = $data['company_file'] ?? [];
        $jobFiles = $data['job_file'] ?? [];
        
        // FileUpload can return a single string if not multiple, or array?
        // To be safe, cast to array if not null.
        if (is_string($companyFiles)) $companyFiles = [$companyFiles];
        if (is_string($jobFiles)) $jobFiles = [$jobFiles];

        if (empty($companyFiles) && empty($jobFiles)) {
            Notification::make()
                ->title('No file uploaded')
                ->warning()
                ->send();
            return;
        }

        if (!empty($companyFiles)) {
            foreach ($companyFiles as $file) {
                 $this->processCompanyImport($file);
            }
        }

        if (!empty($jobFiles)) {
            foreach ($jobFiles as $file) {
                $this->processJobImport($file);
            }
        }

        Notification::make() 
            ->title('Import processed successfully')
            ->success()
            ->send();
            
        // Reload to clear form
        $this->redirect(static::getUrl());
    }

    protected function processCompanyImport($filePath)
    {
        $path = Storage::disk('public')->path($filePath);
        
        if (!file_exists($path)) {
             return;
        }
        
        if (($handle = fopen($path, "r")) !== FALSE) {
            $header = fgetcsv($handle, 1000, ","); // Skip header
            
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (count($row) < 2) continue;
                
                // Map: company_name,email,website,tagline,description,industry,city,country,address,phone
                $name = $row[0] ?? null;
                $email = $row[1] ?? null;
                $website = $row[2] ?? null;
                $tagline = $row[3] ?? null;
                $description = $row[4] ?? null;
                $industryName = $row[5] ?? null;
                $city = $row[6] ?? null;
                $country = $row[7] ?? null;
                $address = $row[8] ?? null;
                $phone = $row[9] ?? null;

                if (!$name) continue;

                $industry = null;
                if ($industryName) {
                    $industry = Industry::firstOrCreate(
                        ['name' => $industryName],
                        ['slug' => Str::slug($industryName)]
                    );
                }

                Company::firstOrCreate(
                    ['email' => $email], // Use email as unique identifier if present, else create
                    [
                        'user_id' => auth()->id(),
                        'company_name' => $name,
                        'slug' => Str::slug($name),
                        'website' => $website,
                        'tagline' => $tagline,
                        'description' => $description,
                        'industry_id' => $industry?->id,
                        'city' => $city,
                        'country' => $country,
                        'address' => $address,
                        'phone' => $phone,
                        'is_active' => true,
                        'is_verified' => true,
                    ]
                );
            }
            fclose($handle);
        }
    }

    protected function processJobImport($filePath)
    {
        $path = Storage::disk('public')->path($filePath);
        
        if (!file_exists($path)) {
             return;
        }
        
        if (($handle = fopen($path, "r")) !== FALSE) {
            $header = fgetcsv($handle, 1000, ","); // Skip header
            
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (count($row) < 3) continue;
                
                // Map: title,company_email,description,min_salary,max_salary,location,is_remote,job_type,industry,employment_type,category
                $title = $row[0] ?? null;
                $companyEmail = $row[1] ?? null;
                $description = $row[2] ?? null;
                $minSalary = $row[3] ?? null;
                $maxSalary = $row[4] ?? null;
                $location = $row[5] ?? null;
                $isRemote = $row[6] ?? 0;
                $jobTypeName = $row[7] ?? null;
                $industryName = $row[8] ?? null;
                $employmentTypeName = $row[9] ?? null;
                $categoryName = $row[10] ?? null;

                if (!$title || !$companyEmail) continue;

                $company = Company::where('email', $companyEmail)->first();
                if (!$company) continue; // Must have valid company

                $industry = null;
                if ($industryName) {
                    $industry = Industry::firstOrCreate(
                        ['name' => $industryName],
                        ['slug' => Str::slug($industryName)]
                    );
                }
                
                $category = null;
                if ($categoryName) {
                    $category = Category::firstOrCreate(
                        ['name' => $categoryName],
                        ['slug' => Str::slug($categoryName)]
                    );
                }

                $jobType = null;
                if ($jobTypeName) {
                    $jobType = JobType::firstOrCreate(
                        ['name' => $jobTypeName],
                        ['slug' => Str::slug($jobTypeName)]
                    );
                }

                $employmentType = null;
                if ($employmentTypeName) {
                    $employmentType = EmploymentType::firstOrCreate(
                        ['name' => $employmentTypeName],
                        ['slug' => Str::slug($employmentTypeName)]
                    );
                }

                Job::create([
                    'user_id' => auth()->id(),
                    'company_id' => $company->id,
                    'title' => $title,
                    'slug' => Str::slug($title) . '-' . Str::random(6),
                    'description' => $description,
                    'min_salary' => is_numeric($minSalary) ? $minSalary : null,
                    'max_salary' => is_numeric($maxSalary) ? $maxSalary : null,
                    'location' => $location,
                    'is_remote' => (bool)$isRemote,
                    'job_type_id' => $jobType?->id,
                    'industry_id' => $industry?->id,
                    'employment_type_id' => $employmentType?->id,
                    'category_id' => $category?->id,
                    'status' => 'published',
                    'published_at' => now(),
                ]);
            }
            fclose($handle);
        }
    }
    
    public function downloadCompanySample()
    {
        return response()->streamDownload(function () {
            echo "company_name,email,website,tagline,description,industry,city,country,address,phone\n";
            echo "Acme Corp,contact@acme.com,https://acme.com,We make everything,\"The best company in the world.\",Technology,New York,USA,123 Main St,123-456-7890\n";
        }, 'sample_companies.csv');
    }

    public function downloadJobSample()
    {
        return response()->streamDownload(function () {
            echo "title,company_email,description,min_salary,max_salary,location,is_remote,job_type,industry,employment_type,category\n";
            echo "Senior Developer,contact@acme.com,\"We are looking for a dev.\",100000,150000,New York,1,Full Time,Technology,Full-time,Engineering\n";
        }, 'sample_jobs.csv');
    }
}