<?php

namespace App\Http\Controllers;

use App\Models\PoliceCertificateApplication;
use App\Models\PoliceCertificateDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PoliceCertificateController extends Controller
{
    protected $stepFields = [
        1 => ['first_name', 'middle_name', 'last_name', 'father_full_name', 'gender', 'date_of_birth', 'place_of_birth_city', 'place_of_birth_country', 'nationality', 'marital_status'],
        2 => ['passport_number', 'passport_issue_date', 'passport_expiry_date', 'passport_place_of_issue', 'cnic_nicop_number', 'uk_home_office_ref', 'uk_brp_number'],
        3 => ['uk_residence_history', 'uk_national_insurance_number'],
        4 => ['uk_address_history'],
        5 => ['spain_address_line1', 'spain_address_line2', 'spain_city', 'spain_province', 'spain_postal_code'],
        6 => ['email', 'phone_spain', 'whatsapp_number'],
        7 => ['service_type', 'payment_currency', 'payment_amount'],
    ];

    public function index()
    {
        return view('police-certificate.index');
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

        return view("police-certificate.step{$step}", compact('application', 'step'));
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
            $application->status = 'draft';
        }

        // Handle special cases for array data
        if ($step === 3 && $request->has('uk_residence_history')) {
            $validated['uk_residence_history'] = $this->processResidenceHistory($request->uk_residence_history);
        }

        if ($step === 4 && $request->has('uk_address_history')) {
            $validated['uk_address_history'] = $this->processAddressHistory($request->uk_address_history);
        }

        // Calculate payment amount for step 7
        if ($step === 7) {
            $validated['payment_amount'] = $this->calculatePaymentAmount(
                $validated['service_type'] ?? $request->service_type,
                $validated['payment_currency'] ?? $request->payment_currency
            );
        }

        $application->fill($validated);
        $application->save();

        // Store application ID in session
        $request->session()->put('pcc_application_id', $application->id);

        // Handle file uploads for step 2
        if ($step === 2) {
            $this->handleStep2Documents($request, $application);
        }

        // If final step, mark as submitted
        if ($step === 7) {
            $application->status = 'submitted';
            $application->submitted_at = now();
            $application->save();
            
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

        return redirect()->route('portal.dashboard')->with('success', 'Receipt uploaded successfully. We will verify your payment shortly.');
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
                $rules = [
                    'passport_number' => 'required|string|max:20',
                    'passport_issue_date' => 'required|date|before:today',
                    'passport_expiry_date' => 'required|date|after:today',
                    'passport_place_of_issue' => 'required|string|max:100',
                    'cnic_nicop_number' => 'required|string|max:20',
                    'uk_home_office_ref' => 'nullable|string|max:50',
                    'uk_brp_number' => 'nullable|string|max:50',
                    'passport_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                    'cnic_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                    'brp_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                ];
                break;

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
                ];
                break;

            case 6:
                $rules = [
                    'email' => 'required|email|max:255',
                    'phone_spain' => 'required|string|max:20',
                    'whatsapp_number' => 'nullable|string|max:20',
                ];
                break;

            case 7:
                $rules = [
                    'service_type' => 'required|in:normal,urgent',
                    'payment_currency' => 'required|in:gbp,eur',
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

    protected function calculatePaymentAmount($serviceType, $currency)
    {
        $prices = [
            'normal' => ['gbp' => 100, 'eur' => 120],
            'urgent' => ['gbp' => 150, 'eur' => 180],
        ];

        return $prices[$serviceType][$currency] ?? 100;
    }
}