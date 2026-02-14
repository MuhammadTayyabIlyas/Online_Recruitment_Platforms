<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Appointment Summary - Placemenet</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f7fa;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f5f7fa;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 650px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #3730a3 0%, #6366f1 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 700;">
                                Daily Appointment Summary
                            </h1>
                            <p style="margin: 10px 0 0; color: rgba(255, 255, 255, 0.95); font-size: 16px;">
                                {{ $date->format('l, F d, Y') }}
                            </p>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 30px;">

                            @if($appointments->count() > 0)
                                <p style="margin: 0 0 20px; color: #1f2937; font-size: 16px; line-height: 1.6;">
                                    You have <strong>{{ $appointments->count() }}</strong> appointment{{ $appointments->count() > 1 ? 's' : '' }} scheduled for tomorrow:
                                </p>

                                @foreach($appointments as $appointment)
                                    <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 15px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                                        <tr>
                                            <td style="padding: 20px;">
                                                <table style="width: 100%; font-size: 14px;">
                                                    <tr>
                                                        <td style="padding: 4px 0; color: #64748b; width: 35%;">Time:</td>
                                                        <td style="padding: 4px 0; color: #1e293b; font-weight: 700; font-size: 16px;">
                                                            {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 4px 0; color: #64748b;">Reference:</td>
                                                        <td style="padding: 4px 0; color: #1e293b; font-weight: 600;">{{ $appointment->booking_reference }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 4px 0; color: #64748b;">Client:</td>
                                                        <td style="padding: 4px 0; color: #1e293b; font-weight: 600;">{{ $appointment->booker_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 4px 0; color: #64748b;">Email:</td>
                                                        <td style="padding: 4px 0;">
                                                            <a href="mailto:{{ $appointment->booker_email }}" style="color: #3b82f6; text-decoration: none;">{{ $appointment->booker_email }}</a>
                                                        </td>
                                                    </tr>
                                                    @if($appointment->booker_phone)
                                                    <tr>
                                                        <td style="padding: 4px 0; color: #64748b;">Phone:</td>
                                                        <td style="padding: 4px 0; color: #1e293b;">{{ $appointment->booker_phone }}</td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <td style="padding: 4px 0; color: #64748b;">Type:</td>
                                                        <td style="padding: 4px 0; color: #1e293b; font-weight: 600;">{{ $appointment->consultationType->name ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 4px 0; color: #64748b;">Format:</td>
                                                        <td style="padding: 4px 0; color: #1e293b;">{{ ucfirst($appointment->meeting_format) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 4px 0; color: #64748b;">Status:</td>
                                                        <td style="padding: 4px 0;">
                                                            <span style="display: inline-block; padding: 2px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600;
                                                                {{ $appointment->status === 'confirmed' ? 'background: #dbeafe; color: #1e40af;' : 'background: #fef3c7; color: #92400e;' }}">
                                                                {{ ucfirst($appointment->status) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    @if($appointment->notes)
                                                    <tr>
                                                        <td style="padding: 4px 0; color: #64748b;">Notes:</td>
                                                        <td style="padding: 4px 0; color: #1e293b;">{{ $appointment->notes }}</td>
                                                    </tr>
                                                    @endif
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                @endforeach

                            @else
                                <div style="text-align: center; padding: 30px 0;">
                                    <p style="margin: 0; color: #6b7280; font-size: 16px;">
                                        No appointments scheduled for tomorrow.
                                    </p>
                                </div>
                            @endif

                            <!-- Admin Link -->
                            <div style="text-align: center; margin: 25px 0 10px;">
                                <a href="{{ route('admin.appointments.index') }}" style="display: inline-block; padding: 14px 35px; background: linear-gradient(135deg, #3730a3 0%, #6366f1 100%); color: #ffffff; font-size: 16px; font-weight: 600; text-decoration: none; border-radius: 8px;">
                                    View All Appointments
                                </a>
                            </div>

                            <p style="margin: 20px 0 0; color: #1f2937; font-size: 15px; line-height: 1.8;">
                                Kind regards,<br>
                                <strong style="color: #1e40af;">Placemenet Team</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 25px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0; color: #9ca3af; font-size: 12px;">
                                &copy; {{ date('Y') }} Placemenet. This is an automated daily summary.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
