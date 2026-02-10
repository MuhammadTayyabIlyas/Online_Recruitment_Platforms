<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Link Ready - Placemenet</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f7fa;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f5f7fa;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 650px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #059669 0%, #34d399 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 26px; font-weight: 700;">
                                Meeting Link Ready
                            </h1>
                            <p style="margin: 10px 0 0; color: rgba(255, 255, 255, 0.95); font-size: 16px;">
                                Reference: <strong>{{ $appointment->booking_reference }}</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px; color: #1f2937; font-size: 16px; line-height: 1.6;">
                                Dear {{ $appointment->booker_name }},
                            </p>

                            <p style="margin: 0 0 25px; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                The meeting link for your upcoming appointment is now ready. You can use the button below to join the meeting at the scheduled time.
                            </p>

                            <!-- Meeting Link Box -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 30px; background: #ecfdf5; border-radius: 12px; border: 2px solid #10b981;">
                                <tr>
                                    <td style="padding: 25px; text-align: center;">
                                        <p style="margin: 0 0 5px; color: #065f46; font-size: 14px; font-weight: 600;">Your meeting link is ready</p>
                                        <h2 style="margin: 0 0 20px; color: #059669; font-size: 22px; font-weight: 700;">
                                            {{ $appointment->appointment_date->format('M d, Y') }} at {{ $appointment->formatted_time }}
                                        </h2>
                                        <a href="{{ $appointment->meeting_link }}" style="display: inline-block; padding: 16px 45px; background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: #ffffff; font-size: 18px; font-weight: 700; text-decoration: none; border-radius: 10px; letter-spacing: 0.5px;">
                                            Join Meeting
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Meeting Link Plain Text -->
                            <div style="background-color: #f8fafc; border-left: 4px solid #10b981; padding: 15px 20px; border-radius: 8px; margin-bottom: 30px;">
                                <p style="margin: 0 0 5px; color: #64748b; font-size: 13px;">
                                    If the button above does not work, copy and paste this link into your browser:
                                </p>
                                <p style="margin: 0; color: #3b82f6; font-size: 14px; word-break: break-all;">
                                    <a href="{{ $appointment->meeting_link }}" style="color: #3b82f6; text-decoration: none;">{{ $appointment->meeting_link }}</a>
                                </p>
                            </div>

                            <!-- Appointment Details -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 30px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <h3 style="margin: 0 0 15px; color: #334155; font-size: 16px; font-weight: 700;">
                                            Appointment Details
                                        </h3>
                                        <table style="width: 100%; font-size: 14px;">
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b; width: 40%;">Reference:</td>
                                                <td style="padding: 5px 0; color: #1e293b; font-weight: 600;">{{ $appointment->booking_reference }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b;">Type:</td>
                                                <td style="padding: 5px 0; color: #1e293b; font-weight: 600;">{{ $appointment->consultationType->name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b;">Date:</td>
                                                <td style="padding: 5px 0; color: #1e293b; font-weight: 600;">{{ $appointment->appointment_date->format('l, M d, Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b;">Time:</td>
                                                <td style="padding: 5px 0; color: #1e293b; font-weight: 600;">{{ $appointment->formatted_time }} ({{ $appointment->duration_minutes }} min)</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b;">Format:</td>
                                                <td style="padding: 5px 0; color: #1e293b; font-weight: 600;">{{ ucfirst($appointment->meeting_format) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 20px; color: #6b7280; font-size: 15px; line-height: 1.6;">
                                If you have any questions or experience technical difficulties, please contact us at <a href="mailto:info@placemenet.com" style="color: #3b82f6; text-decoration: none; font-weight: 600;">info@placemenet.com</a>.
                            </p>

                            <p style="margin: 0; color: #1f2937; font-size: 15px; line-height: 1.8;">
                                Kind regards,<br>
                                <strong style="color: #1e40af;">Placemenet Team</strong><br>
                                <span style="color: #6b7280; font-size: 14px;">
                                    Email: <a href="mailto:info@placemenet.com" style="color: #3b82f6; text-decoration: none;">info@placemenet.com</a><br>
                                    Website: <a href="https://www.placemenet.com" style="color: #3b82f6; text-decoration: none;">www.placemenet.com</a>
                                </span>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 10px; color: #6b7280; font-size: 14px;">
                                Need help? Contact us at <a href="mailto:info@placemenet.com" style="color: #3b82f6; text-decoration: none; font-weight: 600;">info@placemenet.com</a>
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
