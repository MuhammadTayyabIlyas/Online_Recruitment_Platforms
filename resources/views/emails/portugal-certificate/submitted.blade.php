<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Received - Portugal Criminal Record Certificate</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f7fa;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f5f7fa;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 650px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #047857 0%, #059669 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 26px; font-weight: 700;">
                                Portugal Criminal Record Certificate
                            </h1>
                            <p style="margin: 10px 0 0; color: rgba(255, 255, 255, 0.95); font-size: 16px;">
                                Application Reference: <strong>{{ $application->application_reference }}</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px; color: #1f2937; font-size: 16px; line-height: 1.6;">
                                Dear Applicant,
                            </p>

                            <p style="margin: 0 0 25px; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                Thank you for your application submitted through the Placemenet portal.
                            </p>

                            <p style="margin: 0 0 25px; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                We confirm that your application has been successfully received and is currently <strong>pending payment confirmation</strong>.
                            </p>

                            <!-- Application Summary -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 30px; background: #ecfdf5; border-radius: 12px; border: 2px solid #a7f3d0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <h3 style="margin: 0 0 15px; color: #047857; font-size: 16px; font-weight: 700;">
                                            Application Summary
                                        </h3>
                                        <table style="width: 100%; font-size: 14px;">
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b;">Reference:</td>
                                                <td style="padding: 5px 0; color: #064e3b; font-weight: 600;">{{ $application->application_reference }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b;">Applicant:</td>
                                                <td style="padding: 5px 0; color: #064e3b; font-weight: 600;">{{ $application->first_name }} {{ $application->last_name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b;">Service Type:</td>
                                                <td style="padding: 5px 0; color: #064e3b; font-weight: 600;">{{ ucfirst($application->service_type) }} Service</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b;">Amount Due:</td>
                                                <td style="padding: 5px 0; color: #064e3b; font-weight: 600; font-size: 16px;">&euro;{{ number_format($application->payment_amount, 2) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Payment Instructions Header -->
                            <div style="border-bottom: 2px solid #e5e7eb; padding-bottom: 10px; margin-bottom: 25px;">
                                <h2 style="margin: 0; color: #1f2937; font-size: 20px; font-weight: 700;">
                                    Payment Instructions
                                </h2>
                            </div>

                            <p style="margin: 0 0 25px; color: #4b5563; font-size: 15px; line-height: 1.6;">
                                Please complete the payment using the bank details provided in the attached PDF or below.
                            </p>

                            <!-- EUR Account Details -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 30px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <h3 style="margin: 0 0 15px; color: #047857; font-size: 16px; font-weight: 700;">
                                            EUR Account Details (Millennium BCP)
                                        </h3>
                                        <table style="width: 100%; font-size: 14px;">
                                            <tr>
                                                <td style="padding: 4px 0; color: #64748b; width: 40%;">Account Name:</td>
                                                <td style="padding: 4px 0; color: #1e293b; font-weight: 600;">PLACEMENET I.K.E.</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 4px 0; color: #64748b;">IBAN:</td>
                                                <td style="padding: 4px 0; color: #1e293b; font-weight: 600; font-family: monospace;">PT50 0033 0000 0012345678901</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 4px 0; color: #64748b;">SWIFT / BIC:</td>
                                                <td style="padding: 4px 0; color: #1e293b; font-weight: 600; font-family: monospace;">BCOMPTPL</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 4px 0; color: #64748b;">Payment Reference:</td>
                                                <td style="padding: 4px 0; color: #047857; font-weight: 700; font-family: monospace;">{{ $application->application_reference }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- After Payment Section -->
                            <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                                <h3 style="margin: 0 0 12px; color: #92400e; font-size: 16px; font-weight: 700;">
                                    After Payment
                                </h3>
                                <p style="margin: 0 0 12px; color: #78350f; font-size: 14px; line-height: 1.6;">
                                    Once the payment has been made, please:
                                </p>
                                <ol style="margin: 0; padding-left: 20px; color: #78350f; font-size: 14px;">
                                    <li style="margin-bottom: 8px; line-height: 1.6;">Upload the payment slip/confirmation to your portal account, or</li>
                                    <li style="line-height: 1.6;">Email the payment confirmation to <a href="mailto:info@placemenet.com" style="color: #92400e; font-weight: 600;">info@placemenet.com</a></li>
                                </ol>
                            </div>

                            <!-- Important Note -->
                            <div style="background-color: #f0fdf4; border: 1px solid #86efac; padding: 20px; border-radius: 8px; margin-bottom: 25px;">
                                <p style="margin: 0; color: #166534; font-size: 14px; line-height: 1.6;">
                                    Upon receipt and verification of payment, we will immediately start processing your application.
                                </p>
                                <p style="margin: 12px 0 0; color: #166534; font-size: 14px; line-height: 1.6;">
                                    <strong>Please note:</strong> All fees are inclusive of the applicable government charges and our facilitation service fee.
                                </p>
                            </div>

                            <!-- Upload Receipt Button -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 25px;">
                                <tr>
                                    <td style="text-align: center; padding: 10px 0;">
                                        <a href="{{ route('portugal-certificate.receipt.show', ['reference' => $application->application_reference]) }}"
                                           style="display: inline-block; background: linear-gradient(135deg, #047857 0%, #059669 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 12px; font-weight: 700; font-size: 16px; box-shadow: 0 4px 12px rgba(4, 120, 87, 0.4);">
                                            Upload Payment Receipt
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 20px; color: #6b7280; font-size: 15px; line-height: 1.6;">
                                If you require any clarification, feel free to reply to this email or contact us at <a href="mailto:info@placemenet.com" style="color: #059669; text-decoration: none; font-weight: 600;">info@placemenet.com</a>.
                            </p>

                            <p style="margin: 0; color: #1f2937; font-size: 15px; line-height: 1.8;">
                                Kind regards,<br>
                                <strong style="color: #047857;">Placemenet Team</strong><br>
                                <span style="color: #6b7280; font-size: 14px;">
                                    Email: <a href="mailto:info@placemenet.com" style="color: #059669; text-decoration: none;">info@placemenet.com</a><br>
                                    Website: <a href="https://www.placemenet.com" style="color: #059669; text-decoration: none;">www.placemenet.com</a>
                                </span>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 10px; color: #6b7280; font-size: 14px;">
                                Need help? Contact us at <a href="mailto:info@placemenet.com" style="color: #059669; text-decoration: none; font-weight: 600;">info@placemenet.com</a>
                            </p>
                            <p style="margin: 0; color: #9ca3af; font-size: 12px;">
                                &copy; {{ date('Y') }} Placemenet. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
