<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status Update</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f7fa;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f5f7fa;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                Application Status Update
                            </h1>
                            <p style="margin: 10px 0 0; color: rgba(255, 255, 255, 0.95); font-size: 16px;">
                                Thank you for your interest in this position
                            </p>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px; color: #1f2937; font-size: 16px; line-height: 1.6;">
                                Dear <strong>{{ $application->user->name }}</strong>,
                            </p>

                            <p style="margin: 0 0 25px; color: #4b5563; font-size: 16px; line-height: 1.7;">
                                Thank you for taking the time to apply for the position of <strong>{{ $application->job->title }}</strong> at <strong>{{ $application->job->company->company_name }}</strong> and for your interest in joining our team.
                            </p>

                            <p style="margin: 0 0 25px; color: #4b5563; font-size: 16px; line-height: 1.7;">
                                After careful consideration of all applications, we regret to inform you that we have decided to move forward with other candidates whose qualifications more closely match our current needs for this particular role.
                            </p>

                            <!-- Job Details Card -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 30px; background-color: #f9fafb; border-radius: 12px; border: 2px solid #e5e7eb;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <div style="margin-bottom: 15px;">
                                            <div style="color: #6b7280; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                                                Position Applied For
                                            </div>
                                            <div style="color: #374151; font-size: 20px; font-weight: 700; margin-bottom: 5px;">
                                                {{ $application->job->title }}
                                            </div>
                                        </div>

                                        <div style="margin-bottom: 12px;">
                                            <span style="color: #6b7280; font-size: 14px; font-weight: 600;">🏢 Company:</span>
                                            <span style="color: #374151; font-size: 14px;">{{ $application->job->company->company_name }}</span>
                                        </div>

                                        <div>
                                            <span style="color: #6b7280; font-size: 14px; font-weight: 600;">📅 Applied:</span>
                                            <span style="color: #374151; font-size: 14px;">{{ $application->created_at->format('F d, Y') }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Encouragement Section -->
                            <div style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-left: 4px solid #3b82f6; padding: 25px; border-radius: 8px; margin-bottom: 30px;">
                                <h3 style="margin: 0 0 15px; color: #1e40af; font-size: 18px; font-weight: 700;">
                                    💡 Moving Forward
                                </h3>
                                <p style="margin: 0 0 15px; color: #1e3a8a; line-height: 1.7;">
                                    While this particular opportunity didn't work out, we encourage you to:
                                </p>
                                <ul style="margin: 0; padding-left: 20px; color: #1e3a8a; line-height: 1.8;">
                                    <li style="margin-bottom: 8px;">Continue exploring other opportunities on our platform</li>
                                    <li style="margin-bottom: 8px;">Keep your profile and resume updated</li>
                                    <li style="margin-bottom: 8px;">Apply for other positions that match your skills and interests</li>
                                    <li>Consider this as valuable experience in your job search journey</li>
                                </ul>
                            </div>

                            <!-- Browse Jobs Button -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 25px;">
                                <tr>
                                    <td style="text-align: center; padding: 20px 0;">
                                        <a href="{{ route('jobs.index') }}"
                                           style="display: inline-block; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 12px; font-weight: 700; font-size: 16px; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);">
                                            🔍 Explore More Opportunities
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Appreciation Note -->
                            <div style="background-color: #f0fdf4; border: 1px solid #86efac; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                                <p style="margin: 0; color: #166534; font-size: 15px; line-height: 1.7; text-align: center;">
                                    We genuinely appreciate the time and effort you invested in your application. We wish you the very best in your job search and future career endeavors.
                                </p>
                            </div>

                            <p style="margin: 0 0 15px; color: #6b7280; font-size: 15px; line-height: 1.6;">
                                Thank you again for your interest, and we hope you find a great opportunity soon!
                            </p>

                            <p style="margin: 0; color: #1f2937; font-size: 15px; font-weight: 600;">
                                Best wishes,<br>
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
                                Keep exploring opportunities
                            </p>

                            <div style="margin: 20px 0;">
                                <a href="{{ route('jobs.index') }}" style="display: inline-block; margin: 0 8px; color: #9ca3af; text-decoration: none; font-size: 13px;">Browse Jobs</a>
                                <span style="color: #d1d5db;">•</span>
                                <a href="{{ route('jobseeker.applications.index') }}" style="display: inline-block; margin: 0 8px; color: #9ca3af; text-decoration: none; font-size: 13px;">My Applications</a>
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
