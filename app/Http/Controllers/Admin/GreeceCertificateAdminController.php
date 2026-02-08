<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GreeceCertificateApplication;
use App\Models\GreeceCertificateDocument;
use App\Services\ReferralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\GreeceCertificateStatusUpdate;
use ZipArchive;

class GreeceCertificateAdminController extends Controller
{
    /**
     * Display a listing of Greece certificate applications.
     */
    public function index(Request $request)
    {
        $query = GreeceCertificateApplication::with('user')
            ->whereNotNull('submitted_at');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('service_type')) {
            $query->where('service_type', $request->service_type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('application_reference', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('submitted_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('submitted_at', '<=', $request->date_to);
        }

        // Get stats
        $stats = [
            'total' => GreeceCertificateApplication::whereNotNull('submitted_at')->count(),
            'submitted' => GreeceCertificateApplication::where('status', 'submitted')->count(),
            'payment_pending' => GreeceCertificateApplication::where('status', 'payment_pending')->count(),
            'payment_verified' => GreeceCertificateApplication::where('status', 'payment_verified')->count(),
            'processing' => GreeceCertificateApplication::where('status', 'processing')->count(),
            'completed' => GreeceCertificateApplication::where('status', 'completed')->count(),
            'rejected' => GreeceCertificateApplication::where('status', 'rejected')->count(),
        ];

        $applications = $query->orderBy('submitted_at', 'desc')->paginate(15);

        return view('admin.greece-certificates.index', compact('applications', 'stats'));
    }

    /**
     * Display the specified Greece certificate application.
     */
    public function show(GreeceCertificateApplication $application)
    {
        $application->load(['user', 'documents', 'verifier']);

        return view('admin.greece-certificates.show', compact('application'));
    }

    /**
     * Update the status of a Greece certificate application.
     */
    public function updateStatus(Request $request, GreeceCertificateApplication $application)
    {
        $request->validate([
            'status' => 'required|in:submitted,payment_pending,payment_verified,processing,completed,rejected',
            'admin_notes' => 'nullable|string|max:5000',
        ]);

        // Capture previous status before updating
        $previousStatus = $application->status;
        $statusChanged = $previousStatus !== $request->status;

        $application->status = $request->status;

        // If payment is being verified, record who verified it
        if ($request->status === 'payment_verified' && $previousStatus !== 'payment_verified') {
            $application->payment_verified_at = now();
            $application->payment_verified_by = Auth::id();
        }

        // Append admin notes with timestamp
        if ($request->filled('admin_notes')) {
            $timestamp = now()->format('Y-m-d H:i');
            $adminName = Auth::user()->name;
            $newNote = "[{$adminName} {$timestamp}]: {$request->admin_notes}";

            if ($application->admin_notes) {
                $application->admin_notes = $application->admin_notes . "\n\n" . $newNote;
            } else {
                $application->admin_notes = $newNote;
            }
        }

        $application->save();

        // Process referral system on payment verification
        if ($request->status === 'payment_verified' && $previousStatus !== 'payment_verified') {
            $referralService = new ReferralService();
            $referralService->ensureReferralCodeOnPaymentVerified($application->user);

            if ($application->referral_code_used) {
                $referralService->processReferralCredits('greece', $application->id, $application->user);
            }
        }

        // Send status update email if status changed
        if ($statusChanged && $application->email && class_exists(GreeceCertificateStatusUpdate::class)) {
            Mail::to($application->email)->send(
                new GreeceCertificateStatusUpdate($application, $previousStatus)
            );
        }

        $message = 'Application status updated successfully.';
        if ($statusChanged) {
            $message .= ' Email notification sent to applicant.';
        }

        return redirect()
            ->route('admin.greece-certificates.show', $application)
            ->with('success', $message);
    }

    /**
     * Export Greece certificate applications to CSV.
     */
    public function export(Request $request)
    {
        $query = GreeceCertificateApplication::with('user')
            ->whereNotNull('submitted_at');

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('service_type')) {
            $query->where('service_type', $request->service_type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('application_reference', 'like', "%{$search}%");
            });
        }

        $applications = $query->orderBy('submitted_at', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="greece-certificates-' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($applications) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, [
                'Reference',
                'Full Name',
                'Email',
                'Phone',
                'Status',
                'Service Type',
                'Amount',
                'Purpose',
                'Nationality',
                'Passport Number',
                'AFM',
                'AMKA',
                'Submitted At',
                'Payment Verified At',
            ]);

            // Data rows
            foreach ($applications as $app) {
                fputcsv($file, [
                    $app->application_reference,
                    $app->first_name . ' ' . $app->last_name,
                    $app->email,
                    $app->phone_number,
                    $app->status,
                    $app->service_type,
                    $app->payment_amount . ' EUR',
                    $app->certificate_purpose,
                    $app->nationality,
                    $app->passport_number,
                    $app->greece_afm,
                    $app->greece_amka,
                    $app->submitted_at?->format('Y-m-d H:i'),
                    $app->payment_verified_at?->format('Y-m-d H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadDocument(GreeceCertificateDocument $document)
    {
        if (!Storage::disk('private')->exists($document->file_path)) {
            abort(404, 'Document not found');
        }

        return Storage::disk('private')->download(
            $document->file_path,
            $document->original_filename
        );
    }

    public function previewDocument(GreeceCertificateDocument $document)
    {
        if (!Storage::disk('private')->exists($document->file_path)) {
            abort(404, 'Document not found');
        }

        $mimeType = $document->mime_type;
        $content = Storage::disk('private')->get($document->file_path);

        return response($content)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . $document->original_filename . '"');
    }

    public function downloadAllDocuments(GreeceCertificateApplication $application)
    {
        $documents = $application->documents;

        if ($documents->isEmpty()) {
            return back()->with('error', 'No documents found for this application.');
        }

        $zipFileName = 'GR_' . $application->application_reference . '_documents.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);

        // Ensure temp directory exists
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Could not create zip file.');
        }

        foreach ($documents as $document) {
            if (Storage::disk('private')->exists($document->file_path)) {
                $content = Storage::disk('private')->get($document->file_path);
                $fileName = $document->document_type . '_' . $document->original_filename;
                $zip->addFromString($fileName, $content);
            }
        }

        $zip->close();

        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
    }
}
