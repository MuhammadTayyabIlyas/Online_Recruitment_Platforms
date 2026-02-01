<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PaymentPdfService
{
    /**
     * Generate a payment details PDF and store it.
     *
     * @param mixed $application The certificate application model
     * @param string $serviceType The service type (uk-police, portugal, greece)
     * @return string The storage path of the generated PDF
     */
    public function generateAndStore($application, string $serviceType): string
    {
        $pdf = $this->generate($application, $serviceType);

        $filename = 'Payment_Details_' . $application->application_reference . '.pdf';
        $storagePath = $this->getStoragePath($serviceType) . '/' . $filename;

        Storage::disk('private')->put($storagePath, $pdf->output());

        return $storagePath;
    }

    /**
     * Generate a payment details PDF without storing it.
     *
     * @param mixed $application The certificate application model
     * @param string $serviceType The service type (uk-police, portugal, greece)
     * @return \Barryvdh\DomPDF\PDF
     */
    public function generate($application, string $serviceType)
    {
        $config = config('certificate-services.services.' . $serviceType);
        $company = config('certificate-services.company');

        // Determine currency
        $currency = $this->determineCurrency($application, $serviceType);
        $bankAccount = $config['bank_accounts'][$currency] ?? $config['bank_accounts']['eur'];
        $pricing = $config['pricing'][$currency] ?? $config['pricing']['eur'];

        // Build data for the view
        $data = [
            'application' => $application,
            'serviceType' => $serviceType,
            'config' => $config,
            'company' => $company,
            'bankAccount' => $bankAccount,
            'pricing' => $pricing,
            'currency' => $currency,
            'currencySymbol' => $pricing['currency_symbol'],
            'currencyCode' => $pricing['currency_code'],
            'processingTime' => $config['processing_times'][$application->service_type] ?? $config['processing_times']['normal'],
            'generatedAt' => now(),
        ];

        $pdf = Pdf::loadView('pdfs.payment-details', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf;
    }

    /**
     * Download a payment PDF directly.
     *
     * @param mixed $application
     * @param string $serviceType
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function download($application, string $serviceType)
    {
        $pdf = $this->generate($application, $serviceType);
        $filename = 'Payment_Details_' . $application->application_reference . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Get the stored PDF path for an application.
     *
     * @param mixed $application
     * @param string $serviceType
     * @return string|null
     */
    public function getStoredPdfPath($application, string $serviceType): ?string
    {
        // Try to find the payment_details document in the application's documents
        $document = $application->documents()
            ->where('document_type', 'payment_details')
            ->first();

        if ($document && Storage::disk('private')->exists($document->file_path)) {
            return $document->file_path;
        }

        return null;
    }

    /**
     * Determine the currency for the application.
     *
     * @param mixed $application
     * @param string $serviceType
     * @return string
     */
    protected function determineCurrency($application, string $serviceType): string
    {
        // UK Police Certificate supports both GBP and EUR
        if ($serviceType === 'uk-police' && isset($application->payment_currency)) {
            return strtolower($application->payment_currency);
        }

        // Portugal and Greece only use EUR
        return 'eur';
    }

    /**
     * Get the storage path for PDF files based on service type.
     *
     * @param string $serviceType
     * @return string
     */
    protected function getStoragePath(string $serviceType): string
    {
        $paths = [
            'uk-police' => 'police-certificates/payment-pdfs',
            'portugal' => 'portugal-certificates/payment-pdfs',
            'greece' => 'greece-certificates/payment-pdfs',
        ];

        return $paths[$serviceType] ?? 'certificates/payment-pdfs';
    }
}
