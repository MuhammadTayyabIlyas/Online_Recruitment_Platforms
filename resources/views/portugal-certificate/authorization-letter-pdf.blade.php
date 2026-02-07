<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Authorization Letter - Portugal Criminal Record Certificate</title>
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
            min-width: 200px;
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
        .portuguese-section {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #000;
        }
    </style>
</head>
<body>
    @php
        $fullName = trim($application->first_name . ' ' . ($application->middle_name ? $application->middle_name . ' ' : '') . $application->last_name);

        $residenceHistory = is_array($application->portugal_residence_history) ? $application->portugal_residence_history : [];
        $hasResidenceHistory = count($residenceHistory) > 0;
        $firstPeriod = $hasResidenceHistory ? $residenceHistory[0] : null;
        $lastPeriod = $hasResidenceHistory ? $residenceHistory[count($residenceHistory) - 1] : null;

        $residencePeriod = '';
        if ($hasResidenceHistory) {
            $fromDate = isset($firstPeriod['from_date']) ? \Carbon\Carbon::parse($firstPeriod['from_date'])->format('d/m/Y') : '';
            $toDate = isset($lastPeriod['to_date']) && $lastPeriod['to_date'] ? \Carbon\Carbon::parse($lastPeriod['to_date'])->format('d/m/Y') : 'Present';
            $residencePeriod = $fromDate . ' - ' . $toDate;
        }

        $residencePeriodPt = '';
        if ($hasResidenceHistory) {
            $fromDatePt = isset($firstPeriod['from_date']) ? \Carbon\Carbon::parse($firstPeriod['from_date'])->format('d/m/Y') : '';
            $toDatePt = isset($lastPeriod['to_date']) && $lastPeriod['to_date'] ? \Carbon\Carbon::parse($lastPeriod['to_date'])->format('d/m/Y') : 'Presente';
            $residencePeriodPt = $fromDatePt . ' - ' . $toDatePt;
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
    <h1>AUTHORIZATION LETTER &ndash; PORTUGAL CRIMINAL RECORD CERTIFICATE</h1>

    <div class="authorization-text">
        <p>
            I, <span class="field-value">{{ $fullName }}</span>, holder of passport number <span class="field-value">{{ $application->passport_number }}</span>,
            nationality <span class="field-value">{{ $application->nationality }}</span>, hereby authorize <span class="empty-field"></span> to
            act on my behalf for the purpose of applying for and collecting my Portuguese Criminal Record
            Certificate (Certificado do Registo Criminal) from the competent authorities in Portugal.
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
            <td><span class="field-value">{{ $application->father_name }}</span></td>
        </tr>
        <tr>
            <td class="label">Mother's Name:</td>
            <td><span class="field-value">{{ $application->mother_name }}</span></td>
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
            <td class="label">Period of residence in Portugal:</td>
            <td><span class="field-value">{{ $residencePeriod }}</span></td>
        </tr>
        <tr>
            <td class="label">Last address in Portugal:</td>
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

    <!-- PORTUGUESE SECTION -->
    <div class="portuguese-section">
        <h1>PROCURA&Ccedil;&Atilde;O &ndash; CERTIFICADO DO REGISTO CRIMINAL</h1>

        <div class="authorization-text">
            <p>
                Eu, <span class="field-value">{{ $fullName }}</span>, titular do passaporte n.&ordm;
                <span class="field-value">{{ $application->passport_number }}</span>, nacionalidade <span class="field-value">{{ $application->nationality }}</span>, autorizo
                <span class="empty-field"></span> a agir em meu nome para efeitos de requerer e recolher o meu
                Certificado do Registo Criminal junto das autoridades competentes em Portugal.
            </p>
            <p>
                Confirmo que todas as informa&ccedil;&otilde;es prestadas nesta candidatura s&atilde;o verdadeiras e corretas, tanto quanto &eacute; do meu conhecimento.
            </p>
        </div>

        <div class="section-title">Dados Pessoais</div>

        <table class="details-table">
            <tr>
                <td class="label">Nome completo:</td>
                <td><span class="field-value">{{ $fullName }}</span></td>
            </tr>
            <tr>
                <td class="label">Nome do pai:</td>
                <td><span class="field-value">{{ $application->father_name }}</span></td>
            </tr>
            <tr>
                <td class="label">Nome da m&atilde;e:</td>
                <td><span class="field-value">{{ $application->mother_name }}</span></td>
            </tr>
            <tr>
                <td class="label">Data de nascimento:</td>
                <td><span class="field-value">{{ $application->date_of_birth ? $application->date_of_birth->format('d/m/Y') : '' }}</span></td>
            </tr>
            <tr>
                <td class="label">N&uacute;mero do passaporte:</td>
                <td><span class="field-value">{{ $application->passport_number }}</span></td>
            </tr>
            <tr>
                <td class="label">Per&iacute;odo de resid&ecirc;ncia em Portugal:</td>
                <td><span class="field-value">{{ $residencePeriodPt }}</span></td>
            </tr>
            <tr>
                <td class="label">&Uacute;ltima morada em Portugal:</td>
                <td><span class="field-value">{{ $lastAddress }}</span></td>
            </tr>
            <tr>
                <td class="label">Morada atual:</td>
                <td><span class="field-value">{{ $currentAddress }}</span></td>
            </tr>
            <tr>
                <td class="label">Email:</td>
                <td><span class="field-value">{{ $application->email }}</span></td>
            </tr>
            <tr>
                <td class="label">Telefone:</td>
                <td><span class="field-value">{{ $application->phone_number }}</span></td>
            </tr>
        </table>

        <table class="signature-table">
            <tr>
                <td class="label">Local:</td>
                <td>
                    @if(!empty($signaturePlace))
                        <span class="signature-line">{{ $signaturePlace }}</span>
                    @else
                        <span class="signature-line"></span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Data:</td>
                <td>
                    @if(!empty($generatedDate))
                        <span class="signature-line">{{ $generatedDate }}</span>
                    @else
                        <span class="signature-line"></span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Assinatura:</td>
                <td>
                    @if(!empty($signatureImage))
                        <img src="{{ $signatureImage }}" class="signature-image" alt="Assinatura">
                    @else
                        <span class="signature-line"></span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Nome completo:</td>
                <td><span class="signature-line">{{ $fullName }}</span></td>
            </tr>
        </table>
    </div>
</body>
</html>
