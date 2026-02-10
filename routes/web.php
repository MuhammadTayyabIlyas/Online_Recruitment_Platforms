<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Employer\CompanyController;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboardController;
use App\Http\Controllers\Employer\JobController as EmployerJobController;
use App\Http\Controllers\Employer\ApplicantsController;
use App\Http\Controllers\Employer\CvSearchController;
use App\Http\Controllers\Employer\UserDocumentController;
use App\Http\Controllers\JobSeeker\ProfileController;
use App\Http\Controllers\JobSeeker\ApplicationController;
use App\Http\Controllers\JobSeeker\SavedJobController;
use App\Http\Controllers\JobSeeker\JobAlertController;
use App\Http\Controllers\JobSeeker\DashboardController as JobSeekerDashboardController;
use App\Http\Controllers\JobSeeker\DocumentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Models\Job;
use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

// Homepage
Route::post('/locale/switch', [LocaleController::class, 'switch'])->name('locale.switch');

// UK Police Character Certificate Routes
require __DIR__ . '/police-certificate.php';

// Portugal Criminal Record Certificate Routes
require __DIR__ . '/portugal-certificate.php';

// Greece Penal Record Certificate Routes
require __DIR__ . '/greece-certificate.php';

// Appointment Booking Routes
require __DIR__ . '/appointments.php';

// Public Partner Pages
Route::get('/partners', [\App\Http\Controllers\PartnerController::class, 'directory'])->name('partners.directory');
Route::get('/partner/verify/{reference}', [\App\Http\Controllers\PartnerController::class, 'verify'])->name('partner.verify');

