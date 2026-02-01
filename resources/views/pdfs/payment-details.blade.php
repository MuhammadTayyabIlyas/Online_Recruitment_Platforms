<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details - {{ $application->application_reference }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #1f2937;
            background: #fff;
        }

        .container {
            padding: 40px;
            max-width: 100%;
        }

        /* Header */
        .header {
            background: {{ $config['brand_color'] }};
            color: #fff;
            padding: 25px 30px;
            margin: -40px -40px 30px -40px;
            display: table;
            width: calc(100% + 80px);
        }

        .header-content {
            display: table-cell;
            vertical-align: middle;
        }

        .logo-section {
            display: table-cell;
            vertical-align: middle;
            width: 80px;
        }

        .logo {
            width: 60px;
            height: auto;
        }

        .header-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .header-subtitle {
            font-size: 14px;
            opacity: 0.9;
        }

        /* Reference Box */
        .reference-box {
            background: #EEF2FF;
            border: 2px solid #6366F1;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin-bottom: 25px;
        }

        .reference-label {
            font-size: 11px;
            color: #6366F1;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .reference-number {
            font-size: 26px;
            font-weight: bold;
            color: #4338CA;
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
        }

        .reference-note {
            font-size: 10px;
            color: #6B7280;
            margin-top: 8px;
        }

        /* Section Title */
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 2px solid #E5E7EB;
        }

        /* Application Summary Table */
        .summary-table {
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 8px 0;
            border-bottom: 1px solid #F3F4F6;
        }

        .summary-table td:first-child {
            color: #6B7280;
            width: 40%;
        }

        .summary-table td:last-child {
            font-weight: 500;
            color: #1f2937;
        }

        /* Amount Box */
        .amount-box {
            background: #FEF3C7;
            border: 2px solid #F59E0B;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin-bottom: 25px;
        }

        .amount-label {
            font-size: 12px;
            color: #92400E;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .amount-value {
            font-size: 32px;
            font-weight: bold;
            color: #92400E;
        }

        /* Bank Details Box */
        .bank-details {
            background: #F9FAFB;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .bank-table {
            width: 100%;
            border-collapse: collapse;
        }

        .bank-table td {
            padding: 6px 0;
        }

        .bank-table td:first-child {
            color: #6B7280;
            width: 35%;
            font-size: 11px;
        }

        .bank-table td:last-child {
            font-weight: 500;
            font-family: 'Courier New', monospace;
        }

        .bank-table tr.highlight td {
            background: #FEF3C7;
            padding: 8px 10px;
            border-radius: 4px;
        }

        .bank-table tr.highlight td:first-child {
            font-weight: bold;
            color: #92400E;
        }

        .bank-table tr.highlight td:last-child {
            font-weight: bold;
            color: #92400E;
        }

        /* Instructions Box */
        .instructions-box {
            background: #ECFDF5;
            border: 1px solid #6EE7B7;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .instructions-title {
            font-size: 13px;
            font-weight: bold;
            color: #065F46;
            margin-bottom: 12px;
        }

        .instructions-list {
            list-style: none;
            padding: 0;
        }

        .instructions-list li {
            padding: 8px 0;
            padding-left: 28px;
            position: relative;
            color: #047857;
        }

        .instructions-list li::before {
            content: attr(data-step);
            position: absolute;
            left: 0;
            top: 8px;
            width: 20px;
            height: 20px;
            background: #10B981;
            color: #fff;
            border-radius: 50%;
            font-size: 11px;
            font-weight: bold;
            text-align: center;
            line-height: 20px;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #E5E7EB;
            text-align: center;
            color: #6B7280;
            font-size: 10px;
        }

        .footer-company {
            font-weight: bold;
            color: #374151;
            margin-bottom: 5px;
        }

        .footer-contact {
            margin-bottom: 10px;
        }

        .footer-generated {
            font-size: 9px;
            color: #9CA3AF;
        }

        /* Important Notice */
        .notice {
            background: #FEF2F2;
            border-left: 4px solid #EF4444;
            padding: 12px 15px;
            margin-bottom: 20px;
            font-size: 11px;
            color: #991B1B;
        }

        .notice strong {
            display: block;
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo-section">
                @if(file_exists(public_path('assets/images/logo.jpg')))
                    <img src="{{ public_path('assets/images/logo.jpg') }}" alt="PlaceMeNet" class="logo">
                @endif
            </div>
            <div class="header-content">
                <div class="header-title">{{ $config['name'] }}</div>
                <div class="header-subtitle">Payment Details & Instructions</div>
            </div>
        </div>

        <!-- Reference Number Box -->
        <div class="reference-box">
            <div class="reference-label">Application Reference</div>
            <div class="reference-number">{{ $application->application_reference }}</div>
            <div class="reference-note">Keep this reference for all communications</div>
        </div>

        <!-- Application Summary -->
        <div class="section-title">Application Summary</div>
        <table class="summary-table">
            <tr>
                <td>Applicant Name:</td>
                <td>{{ $application->first_name }} {{ $application->middle_name ?? '' }} {{ $application->last_name }}</td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>{{ $application->email }}</td>
            </tr>
            <tr>
                <td>Service Type:</td>
                <td>{{ ucfirst($application->service_type ?? 'normal') }} Processing ({{ $processingTime }})</td>
            </tr>
            <tr>
                <td>Submitted:</td>
                <td>{{ $application->submitted_at ? $application->submitted_at->format('d M Y, H:i') : $generatedAt->format('d M Y, H:i') }}</td>
            </tr>
        </table>

        <!-- Amount Due -->
        <div class="amount-box">
            <div class="amount-label">Amount Due</div>
            <div class="amount-value">{{ $currencySymbol }}{{ number_format($application->payment_amount, 2) }} {{ $currencyCode }}</div>
        </div>

        <!-- Bank Transfer Details -->
        <div class="section-title">Bank Transfer Details</div>
        <div class="bank-details">
            <table class="bank-table">
                <tr>
                    <td>Bank:</td>
                    <td>{{ $bankAccount['bank_name'] }}</td>
                </tr>
                <tr>
                    <td>Account Name:</td>
                    <td>{{ $bankAccount['account_name'] }}</td>
                </tr>
                @if(isset($bankAccount['account_number']))
                <tr>
                    <td>Account Number:</td>
                    <td>{{ $bankAccount['account_number'] }}</td>
                </tr>
                @endif
                @if(isset($bankAccount['sort_code']))
                <tr>
                    <td>Sort Code:</td>
                    <td>{{ $bankAccount['sort_code'] }}</td>
                </tr>
                @endif
                <tr>
                    <td>IBAN:</td>
                    <td>{{ $bankAccount['iban'] }}</td>
                </tr>
                <tr>
                    <td>SWIFT/BIC:</td>
                    <td>{{ $bankAccount['swift_bic'] }}</td>
                </tr>
                <tr class="highlight">
                    <td>Payment Reference:</td>
                    <td>{{ $application->application_reference }}</td>
                </tr>
            </table>
        </div>

        <!-- Important Notice -->
        <div class="notice">
            <strong>IMPORTANT:</strong>
            Always use your application reference ({{ $application->application_reference }}) as the payment reference. This helps us identify and verify your payment quickly.
        </div>

        <!-- What To Do Next -->
        <div class="instructions-box">
            <div class="instructions-title">What To Do Next</div>
            <ul class="instructions-list">
                <li data-step="1">Make a bank transfer using the details above</li>
                <li data-step="2">Use <strong>{{ $application->application_reference }}</strong> as your payment reference</li>
                <li data-step="3">Upload your payment receipt to your dashboard or email it to us</li>
                <li data-step="4">We'll verify your payment and begin processing your application</li>
            </ul>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-company">{{ $company['name'] }}</div>
            <div class="footer-contact">
                Email: {{ $company['email'] }} | Website: {{ $company['website'] }}
            </div>
            <div class="footer-generated">
                Generated on {{ $generatedAt->format('d M Y') }} at {{ $generatedAt->format('H:i') }} (UTC)
            </div>
        </div>
    </div>
</body>
</html>
