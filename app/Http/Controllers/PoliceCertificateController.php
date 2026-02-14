<?php

namespace App\Http\Controllers;

use App\Mail\PoliceCertificateSubmitted;
use App\Models\PoliceCertificateApplication;
use App\Models\PoliceCertificateDocument;
use App\Services\PaymentPdfService;
use App\Services\ReferralService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class PoliceCertificateController extends Controller
{
    protected $stepFields = [
        1 => ['first_name', 'middle_name', 'last_name', 'father_full_name', 'gender', 'date_of_birth', 'place_of_birth_city', 'place_of_birth_country', 'nationality', 'marital_status'],
        2 => ['passport_number', 'passport_issue_date', 'passport_expiry_date', 'passport_place_of_issue', 'cnic_nicop_number', 'uk_home_office_ref', 'uk_brp_number'],
        3 => ['uk_residence_history', 'uk_national_insurance_number'],
        4 => ['uk_address_history'],
        5 => ['spain_address_line1', 'spain_address_line2', 'spain_city', 'spain_province', 'spain_postal_code', 'email', 'phone_spain', 'whatsapp_number'],
        6 => ['signature_data', 'signature_place', 'signature_date', 'signature_method'],
        7 => ['service_type', 'payment_currency', 'payment_amount'],
    ];

    public function index()
    {
        return view('police-certificate.index');
    }

    /**
     * Accept the disclaimer and store in session
     */
    public function acceptDisclaimer(Request $request)
    {
        $request->session()->put('pcc_disclaimer_accepted', true);
        $request->session()->put('pcc_disclaimer_accepted_at', now()->toDateTimeString());

        return response()->json(['success' => true]);
    }

    public function showStep(Request $request, $step)
    {
        $step = (int) $step;
        if ($step < 1 || $step > 7) {
            return redirect()->route('police-certificate.index');
        }

        $applicationId = $request->session()->get('pcc_application_id');
        $application = null;

        if ($applicationId) {
            $application = PoliceCertificateApplication::find($applicationId);
        }

        // If no application in session and not step 1, redirect to step 1
        if (!$application && $step > 1) {
            return redirect()->route('police-certificate.step', ['step' => 1]);
        }

        // Check for existing drafts when starting step 1 without a session application
        $existingDrafts = collect();
        if ($step === 1 && !$application && auth()->check()) {
            $existingDrafts = PoliceCertificateApplication::where('user_id', auth()->id())
                ->where('status', 'draft')
                ->latest()
                ->get();
        }

        // Pass document existence flags for step 2
        $hasPhoto = false;
        $hasSelfie = false;
        $hasPassport = false;
        $hasCnic = false;
        $hasBrp = false;

        if ($step === 2 && $application) {
            $hasPhoto = $application->documents()->where('document_type', 'photo')->exists();
            $hasSelfie = $application->documents()->where('document_type', 'selfie_passport')->exists();
            $hasPassport = $application->documents()->where('document_type', 'passport')->exists();
            $hasCnic = $application->documents()->where('document_type', 'cnic')->exists();
            $hasBrp = $application->documents()->where('document_type', 'brp')->exists();
        }

        return view("police-certificate.step{$step}", compact(
            'application', 'step', 'existingDrafts',
            'hasPhoto', 'hasSelfie', 'hasPassport', 'hasCnic', 'hasBrp'
        ));
    }

    public function processStep(Request $request, $step)
    {
        $step = (int) $step;
        
        $validated = $this->validateStep($request, $step);

        $applicationId = $request->session()->get('pcc_application_id');
        $application = null;

        if ($applicationId) {
            $application = PoliceCertificateApplication::find($applicationId);
        }

        if (!$application) {
            $application = new PoliceCertificateApplication();
            $application->user_id = auth()->id();
            $application->status = 'draft';

            // Record disclaimer acceptance from session
            if ($request->session()->get('pcc_disclaimer_accepted')) {
                $application->disclaimer_accepted_at = $request->session()->get('pcc_disclaimer_accepted_at', now());
            }
        }

        // Handle special cases for array data
        if ($step === 3 && $request->has('uk_residence_history')) {
            $validated['uk_residence_history'] = $this->processResidenceHistory($request->uk_residence_history);
        }

        if ($step === 4 && $request->has('uk_address_history')) {
            $validated['uk_address_history'] = $this->processAddressHistory($request->uk_address_history);
        }

        // Handle authorization letter - step 6
        if ($step === 6) {
            $signatureMethod = $request->input('signature_method', 'drawn');

            if ($signatureMethod === 'drawn') {
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
            $validated['apostille_required'] = $request->boolean('apostille_required');
            $validated['payment_amount'] = $this->calculatePaymentAmount(
                $validated['service_type'] ?? $request->service_type,
                $validated['payment_currency'] ?? $request->payment_currency,
                $request->boolean('apostille_required')
            );
        }

        // Handle "I don't have this" checkboxes
        if ($step === 2) {
            $validated['no_uk_home_office_ref'] = $request->boolean('no_uk_home_office_ref');
            $validated['no_uk_brp_number'] = $request->boolean('no_uk_brp_number');
        }
        if ($step === 3) {
            $validated['no_uk_national_insurance_number'] = $request->boolean('no_uk_national_insurance_number');
        }
        if ($step === 4) {
            $validated['address_dates_approximate'] = $request->boolean('address_dates_approximate');
            $validated['address_dates_notes'] = $request->input('address_dates_notes');
        }

        $application->fill($validated);
        $application->last_completed_step = $step;
        $application->last_saved_at = now();
        $application->save();

        // Store application ID in session
        $request->session()->put('pcc_application_id', $application->id);

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

        // If final step, mark as submitted and send confirmation email
        if ($step === 7) {
            // Handle referral code
            $referralCode = $request->input('referral_code');
            if (!empty($referralCode)) {
                $referralService = new ReferralService();
                $validation = $referralService->validateReferralCode($referralCode, auth()->user());
                if ($validation['valid']) {
                    $application->referral_code_used = $referralCode;
                    $application->save();
                    $referralService->recordReferralUse($referralCode, auth()->user(), 'uk-police', $application->id);
                }
            }

            $application->status = 'submitted';
            $application->submitted_at = now();
            $application->save();

            // Generate and store payment PDF
            $this->generatePaymentPdf($application);

            // Send confirmation email to applicant (with PDF attached)
            Mail::to($application->email)->send(new PoliceCertificateSubmitted($application));

            // Send WhatsApp notification to admin
            try {
                $whatsapp = app(WhatsAppService::class);
                $whatsapp->sendCertificateSubmissionNotification($application, 'uk-police');
            } catch (\Exception $e) {
                // Log but don't block submission
            }

            return redirect()->route('police-certificate.success', ['reference' => $application->application_reference]);
        }

        return redirect()->route('police-certificate.step', ['step' => $step + 1]);
    }

    public function success(Request $request)
    {
        $reference = $request->query('reference');
        $application = PoliceCertificateApplication::where('application_reference', $reference)->firstOrFail();

        // Clear session
        $request->session()->forget('pcc_application_id');

        return view('police-certificate.success', compact('application'));
    }

    /**
     * Resume a draft application
     */
    public function resume(Request $request, $reference)
    {
        $application = PoliceCertificateApplication::where('application_reference', $reference)
            ->where('user_id', auth()->id())
            ->where('status', 'draft')
            ->firstOrFail();

        // Store application ID in session
        $request->session()->put('pcc_application_id', $application->id);

        // Determine which step to resume from
        $nextStep = $this->getNextStep($application);

        return redirect()->route('police-certificate.step', ['step' => $nextStep]);
    }

    /**
     * Determine the next step for a draft application based on filled fields
     */
    public function getNextStep(PoliceCertificateApplication $application): int
    {
        // Check each step's required fields to find where user left off

        // Step 1: Personal Information
        if (empty($application->first_name) || empty($application->last_name) || empty($application->date_of_birth)) {
            return 1;
        }

        // Step 2: Passport & ID - check if documents were uploaded
        if (empty($application->passport_number) || empty($application->cnic_nicop_number)) {
            return 2;
        }

        // Check if required documents exist
        $hasPassportDoc = $application->documents()->where('document_type', 'passport')->exists();
        $hasCnicDoc = $application->documents()->where('document_type', 'cnic')->exists();
        $hasPhoto = $application->documents()->where('document_type', 'photo')->exists();
        $hasSelfie = $application->documents()->where('document_type', 'selfie_passport')->exists();
        if (!$hasPassportDoc || !$hasCnicDoc || !$hasPhoto || !$hasSelfie) {
            return 2;
        }

        // Step 3: UK Residence History
        if (empty($application->uk_residence_history) || !is_array($application->uk_residence_history) || count($application->uk_residence_history) === 0) {
            return 3;
        }

        // Step 4: UK Address History
        if (empty($application->uk_address_history) || !is_array($application->uk_address_history) || count($application->uk_address_history) === 0) {
            return 4;
        }

        // Step 5: Spain Address + Contact
        if (empty($application->spain_address_line1) || empty($application->spain_city) || empty($application->email) || empty($application->phone_spain)) {
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
        $application = PoliceCertificateApplication::where('application_reference', $reference)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('police-certificate.receipt-upload', compact('application'));
    }

    public function uploadReceipt(Request $request, $reference)
    {
        $application = PoliceCertificateApplication::where('application_reference', $reference)
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
        $path = $file->store('police-certificates/receipts', 'private');

        // Create document record
        PoliceCertificateDocument::create([
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
                    'father_full_name' => 'required|string|max:200',
                    'gender' => 'required|in:male,female,other',
                    'date_of_birth' => 'required|date|before:today',
                    'place_of_birth_city' => 'required|string|max:100',
                    'place_of_birth_country' => 'required|string|max:100',
                    'nationality' => 'required|string|max:100',
                    'marital_status' => 'required|in:single,married,divorced,widowed',
                ];
                break;

            case 2:
                $applicationId = $request->session()->get('pcc_application_id');
                $existingApp = $applicationId ? PoliceCertificateApplication::find($applicationId) : null;

                $rules = [
                    'passport_number' => 'required|string|max:20',
                    'passport_issue_date' => 'required|date|before:today',
                    'passport_expiry_date' => 'required|date|after:today',
                    'passport_place_of_issue' => 'required|string|max:100',
                    'cnic_nicop_number' => 'required|string|max:20',
                    'uk_home_office_ref' => 'nullable|string|max:50',
                    'uk_brp_number' => 'nullable|string|max:50',
                    'photo_file' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
                    'selfie_passport_file' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
                    'passport_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                    'cnic_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                    'brp_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                ];

                $messages = [
                    'photo_file.mimes' => 'Photo must be a JPG or PNG image.',
                    'photo_file.max' => 'Photo must be under 5MB. Try taking the photo with lower resolution.',
                    'selfie_passport_file.mimes' => 'Selfie must be a JPG or PNG image.',
                    'selfie_passport_file.max' => 'Selfie must be under 5MB.',
                ];

                $validated = $request->validate($rules, $messages);

                // Server-side check: require files if no existing documents
                $missingDocs = [];
                $hasExistingPhoto = $existingApp && $existingApp->documents()->where('document_type', 'photo')->exists();
                $hasExistingSelfie = $existingApp && $existingApp->documents()->where('document_type', 'selfie_passport')->exists();
                $hasExistingPassport = $existingApp && $existingApp->documents()->where('document_type', 'passport')->exists();
                $hasExistingCnic = $existingApp && $existingApp->documents()->where('document_type', 'cnic')->exists();

                if (!$hasExistingPhoto && !$request->hasFile('photo_file')) {
                    $missingDocs['photo_file'] = 'A passport-style photo is required.';
                }
                if (!$hasExistingSelfie && !$request->hasFile('selfie_passport_file')) {
                    $missingDocs['selfie_passport_file'] = 'A selfie while holding your passport is required.';
                }
                if (!$hasExistingPassport && !$request->hasFile('passport_file')) {
                    $missingDocs['passport_file'] = 'A passport scan is required.';
                }
                if (!$hasExistingCnic && !$request->hasFile('cnic_file')) {
                    $missingDocs['cnic_file'] = 'A CNIC/NICOP scan is required.';
                }

                if (!empty($missingDocs)) {
                    throw \Illuminate\Validation\ValidationException::withMessages($missingDocs);
                }

                return $validated;

            case 3:
                $rules = [
                    'uk_residence_history' => 'required|array|min:1',
                    'uk_residence_history.*.entry_date' => 'required|date',
                    'uk_residence_history.*.exit_date' => 'nullable|date|after:uk_residence_history.*.entry_date',
                    'uk_residence_history.*.visa_category' => 'required|string',
                    'uk_residence_history.*.notes' => 'nullable|string',
                    'uk_national_insurance_number' => 'nullable|string|max:20',
                ];
                break;

            case 4:
                $rules = [
                    'uk_address_history' => 'required|array|min:1',
                    'uk_address_history.*.address_line1' => 'required|string|max:200',
                    'uk_address_history.*.address_line2' => 'nullable|string|max:200',
                    'uk_address_history.*.city' => 'required|string|max:100',
                    'uk_address_history.*.postcode' => 'required|string|max:20',
                    'uk_address_history.*.from_date' => 'required|date',
                    'uk_address_history.*.to_date' => 'nullable|date|after:uk_address_history.*.from_date',
                ];
                break;

            case 5:
                $rules = [
                    'spain_address_line1' => 'required|string|max:200',
                    'spain_address_line2' => 'nullable|string|max:200',
                    'spain_city' => 'required|string|max:100',
                    'spain_province' => 'required|string|max:100',
                    'spain_postal_code' => 'required|string|max:20',
                    'email' => 'required|email|max:255',
                    'phone_spain' => 'required|string|max:20',
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
                } else {
                    $rules = [
                        'authorization_letter' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                        'signature_method' => 'required|in:drawn,uploaded',
                    ];
                }
                break;

            case 7:
                $rules = [
                    'service_type' => 'required|in:normal,urgent',
                    'payment_currency' => 'required|in:gbp,eur',
                    'apostille_required' => 'nullable|boolean',
                    'referral_code' => 'nullable|string|max:10',
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
                'entry_date' => $item['entry_date'] ?? null,
                'exit_date' => $item['exit_date'] ?? null,
                'visa_category' => $item['visa_category'] ?? null,
                'notes' => $item['notes'] ?? null,
            ];
        }
        return $processed;
    }

    protected function processAddressHistory($data)
    {
        $processed = [];
        foreach ($data as $item) {
            $processed[] = [
                'address_line1' => $item['address_line1'] ?? null,
                'address_line2' => $item['address_line2'] ?? null,
                'city' => $item['city'] ?? null,
                'postcode' => $item['postcode'] ?? null,
                'from_date' => $item['from_date'] ?? null,
                'to_date' => $item['to_date'] ?? null,
            ];
        }
        return $processed;
    }

    protected function handleStep2Documents(Request $request, $application)
    {
        // Passport photo
        if ($request->hasFile('photo_file')) {
            $this->storeDocument($request->file('photo_file'), $application, 'photo');
        }

        // Selfie with passport
        if ($request->hasFile('selfie_passport_file')) {
            $this->storeDocument($request->file('selfie_passport_file'), $application, 'selfie_passport');
        }

        // Passport
        if ($request->hasFile('passport_file')) {
            $this->storeDocument($request->file('passport_file'), $application, 'passport');
        }

        // CNIC/NICOP
        if ($request->hasFile('cnic_file')) {
            $this->storeDocument($request->file('cnic_file'), $application, 'cnic');
        }

        // BRP (optional)
        if ($request->hasFile('brp_file')) {
            $this->storeDocument($request->file('brp_file'), $application, 'brp');
        }
    }

    protected function storeDocument($file, $application, $type)
    {
        $path = $file->store('police-certificates/' . $type . 's', 'private');

        PoliceCertificateDocument::create([
            'application_id' => $application->id,
            'document_type' => $type,
            'file_path' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);
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

    protected function generateSignedAuthorizationLetter(PoliceCertificateApplication $application): void
    {
        // Delete old authorization letter docs
        $application->documents()->where('document_type', 'authorization_letter')->each(function ($doc) {
            if (Storage::disk('private')->exists($doc->file_path)) {
                Storage::disk('private')->delete($doc->file_path);
            }
            $doc->delete();
        });

        $pdf = Pdf::loadView('police-certificate.authorization-letter-pdf', [
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
            'police-certificates/' . $filename,
            $pdf->output()
        );

        PoliceCertificateDocument::create([
            'application_id' => $application->id,
            'document_type' => 'authorization_letter',
            'file_path' => 'police-certificates/' . $filename,
            'original_filename' => 'Authorization_Letter_Signed_' . $application->application_reference . '.pdf',
            'mime_type' => 'application/pdf',
            'file_size' => Storage::disk('private')->size('police-certificates/' . $filename),
        ]);
    }

    public function downloadAuthorizationLetter(Request $request)
    {
        $applicationId = $request->session()->get('pcc_application_id');

        if (!$applicationId) {
            return redirect()->route('police-certificate.step', ['step' => 1])
                ->with('error', 'Please complete the previous steps first.');
        }

        $application = PoliceCertificateApplication::find($applicationId);

        if (!$application) {
            return redirect()->route('police-certificate.step', ['step' => 1])
                ->with('error', 'Application not found.');
        }

        $pdf = Pdf::loadView('police-certificate.authorization-letter-pdf', [
            'application' => $application,
            'generatedDate' => now()->format('d/m/Y'),
            'signatureImage' => null,
            'signaturePlace' => null,
        ]);

        $pdf->setPaper('A4', 'portrait');

        $filename = 'Authorization_Letter_' . ($application->application_reference ?? 'DRAFT') . '.pdf';

        return $pdf->download($filename);
    }

    protected function calculatePaymentAmount($serviceType, $currency, $apostilleRequired = false)
    {
        $pricing = config('certificate-services.services.uk-police.pricing.' . $currency);
        $amount = $pricing[$serviceType] ?? $pricing['normal'];

        if ($apostilleRequired) {
            $apostillePrice = config('certificate-services.services.uk-police.apostille.' . $currency, 0);
            $amount += $apostillePrice;
        }

        return $amount;
    }

    /**
     * Generate and store payment PDF for the application
     */
    protected function generatePaymentPdf(PoliceCertificateApplication $application): void
    {
        $pdfService = app(PaymentPdfService::class);
        $pdfPath = $pdfService->generateAndStore($application, 'uk-police');

        // Store as document record
        PoliceCertificateDocument::create([
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
        $application = PoliceCertificateApplication::where('application_reference', $reference)->firstOrFail();

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
        return $pdfService->download($application, 'uk-police');
    }
}