<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Payment Details - {{ $application->application_reference }}</title>
    <style>
        @page {
            margin: 1cm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9pt;
            line-height: 1.3;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }

        .header {
            background: {{ $config['brand_color'] }};
            color: #fff;
            padding: 12px 15px;
            margin-bottom: 10px;
        }

        .header-title {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
        }

        .header-subtitle {
            font-size: 9pt;
            opacity: 0.9;
            margin: 2px 0 0 0;
        }

        .reference-box {
            background: #f0f9ff;
            border: 2px solid {{ $config['brand_color'] }};
            padding: 10px;
            text-align: center;
            margin-bottom: 10px;
        }

        .reference-label {
            font-size: 8pt;
            color: {{ $config['brand_color'] }};
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 3px;
        }

        .reference-number {
            font-size: 16pt;
            font-weight: bold;
            color: #1f2937;
            font-family: monospace;
        }

        .main-content {
            width: 100%;
        }

        .left-col {
            width: 58%;
            float: left;
            padding-right: 10px;
        }

        .right-col {
            width: 40%;
            float: right;
        }

        .clearfix::after {
            content: "";
            display: block;
            clear: both;
        }

        .section-title {
            font-size: 10pt;
            font-weight: bold;
            color: #1f2937;
            margin: 0 0 6px 0;
            padding-bottom: 3px;
            border-bottom: 2px solid {{ $config['brand_color'] }};
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .info-table td {
            padding: 3px 0;
            font-size: 9pt;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-table td:first-child {
            color: #6b7280;
            width: 35%;
        }

        .info-table td:last-child {
            font-weight: 500;
        }

        .amount-box {
            background: #fef3c7;
            border: 2px solid #f59e0b;
            padding: 12px 10px;
            text-align: center;
            margin-bottom: 8px;
        }

        .amount-label {
            font-size: 8pt;
            color: #92400e;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .amount-value {
            font-size: 20pt;
            font-weight: bold;
            color: #92400e;
        }

        .amount-currency {
            font-size: 8pt;
            color: #92400e;
        }

        .bank-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 10px;
            margin-bottom: 8px;
        }

        .bank-table {
            width: 100%;
            border-collapse: collapse;
        }

        .bank-table td {
            padding: 3px 0;
            font-size: 9pt;
        }

        .bank-table td:first-child {
            color: #6b7280;
            width: 35%;
        }

        .bank-table td:last-child {
            font-weight: 500;
            font-family: monospace;
            font-size: 8pt;
        }

        .bank-table tr.highlight td {
            background: #fef3c7;
            padding: 5px;
            font-weight: bold;
            color: #92400e;
        }

        .notice {
            background: #fef2f2;
            border-left: 3px solid #ef4444;
            padding: 6px 10px;
            margin-bottom: 8px;
            font-size: 8pt;
            color: #991b1b;
        }

        .steps-box {
            background: #ecfdf5;
            border: 1px solid #6ee7b7;
            padding: 10px;
            margin-bottom: 8px;
        }

        .steps-title {
            font-size: 10pt;
            font-weight: bold;
            color: #065f46;
            margin: 0 0 6px 0;
        }

        .steps-table {
            width: 100%;
            border-collapse: collapse;
        }

        .steps-table td {
            padding: 2px 0;
            font-size: 9pt;
            color: #047857;
            vertical-align: top;
        }

        .steps-table td:first-child {
            width: 18px;
            font-weight: bold;
        }

        .footer {
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 8pt;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-title">{{ $config['name'] }}</div>
        <div class="header-subtitle">Payment Details & Instructions</div>
    </div>

    <div class="reference-box">
        <div class="reference-label">Application Reference</div>
        <div class="reference-number">{{ $application->application_reference }}</div>
    </div>

    <div class="main-content clearfix">
        <div class="left-col">
            <div class="section-title">Application Summary</div>
            <table class="info-table">
                <tr>
                    <td>Applicant:</td>
                    <td>{{ $application->first_name }} {{ $application->middle_name ?? '' }} {{ $application->last_name }}</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>{{ $application->email }}</td>
                </tr>
                <tr>
                    <td>Service:</td>
                    <td>{{ ucfirst($application->service_type ?? 'normal') }} ({{ $processingTime }})</td>
                </tr>
                <tr>
                    <td>Date:</td>
                    <td>{{ $application->submitted_at ? $application->submitted_at->format('d M Y') : $generatedAt->format('d M Y') }}</td>
                </tr>
            </table>
        </div>
        <div class="right-col">
            <div class="amount-box">
                <div class="amount-label">Amount Due</div>
                <div class="amount-value">{{ $currencySymbol }}{{ number_format($application->payment_amount, 2) }}</div>
                <div class="amount-currency">{{ $currencyCode }}</div>
            </div>
        </div>
    </div>

    <div class="section-title">Bank Transfer Details</div>
    <div class="bank-box">
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
                <td>Reference:</td>
                <td>{{ $application->application_reference }}</td>
            </tr>
        </table>
    </div>

    <div class="notice">
        <strong>IMPORTANT:</strong> Always use <strong>{{ $application->application_reference }}</strong> as your payment reference.
    </div>

    <div class="steps-box">
        <div class="steps-title">What To Do Next</div>
        <table class="steps-table">
            <tr>
                <td>1.</td>
                <td>Make a bank transfer using the details above</td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Use <strong>{{ $application->application_reference }}</strong> as payment reference</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Upload your payment receipt to your dashboard or email to {{ $company['email'] }}</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>We'll verify payment and begin processing your application</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <strong>{{ $company['name'] }}</strong> | {{ $company['email'] }} | {{ $company['website'] }}<br>
        Generated: {{ $generatedAt->format('d M Y, H:i') }} UTC
    </div>
</body>
</html>
