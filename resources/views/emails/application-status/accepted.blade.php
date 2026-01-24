<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Congratulations - Job Offer!</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f7fa;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f5f7fa;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">

                    <!-- Header with Celebration -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 50%, #6d28d9 100%); padding: 40px 30px; text-align: center;">
                            <div style="background-color: rgba(255, 255, 255, 0.2); width: 120px; height: 120px; border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);">
                                <span style="font-size: 70px;">🎊</span>
                            </div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 36px; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                Congratulations!
                            </h1>
                            <p style="margin: 10px 0 0; color: rgba(255, 255, 255, 0.95); font-size: 20px; font-weight: 600;">
                                You've Been Selected!
                            </p>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px; color: #1f2937; font-size: 18px; line-height: 1.6;">
                                Dear <strong>{{ $application->user->name }}</strong>,
                            </p>

                            <p style="margin: 0 0 25px; color: #4b5563; font-size: 17px; line-height: 1.7;">
                                We are thrilled to inform you that you have been <strong style="color: #8b5cf6;">selected for the position</strong>! After careful consideration of all candidates, we believe you are the perfect fit for our team.
                            </p>

                            <!-- Job Details Card -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 30px; background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%); border-radius: 12px; border: 2px solid #c084fc;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <div style="margin-bottom: 15px;">
                                            <div style="color: #6d28d9; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                                                Your New Position
                                            </div>
                                            <div style="color: #581c87; font-size: 24px; font-weight: 700; margin-bottom: 5px;">
                                                {{ $application->job->title }}
                                            </div>
                                        </div>

                                        <div style="margin-bottom: 12px;">
                                            <span style="color: #6d28d9; font-size: 14px; font-weight: 600;">🏢 Company:</span>
                                            <span style="color: #581c87; font-size: 14px; font-weight: 500;">{{ $application->job->company->company_name }}</span>
                                        </div>

                                        @if($application->job->location)
                                        <div style="margin-bottom: 12px;">
                                            <span style="color: #6d28d9; font-size: 14px; font-weight: 600;">📍 Location:</span>
                                            <span style="color: #581c87; font-size: 14px;">{{ $application->job->location }}</span>
                                        </div>
                                        @endif

                                        <div>
                                            <span style="color: #6d28d9; font-size: 14px; font-weight: 600;">✅ Status:</span>
                                            <span style="background-color: #8b5cf6; color: #ffffff; padding: 4px 12px; border-radius: 12px; font-size: 13px; font-weight: 700;">ACCEPTED</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Next Steps -->
                            <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-left: 4px solid #f59e0b; padding: 25px; border-radius: 8px; margin-bottom: 30px;">
                                <h3 style="margin: 0 0 15px; color: #92400e; font-size: 18px; font-weight: 700;">
                                    📋 What Comes Next?
                                </h3>
                                <p style="margin: 0 0 15px; color: #78350f; line-height: 1.7;">
                                    The employer will reach out to you shortly with:
                                </p>
                                <ul style="margin: 0; padding-left: 20px; color: #78350f; line-height: 1.8;">
                                    <li style="margin-bottom: 8px;">Formal offer letter with compensation details</li>
                                    <li style="margin-bottom: 8px;">Employment contract and onboarding information</li>
                                    <li style="margin-bottom: 8px;">Start date and first-day instructions</li>
                                    <li>Any required documentation or background checks</li>
                                </ul>
                            </div>

                            <!-- Celebration Message -->
                            <div style="background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%); padding: 30px; border-radius: 12px; border: 2px solid #c084fc; margin-bottom: 30px; text-align: center;">
                                <h3 style="margin: 0 0 15px; color: #6d28d9; font-size: 20px; font-weight: 700;">
                                    🌟 Welcome to Your New Journey!
                                </h3>
                                <p style="margin: 0; color: #581c87; font-size: 16px; line-height: 1.7;">
                                    This is an exciting new chapter in your career. We're confident you'll make a great impact in your new role. Congratulations once again, and we wish you all the best!
                                </p>
                            </div>

                            <!-- View Application Button -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 25px;">
                                <tr>
                                    <td style="text-align: center; padding: 20px 0;">
                                        <a href="{{ route('jobseeker.applications.show', $application) }}"
                                           style="display: inline-block; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: #ffffff; text-decoration: none; padding: 18px 50px; border-radius: 12px; font-weight: 700; font-size: 18px; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);">
                                            👁️ View Application Details
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0; color: #1f2937; font-size: 15px; font-weight: 600;">
                                Congratulations and best wishes!<br>
                                <span style="background: linear-gradient(135deg, #3b82f6, #6366f1, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 700;">
                                    {{ config('app.name') }} Team
                                </span>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <div style="margin: 20px 0;">
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
