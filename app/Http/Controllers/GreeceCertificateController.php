<?php

namespace App\Http\Controllers;

use App\Models\GreeceCertificateApplication;
use App\Models\GreeceCertificateDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        // Handle authorization letter upload for step 6
        if ($step === 6 && $request->hasFile('authorization_letter')) {
            $this->handleAuthorizationLetter($request, $application);
            $validated['authorization_letter_uploaded'] = true;
        }

        // Calculate payment amount for step 7
        if ($step === 7) {
            $validated['payment_amount'] = $this->calculatePaymentAmount(
                $validated['service_type'] ?? $request->service_type
            );
        }

        $application->fill($validated);
        $application->save();

        // Store application ID in session
        $request->session()->put('greece_application_id', $application->id);

        // Handle file uploads for step 2
        if ($step === 2) {
            $this->handleStep2Documents($request, $application);
        }

        // If final step, mark as submitted
        if ($step === 7) {
            $application->status = 'submitted';
            $application->submitted_at = now();
            $application->save();

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

        // Check if passport document exists
        $hasPassportDoc = $application->documents()->where('document_type', 'passport')->exists();
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

        return view('greece-certificate.receipt-upload', compact('application'));
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
                    'passport_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                    'residence_permit_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
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
                $rules = [
                    'authorization_letter' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                ];
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

        return $request->validate($rules);
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
        // Passport
        if ($request->hasFile('passport_file')) {
            $this->storeDocument($request->file('passport_file'), $application, 'passport');
        }

        // Residence Permit (optional)
        if ($request->hasFile('residence_permit_file')) {
            $this->storeDocument($request->file('residence_permit_file'), $application, 'residence_permit');
        }
    }

    protected function handleAuthorizationLetter(Request $request, $application)
    {
        if ($request->hasFile('authorization_letter')) {
            // Delete old authorization letter if exists
            $application->documents()->where('document_type', 'authorization_letter')->delete();

            $this->storeDocument($request->file('authorization_letter'), $application, 'authorization_letter');
        }
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
        $prices = [
            'normal' => 75,  // EUR
            'urgent' => 120, // EUR
        ];

        return $prices[$serviceType] ?? 75;
    }
}
