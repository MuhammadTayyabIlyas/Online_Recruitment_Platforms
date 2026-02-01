<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoliceCertificateController;

/*
|--------------------------------------------------------------------------
| UK Police Character Certificate Routes
|--------------------------------------------------------------------------
*/

// Public landing page (no auth required)
Route::get('/uk-police-certificate', [PoliceCertificateController::class, 'index'])
    ->name('police-certificate.index');

// Application wizard routes (auth required)
Route::middleware(['auth', 'verified'])->group(function () {
    // Accept disclaimer
    Route::post('/uk-police-certificate/accept-disclaimer', [PoliceCertificateController::class, 'acceptDisclaimer'])
        ->name('police-certificate.accept-disclaimer');

    Route::get('/uk-police-certificate/step/{step}', [PoliceCertificateController::class, 'showStep'])
        ->where('step', '[1-7]')
        ->name('police-certificate.step');

    Route::post('/uk-police-certificate/step/{step}', [PoliceCertificateController::class, 'processStep'])
        ->where('step', '[1-7]')
        ->name('police-certificate.process-step');

    Route::get('/uk-police-certificate/success', [PoliceCertificateController::class, 'success'])
        ->name('police-certificate.success');

    // Resume draft application
    Route::get('/uk-police-certificate/resume/{reference}', [PoliceCertificateController::class, 'resume'])
        ->name('police-certificate.resume');

    // Receipt upload routes
    Route::get('/services/police-certificate/receipt/{reference}', [PoliceCertificateController::class, 'showReceiptUpload'])
        ->name('police-certificate.receipt.show');

    Route::post('/services/police-certificate/receipt/{reference}', [PoliceCertificateController::class, 'uploadReceipt'])
        ->name('police-certificate.receipt.upload');
});
