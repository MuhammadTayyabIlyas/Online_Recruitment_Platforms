<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Authorization Letter - Greek Police Certificate</title>
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
            margin: 0 0 12px 0;
            letter-spacing: 0.5px;
        }
        .authorization-text {
            text-align: justify;
            margin-bottom: 12px;
        }
        .authorization-text p {
            margin: 0;
        }
        .section-title {
            font-size: 11pt;
            font-weight: bold;
            margin: 10px 0 8px 0;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .details-table .label {
            width: 40%;
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
            margin-top: 10px;
        }
        .signature-table td {
            padding: 3px 0;
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
        .greek-section {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #000;
        }
    </style>
</head>
<body>
    @php
        $residenceHistory = is_array($application->greece_residence_history) ? $application->greece_residence_history : [];
        $hasResidenceHistory = count($residenceHistory) > 0;
        $firstPeriod = $hasResidenceHistory ? $residenceHistory[0] : null;
        $lastPeriod = $hasResidenceHistory ? $residenceHistory[count($residenceHistory) - 1] : null;

        $fullName = trim($application->first_name . ' ' . ($application->middle_name ? $application->middle_name . ' ' : '') . $application->last_name);

        $residencePeriod = '';
        if ($hasResidenceHistory) {
            $fromDate = isset($firstPeriod['from_date']) ? \Carbon\Carbon::parse($firstPeriod['from_date'])->format('d/m/Y') : '';
            $toDate = isset($lastPeriod['to_date']) && $lastPeriod['to_date'] ? \Carbon\Carbon::parse($lastPeriod['to_date'])->format('d/m/Y') : 'Present';
            $residencePeriod = $fromDate . ' - ' . $toDate;
        }

        $residencePeriodGr = '';
        if ($hasResidenceHistory) {
            $fromDateGr = isset($firstPeriod['from_date']) ? \Carbon\Carbon::parse($firstPeriod['from_date'])->format('d/m/Y') : '';
            $toDateGr = isset($lastPeriod['to_date']) && $lastPeriod['to_date'] ? \Carbon\Carbon::parse($lastPeriod['to_date'])->format('d/m/Y') : 'Παρόν';
            $residencePeriodGr = $fromDateGr . ' - ' . $toDateGr;
        }

        $lastAddress = '';
        if ($hasResidenceHistory) {
            $lastAddress = ($lastPeriod['address'] ?? '') . (isset($lastPeriod['city']) ? ', ' . $lastPeriod['city'] : '');
        }

        $currentAddress = $application->current_address_line1
            . ($application->current_address_line2 ? ', ' . $application->current_address_line2 : '')
            . ', ' . $application->current_city
            . ', ' . $application->current_postal_code
            . ', ' . $application->current_country;
    @endphp

    <!-- ENGLISH SECTION -->
    <h1>AUTHORIZATION LETTER – GREEK POLICE CERTIFICATE</h1>

    <div class="authorization-text">
        <p>
            I, <span class="field-value">{{ $fullName }}</span>, holder of passport number <span class="field-value">{{ $application->passport_number }}</span>,
            nationality <span class="field-value">{{ $application->nationality }}</span>, hereby authorize <span class="empty-field"></span> to
            act on my behalf for the purpose of applying for and collecting my Greek Police Clearance
            Certificate (Criminal Record Certificate) from the competent authorities in Greece.
        </p>
    </div>

    <div class="section-title">Personal Details</div>

    <table class="details-table">
        <tr>
            <td class="label">Period of residence in Greece:</td>
            <td><span class="field-value">{{ $residencePeriod }}</span></td>
        </tr>
        <tr>
            <td class="label">Last address in Greece:</td>
            <td><span class="field-value">{{ $lastAddress }}</span></td>
        </tr>
        <tr>
            <td class="label">Current address:</td>
            <td><span class="field-value">{{ $currentAddress }}</span></td>
        </tr>
        <tr>
            <td class="label">Email:</td>
            <td><span class="field-value">{{ $application->email }}</span></td>
        </tr>
        <tr>
            <td class="label">Telephone:</td>
            <td><span class="field-value">{{ $application->phone_number }}</span></td>
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

    <!-- GREEK SECTION -->
    <div class="greek-section">
        <h1>ΕΞΟΥΣΙΟΔΟΤΗΣΗ – ΠΙΣΤΟΠΟΙΗΤΙΚΟ ΠΟΙΝΙΚΟΥ ΜΗΤΡΩΟΥ ΕΛΛΑΔΑΣ</h1>

        <div class="authorization-text">
            <p>
                Εγώ ο/η <span class="field-value">{{ $fullName }}</span>, κάτοχος διαβατηρίου αριθ.
                <span class="field-value">{{ $application->passport_number }}</span>, υπηκοότητας <span class="field-value">{{ $application->nationality }}</span>, εξουσιοδοτώ
                τον/την <span class="empty-field"></span> να ενεργήσει εκ μέρους μου για την υποβολή αίτησης
                και παραλαβή του Πιστοποιητικού Ποινικού Μητρώου από τις αρμόδιες αρχές της Ελλάδας.
            </p>
        </div>

        <div class="section-title">Στοιχεία Αιτούντος</div>

        <table class="details-table">
            <tr>
                <td class="label">Περίοδος διαμονής στην Ελλάδα:</td>
                <td><span class="field-value">{{ $residencePeriodGr }}</span></td>
            </tr>
            <tr>
                <td class="label">Τελευταία διεύθυνση στην Ελλάδα:</td>
                <td><span class="field-value">{{ $lastAddress }}</span></td>
            </tr>
            <tr>
                <td class="label">Τρέχουσα διεύθυνση:</td>
                <td><span class="field-value">{{ $currentAddress }}</span></td>
            </tr>
            <tr>
                <td class="label">Ηλεκτρονικό ταχυδρομείο:</td>
                <td><span class="field-value">{{ $application->email }}</span></td>
            </tr>
            <tr>
                <td class="label">Τηλέφωνο επικοινωνίας:</td>
                <td><span class="field-value">{{ $application->phone_number }}</span></td>
            </tr>
        </table>

        <table class="signature-table">
            <tr>
                <td class="label">Τόπος:</td>
                <td>
                    @if(!empty($signaturePlace))
                        <span class="signature-line">{{ $signaturePlace }}</span>
                    @else
                        <span class="signature-line"></span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Ημερομηνία:</td>
                <td>
                    @if(!empty($generatedDate))
                        <span class="signature-line">{{ $generatedDate }}</span>
                    @else
                        <span class="signature-line"></span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Υπογραφή:</td>
                <td>
                    @if(!empty($signatureImage))
                        <img src="{{ $signatureImage }}" class="signature-image" alt="Υπογραφή">
                    @else
                        <span class="signature-line"></span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Ονοματεπώνυμο:</td>
                <td><span class="signature-line">{{ $fullName }}</span></td>
            </tr>
        </table>
    </div>
</body>
</html>
