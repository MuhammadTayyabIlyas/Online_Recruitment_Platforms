<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortugalCertificateController;

/*
|--------------------------------------------------------------------------
| Portugal Criminal Record Certificate Routes
|--------------------------------------------------------------------------
*/

// Public landing page (no auth required)
Route::get('/portugal-criminal-record', [PortugalCertificateController::class, 'index'])
    ->name('portugal-certificate.index');

// Application wizard routes (auth required)
Route::middleware(['auth', 'verified'])->group(function () {
    // Accept disclaimer
    Route::post('/portugal-criminal-record/accept-disclaimer', [PortugalCertificateController::class, 'acceptDisclaimer'])
        ->name('portugal-certificate.accept-disclaimer');

    Route::get('/portugal-criminal-record/step/{step}', [PortugalCertificateController::class, 'showStep'])
        ->where('step', '[1-7]')
        ->name('portugal-certificate.step');

    Route::post('/portugal-criminal-record/step/{step}', [PortugalCertificateController::class, 'processStep'])
        ->where('step', '[1-7]')
        ->name('portugal-certificate.process-step');

    Route::get('/portugal-criminal-record/success', [PortugalCertificateController::class, 'success'])
        ->name('portugal-certificate.success');

    // Payment PDF download
    Route::get('/portugal-certificate/payment-pdf/{reference}', [PortugalCertificateController::class, 'downloadPaymentPdf'])
        ->name('portugal-certificate.download-payment-pdf');

    // Authorization letter download
    Route::get('/portugal-criminal-record/authorization-letter/download', [PortugalCertificateController::class, 'downloadAuthorizationLetter'])
        ->name('portugal-certificate.download-authorization-letter');

    // Resume draft application
    Route::get('/portugal-criminal-record/resume/{reference}', [PortugalCertificateController::class, 'resume'])
        ->name('portugal-certificate.resume');

    // Receipt upload routes
    Route::get('/services/portugal-certificate/receipt/{reference}', [PortugalCertificateController::class, 'showReceiptUpload'])
        ->name('portugal-certificate.receipt.show');

    Route::post('/services/portugal-certificate/receipt/{reference}', [PortugalCertificateController::class, 'uploadReceipt'])
        ->name('portugal-certificate.receipt.upload');

    Route::delete('/services/portugal-certificate/receipt/{reference}/{documentId}', [PortugalCertificateController::class, 'deleteReceipt'])
        ->name('portugal-certificate.receipt.delete');
});