Route::get('/sitemap.xml', function () {
    $uploadedPath = public_path('sitemap.xml');
    if (File::exists($uploadedPath)) {
        return response(File::get($uploadedPath), 200, ['Content-Type' => 'application/xml']);
    }

    $base = rtrim(config('app.url'), '/');
    $staticPaths = ['/', '/about', '/contact', '/privacy', '/jobs', '/visa-residency', '/study-programs', '/blog'];

    $urls = collect($staticPaths)->map(function ($path) use ($base) {
        return [
            'loc' => $base . $path,
            'changefreq' => 'weekly',
            'priority' => '0.8',
            'lastmod' => now()->toAtomString(),
        ];
    });

    $jobUrls = Job::published()->latest()->take(50)->get()->map(function ($job) use ($base) {
        return [
            'loc' => $base . '/jobs/' . $job->slug,
            'changefreq' => 'daily',
            'priority' => '0.9',
            'lastmod' => optional($job->updated_at ?? $job->published_at ?? $job->created_at)->toAtomString(),
        ];
    });

    // Blog URLs
    $blogUrls = \App\Models\Blog::published()->latest()->take(100)->get()->map(function ($blog) use ($base) {
        return [
            'loc' => $base . '/blog/' . $blog->slug,
            'changefreq' => 'monthly',
            'priority' => '0.7',
            'lastmod' => optional($blog->updated_at ?? $blog->published_at)->toAtomString(),
        ];
    });

    // Blog Category URLs
    $categoryUrls = \App\Models\BlogCategory::active()->get()->map(function ($category) use ($base) {
        return [
            'loc' => $base . '/blog/category/' . $category->slug,
            'changefreq' => 'weekly',
            'priority' => '0.6',
            'lastmod' => now()->toAtomString(),
        ];
    });

    $xmlBody = '<?xml version="1.0" encoding="UTF-8"?>';
    $xmlBody .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    foreach ($urls->concat($jobUrls)->concat($blogUrls)->concat($categoryUrls) as $url) {
        $xmlBody .= '<url>';
        $xmlBody .= '<loc>' . e($url['loc']) . '</loc>';
        if (!empty($url['lastmod'])) {
            $xmlBody .= '<lastmod>' . $url['lastmod'] . '</lastmod>';
        }
        $xmlBody .= '<changefreq>' . $url['changefreq'] . '</changefreq>';
        $xmlBody .= '<priority>' . $url['priority'] . '</priority>';
        $xmlBody .= '</url>';
    }

    $xmlBody .= '</urlset>';

    return response($xmlBody, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::get('/', function () {
    return view('home');
})->name('home');

// Static pages
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/terms', 'privacy')->name('terms');
Route::view('/visa-residency', 'visa.index')->name('visa.index');

// Public Job Routes (Module 12)
Route::view('/study-programs', 'study-programs.index')->name('study-programs.index');
Route::get('/study/{country}/{slug}', [\App\Http\Controllers\StudyProgramController::class, 'show'])->name('study-programs.show');
Route::post('/study/{country}/{slug}/apply', [\App\Http\Controllers\StudyProgramController::class, 'apply'])->name('study-programs.apply');
Route::prefix('jobs')->name('jobs.')->group(function () {
    Route::get('/', [JobController::class, 'index'])->name('index');
    Route::get('/search', [JobController::class, 'search'])->name('search');
    Route::get('/{job}', [JobController::class, 'show'])->name('show');
});

// Public Blog Routes
Route::prefix('blog')->name('blogs.')->group(function () {
    Route::get('/', [\App\Http\Controllers\BlogController::class, 'index'])->name('index');
    Route::get('/category/{category:slug}', [\App\Http\Controllers\BlogController::class, 'byCategory'])->name('category');
    Route::get('/{blog:slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('show');
});

// Authentication Routes
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
    // Apply email verification requirement to all authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard redirect based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect('/admin');
        }

        if ($user->hasRole('educational_institution')) {
            return redirect()->route('institution.dashboard');
        }

        if ($user->hasRole('employer')) {
            return redirect()->route('employer.dashboard');
        }

        if ($user->hasRole('student')) {
            return redirect()->route('student.dashboard');
        }

        if ($user->hasRole('service_user')) {
            return redirect()->route('service_user.dashboard');
        }

        return redirect()->route('jobseeker.dashboard');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Employer Routes (Modules 9, 11, 15, 20)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:employer|admin|educational_institution'])->prefix('employer')->name('employer.')->group(function () {

        // Employer Dashboard
        Route::get('/dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');

        // Company Management (Module 9)
        Route::prefix('company')->name('company.')->group(function () {
            Route::get('/create', [CompanyController::class, 'create'])->name('create');
            Route::post('/', [CompanyController::class, 'store'])->name('store');
            Route::get('/', [CompanyController::class, 'show'])->name('show');
            Route::get('/edit', [CompanyController::class, 'edit'])->name('edit');
            Route::put('/', [CompanyController::class, 'update'])->name('update');
            Route::post('/logo', [CompanyController::class, 'uploadLogo'])->name('logo.upload');
            Route::delete('/logo', [CompanyController::class, 'deleteLogo'])->name('logo.delete');
        });

        // Job Management (Module 11)
        Route::prefix('jobs')->name('jobs.')->group(function () {
            Route::get('/', [EmployerJobController::class, 'index'])->name('index');
            Route::get('/create', [EmployerJobController::class, 'create'])->name('create');
            Route::post('/', [EmployerJobController::class, 'store'])->name('store');
            Route::get('/{job}', [EmployerJobController::class, 'show'])->name('show');
            Route::get('/{job}/edit', [EmployerJobController::class, 'edit'])->name('edit');
            Route::put('/{job}', [EmployerJobController::class, 'update'])->name('update');
            Route::delete('/{job}', [EmployerJobController::class, 'destroy'])->name('destroy');
            Route::patch('/{job}/status', [EmployerJobController::class, 'updateStatus'])->name('status');
            Route::post('/{job}/duplicate', [EmployerJobController::class, 'duplicate'])->name('duplicate');
        });

        Route::prefix('applicants')->name('applicants.')->group(function () {
            Route::get('/', [ApplicantsController::class, 'index'])->name('index');
            Route::get('/{application}', [ApplicantsController::class, 'show'])->name('show');
            Route::patch('/{application}/status', [ApplicantsController::class, 'updateStatus'])->name('status');
            Route::get('/{application}/resume', [ApplicantsController::class, 'downloadResume'])->name('resume');
            Route::post('/{application}/notes', [ApplicantsController::class, 'addNote'])->name('notes.store');
            Route::post('/bulk-status', [ApplicantsController::class, 'bulkStatus'])->name('bulk-status');
        });

        // CV Database / Candidate Search (Module 20)
        Route::prefix('cv-database')->name('cv.')->group(function () {
            Route::get('/', [CvSearchController::class, 'index'])->name('index');
            Route::get('/search', [CvSearchController::class, 'search'])->name('search');
            Route::get('/candidate/{user}', [CvSearchController::class, 'showCandidate'])->name('candidate');
            Route::post('/candidate/{user}/contact', [CvSearchController::class, 'contact'])->name('contact');
            Route::get('/candidate/{user}/resume', [CvSearchController::class, 'downloadResume'])->name('resume');
        });

        // User Documents
        Route::prefix('user-documents')->name('user-documents.')->group(function () {
            Route::get('/{user}', [UserDocumentController::class, 'show'])->name('show');
            Route::get('/document/{documentId}/download', [UserDocumentController::class, 'download'])->name('download');
        });

        // Packages & Subscriptions (Module 17)
        Route::get('/packages', [PaymentController::class, 'packages'])->name('packages');
        Route::get('/subscription', [PaymentController::class, 'subscription'])->name('subscription');
    });

    /*
    |--------------------------------------------------------------------------
    | Content Creator Blog Routes (Employer & Educational Institution)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:employer,educational_institution'])->prefix('my-blogs')->name('content-creator.blogs.')->group(function () {
        Route::get('/', [\App\Http\Controllers\ContentCreator\BlogController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\ContentCreator\BlogController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\ContentCreator\BlogController::class, 'store'])->name('store');
        Route::get('/{blog}', [\App\Http\Controllers\ContentCreator\BlogController::class, 'show'])->name('show');
        Route::get('/{blog}/edit', [\App\Http\Controllers\ContentCreator\BlogController::class, 'edit'])->name('edit');
        Route::put('/{blog}', [\App\Http\Controllers\ContentCreator\BlogController::class, 'update'])->name('update');
        Route::delete('/{blog}', [\App\Http\Controllers\ContentCreator\BlogController::class, 'destroy'])->name('destroy');
        Route::post('/{blog}/submit', [\App\Http\Controllers\ContentCreator\BlogController::class, 'submit'])->name('submit');
        Route::post('/{blog}/withdraw', [\App\Http\Controllers\ContentCreator\BlogController::class, 'withdraw'])->name('withdraw');

        // Trix editor attachment upload
        Route::post('/attachments/upload', [\App\Http\Controllers\ContentCreator\BlogController::class, 'uploadAttachment'])->name('attachments.upload');
    });

    /*
    |--------------------------------------------------------------------------
    | Job Seeker Routes (Modules 14, 16, 19)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:job_seeker'])->prefix('jobseeker')->name('jobseeker.')->group(function () {

        // Job Seeker Dashboard
        Route::get('/dashboard', [JobSeekerDashboardController::class, 'index'])->name('dashboard');

        // Profile Management (Module 16)
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('index');
            Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
            Route::put('/', [ProfileController::class, 'update'])->name('update');
            Route::post('/photo', [ProfileController::class, 'uploadPhoto'])->name('photo.upload');
            Route::delete('/photo', [ProfileController::class, 'deletePhoto'])->name('photo.delete');

            // Education
            Route::post('/education', [ProfileController::class, 'storeEducation'])->name('education.store');
            Route::put('/education/{education}', [ProfileController::class, 'updateEducation'])->name('education.update');
            Route::delete('/education/{education}', [ProfileController::class, 'deleteEducation'])->name('education.destroy');

            // Experience
            Route::post('/experience', [ProfileController::class, 'storeExperience'])->name('experience.store');
            Route::put('/experience/{experience}', [ProfileController::class, 'updateExperience'])->name('experience.update');
            Route::delete('/experience/{experience}', [ProfileController::class, 'deleteExperience'])->name('experience.destroy');

            // Skills
            Route::post('/skills', [ProfileController::class, 'updateSkills'])->name('skills.update');

            // Languages
            Route::post('/languages', [ProfileController::class, 'updateLanguages'])->name('languages.update');

            // Certifications
            Route::post('/certifications', [ProfileController::class, 'storeCertification'])->name('certifications.store');
            Route::put('/certifications/{certification}', [ProfileController::class, 'updateCertification'])->name('certifications.update');
            Route::delete('/certifications/{certification}', [ProfileController::class, 'deleteCertification'])->name('certifications.destroy');

            // Resumes
            Route::get('/resumes', [ProfileController::class, 'resumes'])->name('resumes');
            Route::post('/resumes', [ProfileController::class, 'uploadResume'])->name('resumes.upload');
            Route::delete('/resumes/{resume}', [ProfileController::class, 'deleteResume'])->name('resumes.destroy');
            Route::patch('/resumes/{resume}/primary', [ProfileController::class, 'setPrimaryResume'])->name('resumes.primary');
        });

        // Job Applications (Module 14)
        Route::prefix('applications')->name('applications.')->group(function () {
            Route::get('/', [ApplicationController::class, 'index'])->name('index');
            Route::get('/job/{job}', [ApplicationController::class, 'create'])->name('create');
            Route::post('/job/{job}', [ApplicationController::class, 'store'])->name('store');
            Route::get('/{application}', [ApplicationController::class, 'show'])->name('show');
            Route::post('/{application}/withdraw', [ApplicationController::class, 'withdraw'])->name('withdraw');
            Route::get('/{application}/resume', [ApplicationController::class, 'downloadResume'])->name('resume');
        });

        // Saved Jobs (Module 19)
        Route::prefix('saved-jobs')->name('saved.')->group(function () {
            Route::get('/', [SavedJobController::class, 'index'])->name('index');
            Route::post('/{job}', [SavedJobController::class, 'store'])->name('store');
            Route::delete('/{job}', [SavedJobController::class, 'destroy'])->name('destroy');
        });

        // Job Alerts (Module 19)
        Route::prefix('job-alerts')->name('alerts.')->group(function () {
            Route::get('/', [JobAlertController::class, 'index'])->name('index');
            Route::get('/create', [JobAlertController::class, 'create'])->name('create');
            Route::post('/', [JobAlertController::class, 'store'])->name('store');
            Route::get('/{alert}/edit', [JobAlertController::class, 'edit'])->name('edit');
            Route::put('/{alert}', [JobAlertController::class, 'update'])->name('update');
            Route::delete('/{alert}', [JobAlertController::class, 'destroy'])->name('destroy');
            Route::patch('/{alert}/toggle', [JobAlertController::class, 'toggle'])->name('toggle');
        });

        // Document Upload
        Route::prefix('documents')->name('documents.')->group(function () {
            Route::get('/', [DocumentController::class, 'index'])->name('index');
            Route::get('/status', [DocumentController::class, 'status'])->name('status');
            Route::post('/upload', [DocumentController::class, 'upload'])->name('upload');
            Route::get('/{id}/download', [DocumentController::class, 'download'])->name('download');
            Route::delete('/{id}', [DocumentController::class, 'destroy'])->name('destroy');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Student Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {

        // Student Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');

        // Profile Management
        Route::get('/profile/edit', [\App\Http\Controllers\Student\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [\App\Http\Controllers\Student\ProfileController::class, 'update'])->name('profile.update');

        // Document Management
        Route::get('/documents', [\App\Http\Controllers\Student\DocumentController::class, 'index'])->name('documents.index');
        Route::post('/documents/upload', [\App\Http\Controllers\Student\DocumentController::class, 'upload'])->name('documents.upload');
        Route::get('/documents/{document}/download', [\App\Http\Controllers\Student\DocumentController::class, 'download'])->name('documents.download');
        Route::delete('/documents/{document}', [\App\Http\Controllers\Student\DocumentController::class, 'destroy'])->name('documents.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Service User Routes (Police Certificates & Other Services)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:service_user'])->prefix('services')->name('service_user.')->group(function () {

        // Service User Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\ServiceUser\DashboardController::class, 'index'])->name('dashboard');

        // Appointments
        Route::get('/appointments', [\App\Http\Controllers\ServiceUser\AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/{appointment}', [\App\Http\Controllers\ServiceUser\AppointmentController::class, 'show'])->name('appointments.show');
        Route::post('/appointments/{appointment}/cancel', [\App\Http\Controllers\ServiceUser\AppointmentController::class, 'cancel'])->name('appointments.cancel');

        // Wallet
        Route::get('/wallet', [\App\Http\Controllers\ServiceUser\WalletController::class, 'index'])->name('wallet');
        Route::post('/wallet/request-payout', [\App\Http\Controllers\ServiceUser\WalletController::class, 'requestPayout'])->name('wallet.request-payout');
    });

    // Referral code validation (accessible to any authenticated user)
    Route::post('/referral/validate', [\App\Http\Controllers\ServiceUser\WalletController::class, 'validateCode'])->name('referral.validate');

    // Partner Profile Routes (accessible to any authenticated user with a partner record)
    Route::get('/partner/profile', [\App\Http\Controllers\ServiceUser\PartnerProfileController::class, 'edit'])->name('partner.profile.edit');
    Route::put('/partner/profile', [\App\Http\Controllers\ServiceUser\PartnerProfileController::class, 'update'])->name('partner.profile.update');
    Route::get('/partner/certificate/download', [\App\Http\Controllers\ServiceUser\PartnerProfileController::class, 'downloadCertificate'])->name('partner.certificate.download');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Routes for admin functionality.
|
*/
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::resource('users', AdminUserController::class);
    Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::patch('/users/{user}/toggle-cv-access', [AdminUserController::class, 'toggleCvAccess'])->name('users.toggle-cv-access');
    Route::post('/users/{user}/assign-package', [AdminUserController::class, 'assignPackage'])->name('users.assign-package');
    Route::get('/users/{user}/resume/{resume}/download', [AdminUserController::class, 'downloadResume'])->name('users.resume.download');
    Route::get('/users/{user}/document/{document}/download', [AdminUserController::class, 'downloadDocument'])->name('users.document.download');

    // Category Management
    Route::resource('categories', AdminCategoryController::class);
    Route::patch('/categories/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

    // Job Management
    Route::get('/jobs', [AdminJobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{id}', [AdminJobController::class, 'show'])->name('jobs.show');
    Route::get('/jobs/{id}/edit', [AdminJobController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{id}', [AdminJobController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{id}', [AdminJobController::class, 'destroy'])->name('jobs.destroy');
    Route::post('/jobs/{id}/restore', [AdminJobController::class, 'restore'])->name('jobs.restore');
    Route::patch('/jobs/{id}/toggle-featured', [AdminJobController::class, 'toggleFeatured'])->name('jobs.toggle-featured');
    Route::patch('/jobs/{id}/toggle-urgent', [AdminJobController::class, 'toggleUrgent'])->name('jobs.toggle-urgent');
    Route::patch('/jobs/{id}/status', [AdminJobController::class, 'updateStatus'])->name('jobs.update-status');
    Route::post('/jobs/bulk-action', [AdminJobController::class, 'bulkAction'])->name('jobs.bulk-action');

    // Program Management
    Route::get('/programs', [\App\Http\Controllers\Admin\ProgramController::class, 'index'])->name('programs.index');
    Route::get('/programs/{program}', [\App\Http\Controllers\Admin\ProgramController::class, 'show'])->name('programs.show');
    Route::get('/programs/{program}/edit', [\App\Http\Controllers\Admin\ProgramController::class, 'edit'])->name('programs.edit');
    Route::put('/programs/{program}', [\App\Http\Controllers\Admin\ProgramController::class, 'update'])->name('programs.update');
    Route::delete('/programs/{program}', [\App\Http\Controllers\Admin\ProgramController::class, 'destroy'])->name('programs.destroy');
    Route::post('/programs/bulk-action', [\App\Http\Controllers\Admin\ProgramController::class, 'bulkAction'])->name('programs.bulk-action');
    Route::get('/programs/{program}/applications/{application}', [\App\Http\Controllers\Admin\ProgramController::class, 'showApplication'])->name('programs.application.show');
    Route::patch('/programs/{program}/applications/{application}/status', [\App\Http\Controllers\Admin\ProgramController::class, 'updateApplicationStatus'])->name('programs.application.update-status');
    Route::patch('/programs/{program}/applications/{application}/notes', [\App\Http\Controllers\Admin\ProgramController::class, 'updateApplicationNotes'])->name('programs.application.update-notes');

    // Application Management
    Route::get('/applications', [\App\Http\Controllers\Admin\ApplicationsController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [\App\Http\Controllers\Admin\ApplicationsController::class, 'show'])->name('applications.show');
    Route::patch('/applications/{application}/status', [\App\Http\Controllers\Admin\ApplicationsController::class, 'updateStatus'])->name('applications.update-status');
    Route::get('/applications/{application}/resume/view', [\App\Http\Controllers\Admin\ApplicationsController::class, 'viewResume'])->name('applications.resume.view');

    // Blog Management
    Route::get('/blogs', [\App\Http\Controllers\Admin\BlogController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/{blog}', [\App\Http\Controllers\Admin\BlogController::class, 'show'])->name('blogs.show');
    Route::get('/blogs/{blog}/edit', [\App\Http\Controllers\Admin\BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{blog}', [\App\Http\Controllers\Admin\BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{blog}', [\App\Http\Controllers\Admin\BlogController::class, 'destroy'])->name('blogs.destroy');
    Route::post('/blogs/{id}/restore', [\App\Http\Controllers\Admin\BlogController::class, 'restore'])->name('blogs.restore');
    Route::patch('/blogs/{blog}/status', [\App\Http\Controllers\Admin\BlogController::class, 'updateStatus'])->name('blogs.update-status');
    Route::patch('/blogs/{blog}/toggle-featured', [\App\Http\Controllers\Admin\BlogController::class, 'toggleFeatured'])->name('blogs.toggle-featured');
    Route::post('/blogs/bulk-action', [\App\Http\Controllers\Admin\BlogController::class, 'bulkAction'])->name('blogs.bulk-action');

    // Blog Category Management
    Route::resource('blog-categories', \App\Http\Controllers\Admin\BlogCategoryController::class);
    Route::patch('/blog-categories/{blogCategory}/toggle-status', [\App\Http\Controllers\Admin\BlogCategoryController::class, 'toggleStatus'])->name('blog-categories.toggle-status');
    Route::get('/applications/{application}/resume', [\App\Http\Controllers\Admin\ApplicationsController::class, 'downloadResume'])->name('applications.resume');
    Route::get('/applications/document/{documentId}/view', [\App\Http\Controllers\Admin\ApplicationsController::class, 'viewDocument'])->name('applications.document.view');
    Route::get('/applications/document/{documentId}/download', [\App\Http\Controllers\Admin\ApplicationsController::class, 'downloadDocument'])->name('applications.document.download');
    Route::post('/applications/bulk-status', [\App\Http\Controllers\Admin\ApplicationsController::class, 'bulkUpdateStatus'])->name('applications.bulk-status');
    Route::get('/applications/export/csv', [\App\Http\Controllers\Admin\ApplicationsController::class, 'export'])->name('applications.export');

    // Settings
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/clear-cache', [AdminSettingsController::class, 'clearCache'])->name('settings.clear-cache');
    Route::post('/settings/optimize', [AdminSettingsController::class, 'optimizeApp'])->name('settings.optimize');
    Route::post('/settings/change-password', [AdminSettingsController::class, 'changePassword'])->name('settings.change-password');
    Route::post('/settings/sitemap', [AdminSettingsController::class, 'uploadSitemap'])->name('settings.sitemap.upload');

    // CSV Import/Export
    Route::get('/csv/companies-sample', [AdminSettingsController::class, 'downloadCompaniesSample'])->name('csv.companies-sample');
    Route::get('/csv/jobs-sample', [AdminSettingsController::class, 'downloadJobsSample'])->name('csv.jobs-sample');
    Route::post('/csv/import-companies', [AdminSettingsController::class, 'importCompanies'])->name('csv.import-companies');
    Route::post('/csv/import-jobs', [AdminSettingsController::class, 'importJobs'])->name('csv.import-jobs');
    Route::get('/csv/export-jobs', [AdminSettingsController::class, 'exportJobs'])->name('csv.export-jobs');
    Route::get('/csv/export-candidates', [AdminSettingsController::class, 'exportCandidates'])->name('csv.export-candidates');

    // Police Certificate Admin Routes
    Route::get('/police-certificates', [\App\Http\Controllers\Admin\PoliceCertificateAdminController::class, 'index'])->name('police-certificates.index');
    Route::get('/police-certificates/export/csv', [\App\Http\Controllers\Admin\PoliceCertificateAdminController::class, 'export'])->name('police-certificates.export');
    Route::get('/police-certificates/{application}', [\App\Http\Controllers\Admin\PoliceCertificateAdminController::class, 'show'])->name('police-certificates.show');
    Route::patch('/police-certificates/{application}/status', [\App\Http\Controllers\Admin\PoliceCertificateAdminController::class, 'updateStatus'])->name('police-certificates.update-status');
    Route::get('/police-certificate/document/{document}/download', [\App\Http\Controllers\Admin\PoliceCertificateAdminController::class, 'downloadDocument'])->name('police-certificate.download-document');
    Route::get('/police-certificate/document/{document}/preview', [\App\Http\Controllers\Admin\PoliceCertificateAdminController::class, 'previewDocument'])->name('police-certificate.preview-document');
    Route::get('/police-certificate/{application}/download-documents', [\App\Http\Controllers\Admin\PoliceCertificateAdminController::class, 'downloadAllDocuments'])->name('police-certificate.download-documents');

    // Portugal Certificate Admin Routes
    Route::get('/portugal-certificates', [\App\Http\Controllers\Admin\PortugalCertificateAdminController::class, 'index'])->name('portugal-certificates.index');
    Route::get('/portugal-certificates/export/csv', [\App\Http\Controllers\Admin\PortugalCertificateAdminController::class, 'export'])->name('portugal-certificates.export');
    Route::get('/portugal-certificates/{application}', [\App\Http\Controllers\Admin\PortugalCertificateAdminController::class, 'show'])->name('portugal-certificates.show');
    Route::patch('/portugal-certificates/{application}/status', [\App\Http\Controllers\Admin\PortugalCertificateAdminController::class, 'updateStatus'])->name('portugal-certificates.update-status');
    Route::get('/portugal-certificate/document/{document}/download', [\App\Http\Controllers\Admin\PortugalCertificateAdminController::class, 'downloadDocument'])->name('portugal-certificate.download-document');
    Route::get('/portugal-certificate/document/{document}/preview', [\App\Http\Controllers\Admin\PortugalCertificateAdminController::class, 'previewDocument'])->name('portugal-certificate.preview-document');
    Route::get('/portugal-certificate/{application}/download-documents', [\App\Http\Controllers\Admin\PortugalCertificateAdminController::class, 'downloadAllDocuments'])->name('portugal-certificate.download-documents');

    // Authorized Partners Admin Routes
    Route::get('/authorized-partners', [\App\Http\Controllers\Admin\AuthorizedPartnerController::class, 'index'])->name('authorized-partners.index');
    Route::get('/authorized-partners/create', [\App\Http\Controllers\Admin\AuthorizedPartnerController::class, 'create'])->name('authorized-partners.create');
    Route::post('/authorized-partners', [\App\Http\Controllers\Admin\AuthorizedPartnerController::class, 'store'])->name('authorized-partners.store');
    Route::get('/authorized-partners/{partner}', [\App\Http\Controllers\Admin\AuthorizedPartnerController::class, 'show'])->name('authorized-partners.show');
    Route::post('/authorized-partners/{partner}/approve', [\App\Http\Controllers\Admin\AuthorizedPartnerController::class, 'approve'])->name('authorized-partners.approve');
    Route::post('/authorized-partners/{partner}/suspend', [\App\Http\Controllers\Admin\AuthorizedPartnerController::class, 'suspend'])->name('authorized-partners.suspend');
    Route::post('/authorized-partners/{partner}/revoke', [\App\Http\Controllers\Admin\AuthorizedPartnerController::class, 'revoke'])->name('authorized-partners.revoke');
    Route::post('/authorized-partners/{partner}/renew', [\App\Http\Controllers\Admin\AuthorizedPartnerController::class, 'renew'])->name('authorized-partners.renew');
    Route::get('/authorized-partners/{partner}/certificate', [\App\Http\Controllers\Admin\AuthorizedPartnerController::class, 'downloadCertificate'])->name('authorized-partners.certificate');

    // Referral Admin Routes
    Route::get('/referrals', [\App\Http\Controllers\Admin\ReferralAdminController::class, 'index'])->name('referrals.index');
    Route::get('/referrals/codes', [\App\Http\Controllers\Admin\ReferralAdminController::class, 'referralCodes'])->name('referrals.codes');
    Route::get('/referrals/withdrawals', [\App\Http\Controllers\Admin\ReferralAdminController::class, 'withdrawalRequests'])->name('referrals.withdrawals');
    Route::patch('/referrals/withdrawals/{withdrawal}', [\App\Http\Controllers\Admin\ReferralAdminController::class, 'processWithdrawal'])->name('referrals.process-withdrawal');
    Route::get('/referrals/user/{user}', [\App\Http\Controllers\Admin\ReferralAdminController::class, 'userReferralDetail'])->name('referrals.user-detail');

    // Consultation Types Admin Routes
    Route::get('/consultation-types', [\App\Http\Controllers\Admin\ConsultationTypeController::class, 'index'])->name('consultation-types.index');
    Route::get('/consultation-types/create', [\App\Http\Controllers\Admin\ConsultationTypeController::class, 'create'])->name('consultation-types.create');
    Route::post('/consultation-types', [\App\Http\Controllers\Admin\ConsultationTypeController::class, 'store'])->name('consultation-types.store');
    Route::get('/consultation-types/{consultationType}/edit', [\App\Http\Controllers\Admin\ConsultationTypeController::class, 'edit'])->name('consultation-types.edit');
    Route::put('/consultation-types/{consultationType}', [\App\Http\Controllers\Admin\ConsultationTypeController::class, 'update'])->name('consultation-types.update');
    Route::delete('/consultation-types/{consultationType}', [\App\Http\Controllers\Admin\ConsultationTypeController::class, 'destroy'])->name('consultation-types.destroy');
    Route::patch('/consultation-types/{consultationType}/toggle-status', [\App\Http\Controllers\Admin\ConsultationTypeController::class, 'toggleStatus'])->name('consultation-types.toggle-status');

    // Appointment Schedule Admin Routes
    Route::get('/appointment-schedule', [\App\Http\Controllers\Admin\AppointmentScheduleController::class, 'index'])->name('appointment-schedule.index');
    Route::post('/appointment-schedule', [\App\Http\Controllers\Admin\AppointmentScheduleController::class, 'store'])->name('appointment-schedule.store');
    Route::put('/appointment-schedule/{schedule}', [\App\Http\Controllers\Admin\AppointmentScheduleController::class, 'update'])->name('appointment-schedule.update');
    Route::delete('/appointment-schedule/{schedule}', [\App\Http\Controllers\Admin\AppointmentScheduleController::class, 'destroy'])->name('appointment-schedule.destroy');
    Route::post('/appointment-schedule/blocks', [\App\Http\Controllers\Admin\AppointmentScheduleController::class, 'storeBlock'])->name('appointment-schedule.store-block');
    Route::delete('/appointment-schedule/blocks/{block}', [\App\Http\Controllers\Admin\AppointmentScheduleController::class, 'destroyBlock'])->name('appointment-schedule.destroy-block');

    // Appointment Admin Routes
    Route::get('/appointments', [\App\Http\Controllers\Admin\AppointmentAdminController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/calendar', [\App\Http\Controllers\Admin\AppointmentAdminController::class, 'calendar'])->name('appointments.calendar');
    Route::get('/appointments/export/csv', [\App\Http\Controllers\Admin\AppointmentAdminController::class, 'export'])->name('appointments.export');
    Route::get('/appointments/{appointment}', [\App\Http\Controllers\Admin\AppointmentAdminController::class, 'show'])->name('appointments.show');
    Route::patch('/appointments/{appointment}/status', [\App\Http\Controllers\Admin\AppointmentAdminController::class, 'updateStatus'])->name('appointments.update-status');
    Route::patch('/appointments/{appointment}/meeting-link', [\App\Http\Controllers\Admin\AppointmentAdminController::class, 'updateMeetingLink'])->name('appointments.update-meeting-link');

    // Greece Certificate Admin Routes
    Route::get('/greece-certificates', [\App\Http\Controllers\Admin\GreeceCertificateAdminController::class, 'index'])->name('greece-certificates.index');
    Route::get('/greece-certificates/export/csv', [\App\Http\Controllers\Admin\GreeceCertificateAdminController::class, 'export'])->name('greece-certificates.export');
    Route::get('/greece-certificates/{application}', [\App\Http\Controllers\Admin\GreeceCertificateAdminController::class, 'show'])->name('greece-certificates.show');
    Route::patch('/greece-certificates/{application}/status', [\App\Http\Controllers\Admin\GreeceCertificateAdminController::class, 'updateStatus'])->name('greece-certificates.update-status');
    Route::get('/greece-certificate/document/{document}/download', [\App\Http\Controllers\Admin\GreeceCertificateAdminController::class, 'downloadDocument'])->name('greece-certificate.download-document');
    Route::get('/greece-certificate/document/{document}/preview', [\App\Http\Controllers\Admin\GreeceCertificateAdminController::class, 'previewDocument'])->name('greece-certificate.preview-document');
    Route::get('/greece-certificate/{application}/download-documents', [\App\Http\Controllers\Admin\GreeceCertificateAdminController::class, 'downloadAllDocuments'])->name('greece-certificate.download-documents');
});

// Institution (study programs)
Route::middleware(['auth', 'verified', 'role:educational_institution|admin'])->prefix('institution')->name('institution.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Institution\DashboardController::class, 'index'])->name('dashboard');
    Route::view('/setup', 'institution.setup')->name('setup');

    // Programs
    Route::get('/programs', [\App\Http\Controllers\Institution\ProgramController::class, 'index'])->name('programs.index');
    Route::get('/programs/create', [\App\Http\Controllers\Institution\ProgramController::class, 'create'])->name('programs.create');
    Route::post('/programs', [\App\Http\Controllers\Institution\ProgramController::class, 'store'])->name('programs.store');
    Route::get('/programs/{program}/edit', [\App\Http\Controllers\Institution\ProgramController::class, 'edit'])->name('programs.edit');
    Route::put('/programs/{program}', [\App\Http\Controllers\Institution\ProgramController::class, 'update'])->name('programs.update');
    Route::delete('/programs/{program}', [\App\Http\Controllers\Institution\ProgramController::class, 'destroy'])->name('programs.destroy');

    Route::get('/universities/create', [\App\Http\Controllers\Institution\UniversityController::class, 'create'])->name('universities.create');
    Route::post('/universities', [\App\Http\Controllers\Institution\UniversityController::class, 'store'])->name('universities.store');

    // Applications
    Route::get('/applications', [\App\Http\Controllers\Institution\ProgramApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [\App\Http\Controllers\Institution\ProgramApplicationController::class, 'show'])->name('applications.show');
    Route::patch('/applications/{application}/status', [\App\Http\Controllers\Institution\ProgramApplicationController::class, 'updateStatus'])->name('applications.status');
});

// Admin view program applications
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/program-applications', [\App\Http\Controllers\Admin\ProgramApplicationController::class, 'index'])->name('program-applications.index');
    Route::get('/program-applications/{application}', [\App\Http\Controllers\Admin\ProgramApplicationController::class, 'show'])->name('program-applications.show');
    Route::patch('/program-applications/{application}/status', [\App\Http\Controllers\Admin\ProgramApplicationController::class, 'updateStatus'])->name('program-applications.update-status');
    Route::post('/program-applications/bulk-status', [\App\Http\Controllers\Admin\ProgramApplicationController::class, 'bulkUpdateStatus'])->name('program-applications.bulk-status');
    Route::get('/program-applications/export/csv', [\App\Http\Controllers\Admin\ProgramApplicationController::class, 'export'])->name('program-applications.export');
});
