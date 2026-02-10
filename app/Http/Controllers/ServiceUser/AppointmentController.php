<?php

namespace App\Http\Controllers\ServiceUser;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\AppointmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function __construct(
        protected AppointmentService $appointmentService
    ) {}

    public function index()
    {
        $user = Auth::user();

        $upcoming = Appointment::where('user_id', $user->id)
            ->upcoming()
            ->with('consultationType')
            ->get();

        $past = Appointment::where('user_id', $user->id)
            ->past()
            ->with('consultationType')
            ->take(20)
            ->get();

        return view('service-user.appointments.index', compact('upcoming', 'past'));
    }

    public function show(Appointment $appointment)
    {
        if ($appointment->user_id !== Auth::id()) {
            abort(403);
        }

        $appointment->load('consultationType');

        return view('service-user.appointments.show', compact('appointment'));
    }

    public function cancel(Request $request, Appointment $appointment)
    {
        if ($appointment->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$appointment->canCancel()) {
            return back()->with('error', 'This appointment can no longer be cancelled.');
        }

        $request->validate([
            'cancellation_reason' => 'nullable|string|max:500',
        ]);

        $this->appointmentService->cancelAppointment(
            $appointment,
            $request->cancellation_reason,
            'user'
        );

        return redirect()->route('service_user.appointments.index')
            ->with('success', 'Appointment cancelled successfully.');
    }
}
