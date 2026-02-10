<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\ConsultationType;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct(
        protected AppointmentService $appointmentService
    ) {}

    public function index()
    {
        $types = ConsultationType::active()->ordered()->get();
        return view('appointments.index', compact('types'));
    }

    public function book(ConsultationType $type)
    {
        if (!$type->is_active) {
            abort(404);
        }

        return view('appointments.book', compact('type'));
    }

    public function store(Request $request, ConsultationType $type)
    {
        $validated = $request->validate([
            'booker_name' => 'required|string|max:255',
            'booker_email' => 'required|email|max:255',
            'booker_phone' => 'nullable|string|max:30',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'meeting_format' => 'required|in:online,in_person',
            'office_key' => 'nullable|required_if:meeting_format,in_person|string|max:50',
            'notes' => 'nullable|string|max:1000',
        ]);

        $validated['consultation_type_id'] = $type->id;
        $validated['user_id'] = auth()->id();

        try {
            $appointment = $this->appointmentService->createAppointment($validated);
        } catch (\Exception $e) {
            return back()->withErrors(['slot' => $e->getMessage()])->withInput();
        }

        // If paid consultation, redirect to payment
        if ($appointment->requiresPayment()) {
            return redirect()->route('appointments.payment.success', [
                'reference' => $appointment->booking_reference,
            ]);
        }

        return redirect()->route('appointments.confirmation', $appointment->booking_reference);
    }

    public function confirmation(string $reference)
    {
        $appointment = Appointment::where('booking_reference', $reference)
            ->with('consultationType')
            ->firstOrFail();

        return view('appointments.confirmation', compact('appointment'));
    }

    public function showCancel(string $reference)
    {
        $appointment = Appointment::where('booking_reference', $reference)
            ->with('consultationType')
            ->firstOrFail();

        if (!$appointment->canCancel()) {
            return view('appointments.cancelled', [
                'appointment' => $appointment,
                'error' => 'This appointment can no longer be cancelled.',
            ]);
        }

        return view('appointments.cancel', compact('appointment'));
    }

    public function cancel(Request $request, string $reference)
    {
        $appointment = Appointment::where('booking_reference', $reference)->firstOrFail();

        if (!$appointment->canCancel()) {
            return back()->with('error', 'This appointment can no longer be cancelled.');
        }

        $request->validate([
            'cancellation_reason' => 'nullable|string|max:500',
        ]);

        $this->appointmentService->cancelAppointment(
            $appointment,
            $request->cancellation_reason,
            auth()->check() ? 'user' : 'user'
        );

        return view('appointments.cancelled', compact('appointment'));
    }

    public function getSlots(Request $request, ConsultationType $type)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);

        $date = Carbon::parse($request->date);
        $slots = $this->appointmentService->getAvailableSlots($type, $date);

        return response()->json(['slots' => $slots]);
    }
}
