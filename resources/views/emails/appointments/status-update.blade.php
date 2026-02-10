<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Status Update - Placemenet</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f7fa;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f5f7fa;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 650px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">

                    <!-- Header -->
                    @php
                        $headerColors = [
                            'confirmed' => 'linear-gradient(135deg, #1e40af 0%, #3b82f6 100%)',
                            'pending' => 'linear-gradient(135deg, #d97706 0%, #fbbf24 100%)',
                            'completed' => 'linear-gradient(135deg, #059669 0%, #34d399 100%)',
                            'cancelled' => 'linear-gradient(135deg, #dc2626 0%, #f87171 100%)',
                            'no_show' => 'linear-gradient(135deg, #6b7280 0%, #9ca3af 100%)',
                            'rescheduled' => 'linear-gradient(135deg, #4f46e5 0%, #818cf8 100%)',
                        ];
                        $statusColors = [
                            'confirmed' => ['bg' => '#eff6ff', 'border' => '#3b82f6', 'text' => '#1e40af'],
                            'pending' => ['bg' => '#fffbeb', 'border' => '#f59e0b', 'text' => '#92400e'],
                            'completed' => ['bg' => '#ecfdf5', 'border' => '#10b981', 'text' => '#065f46'],
                            'cancelled' => ['bg' => '#fef2f2', 'border' => '#ef4444', 'text' => '#991b1b'],
                            'no_show' => ['bg' => '#f3f4f6', 'border' => '#6b7280', 'text' => '#374151'],
                            'rescheduled' => ['bg' => '#eef2ff', 'border' => '#6366f1', 'text' => '#3730a3'],
                        ];
                        $statusLabels = [
                            'confirmed' => 'Confirmed',
                            'pending' => 'Pending',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled',
                            'no_show' => 'No Show',
                            'rescheduled' => 'Rescheduled',
                        ];
                        $headerBg = $headerColors[$appointment->status] ?? 'linear-gradient(135deg, #1e40af 0%, #3b82f6 100%)';
                        $colors = $statusColors[$appointment->status] ?? ['bg' => '#f3f4f6', 'border' => '#6b7280', 'text' => '#374151'];
                        $statusLabel = $statusLabels[$appointment->status] ?? ucfirst($appointment->status);
                        $previousLabel = $statusLabels[$previousStatus] ?? ucfirst($previousStatus);
                    @endphp
                    <tr>
                        <td style="background: {{ $headerBg }}; padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 26px; font-weight: 700;">
                                Appointment Status Update
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
                                We are writing to inform you that the status of your appointment has been updated.
                            </p>

                            <!-- Status Update Box -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 30px; background: {{ $colors['bg'] }}; border-radius: 12px; border: 2px solid {{ $colors['border'] }};">
                                <tr>
                                    <td style="padding: 25px; text-align: center;">
                                        <p style="margin: 0 0 10px; color: #6b7280; font-size: 14px;">
                                            Status changed from <strong>{{ $previousLabel }}</strong> to:
                                        </p>
                                        <h2 style="margin: 0; color: {{ $colors['text'] }}; font-size: 28px; font-weight: 700;">
                                            {{ $statusLabel }}
                                        </h2>
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
                                                    <a href="{{ $appointment->meeting_link }}" style="color: #3b82f6; text-decoration: none; font-weight: 600;">Join Meeting</a>
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

                            <p style="margin: 0 0 20px; color: #6b7280; font-size: 15px; line-height: 1.6;">
                                If you have any questions or require assistance, please don't hesitate to contact us at <a href="mailto:info@placemenet.com" style="color: #3b82f6; text-decoration: none; font-weight: 600;">info@placemenet.com</a>.
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
