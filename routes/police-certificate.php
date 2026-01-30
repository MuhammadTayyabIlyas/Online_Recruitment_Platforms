<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoliceCertificateController;

/*
|--------------------------------------------------------------------------
| UK Police Character Certificate Routes
|--------------------------------------------------------------------------
*/

// Public form routes
Route::get('/uk-police-certificate', [PoliceCertificateController::class, 'index'])
    ->name('police-certificate.index');

Route::get('/uk-police-certificate/step/{step}', [PoliceCertificateController::class, 'showStep'])
    ->where('step', '[1-7]')
    ->name('police-certificate.step');

Route::post('/uk-police-certificate/step/{step}', [PoliceCertificateController::class, 'processStep'])
    ->where('step', '[1-7]')
    ->name('police-certificate.process-step');

Route::get('/uk-police-certificate/success', [PoliceCertificateController::class, 'success'])
    ->name('police-certificate.success');

// User portal routes (require authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/portal/police-certificate/receipt/{reference}', [PoliceCertificateController::class, 'showReceiptUpload'])
        ->name('police-certificate.receipt.show');
    
    Route::post('/portal/police-certificate/receipt/{reference}', [PoliceCertificateController::class, 'uploadReceipt'])
        ->name('police-certificate.receipt.upload');
});