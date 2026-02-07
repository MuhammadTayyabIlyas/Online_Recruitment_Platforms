<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Authorized Partner Certificate - {{ $partner->reference_number }}</title>
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
            color: #1f2937;
        }

        .certificate-wrapper {
            width: 100%;
            height: 100%;
            position: relative;
        }

        .border-outer {
            border: 3px solid #4338ca;
            margin: 15px;
            padding: 5px;
        }

        .border-inner {
            border: 1px solid #6366f1;
            padding: 30px 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            max-height: 50px;
            margin-bottom: 10px;
        }

        .title {
            font-size: 22pt;
            font-weight: bold;
            color: #312e81;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin: 10px 0 5px 0;
        }

        .subtitle {
            font-size: 10pt;
            color: #6366f1;
            margin: 0;
            letter-spacing: 1px;
        }

        .divider {
            border: none;
            border-top: 2px solid #e0e7ff;
            margin: 15px 60px;
        }

        .body-text {
            text-align: center;
            font-size: 10pt;
            line-height: 1.8;
            color: #374151;
            max-width: 700px;
            margin: 0 auto 15px auto;
            padding: 0 20px;
        }

        .business-name {
            font-size: 16pt;
            font-weight: bold;
            color: #1e1b4b;
        }

        .countries-list {
            display: inline;
            font-weight: bold;
            color: #4338ca;
        }

        .details-grid {
            width: 100%;
            margin: 15px auto;
        }

        .details-grid td {
            padding: 3px 0;
            font-size: 9pt;
        }

        .details-label {
            color: #6b7280;
            width: 50%;
            text-align: right;
            padding-right: 10px;
        }

        .details-value {
            font-weight: bold;
            color: #1f2937;
            width: 50%;
            padding-left: 10px;
        }

        .qr-section {
            text-align: center;
            margin-top: 10px;
        }

        .qr-section img {
            width: 120px;
            height: 120px;
        }

        .qr-label {
            font-size: 7pt;
            color: #9ca3af;
            margin-top: 3px;
        }

        .footer {
            text-align: center;
            font-size: 7pt;
            color: #9ca3af;
            margin-top: 10px;
        }

        .footer-url {
            font-size: 7.5pt;
            color: #6366f1;
        }

        .content-area {
            width: 100%;
        }

        .left-content {
            width: 72%;
            vertical-align: top;
        }

        .right-content {
            width: 28%;
            vertical-align: middle;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="certificate-wrapper">
        <div class="border-outer">
            <div class="border-inner">
                <!-- Header -->
                <div class="header">
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" class="logo" alt="PlaceMeNet">
                    @endif
                    <p class="title">Authorized Partner Certificate</p>
                    <p class="subtitle">PlaceMeNet I.K.E. - Certificate Services</p>
                </div>

                <hr class="divider">

                <!-- Main Content -->
                <table class="content-area">
                    <tr>
                        <td class="left-content">
                            <div class="body-text">
                                This is to certify that
                            </div>
                            <div class="body-text">
                                <span class="business-name">{{ $partner->business_name }}</span>
                            </div>
                            <div class="body-text">
                                operated by <strong>{{ $partner->user->name }}</strong>,
                                located at {{ $partner->address_line1 }}, {{ $partner->city }}, {{ $partner->country }},
                                Tax ID: <strong>{{ $partner->tax_id }}</strong>,
                                is an authorized partner of PlaceMeNet I.K.E. for the provision of the following certificate services:
                            </div>
                            <div class="body-text">
                                <span class="countries-list">
                                    {{ implode(', ', $partner->authorized_country_labels) }}
                                </span>
                            </div>

                            <!-- Details -->
                            <table class="details-grid">
                                <tr>
                                    <td class="details-label">Reference Number:</td>
                                    <td class="details-value">{{ $partner->reference_number }}</td>
                                </tr>
                                <tr>
                                    <td class="details-label">Valid From:</td>
                                    <td class="details-value">{{ $partner->approved_at?->format('F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="details-label">Valid Until:</td>
                                    <td class="details-value">{{ $partner->expires_at?->format('F d, Y') }}</td>
                                </tr>
                            </table>
                        </td>
                        <td class="right-content">
                            <!-- QR Code -->
                            <div class="qr-section">
                                <img src="{{ $qrCodeBase64 }}" alt="Verification QR Code">
                                <div class="qr-label">Scan to verify</div>
                            </div>
                        </td>
                    </tr>
                </table>

                <!-- Footer -->
                <div class="footer">
                    <p class="footer-url">Verify this certificate at: {{ $verificationUrl }}</p>
                    <p>&copy; {{ date('Y') }} PlaceMeNet I.K.E. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
