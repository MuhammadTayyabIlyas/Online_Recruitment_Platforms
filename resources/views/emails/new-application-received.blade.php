<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Application Received</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f7fa;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f5f7fa;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">

                    <!-- Header with Gradient -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%); padding: 40px 30px; text-align: center;">
                            <div style="background-color: rgba(255, 255, 255, 0.2); width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
                                <span style="font-size: 40px;">📩</span>
                            </div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                New Application Received!
                            </h1>
                            <p style="margin: 10px 0 0; color: rgba(255, 255, 255, 0.95); font-size: 16px;">
                                A candidate has applied for your job posting
                            </p>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px; color: #1f2937; font-size: 16px; line-height: 1.6;">
                                Hello <strong>{{ $application->job->user->name }}</strong>,
                            </p>

                            <p style="margin: 0 0 25px; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                Good news! You have received a new application for your job posting. Here are the details:
                            </p>

                            <!-- Job Details Card -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 25px; background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border-radius: 12px; border: 2px solid #6ee7b7;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <div style="margin-bottom: 15px;">
                                            <div style="color: #065f46; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                                                Job Position
                                            </div>
                                            <div style="color: #064e3b; font-size: 20px; font-weight: 700; margin-bottom: 5px;">
                                                {{ $application->job->title }}
                                            </div>
                                        </div>

                                        @if($application->job->location)
                                        <div style="margin-bottom: 12px;">
                                            <span style="color: #065f46; font-size: 14px; font-weight: 600;">📍 Location:</span>
                                            <span style="color: #064e3b; font-size: 14px;">{{ $application->job->location }}</span>
                                        </div>
                                        @endif

                                        <div>
                                            <span style="color: #065f46; font-size: 14px; font-weight: 600;">🕐 Posted:</span>
                                            <span style="color: #064e3b; font-size: 14px;">{{ $application->job->created_at->diffForHumans() }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Candidate Details Card -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 30px; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-radius: 12px; border: 2px solid #93c5fd;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <div style="margin-bottom: 15px;">
                                            <div style="color: #1e40af; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                                                Candidate Information
                                            </div>
                                            <div style="color: #1e3a8a; font-size: 20px; font-weight: 700; margin-bottom: 10px;">
                                                {{ $application->user->name }}
                                            </div>
                                        </div>

                                        <div style="margin-bottom: 12px;">
                                            <span style="color: #1e40af; font-size: 14px; font-weight: 600;">📧 Email:</span>
                                            <span style="color: #1e3a8a; font-size: 14px;">{{ $application->user->email }}</span>
                                        </div>

                                        @if($application->user->phone)
                                        <div style="margin-bottom: 12px;">
                                            <span style="color: #1e40af; font-size: 14px; font-weight: 600;">📱 Phone:</span>
                                            <span style="color: #1e3a8a; font-size: 14px;">{{ $application->user->phone }}</span>
                                        </div>
                                        @endif

                                        @if($application->user->profile?->headline)
                                        <div style="margin-bottom: 12px;">
                                            <span style="color: #1e40af; font-size: 14px; font-weight: 600;">💼 Headline:</span>
                                            <span style="color: #1e3a8a; font-size: 14px;">{{ $application->user->profile->headline }}</span>
                                        </div>
                                        @endif

                                        <div>
                                            <span style="color: #1e40af; font-size: 14px; font-weight: 600;">⏰ Applied:</span>
                                            <span style="color: #1e3a8a; font-size: 14px;">{{ $application->created_at->format('F d, Y \a\t h:i A') }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            @if($application->cover_letter)
                            <!-- Cover Letter Section -->
                            <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                                <h3 style="margin: 0 0 12px; color: #92400e; font-size: 16px; font-weight: 700;">
                                    📝 Cover Letter
                                </h3>
                                <p style="margin: 0; color: #78350f; font-size: 14px; line-height: 1.6; white-space: pre-line;">
                                    {{ \Illuminate\Support\Str::limit($application->cover_letter, 250) }}
                                </p>
                            </div>
                            @endif

                            <!-- Review Application Button -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 25px;">
                                <tr>
                                    <td style="text-align: center; padding: 20px 0;">
                                        <a href="{{ route('employer.applicants.show', $application) }}"
                                           style="display: inline-block; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; text-decoration: none; padding: 18px 50px; border-radius: 12px; font-weight: 700; font-size: 18px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4); transition: all 0.3s ease;">
                                            👁️ Review Application Now
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Quick Actions -->
                            <div style="background-color: #f0fdf4; border: 1px solid #86efac; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                                <h3 style="margin: 0 0 15px; color: #166534; font-size: 16px; font-weight: 700;">
                                    ⚡ Quick Actions
                                </h3>
                                <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="padding: 8px 0;">
                                            <a href="{{ route('employer.applicants.show', $application) }}" style="color: #166534; text-decoration: none; font-size: 14px; font-weight: 600;">
                                                → View full application & resume
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0;">
                                            <a href="{{ route('employer.applicants.show', $application) }}#candidate-profile" style="color: #166534; text-decoration: none; font-size: 14px; font-weight: 600;">
                                                → Review candidate profile
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0;">
                                            <a href="{{ route('employer.applicants.index') }}" style="color: #166534; text-decoration: none; font-size: 14px; font-weight: 600;">
                                                → View all applications
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <p style="margin: 0 0 10px; color: #6b7280; font-size: 15px; line-height: 1.6;">
                                Don't forget to update the application status after reviewing to keep candidates informed!
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
                                Manage your job postings and applications
                            </p>

                            <div style="margin: 20px 0;">
                                <a href="{{ route('employer.dashboard') }}" style="display: inline-block; margin: 0 8px; color: #9ca3af; text-decoration: none; font-size: 13px;">Dashboard</a>
                                <span style="color: #d1d5db;">•</span>
                                <a href="{{ route('employer.applicants.index') }}" style="display: inline-block; margin: 0 8px; color: #9ca3af; text-decoration: none; font-size: 13px;">All Applicants</a>
                                <span style="color: #d1d5db;">•</span>
                                <a href="{{ route('employer.jobs.index') }}" style="display: inline-block; margin: 0 8px; color: #9ca3af; text-decoration: none; font-size: 13px;">My Jobs</a>
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
