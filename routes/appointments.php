<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentPaymentController;

/*
|--------------------------------------------------------------------------
| Appointment Booking Routes (Public)
|--------------------------------------------------------------------------
*/

Route::prefix('appointments')->name('appointments.')->group(function () {
    // Landing page with consultation type cards
    Route::get('/', [AppointmentController::class, 'index'])->name('index');

    // Booking flow
    Route::get('/book/{type:slug}', [AppointmentController::class, 'book'])->name('book');
    Route::post('/book/{type:slug}', [AppointmentController::class, 'store'])->name('store');

    // Confirmation
    Route::get('/confirmation/{reference}', [AppointmentController::class, 'confirmation'])->name('confirmation');

    // Cancellation
    Route::get('/cancel/{reference}', [AppointmentController::class, 'showCancel'])->name('show-cancel');
    Route::post('/cancel/{reference}', [AppointmentController::class, 'cancel'])->name('cancel');

    // API endpoint for Livewire slot fetching
    Route::get('/api/slots/{type}', [AppointmentController::class, 'getSlots'])->name('api.slots');

    // Payment
    Route::post('/payment/create-intent', [AppointmentPaymentController::class, 'createIntent'])->name('payment.create-intent');
    Route::get('/payment/success', [AppointmentPaymentController::class, 'success'])->name('payment.success');
});
