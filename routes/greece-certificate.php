<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GreeceCertificateController;

/*
|--------------------------------------------------------------------------
| Greece Penal Record Certificate Routes
|--------------------------------------------------------------------------
*/

// Public landing page (no auth required)
Route::get('/greece-penal-record', [GreeceCertificateController::class, 'index'])
    ->name('greece-certificate.index');

// Application wizard routes (auth required)
Route::middleware(['auth', 'verified'])->group(function () {
    // Accept disclaimer
    Route::post('/greece-penal-record/accept-disclaimer', [GreeceCertificateController::class, 'acceptDisclaimer'])
        ->name('greece-certificate.accept-disclaimer');

    Route::get('/greece-penal-record/step/{step}', [GreeceCertificateController::class, 'showStep'])
        ->where('step', '[1-7]')
        ->name('greece-certificate.step');

    Route::post('/greece-penal-record/step/{step}', [GreeceCertificateController::class, 'processStep'])
        ->where('step', '[1-7]')
        ->name('greece-certificate.process-step');

    Route::get('/greece-penal-record/success', [GreeceCertificateController::class, 'success'])
        ->name('greece-certificate.success');

    // Payment PDF download
    Route::get('/greece-certificate/payment-pdf/{reference}', [GreeceCertificateController::class, 'downloadPaymentPdf'])
        ->name('greece-certificate.download-payment-pdf');

    // Pre-filled Authorization Letter PDF download
    Route::get('/greece-penal-record/authorization-letter/download', [GreeceCertificateController::class, 'downloadAuthorizationLetter'])
        ->name('greece-certificate.download-authorization-letter');

    // Resume draft application
    Route::get('/greece-penal-record/resume/{reference}', [GreeceCertificateController::class, 'resume'])
        ->name('greece-certificate.resume');

    // Receipt upload routes
    Route::get('/services/greece-certificate/receipt/{reference}', [GreeceCertificateController::class, 'showReceiptUpload'])
        ->name('greece-certificate.receipt.show');

    Route::post('/services/greece-certificate/receipt/{reference}', [GreeceCertificateController::class, 'uploadReceipt'])
        ->name('greece-certificate.receipt.upload');

    Route::delete('/services/greece-certificate/receipt/{reference}/{documentId}', [GreeceCertificateController::class, 'deleteReceipt'])
        ->name('greece-certificate.receipt.delete');
});
