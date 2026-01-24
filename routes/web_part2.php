    // Apply email verification requirement to all authenticated routes
    Route::middleware(['auth', RequireEmailVerification::class])->group(function () {
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard redirect based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect('/admin');
        } elseif ($user->hasRole('employer')) {
            return redirect()->route('employer.dashboard');
        } else {
            return redirect()->route('jobseeker.dashboard');
        }
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Employer Routes (Modules 9, 11, 15, 20)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:employer'])->prefix('employer')->name('employer.')->group(function () {

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
        });

        // CV Database / Candidate Search (Module 20)
        Route::prefix('cv-database')->name('cv.')->group(function () {
            Route::get('/', [CvSearchController::class, 'index'])->name('index');
            Route::get('/search', [CvSearchController::class, 'search'])->name('search');
            Route::get('/candidate/{user}', [CvSearchController::class, 'showCandidate'])->name('candidate');
            Route::post('/candidate/{user}/contact', [CvSearchController::class, 'contact'])->name('contact');
            Route::get('/candidate/{user}/resume', [CvSearchController::class, 'downloadResume'])->name('resume');
        });

        // Packages & Subscriptions (Module 17)
        Route::get('/packages', [PaymentController::class, 'packages'])->name('packages');
        Route::get('/subscription', [PaymentController::class, 'subscription'])->name('subscription');
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
    });

    /*
