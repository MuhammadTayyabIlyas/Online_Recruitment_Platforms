<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Services\AppointmentService;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class AppointmentPaymentController extends Controller
{
    public function __construct(
        protected AppointmentService $appointmentService
    ) {}

    public function createIntent(Request $request)
    {
        $request->validate([
            'reference' => 'required|string',
        ]);

        $appointment = Appointment::where('booking_reference', $request->reference)
            ->where('payment_status', 'pending')
            ->firstOrFail();

        Stripe::setApiKey(config('services.stripe.secret'));

        $intent = PaymentIntent::create([
            'amount' => (int) ($appointment->price * 100),
            'currency' => strtolower($appointment->currency),
            'metadata' => [
                'booking_reference' => $appointment->booking_reference,
                'appointment_id' => $appointment->id,
            ],
        ]);

        $appointment->update(['stripe_payment_intent_id' => $intent->id]);

        return response()->json([
            'clientSecret' => $intent->client_secret,
        ]);
    }

    public function success(Request $request)
    {
        $reference = $request->query('reference');
        $appointment = Appointment::where('booking_reference', $reference)
            ->with('consultationType')
            ->firstOrFail();

        if ($appointment->payment_status === 'pending' && $appointment->stripe_payment_intent_id) {
            Stripe::setApiKey(config('services.stripe.secret'));

            try {
                $intent = PaymentIntent::retrieve($appointment->stripe_payment_intent_id);
                if ($intent->status === 'succeeded') {
                    $this->appointmentService->markPaid($appointment, $intent->id);
                    $appointment->refresh();
                }
            } catch (\Exception $e) {
                // Log but don't block - webhook will handle it
            }
        }

        return redirect()->route('appointments.confirmation', $reference);
    }
}
