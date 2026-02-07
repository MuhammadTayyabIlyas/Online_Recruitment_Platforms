<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorized Partner Certificate</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f7fa;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f5f7fa;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 650px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #4338ca 0%, #6366f1 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 26px; font-weight: 700;">
                                Authorized Partner Certificate
                            </h1>
                            <p style="margin: 10px 0 0; color: rgba(255, 255, 255, 0.95); font-size: 16px;">
                                Reference: <strong>{{ $partner->reference_number }}</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px; color: #1f2937; font-size: 16px; line-height: 1.6;">
                                Dear {{ $partner->user->name ?? 'Partner' }},
                            </p>

                            <p style="margin: 0 0 25px; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                Congratulations! You have been approved as an <strong>Authorized Partner</strong> of PlaceMeNet.
                            </p>

                            <!-- Partner Details -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 30px; background: #eef2ff; border-radius: 12px; border: 2px solid #c7d2fe;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <h3 style="margin: 0 0 15px; color: #4338ca; font-size: 16px; font-weight: 700;">
                                            Partner Details
                                        </h3>
                                        <table style="width: 100%; font-size: 14px;">
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b;">Business Name:</td>
                                                <td style="padding: 5px 0; color: #312e81; font-weight: 600;">{{ $partner->business_name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b;">Reference:</td>
                                                <td style="padding: 5px 0; color: #312e81; font-weight: 600; font-family: monospace;">{{ $partner->reference_number }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b;">Authorized Services:</td>
                                                <td style="padding: 5px 0; color: #312e81; font-weight: 600;">{{ implode(', ', $partner->authorized_country_labels) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b;">Valid Until:</td>
                                                <td style="padding: 5px 0; color: #312e81; font-weight: 600;">{{ $partner->expires_at?->format('F d, Y') }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 25px; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                Your certificate is attached to this email. You can also download it from your dashboard at any time.
                            </p>

                            <!-- Verification Link -->
                            <div style="background-color: #f0fdf4; border: 1px solid #86efac; padding: 20px; border-radius: 8px; margin-bottom: 25px;">
                                <p style="margin: 0; color: #166534; font-size: 14px; line-height: 1.6;">
                                    <strong>Verification:</strong> Your partner status can be verified at:
                                </p>
                                <p style="margin: 8px 0 0; color: #166534; font-size: 14px;">
                                    <a href="{{ route('partner.verify', $partner->reference_number) }}" style="color: #15803d; font-weight: 600;">
                                        {{ route('partner.verify', $partner->reference_number) }}
                                    </a>
                                </p>
                            </div>

                            <!-- Dashboard Button -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 25px;">
                                <tr>
                                    <td style="text-align: center; padding: 10px 0;">
                                        <a href="{{ route('partner.profile.edit') }}"
                                           style="display: inline-block; background: linear-gradient(135deg, #4338ca 0%, #6366f1 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 12px; font-weight: 700; font-size: 16px; box-shadow: 0 4px 12px rgba(67, 56, 202, 0.4);">
                                            View Partner Profile
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 20px; color: #6b7280; font-size: 15px; line-height: 1.6;">
                                If you have any questions, feel free to contact us at <a href="mailto:info@placemenet.com" style="color: #6366f1; text-decoration: none; font-weight: 600;">info@placemenet.com</a>.
                            </p>

                            <p style="margin: 0; color: #1f2937; font-size: 15px; line-height: 1.8;">
                                Kind regards,<br>
                                <strong style="color: #4338ca;">PlaceMeNet Team</strong><br>
                                <span style="color: #6b7280; font-size: 14px;">
                                    Email: <a href="mailto:info@placemenet.com" style="color: #6366f1; text-decoration: none;">info@placemenet.com</a><br>
                                    Website: <a href="https://www.placemenet.com" style="color: #6366f1; text-decoration: none;">www.placemenet.com</a>
                                </span>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 10px; color: #6b7280; font-size: 14px;">
                                Need help? Contact us at <a href="mailto:info@placemenet.com" style="color: #6366f1; text-decoration: none; font-weight: 600;">info@placemenet.com</a>
                            </p>
                            <p style="margin: 0; color: #9ca3af; font-size: 12px;">
                                &copy; {{ date('Y') }} PlaceMeNet. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
