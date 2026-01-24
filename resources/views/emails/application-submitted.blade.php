<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted Successfully</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f7fa;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f5f7fa;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">

                    <!-- Header with Gradient -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #3b82f6 0%, #6366f1 50%, #8b5cf6 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                ✓ Application Submitted!
                            </h1>
                            <p style="margin: 10px 0 0; color: rgba(255, 255, 255, 0.95); font-size: 16px;">
                                Your application has been successfully received
                            </p>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px; color: #1f2937; font-size: 16px; line-height: 1.6;">
                                Hello <strong>{{ $application->user->name }}</strong>,
                            </p>

                            <p style="margin: 0 0 25px; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                Great news! We have successfully received your application for the position listed below:
                            </p>

                            <!-- Job Details Card -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 30px; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-radius: 12px; border: 2px solid #bae6fd;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <div style="margin-bottom: 15px;">
                                            <div style="color: #0369a1; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                                                Position Applied For
                                            </div>
                                            <div style="color: #0c4a6e; font-size: 20px; font-weight: 700; margin-bottom: 5px;">
                                                {{ $application->job->title }}
                                            </div>
                                        </div>

                                        <div style="margin-bottom: 12px;">
                                            <span style="color: #0369a1; font-size: 14px; font-weight: 600;">Company:</span>
                                            <span style="color: #0c4a6e; font-size: 14px; font-weight: 500;">{{ $application->job->company->company_name }}</span>
                                        </div>

                                        @if($application->job->location)
                                        <div style="margin-bottom: 12px;">
                                            <span style="color: #0369a1; font-size: 14px; font-weight: 600;">📍 Location:</span>
                                            <span style="color: #0c4a6e; font-size: 14px;">{{ $application->job->location }}</span>
                                        </div>
                                        @endif

                                        <div>
                                            <span style="color: #0369a1; font-size: 14px; font-weight: 600;">🕐 Applied On:</span>
                                            <span style="color: #0c4a6e; font-size: 14px;">{{ $application->created_at->format('F d, Y \a\t h:i A') }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- What Happens Next Section -->
                            <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                                <h3 style="margin: 0 0 12px; color: #92400e; font-size: 16px; font-weight: 700;">
                                    📋 What Happens Next?
                                </h3>
                                <ul style="margin: 0; padding-left: 20px; color: #78350f;">
                                    <li style="margin-bottom: 8px; line-height: 1.6;">The employer will review your application and profile</li>
                                    <li style="margin-bottom: 8px; line-height: 1.6;">You'll receive a notification if your profile matches their requirements</li>
                                    <li style="margin-bottom: 8px; line-height: 1.6;">You can track your application status anytime in your dashboard</li>
                                    <li style="line-height: 1.6;">Keep your profile updated to increase your chances!</li>
                                </ul>
                            </div>

                            <!-- View Application Button -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 25px;">
                                <tr>
                                    <td style="text-align: center; padding: 20px 0;">
                                        <a href="{{ route('jobseeker.applications.show', $application) }}"
                                           style="display: inline-block; background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 12px; font-weight: 700; font-size: 16px; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4); transition: all 0.3s ease;">
                                            👁️ View Your Application
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Tips Section -->
                            <div style="background-color: #f0fdf4; border: 1px solid #86efac; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                                <h3 style="margin: 0 0 12px; color: #166534; font-size: 16px; font-weight: 700;">
                                    💡 Pro Tips While You Wait
                                </h3>
                                <ul style="margin: 0; padding-left: 20px; color: #166534; font-size: 14px;">
                                    <li style="margin-bottom: 6px;">Keep your email notifications enabled</li>
                                    <li style="margin-bottom: 6px;">Update your profile with recent achievements</li>
                                    <li style="margin-bottom: 6px;">Continue exploring other opportunities</li>
                                </ul>
                            </div>

                            <p style="margin: 0 0 10px; color: #6b7280; font-size: 15px; line-height: 1.6;">
                                Good luck with your application! We're here to help you find your dream job.
                            </p>

                            <p style="margin: 0; color: #1f2937; font-size: 15px; font-weight: 600;">
                                Best regards,<br>
                                <span style="background: linear-gradient(135deg, #3b82f6, #6366f1, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 700;">
                                    {{ config('app.name') }} Team
                                </span>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 15px; color: #6b7280; font-size: 14px;">
                                Need help? <a href="{{ config('app.url') }}" style="color: #3b82f6; text-decoration: none; font-weight: 600;">Visit our Help Center</a>
                            </p>

                            <div style="margin: 20px 0;">
                                <a href="{{ config('app.url') }}" style="display: inline-block; margin: 0 8px; color: #9ca3af; text-decoration: none; font-size: 13px;">Dashboard</a>
                                <span style="color: #d1d5db;">•</span>
                                <a href="{{ route('jobs.index') }}" style="display: inline-block; margin: 0 8px; color: #9ca3af; text-decoration: none; font-size: 13px;">Browse Jobs</a>
                                <span style="color: #d1d5db;">•</span>
                                <a href="{{ route('jobseeker.profile.index') }}" style="display: inline-block; margin: 0 8px; color: #9ca3af; text-decoration: none; font-size: 13px;">My Profile</a>
                            </div>

                            <p style="margin: 15px 0 0; color: #9ca3af; font-size: 12px;">
                                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
