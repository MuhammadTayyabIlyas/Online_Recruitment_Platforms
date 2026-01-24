<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use App\Models\Industry;
use App\Models\Category;
use App\Models\JobType;
use App\Models\EmploymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'app_name' => config('app.name'),
            'app_url' => config('app.url'),
            'mail_from_address' => config('mail.from.address'),
            'mail_from_name' => config('mail.from.name'),
        ];

        // Get system info
        $systemInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'environment' => config('app.env'),
            'debug_mode' => config('app.debug') ? 'Enabled' : 'Disabled',
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
            'queue_driver' => config('queue.default'),
        ];

        return view('admin.settings.index', compact('settings', 'systemInfo'));
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');

        return back()->with('success', 'All caches cleared successfully.');
    }

    public function optimizeApp()
    {
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');

        return back()->with('success', 'Application optimized successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            // Explicitly validate against the current guard to avoid silent skips
            'current_password' => ['required', 'current_password:web'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = $request->user()->fresh();

        // Extra safety: ensure the provided current password matches
        if (! Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The provided password does not match your current password.'],
            ]);
        }

        // Cast will hash automatically; forceFill avoids mass-assignment issues
        $user->forceFill([
            'password' => $request->password,
        ])->save();

        // Invalidate other sessions so the old password cannot be reused elsewhere
        Auth::logoutOtherDevices($request->password);

        return back()->with('success', 'Password changed successfully.');
    }

    // CSV Sample Templates Download
    public function downloadCompaniesSample()
    {
        $filename = 'companies_sample_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = [
            'employer_email', 'company_name', 'tagline', 'description', 'industry_name',
            'company_size', 'founded_year', 'website', 'email', 'phone',
            'address', 'city', 'state', 'country', 'postal_code'
        ];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            // Add sample data row
            fputcsv($file, [
                'employer@example.com',
                'Tech Solutions Inc',
                'Innovative Solutions for Modern Problems',
                'We are a leading technology company specializing in software development...',
                'Information Technology',
                '50-100',
                '2015',
                'https://example.com',
                'contact@example.com',
                '+1234567890',
                '123 Main Street',
                'New York',
                'NY',
                'United States',
                '10001'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadJobsSample()
    {
        $filename = 'jobs_sample_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = [
            'employer_email', 'title', 'category_name', 'industry_name', 'job_type',
            'employment_type', 'experience_level', 'education_level', 'description',
            'responsibilities', 'requirements', 'min_salary', 'max_salary',
            'salary_currency', 'salary_period', 'location', 'city', 'state',
            'country', 'is_remote', 'apply_email', 'status', 'expires_at'
        ];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            // Add sample data row
            fputcsv($file, [
                'employer@example.com',
                'Senior Software Developer',
                'Software Development',
                'Information Technology',
                'Full-time',
                'Permanent',
                'Senior',
                'Bachelor',
                'We are looking for an experienced software developer...',
                'Develop and maintain applications|Review code|Mentor junior developers',
                '5+ years experience|Strong in PHP/Laravel|Good communication skills',
                '80000',
                '120000',
                'USD',
                'year',
                'Remote',
                'New York',
                'NY',
                'United States',
                'yes',
                'jobs@example.com',
                'published',
                '2025-12-31'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function uploadSitemap(Request $request)
    {
        $request->validate([
            'sitemap' => 'required|file|mimetypes:application/xml,text/xml,text/plain|max:5120',
        ]);

        $content = $request->file('sitemap')->get();
        $targetPath = public_path('sitemap.xml');

        File::put($targetPath, $content);

        return back()->with('success', 'Sitemap uploaded successfully and is available at ' . url('sitemap.xml'));
    }

    // CSV Import Methods
    public function importCompanies(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        try {
            $file = $request->file('csv_file');
            $csvData = array_map('str_getcsv', file($file->getRealPath()));
            $headers = array_shift($csvData);

            $imported = 0;
            $errors = [];

            DB::beginTransaction();

            foreach ($csvData as $index => $row) {
                if (count($row) !== count($headers)) {
                    continue;
                }

                $data = array_combine($headers, $row);
                $rowNumber = $index + 2;

                try {
                    // Find employer user
                    $user = User::where('email', $data['employer_email'])
                        ->where('user_type', 'employer')
                        ->first();

                    if (!$user) {
                        $errors[] = "Row $rowNumber: Employer with email {$data['employer_email']} not found";
                        continue;
                    }

                    // Check if company already exists
                    if ($user->company) {
                        $errors[] = "Row $rowNumber: Employer {$data['employer_email']} already has a company";
                        continue;
                    }

                    // Find or create industry
                    $industry = null;
                    if (!empty($data['industry_name'])) {
                        $industry = Industry::firstOrCreate(
                            ['name' => $data['industry_name']],
                            ['slug' => Str::slug($data['industry_name']), 'is_active' => true]
                        );
                    }

                    // Create company
                    Company::create([
                        'user_id' => $user->id,
                        'company_name' => $data['company_name'],
                        'tagline' => $data['tagline'] ?? null,
                        'description' => $data['description'] ?? null,
                        'industry_id' => $industry?->id,
                        'company_size' => $data['company_size'] ?? null,
                        'founded_year' => $data['founded_year'] ?? null,
                        'website' => $data['website'] ?? null,
                        'email' => $data['email'] ?? null,
                        'phone' => $data['phone'] ?? null,
                        'address' => $data['address'] ?? null,
                        'city' => $data['city'] ?? null,
                        'state' => $data['state'] ?? null,
                        'country' => $data['country'] ?? null,
                        'postal_code' => $data['postal_code'] ?? null,
                        'is_active' => true,
                    ]);

                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Row $rowNumber: " . $e->getMessage();
                }
            }

            DB::commit();

            $message = "$imported companies imported successfully.";
            if (!empty($errors)) {
                $message .= " Errors: " . implode('; ', array_slice($errors, 0, 5));
                if (count($errors) > 5) {
                    $message .= " and " . (count($errors) - 5) . " more errors.";
                }
            }

            return back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function importJobs(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        try {
            $file = $request->file('csv_file');
            $csvData = array_map('str_getcsv', file($file->getRealPath()));
            $headers = array_shift($csvData);

            $imported = 0;
            $errors = [];

            DB::beginTransaction();

            foreach ($csvData as $index => $row) {
                if (count($row) !== count($headers)) {
                    continue;
                }

                $data = array_combine($headers, $row);
                $rowNumber = $index + 2;

                try {
                    // Find employer user
                    $user = User::where('email', $data['employer_email'])
                        ->where('user_type', 'employer')
                        ->first();

                    if (!$user || !$user->company) {
                        $errors[] = "Row $rowNumber: Employer with email {$data['employer_email']} not found or has no company";
                        continue;
                    }

                    // Find or create category
                    $category = Category::firstOrCreate(
                        ['name' => $data['category_name']],
                        ['slug' => Str::slug($data['category_name']), 'is_active' => true]
                    );

                    // Find or create industry
                    $industry = null;
                    if (!empty($data['industry_name'])) {
                        $industry = Industry::firstOrCreate(
                            ['name' => $data['industry_name']],
                            ['slug' => Str::slug($data['industry_name']), 'is_active' => true]
                        );
                    }

                    // Find or create job type
                    $jobType = JobType::firstOrCreate(
                        ['name' => $data['job_type']],
                        ['slug' => Str::slug($data['job_type']), 'is_active' => true]
                    );

                    // Find or create employment type
                    $employmentType = EmploymentType::firstOrCreate(
                        ['name' => $data['employment_type']],
                        ['slug' => Str::slug($data['employment_type']), 'is_active' => true]
                    );

                    // Create job
                    Job::create([
                        'user_id' => $user->id,
                        'company_id' => $user->company->id,
                        'title' => $data['title'],
                        'category_id' => $category->id,
                        'industry_id' => $industry?->id,
                        'job_type_id' => $jobType->id,
                        'employment_type_id' => $employmentType->id,
                        'experience_level' => $data['experience_level'] ?? null,
                        'education_level' => $data['education_level'] ?? null,
                        'description' => $data['description'] ?? null,
                        'responsibilities' => $data['responsibilities'] ?? null,
                        'requirements' => $data['requirements'] ?? null,
                        'min_salary' => !empty($data['min_salary']) ? $data['min_salary'] : null,
                        'max_salary' => !empty($data['max_salary']) ? $data['max_salary'] : null,
                        'salary_currency' => $data['salary_currency'] ?? 'USD',
                        'salary_period' => $data['salary_period'] ?? 'year',
                        'location' => $data['location'] ?? null,
                        'city' => $data['city'] ?? null,
                        'state' => $data['state'] ?? null,
                        'country' => $data['country'] ?? null,
                        'is_remote' => strtolower($data['is_remote'] ?? 'no') === 'yes',
                        'apply_type' => 'email',
                        'apply_email' => $data['apply_email'] ?? $user->company->email,
                        'status' => $data['status'] ?? 'published',
                        'published_at' => now(),
                        'expires_at' => !empty($data['expires_at']) ? $data['expires_at'] : null,
                    ]);

                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Row $rowNumber: " . $e->getMessage();
                }
            }

            DB::commit();

            $message = "$imported jobs imported successfully.";
            if (!empty($errors)) {
                $message .= " Errors: " . implode('; ', array_slice($errors, 0, 5));
                if (count($errors) > 5) {
                    $message .= " and " . (count($errors) - 5) . " more errors.";
                }
            }

            return back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    // CSV Export Methods
    public function exportJobs()
    {
        $filename = 'jobs_export_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = [
            'ID', 'Title', 'Company', 'Employer Email', 'Category', 'Industry',
            'Job Type', 'Employment Type', 'Experience Level', 'Education Level',
            'Location', 'City', 'State', 'Country', 'Is Remote',
            'Min Salary', 'Max Salary', 'Currency', 'Apply Email',
            'Status', 'Applications Count', 'Views Count',
            'Published At', 'Expires At', 'Created At'
        ];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            Job::with(['company', 'user', 'category', 'industry', 'jobType', 'employmentType'])
                ->chunk(1000, function($jobs) use ($file) {
                    foreach ($jobs as $job) {
                        fputcsv($file, [
                            $job->id,
                            $job->title,
                            $job->company?->company_name,
                            $job->user?->email,
                            $job->category?->name,
                            $job->industry?->name,
                            $job->jobType?->name,
                            $job->employmentType?->name,
                            $job->experience_level,
                            $job->education_level,
                            $job->location,
                            $job->city,
                            $job->state,
                            $job->country,
                            $job->is_remote ? 'Yes' : 'No',
                            $job->min_salary,
                            $job->max_salary,
                            $job->salary_currency,
                            $job->apply_email,
                            $job->status,
                            $job->applications_count,
                            $job->views_count,
                            $job->published_at?->format('Y-m-d H:i:s'),
                            $job->expires_at?->format('Y-m-d H:i:s'),
                            $job->created_at->format('Y-m-d H:i:s'),
                        ]);
                    }
                });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportCandidates()
    {
        $filename = 'candidates_export_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = [
            'ID', 'Name', 'Email', 'Phone', 'Headline', 'Bio',
            'City', 'State', 'Country', 'Experience Level',
            'Education Level', 'Skills', 'Languages',
            'Is Searchable', 'Applications Count',
            'Email Verified', 'Joined Date', 'Last Login'
        ];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            User::where('user_type', 'job_seeker')
                ->with(['profile', 'skills', 'languages', 'education'])
                ->chunk(1000, function($users) use ($file) {
                    foreach ($users as $user) {
                        $skills = $user->skills->pluck('name')->implode(', ');
                        $languages = $user->languages->pluck('language')->implode(', ');
                        $latestEducation = $user->education->first();

                        fputcsv($file, [
                            $user->id,
                            $user->name,
                            $user->email,
                            $user->phone,
                            $user->profile?->headline,
                            $user->profile?->bio,
                            $user->profile?->city,
                            $user->profile?->state,
                            $user->profile?->country,
                            $user->profile?->experience_level,
                            $latestEducation?->degree ?? 'Not specified',
                            $skills,
                            $languages,
                            $user->profile?->is_searchable ? 'Yes' : 'No',
                            $user->jobApplications->count(),
                            $user->email_verified_at ? 'Yes' : 'No',
                            $user->created_at->format('Y-m-d H:i:s'),
                            $user->last_login_at?->format('Y-m-d H:i:s') ?? 'Never',
                        ]);
                    }
                });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
