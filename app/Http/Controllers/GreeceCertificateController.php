<?php

namespace App\Http\Controllers;

use App\Mail\GreeceCertificateSubmitted;
use App\Models\GreeceCertificateApplication;
use App\Models\GreeceCertificateDocument;
use App\Services\PaymentPdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class GreeceCertificateController extends Controller
{
    public function index()
    {
        return view('greece-certificate.index');
    }

    /**
     * Accept the disclaimer and store in session
     */
    public function acceptDisclaimer(Request $request)
    {
        $request->session()->put('greece_disclaimer_accepted', true);
        $request->session()->put('greece_disclaimer_accepted_at', now()->toDateTimeString());

        return response()->json(['success' => true]);
    }

    public function showStep(Request $request, $step)
    {
        $step = (int) $step;
        if ($step < 1 || $step > 7) {
            return redirect()->route('greece-certificate.index');
        }

        $applicationId = $request->session()->get('greece_application_id');
        $application = null;

        if ($applicationId) {
            $application = GreeceCertificateApplication::find($applicationId);
        }

        // If no application in session and not step 1, redirect to step 1
        if (!$application && $step > 1) {
            return redirect()->route('greece-certificate.step', ['step' => 1]);
        }

        // Check for existing drafts when starting step 1 without a session application
        $existingDrafts = collect();
        if ($step === 1 && !$application && auth()->check()) {
            $existingDrafts = GreeceCertificateApplication::where('user_id', auth()->id())
                ->where('status', 'draft')
                ->latest()
                ->get();
        }

        return view("greece-certificate.step{$step}", compact('application', 'step', 'existingDrafts'));
    }

    public function processStep(Request $request, $step)
    {
        $step = (int) $step;

        $validated = $this->validateStep($request, $step);

        $applicationId = $request->session()->get('greece_application_id');
        $application = null;

        if ($applicationId) {
            $application = GreeceCertificateApplication::find($applicationId);
        }

        if (!$application) {
            $application = new GreeceCertificateApplication();
            $application->user_id = auth()->id();
            $application->status = 'draft';

            // Record disclaimer acceptance from session
            if ($request->session()->get('greece_disclaimer_accepted')) {
                $application->disclaimer_accepted_at = $request->session()->get('greece_disclaimer_accepted_at', now());
            }
        }

        // Handle special cases for array data
        if ($step === 3 && $request->has('greece_residence_history')) {
            $validated['greece_residence_history'] = $this->processResidenceHistory($request->greece_residence_history);
        }

        // Handle authorization letter - step 6
        if ($step === 6) {
            $signatureMethod = $request->input('signature_method', 'drawn');

            if ($signatureMethod === 'drawn') {
                // Save signature fields
                $validated['signature_data'] = $request->input('signature_data');
                $validated['signature_place'] = $request->input('signature_place');
                $validated['signature_date'] = $request->input('signature_date');
                $validated['signature_method'] = 'drawn';
                $validated['authorization_letter_uploaded'] = true;
            } elseif ($signatureMethod === 'uploaded' && $request->hasFile('authorization_letter')) {
                $this->handleAuthorizationLetter($request, $application);
                $validated['signature_method'] = 'uploaded';
                $validated['authorization_letter_uploaded'] = true;
            }
        }

        // Calculate payment amount for step 7
        if ($step === 7) {
            $validated['payment_amount'] = $this->calculatePaymentAmount(
                $validated['service_type'] ?? $request->service_type
            );
        }

        // Handle "I don't have this" checkboxes
        if ($step === 2) {
            $validated['no_greece_afm'] = $request->boolean('no_greece_afm');
            $validated['no_greece_amka'] = $request->boolean('no_greece_amka');
        }

        $application->fill($validated);
        $application->last_completed_step = $step;
        $application->last_saved_at = now();
        $application->save();

        // Store application ID in session
        $request->session()->put('greece_application_id', $application->id);

        // Handle file uploads for step 2
        if ($step === 2) {
            $this->handleStep2Documents($request, $application);
        }

        // Generate signed authorization letter PDF for drawn signatures
        if ($step === 6 && ($request->input('signature_method') === 'drawn')) {
            $this->generateSignedAuthorizationLetter($application);
        }

        // Handle "Save & Continue Later" button
        if ($request->has('save_for_later')) {
            return redirect()->route('service_user.dashboard')
                ->with('success', 'Application saved! You can resume anytime.')
                ->with('progress_saved', true)
                ->with('application_reference', $application->application_reference);
        }

        // If final step, mark as submitted
        if ($step === 7) {
            $application->status = 'submitted';
            $application->submitted_at = now();
            $application->save();

            // Generate and store payment PDF
            $this->generatePaymentPdf($application);

            // Send confirmation email to applicant (with PDF attached)
            Mail::to($application->email)->send(new GreeceCertificateSubmitted($application));

            return redirect()->route('greece-certificate.success', ['reference' => $application->application_reference]);
        }

        return redirect()->route('greece-certificate.step', ['step' => $step + 1]);
    }

    public function success(Request $request)
    {
        $reference = $request->query('reference');
        $application = GreeceCertificateApplication::where('application_reference', $reference)->firstOrFail();

        // Clear session
        $request->session()->forget('greece_application_id');

        return view('greece-certificate.success', compact('application'));
    }

    /**
     * Resume a draft application
     */
    public function resume(Request $request, $reference)
    {
        $application = GreeceCertificateApplication::where('application_reference', $reference)
            ->where('user_id', auth()->id())
            ->where('status', 'draft')
            ->firstOrFail();

        // Store application ID in session
        $request->session()->put('greece_application_id', $application->id);

        // Determine which step to resume from
        $nextStep = $this->getNextStep($application);

        return redirect()->route('greece-certificate.step', ['step' => $nextStep]);
    }

    /**
     * Determine the next step for a draft application based on filled fields
     */
    public function getNextStep(GreeceCertificateApplication $application): int
    {
        // Step 1: Personal Information
        if (empty($application->first_name) || empty($application->last_name) || empty($application->date_of_birth)) {
            return 1;
        }

        // Step 2: Identification Documents
        if (empty($application->passport_number)) {
            return 2;
        }

        // Check if passport document exists (support both new and legacy types)
        $hasPassportDoc = $application->documents()
            ->whereIn('document_type', ['passport_front', 'passport'])
            ->exists();
        if (!$hasPassportDoc) {
            return 2;
        }

        // Step 3: Greece Residence History
        if (empty($application->greece_residence_history) || !is_array($application->greece_residence_history) || count($application->greece_residence_history) === 0) {
            return 3;
        }

        // Step 4: Current Address
        if (empty($application->current_address_line1) || empty($application->current_city)) {
            return 4;
        }

        // Step 5: Contact Information
        if (empty($application->email) || empty($application->phone_number)) {
            return 5;
        }

        // Step 6: Authorization Letter
        if (!$application->authorization_letter_uploaded) {
            return 6;
        }

        // Step 7: Service Selection (final step)
        return 7;
    }

    public function showReceiptUpload(Request $request, $reference)
    {
        $application = GreeceCertificateApplication::where('application_reference', $reference)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $receipts = $application->documents()->where('document_type', 'receipt')->get();

        return view('greece-certificate.receipt-upload', compact('application', 'receipts'));
    }

    public function deleteReceipt($reference, $documentId)
    {
        $application = GreeceCertificateApplication::where('application_reference', $reference)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $document = $application->documents()
            ->where('id', $documentId)
            ->where('document_type', 'receipt')
            ->firstOrFail();

        // Delete file from storage
        if (Storage::disk('private')->exists($document->file_path)) {
            Storage::disk('private')->delete($document->file_path);
        }

        // Delete document record
        $document->delete();

        return back()->with('success', 'Receipt deleted successfully.');
    }

    public function uploadReceipt(Request $request, $reference)
    {
        $application = GreeceCertificateApplication::where('application_reference', $reference)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'receipt' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'transaction_reference' => 'required|string|max:100',
            'transaction_date' => 'required|date',
            'transaction_amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Store receipt file
        $file = $request->file('receipt');
        $path = $file->store('greece-certificates/receipts', 'private');

        // Create document record
        GreeceCertificateDocument::create([
            'application_id' => $application->id,
            'document_type' => 'receipt',
            'file_path' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'description' => 'Ref: ' . $request->transaction_reference . ' | Date: ' . $request->transaction_date . ' | Amount: ' . $request->transaction_amount,
        ]);

        // Update application status
        $application->status = 'payment_pending';
        $application->save();

        return redirect()->route('service_user.dashboard')->with('success', 'Receipt uploaded successfully. We will verify your payment shortly.');
    }

    protected function validateStep(Request $request, $step)
    {
        $rules = [];
        $messages = [];

        switch ($step) {
            case 1:
                $rules = [
                    'first_name' => 'required|string|max:100',
                    'middle_name' => 'nullable|string|max:100',
                    'last_name' => 'required|string|max:100',
                    'father_name' => 'required|string|max:200',
                    'mother_name' => 'required|string|max:200',
                    'gender' => 'required|in:male,female,other',
                    'date_of_birth' => 'required|date|before:today',
                    'place_of_birth_city' => 'required|string|max:100',
                    'place_of_birth_country' => 'required|string|max:100',
                    'nationality' => 'required|string|max:100',
                ];
                break;

            case 2:
                $rules = [
                    'passport_number' => 'required|string|max:20',
                    'passport_issue_date' => 'required|date|before:today',
                    'passport_expiry_date' => 'required|date|after:today',
                    'passport_place_of_issue' => 'required|string|max:100',
                    'greece_afm' => 'nullable|string|max:20',
                    'greece_amka' => 'nullable|string|max:20',
                    'greece_residence_permit' => 'nullable|string|max:50',
                    'greece_residence_permit_expiry' => 'nullable|date',
                    'passport_front_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                    'passport_back_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                    'residence_permit_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                ];
                $messages = [
                    'passport_front_file.mimes' => 'Please upload the front side of your passport as a PDF, JPG, or PNG file.',
                    'passport_front_file.max' => 'File size must be under 5MB. Try taking a photo with lower resolution.',
                    'passport_back_file.mimes' => 'Please upload the back side of your passport as a PDF, JPG, or PNG file.',
                    'passport_back_file.max' => 'File size must be under 5MB. Try taking a photo with lower resolution.',
                    'residence_permit_file.max' => 'File size must be under 5MB. Try taking a photo with lower resolution.',
                ];
                break;

            case 3:
                $rules = [
                    'greece_residence_history' => 'required|array|min:1',
                    'greece_residence_history.*.from_date' => 'required|date',
                    'greece_residence_history.*.to_date' => 'nullable|date|after:greece_residence_history.*.from_date',
                    'greece_residence_history.*.address' => 'required|string',
                    'greece_residence_history.*.city' => 'required|string',
                ];
                break;

            case 4:
                $rules = [
                    'current_address_line1' => 'required|string|max:200',
                    'current_address_line2' => 'nullable|string|max:200',
                    'current_city' => 'required|string|max:100',
                    'current_postal_code' => 'required|string|max:20',
                    'current_country' => 'required|string|max:100',
                ];
                break;

            case 5:
                $rules = [
                    'email' => 'required|email|max:255',
                    'phone_number' => 'required|string|max:20',
                    'whatsapp_number' => 'nullable|string|max:20',
                ];
                break;

            case 6:
                $signatureMethod = $request->input('signature_method', 'drawn');

                if ($signatureMethod === 'drawn') {
                    $rules = [
                        'signature_data' => 'required|string',
                        'signature_place' => 'required|string|max:200',
                        'signature_date' => 'required|date',
                        'signature_method' => 'required|in:drawn,uploaded',
                    ];
                    $messages = [
                        'signature_data.required' => 'Please sign the authorization letter using the signature pad.',
                        'signature_place.required' => 'Please enter the place where you are signing.',
                    ];
                } else {
                    $rules = [
                        'authorization_letter' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                        'signature_method' => 'required|in:drawn,uploaded',
                    ];
                    $messages = [
                        'authorization_letter.required' => 'Please upload your signed authorization letter.',
                        'authorization_letter.max' => 'File size must be under 5MB. Try taking a photo with lower resolution.',
                    ];
                }
                break;

            case 7:
                $rules = [
                    'certificate_purpose' => 'required|in:employment,immigration,visa,residency,education,adoption,other',
                    'purpose_details' => 'nullable|string|max:500',
                    'service_type' => 'required|in:normal,urgent',
                    'terms_accepted' => 'required|accepted',
                    'privacy_accepted' => 'required|accepted',
                ];
                break;
        }

        return $request->validate($rules, $messages);
    }

    protected function processResidenceHistory($data)
    {
        $processed = [];
        foreach ($data as $item) {
            $processed[] = [
                'from_date' => $item['from_date'] ?? null,
                'to_date' => $item['to_date'] ?? null,
                'address' => $item['address'] ?? null,
                'city' => $item['city'] ?? null,
            ];
        }
        return $processed;
    }

    protected function handleStep2Documents(Request $request, $application)
    {
        // Passport Front
        if ($request->hasFile('passport_front_file')) {
            // Delete old passport docs before replacing
            $application->documents()
                ->whereIn('document_type', ['passport_front', 'passport'])
                ->each(function ($doc) {
                    if (Storage::disk('private')->exists($doc->file_path)) {
                        Storage::disk('private')->delete($doc->file_path);
                    }
                    $doc->delete();
                });

            $this->storeDocument($request->file('passport_front_file'), $application, 'passport_front');
        }

        // Passport Back (optional)
        if ($request->hasFile('passport_back_file')) {
            // Delete old back docs before replacing
            $application->documents()
                ->where('document_type', 'passport_back')
                ->each(function ($doc) {
                    if (Storage::disk('private')->exists($doc->file_path)) {
                        Storage::disk('private')->delete($doc->file_path);
                    }
                    $doc->delete();
                });

            $this->storeDocument($request->file('passport_back_file'), $application, 'passport_back');
        }

        // Residence Permit (optional)
        if ($request->hasFile('residence_permit_file')) {
            $application->documents()
                ->where('document_type', 'residence_permit')
                ->each(function ($doc) {
                    if (Storage::disk('private')->exists($doc->file_path)) {
                        Storage::disk('private')->delete($doc->file_path);
                    }
                    $doc->delete();
                });

            $this->storeDocument($request->file('residence_permit_file'), $application, 'residence_permit');
        }
    }

    protected function handleAuthorizationLetter(Request $request, $application)
    {
        if ($request->hasFile('authorization_letter')) {
            // Delete old authorization letter if exists
            $application->documents()->where('document_type', 'authorization_letter')->each(function ($doc) {
                if (Storage::disk('private')->exists($doc->file_path)) {
                    Storage::disk('private')->delete($doc->file_path);
                }
                $doc->delete();
            });

            $this->storeDocument($request->file('authorization_letter'), $application, 'authorization_letter');
        }
    }

    /**
     * Generate a signed authorization letter PDF with embedded signature image
     */
    protected function generateSignedAuthorizationLetter(GreeceCertificateApplication $application): void
    {
        // Delete old authorization letter docs
        $application->documents()->where('document_type', 'authorization_letter')->each(function ($doc) {
            if (Storage::disk('private')->exists($doc->file_path)) {
                Storage::disk('private')->delete($doc->file_path);
            }
            $doc->delete();
        });

        $pdf = Pdf::loadView('greece-certificate.authorization-letter-pdf', [
            'application' => $application,
            'generatedDate' => $application->signature_date
                ? $application->signature_date->format('d/m/Y')
                : now()->format('d/m/Y'),
            'signatureImage' => $application->signature_data,
            'signaturePlace' => $application->signature_place,
        ]);

        $pdf->setPaper('A4', 'portrait');

        $filename = 'authorization_letters/signed_' . $application->application_reference . '_' . time() . '.pdf';
        Storage::disk('private')->put(
            'greece-certificates/' . $filename,
            $pdf->output()
        );

        GreeceCertificateDocument::create([
            'application_id' => $application->id,
            'document_type' => 'authorization_letter',
            'file_path' => 'greece-certificates/' . $filename,
            'original_filename' => 'Authorization_Letter_Signed_' . $application->application_reference . '.pdf',
            'mime_type' => 'application/pdf',
            'file_size' => Storage::disk('private')->size('greece-certificates/' . $filename),
        ]);
    }

    protected function storeDocument($file, $application, $type)
    {
        $path = $file->store('greece-certificates/' . $type . 's', 'private');

        GreeceCertificateDocument::create([
            'application_id' => $application->id,
            'document_type' => $type,
            'file_path' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);
    }

    protected function calculatePaymentAmount($serviceType)
    {
        $pricing = config('certificate-services.services.greece.pricing.eur');

        return $pricing[$serviceType] ?? $pricing['normal'];
    }

    /**
     * Generate and store payment PDF for the application
     */
    protected function generatePaymentPdf(GreeceCertificateApplication $application): void
    {
        $pdfService = app(PaymentPdfService::class);
        $pdfPath = $pdfService->generateAndStore($application, 'greece');

        // Store as document record
        GreeceCertificateDocument::create([
            'application_id' => $application->id,
            'document_type' => 'payment_details',
            'file_path' => $pdfPath,
            'original_filename' => 'Payment_Details_' . $application->application_reference . '.pdf',
            'mime_type' => 'application/pdf',
            'file_size' => Storage::disk('private')->size($pdfPath),
        ]);
    }

    /**
     * Download the payment details PDF
     */
    public function downloadPaymentPdf(Request $request, $reference)
    {
        $application = GreeceCertificateApplication::where('application_reference', $reference)->firstOrFail();

        // Check if user is the owner or an admin
        if (!auth()->user()->hasRole('admin') && $application->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Try to get stored PDF first
        $document = $application->documents()
            ->where('document_type', 'payment_details')
            ->first();

        if ($document && Storage::disk('private')->exists($document->file_path)) {
            return Storage::disk('private')->download(
                $document->file_path,
                'Payment_Details_' . $application->application_reference . '.pdf'
            );
        }

        // Fallback: generate PDF on the fly if not stored
        $pdfService = app(PaymentPdfService::class);
        return $pdfService->download($application, 'greece');
    }

    /**
     * Generate and download pre-filled authorization letter PDF
     */
    public function downloadAuthorizationLetter(Request $request)
    {
        $applicationId = $request->session()->get('greece_application_id');

        if (!$applicationId) {
            return redirect()->route('greece-certificate.step', ['step' => 1])
                ->with('error', 'Please complete the previous steps first.');
        }

        $application = GreeceCertificateApplication::find($applicationId);

        if (!$application) {
            return redirect()->route('greece-certificate.step', ['step' => 1])
                ->with('error', 'Application not found.');
        }

        // Generate the PDF with pre-filled data (blank signature lines for print-and-sign flow)
        $pdf = Pdf::loadView('greece-certificate.authorization-letter-pdf', [
            'application' => $application,
            'generatedDate' => now()->format('d/m/Y'),
            'signatureImage' => null,
            'signaturePlace' => null,
        ]);

        $pdf->setPaper('A4', 'portrait');

        $filename = 'Authorization_Letter_' . ($application->application_reference ?? 'DRAFT') . '.pdf';

        return $pdf->download($filename);
    }
}
