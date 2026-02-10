<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Appointment Booked - Placemenet</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f7fa;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f5f7fa;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 650px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #3730a3 0%, #6366f1 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 26px; font-weight: 700;">
                                New Appointment Booked
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
                                A new appointment has been booked. Here are the details:
                            </p>

                            <!-- Client Details -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 25px; background: #eef2ff; border-radius: 12px; border: 1px solid #c7d2fe;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <h3 style="margin: 0 0 15px; color: #3730a3; font-size: 16px; font-weight: 700;">
                                            Client Information
                                        </h3>
                                        <table style="width: 100%; font-size: 14px;">
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b; width: 40%;">Name:</td>
                                                <td style="padding: 5px 0; color: #1e293b; font-weight: 600;">{{ $appointment->booker_name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b;">Email:</td>
                                                <td style="padding: 5px 0;">
                                                    <a href="mailto:{{ $appointment->booker_email }}" style="color: #3b82f6; text-decoration: none; font-weight: 600;">{{ $appointment->booker_email }}</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

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
                                            @if($appointment->meeting_format === 'online' && $appointment->meeting_link)
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b;">Meeting Link:</td>
                                                <td style="padding: 5px 0;">
                                                    <a href="{{ $appointment->meeting_link }}" style="color: #3b82f6; text-decoration: none; font-weight: 600;">{{ $appointment->meeting_link }}</a>
                                                </td>
                                            </tr>
                                            @endif
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

                            <!-- Admin Action Button -->
                            <div style="text-align: center; margin: 0 0 30px;">
                                <a href="{{ route('admin.appointments.show', $appointment->id) }}" style="display: inline-block; padding: 14px 35px; background: linear-gradient(135deg, #3730a3 0%, #6366f1 100%); color: #ffffff; font-size: 16px; font-weight: 600; text-decoration: none; border-radius: 8px;">
                                    View in Admin Panel
                                </a>
                            </div>

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
