<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramApplication;
use App\Models\StudentDocument;
use Illuminate\Http\Request;

class ProgramApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = ProgramApplication::with(['program.university', 'program.country', 'user', 'user.studentProfile']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by university
        if ($request->filled('university')) {
            $query->whereHas('program', function ($q) use ($request) {
                $q->where('university_id', $request->university);
            });
        }

        // Search by student name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $applications = $query->latest()->paginate(30);

        // Get statistics
        $stats = [
            'total' => ProgramApplication::count(),
            'pending' => ProgramApplication::where('status', 'pending')->count(),
            'accepted' => ProgramApplication::where('status', 'accepted')->count(),
            'rejected' => ProgramApplication::where('status', 'rejected')->count(),
        ];

        return view('admin.program-applications.index', compact('applications', 'stats'));
    }

    public function show(ProgramApplication $application)
    {
        $application->load([
            'program.university',
            'program.country',
            'program.degree',
            'program.subject',
            'user.studentProfile',
            'user.studentDocuments'
        ]);

        // Get student documents
        $documents = StudentDocument::where('user_id', $application->user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.program-applications.show', compact('application', 'documents'));
    }

    public function updateStatus(Request $request, ProgramApplication $application)
    {
        $request->validate([
            'status' => ['required', 'in:pending,accepted,rejected,withdrawn'],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $application->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
        ]);

        return redirect()->back()->with('status', 'Application status updated successfully!');
    }

    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'application_ids' => ['required', 'array'],
            'application_ids.*' => ['exists:program_applications,id'],
            'status' => ['required', 'in:pending,accepted,rejected'],
        ]);

        ProgramApplication::whereIn('id', $request->application_ids)
            ->update([
                'status' => $request->status,
                'reviewed_at' => now(),
            ]);

        return redirect()->back()->with('status', count($request->application_ids) . ' applications updated successfully!');
    }

    public function export(Request $request)
    {
        $query = ProgramApplication::with(['program.university', 'user', 'user.studentProfile']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->latest()->get();

        $filename = 'program-applications-' . now()->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($applications) {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, [
                'Application ID',
                'Student Name',
                'Student Email',
                'Program',
                'University',
                'Country',
                'Status',
                'Applied Date',
                'GPA',
                'Phone',
            ]);

            // Data
            foreach ($applications as $application) {
                fputcsv($file, [
                    $application->id,
                    $application->user->name,
                    $application->user->email,
                    $application->program->title,
                    $application->program->university->name,
                    $application->program->country->name,
                    ucfirst($application->status),
                    $application->created_at->format('Y-m-d'),
                    $application->user->studentProfile->gpa ?? 'N/A',
                    $application->user->studentProfile->phone ?? 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
