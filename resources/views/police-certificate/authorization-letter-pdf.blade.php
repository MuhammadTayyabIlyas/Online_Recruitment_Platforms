<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Authorization Letter - UK Police Certificate (ACRO)</title>
    <style>
        @page {
            margin: 1.5cm;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #000;
        }
        h1 {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin: 0 0 20px 0;
            letter-spacing: 0.5px;
        }
        .authorization-text {
            text-align: justify;
            margin-bottom: 16px;
        }
        .authorization-text p {
            margin: 0 0 10px 0;
        }
        .section-title {
            font-size: 11pt;
            font-weight: bold;
            margin: 16px 0 10px 0;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .details-table .label {
            width: 35%;
        }
        .field-value {
            border-bottom: 1px solid #000;
            padding: 0 3px;
            word-wrap: break-word;
        }
        .empty-field {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 140px;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .signature-table td {
            padding: 4px 0;
            vertical-align: bottom;
        }
        .signature-table .label {
            width: 20%;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 200px;
            padding: 0 3px;
            word-wrap: break-word;
        }
        .signature-image {
            max-width: 200px;
            max-height: 60px;
        }
        .declaration {
            margin-top: 16px;
            font-style: italic;
        }
    </style>
</head>
<body>
    @php
        $fullName = trim($application->first_name . ' ' . ($application->middle_name ? $application->middle_name . ' ' : '') . $application->last_name);

        $currentAddress = $application->spain_address_line1
            . ($application->spain_address_line2 ? ', ' . $application->spain_address_line2 : '')
            . ', ' . $application->spain_city
            . ', ' . $application->spain_province
            . ' ' . $application->spain_postal_code
            . ', Spain';
    @endphp

    <h1>AUTHORIZATION LETTER &ndash; UK POLICE CERTIFICATE (ACRO)</h1>

    <div class="authorization-text">
        <p>
            I, <span class="field-value">{{ $fullName }}</span>, born on
            <span class="field-value">{{ $application->date_of_birth ? $application->date_of_birth->format('d/m/Y') : '' }}</span>,
            holder of Pakistani passport number <span class="field-value">{{ $application->passport_number }}</span>,
            CNIC/NICOP number <span class="field-value">{{ $application->cnic_nicop_number }}</span>,
            hereby authorize <strong>PLACEMENT UK LIMITED</strong> (Company No. 04699796, registered in England and Wales)
            to act on my behalf for the purpose of applying for and obtaining my UK Police Certificate
            (ACRO Criminal Records Certificate) from the ACRO Criminal Records Office.
        </p>
        <p>
            I confirm that all information provided in this application is true and correct to the best of my knowledge.
        </p>
    </div>

    <div class="section-title">Personal Details</div>

    <table class="details-table">
        <tr>
            <td class="label">Full Name:</td>
            <td><span class="field-value">{{ $fullName }}</span></td>
        </tr>
        <tr>
            <td class="label">Father's Name:</td>
            <td><span class="field-value">{{ $application->father_full_name }}</span></td>
        </tr>
        <tr>
            <td class="label">Date of Birth:</td>
            <td><span class="field-value">{{ $application->date_of_birth ? $application->date_of_birth->format('d/m/Y') : '' }}</span></td>
        </tr>
        <tr>
            <td class="label">Passport Number:</td>
            <td><span class="field-value">{{ $application->passport_number }}</span></td>
        </tr>
        <tr>
            <td class="label">CNIC/NICOP Number:</td>
            <td><span class="field-value">{{ $application->cnic_nicop_number }}</span></td>
        </tr>
        <tr>
            <td class="label">Current Address (Spain):</td>
            <td><span class="field-value">{{ $currentAddress }}</span></td>
        </tr>
        <tr>
            <td class="label">Email:</td>
            <td><span class="field-value">{{ $application->email }}</span></td>
        </tr>
        <tr>
            <td class="label">Phone:</td>
            <td><span class="field-value">{{ $application->phone_spain }}</span></td>
        </tr>
    </table>

    <table class="signature-table">
        <tr>
            <td class="label">Place:</td>
            <td>
                @if(!empty($signaturePlace))
                    <span class="signature-line">{{ $signaturePlace }}</span>
                @else
                    <span class="signature-line"></span>
                @endif
            </td>
        </tr>
        <tr>
            <td class="label">Date:</td>
            <td>
                @if(!empty($generatedDate))
                    <span class="signature-line">{{ $generatedDate }}</span>
                @else
                    <span class="signature-line"></span>
                @endif
            </td>
        </tr>
        <tr>
            <td class="label">Signature:</td>
            <td>
                @if(!empty($signatureImage))
                    <img src="{{ $signatureImage }}" class="signature-image" alt="Signature">
                @else
                    <span class="signature-line"></span>
                @endif
            </td>
        </tr>
        <tr>
            <td class="label">Full Name:</td>
            <td><span class="signature-line">{{ $fullName }}</span></td>
        </tr>
    </table>
</body>
</html>
