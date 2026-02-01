<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status Update - UK Police Certificate</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f7fa;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f5f7fa;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 650px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">

                    <!-- Header -->
                    @php
                        $headerColors = [
                            'payment_verified' => 'linear-gradient(135deg, #059669 0%, #10b981 100%)',
                            'processing' => 'linear-gradient(135deg, #4f46e5 0%, #818cf8 100%)',
                            'completed' => 'linear-gradient(135deg, #059669 0%, #34d399 100%)',
                            'rejected' => 'linear-gradient(135deg, #dc2626 0%, #f87171 100%)',
                            'payment_pending' => 'linear-gradient(135deg, #d97706 0%, #fbbf24 100%)',
                            'submitted' => 'linear-gradient(135deg, #2563eb 0%, #60a5fa 100%)',
                        ];
                        $headerBg = $headerColors[$application->status] ?? 'linear-gradient(135deg, #1e40af 0%, #3b82f6 100%)';
                    @endphp
                    <tr>
                        <td style="background: {{ $headerBg }}; padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 26px; font-weight: 700;">
                                Application Status Update
                            </h1>
                            <p style="margin: 10px 0 0; color: rgba(255, 255, 255, 0.95); font-size: 16px;">
                                Reference: <strong>{{ $application->application_reference }}</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px; color: #1f2937; font-size: 16px; line-height: 1.6;">
                                Dear {{ $application->first_name }},
                            </p>

                            <p style="margin: 0 0 25px; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                We are writing to inform you that the status of your UK Police Certificate application has been updated.
                            </p>

                            <!-- Status Update Box -->
                            @php
                                $statusColors = [
                                    'submitted' => ['bg' => '#eff6ff', 'border' => '#3b82f6', 'text' => '#1e40af'],
                                    'payment_pending' => ['bg' => '#fffbeb', 'border' => '#f59e0b', 'text' => '#92400e'],
                                    'payment_verified' => ['bg' => '#ecfdf5', 'border' => '#10b981', 'text' => '#065f46'],
                                    'processing' => ['bg' => '#eef2ff', 'border' => '#6366f1', 'text' => '#3730a3'],
                                    'completed' => ['bg' => '#ecfdf5', 'border' => '#10b981', 'text' => '#065f46'],
                                    'rejected' => ['bg' => '#fef2f2', 'border' => '#ef4444', 'text' => '#991b1b'],
                                ];
                                $statusLabels = [
                                    'submitted' => 'Submitted',
                                    'payment_pending' => 'Payment Pending',
                                    'payment_verified' => 'Payment Verified',
                                    'processing' => 'Processing',
                                    'completed' => 'Completed',
                                    'rejected' => 'Rejected',
                                ];
                                $colors = $statusColors[$application->status] ?? ['bg' => '#f3f4f6', 'border' => '#6b7280', 'text' => '#374151'];
                                $statusLabel = $statusLabels[$application->status] ?? ucfirst($application->status);
                                $previousLabel = $statusLabels[$previousStatus] ?? ucfirst($previousStatus);
                            @endphp
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

                            <!-- Status-specific Message -->
                            @if($application->status === 'payment_verified')
                            <div style="background-color: #ecfdf5; border-left: 4px solid #10b981; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                                <h3 style="margin: 0 0 12px; color: #065f46; font-size: 16px; font-weight: 700;">
                                    Payment Confirmed
                                </h3>
                                <p style="margin: 0; color: #047857; font-size: 14px; line-height: 1.6;">
                                    We have successfully received and verified your payment. Your application will now be processed. We will notify you once there are further updates.
                                </p>
                            </div>
                            @elseif($application->status === 'processing')
                            <div style="background-color: #eef2ff; border-left: 4px solid #6366f1; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                                <h3 style="margin: 0 0 12px; color: #3730a3; font-size: 16px; font-weight: 700;">
                                    Application In Progress
                                </h3>
                                <p style="margin: 0; color: #4338ca; font-size: 14px; line-height: 1.6;">
                                    Your application is currently being processed. This typically takes {{ $application->service_type === 'urgent' ? '7 working days' : '14 working days' }} from the date of payment verification. We will keep you informed of any updates.
                                </p>
                            </div>
                            @elseif($application->status === 'completed')
                            <div style="background-color: #ecfdf5; border-left: 4px solid #10b981; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                                <h3 style="margin: 0 0 12px; color: #065f46; font-size: 16px; font-weight: 700;">
                                    Application Completed
                                </h3>
                                <p style="margin: 0; color: #047857; font-size: 14px; line-height: 1.6;">
                                    Congratulations! Your UK Police Certificate application has been completed successfully. Your certificate will be delivered to the address provided in your application. If you have any questions, please don't hesitate to contact us.
                                </p>
                            </div>
                            @elseif($application->status === 'rejected')
                            <div style="background-color: #fef2f2; border-left: 4px solid #ef4444; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                                <h3 style="margin: 0 0 12px; color: #991b1b; font-size: 16px; font-weight: 700;">
                                    Application Not Approved
                                </h3>
                                <p style="margin: 0; color: #b91c1c; font-size: 14px; line-height: 1.6;">
                                    Unfortunately, your application could not be processed. Please contact our support team for more information about the reason for rejection and possible next steps.
                                </p>
                            </div>
                            @elseif($application->status === 'payment_pending')
                            <div style="background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                                <h3 style="margin: 0 0 12px; color: #92400e; font-size: 16px; font-weight: 700;">
                                    Payment Required
                                </h3>
                                <p style="margin: 0 0 12px; color: #78350f; font-size: 14px; line-height: 1.6;">
                                    Your application is awaiting payment. Please complete the payment to proceed with processing.
                                </p>
                                <p style="margin: 0; color: #78350f; font-size: 14px;">
                                    <strong>Amount Due:</strong> {{ $application->payment_amount_display }}
                                </p>
                            </div>
                            @endif

                            <!-- Application Summary -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 30px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <h3 style="margin: 0 0 15px; color: #334155; font-size: 16px; font-weight: 700;">
                                            Application Details
                                        </h3>
                                        <table style="width: 100%; font-size: 14px;">
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b;">Reference:</td>
                                                <td style="padding: 5px 0; color: #1e293b; font-weight: 600;">{{ $application->application_reference }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b;">Applicant:</td>
                                                <td style="padding: 5px 0; color: #1e293b; font-weight: 600;">{{ $application->full_name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b;">Service Type:</td>
                                                <td style="padding: 5px 0; color: #1e293b; font-weight: 600;">{{ $application->service_type_label }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 0; color: #64748b;">Submitted:</td>
                                                <td style="padding: 5px 0; color: #1e293b; font-weight: 600;">{{ $application->submitted_at?->format('M d, Y') }}</td>
                                            </tr>
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
