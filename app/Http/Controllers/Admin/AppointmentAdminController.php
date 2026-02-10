<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ConsultationType;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AppointmentAdminController extends Controller
{
    public function __construct(
        protected AppointmentService $appointmentService
    ) {}

    public function index(Request $request)
    {
        $query = Appointment::with(['consultationType', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('consultation_type_id', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booker_name', 'like', "%{$search}%")
                    ->orWhere('booker_email', 'like', "%{$search}%")
                    ->orWhere('booking_reference', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('appointment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('appointment_date', '<=', $request->date_to);
        }

        $stats = [
            'total' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
            'no_show' => Appointment::where('status', 'no_show')->count(),
            'today' => Appointment::forDate(now())->active()->count(),
        ];

        $consultationTypes = ConsultationType::ordered()->get();
        $appointments = $query->orderByDesc('appointment_date')->orderByDesc('start_time')->paginate(15);

        return view('admin.appointments.index', compact('appointments', 'stats', 'consultationTypes'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['consultationType', 'user']);
        return view('admin.appointments.show', compact('appointment'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed,no_show,rescheduled',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $previousStatus = $appointment->status;

        $appointment->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? $appointment->admin_notes,
        ]);

        if ($validated['status'] === 'cancelled') {
            $appointment->update([
                'cancelled_at' => now(),
                'cancelled_by' => 'admin',
            ]);
        }

        // Send status update email
        if ($previousStatus !== $validated['status']) {
            try {
                Mail::to($appointment->booker_email)
                    ->send(new \App\Mail\AppointmentStatusUpdate($appointment, $previousStatus));
            } catch (\Exception $e) {
                // Log but don't block
            }
        }

        return redirect()->route('admin.appointments.show', $appointment)
            ->with('success', 'Appointment status updated to ' . ucfirst($validated['status']) . '.');
    }

    public function updateMeetingLink(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'meeting_link' => 'required|url|max:500',
        ]);

        $appointment->update(['meeting_link' => $validated['meeting_link']]);

        // Send meeting link email
        try {
            Mail::to($appointment->booker_email)
                ->send(new \App\Mail\AppointmentMeetingLink($appointment));
        } catch (\Exception $e) {
            // Log but don't block
        }

        return redirect()->route('admin.appointments.show', $appointment)
            ->with('success', 'Meeting link updated and notification sent.');
    }

    public function calendar(Request $request)
    {
        $tz = config('appointments.timezone', 'Europe/Athens');
        $year = $request->get('year', now($tz)->year);
        $month = $request->get('month', now($tz)->month);

        $start = Carbon::create($year, $month, 1, 0, 0, 0, $tz);
        $end = $start->copy()->endOfMonth();

        $appointments = Appointment::with('consultationType')
            ->whereBetween('appointment_date', [$start, $end])
            ->active()
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(fn ($a) => $a->appointment_date->format('Y-m-d'));

        $monthLabel = $start->format('F Y');
        $prevMonth = $start->copy()->subMonth();
        $nextMonth = $start->copy()->addMonth();

        return view('admin.appointments.calendar', compact(
            'appointments', 'year', 'month', 'monthLabel', 'prevMonth', 'nextMonth', 'start'
        ));
    }

    public function export(Request $request)
    {
        $query = Appointment::with(['consultationType', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('appointment_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('appointment_date', '<=', $request->date_to);
        }

        $appointments = $query->orderByDesc('appointment_date')->get();

        $csv = "Reference,Name,Email,Phone,Type,Date,Time,Format,Status,Payment,Created\n";
        foreach ($appointments as $a) {
            $csv .= implode(',', [
                $a->booking_reference,
                '"' . str_replace('"', '""', $a->booker_name) . '"',
                $a->booker_email,
                $a->booker_phone ?? '',
                '"' . ($a->consultationType->name ?? '') . '"',
                $a->appointment_date->format('Y-m-d'),
                $a->formatted_time,
                $a->meeting_format,
                $a->status,
                $a->payment_status,
                $a->created_at->format('Y-m-d H:i'),
            ]) . "\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="appointments-' . now()->format('Y-m-d') . '.csv"',
        ]);
    }
}
