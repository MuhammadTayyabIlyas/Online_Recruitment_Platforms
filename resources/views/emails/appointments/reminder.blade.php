<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Reminder - Placemenet</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f7fa;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f5f7fa;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 650px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">

                    <!-- Header -->
                    @php
                        $headerBg = $reminderType === '1h'
                            ? 'linear-gradient(135deg, #dc2626 0%, #f97316 100%)'
                            : 'linear-gradient(135deg, #d97706 0%, #fbbf24 100%)';
                        $headerTitle = $reminderType === '1h'
                            ? 'Appointment Starting Soon'
                            : 'Appointment Tomorrow';
                    @endphp
                    <tr>
                        <td style="background: {{ $headerBg }}; padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 26px; font-weight: 700;">
                                {{ $headerTitle }}
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

                            @if($reminderType === '1h')
                            <p style="margin: 0 0 25px; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                This is a friendly reminder that your appointment is <strong>starting soon</strong>. Please make sure you are prepared.
                            </p>

                            <!-- Urgent Reminder Box -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 30px; background: #fef2f2; border-radius: 12px; border: 2px solid #ef4444;">
                                <tr>
                                    <td style="padding: 25px; text-align: center;">
                                        <p style="margin: 0 0 5px; color: #991b1b; font-size: 14px; font-weight: 600;">Starting in approximately</p>
                                        <h2 style="margin: 0; color: #dc2626; font-size: 28px; font-weight: 700;">
                                            1 Hour
                                        </h2>
                                    </td>
                                </tr>
                            </table>
                            @else
                            <p style="margin: 0 0 25px; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                This is a friendly reminder that you have an appointment scheduled for <strong>tomorrow</strong>. Please find the details below.
                            </p>

                            <!-- Reminder Box -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 30px; background: #fffbeb; border-radius: 12px; border: 2px solid #f59e0b;">
                                <tr>
                                    <td style="padding: 25px; text-align: center;">
                                        <p style="margin: 0 0 5px; color: #92400e; font-size: 14px; font-weight: 600;">Your appointment is</p>
                                        <h2 style="margin: 0; color: #d97706; font-size: 28px; font-weight: 700;">
                                            Tomorrow
                                        </h2>
                                    </td>
                                </tr>
                            </table>
                            @endif

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
                                            @if($appointment->meeting_format === 'in-person' && $appointment->office)
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b;">Location:</td>
                                                <td style="padding: 5px 0; color: #1e293b; font-weight: 600;">{{ $appointment->office }}</td>
                                            </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Meeting Link Button (for online appointments) -->
                            @if($appointment->meeting_format === 'online' && $appointment->meeting_link)
                            <div style="text-align: center; margin: 0 0 30px;">
                                <p style="margin: 0 0 10px; color: #6b7280; font-size: 14px;">
                                    Join your meeting using the link below:
                                </p>
                                <a href="{{ $appointment->meeting_link }}" style="display: inline-block; padding: 14px 35px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: #ffffff; font-size: 16px; font-weight: 600; text-decoration: none; border-radius: 8px;">
                                    Join Meeting
                                </a>
                            </div>
                            @endif

                            <p style="margin: 0 0 20px; color: #6b7280; font-size: 15px; line-height: 1.6;">
                                If you have any questions, please don't hesitate to contact us at <a href="mailto:info@placemenet.com" style="color: #3b82f6; text-decoration: none; font-weight: 600;">info@placemenet.com</a>.
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
