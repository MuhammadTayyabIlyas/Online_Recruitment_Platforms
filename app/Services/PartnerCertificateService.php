<?php

namespace App\Services;

use App\Models\AuthorizedPartner;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PartnerCertificateService
{
    /**
     * Generate the partner certificate PDF and store it.
     */
    public function generate(AuthorizedPartner $partner): string
    {
        $verificationUrl = route('partner.verify', $partner->reference_number);

        // Generate QR code as base64 SVG for embedding in PDF
        $qrCodeSvg = QrCode::format('svg')
            ->size(200)
            ->margin(1)
            ->generate($verificationUrl);

        $qrCodeBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);

        // Load the company logo as base64
        $logoPath = public_path('assets/images/logo.jpg');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath));
        }

        $data = [
            'partner' => $partner,
            'qrCodeBase64' => $qrCodeBase64,
            'logoBase64' => $logoBase64,
            'verificationUrl' => $verificationUrl,
        ];

        $pdf = Pdf::loadView('pdfs.partner-certificate', $data);
        $pdf->setPaper('A4', 'landscape');

        $filename = 'Partner_Certificate_' . $partner->reference_number . '.pdf';
        $storagePath = 'partner-certificates/' . $filename;

        Storage::disk('private')->put($storagePath, $pdf->output());

        $partner->certificate_path = $storagePath;
        $partner->save();

        return $storagePath;
    }
}
