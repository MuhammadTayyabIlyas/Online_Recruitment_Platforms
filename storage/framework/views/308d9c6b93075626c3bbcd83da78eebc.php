<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You've Been Shortlisted!</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f7fa;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f5f7fa;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">

                    <!-- Header with Celebration Gradient -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%); padding: 40px 30px; text-align: center; position: relative;">
                            <!-- Celebration Icons -->
                            <div style="position: relative;">
                                <div style="background-color: rgba(255, 255, 255, 0.2); width: 100px; height: 100px; border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);">
                                    <span style="font-size: 60px;">🎉</span>
                                </div>
                                <h1 style="margin: 0; color: #ffffff; font-size: 32px; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    Congratulations!
                                </h1>
                                <p style="margin: 10px 0 0; color: rgba(255, 255, 255, 0.95); font-size: 18px; font-weight: 600;">
                                    You've Been Shortlisted for Interview
                                </p>
                            </div>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px; color: #1f2937; font-size: 16px; line-height: 1.6;">
                                Hello <strong><?php echo e($application->user->name); ?></strong>,
                            </p>

                            <p style="margin: 0 0 25px; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                We're excited to inform you that your profile has impressed us! You have been <strong style="color: #059669;">shortlisted for an interview</strong> for the following position:
                            </p>

                            <!-- Job Details Card with Success Theme -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 30px; background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border-radius: 12px; border: 2px solid #6ee7b7;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <div style="margin-bottom: 15px;">
                                            <div style="color: #065f46; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                                                Position
                                            </div>
                                            <div style="color: #064e3b; font-size: 22px; font-weight: 700; margin-bottom: 5px;">
                                                <?php echo e($application->job->title); ?>

                                            </div>
                                        </div>

                                        <div style="margin-bottom: 12px;">
                                            <span style="color: #065f46; font-size: 14px; font-weight: 600;">🏢 Company:</span>
                                            <span style="color: #064e3b; font-size: 14px; font-weight: 500;"><?php echo e($application->job->company->company_name); ?></span>
                                        </div>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->job->location): ?>
                                        <div style="margin-bottom: 12px;">
                                            <span style="color: #065f46; font-size: 14px; font-weight: 600;">📍 Location:</span>
                                            <span style="color: #064e3b; font-size: 14px;"><?php echo e($application->job->location); ?></span>
                                        </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                        <div>
                                            <span style="color: #065f46; font-size: 14px; font-weight: 600;">✅ Status:</span>
                                            <span style="background-color: #10b981; color: #ffffff; padding: 4px 12px; border-radius: 12px; font-size: 13px; font-weight: 700;">SHORTLISTED</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Next Steps Section -->
                            <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-left: 4px solid #f59e0b; padding: 25px; border-radius: 8px; margin-bottom: 30px;">
                                <h3 style="margin: 0 0 15px; color: #92400e; font-size: 18px; font-weight: 700;">
                                    📋 What Happens Next?
                                </h3>
                                <ul style="margin: 0; padding-left: 20px; color: #78350f; line-height: 1.8;">
                                    <li style="margin-bottom: 10px;">
                                        <strong>The employer will contact you shortly</strong> with interview details including date, time, and format (in-person, video, or phone)
                                    </li>
                                    <li style="margin-bottom: 10px;">
                                        <strong>Prepare for the interview:</strong> Research the company, review the job description, and prepare your questions
                                    </li>
                                    <li style="margin-bottom: 10px;">
                                        <strong>Keep an eye on your email and phone</strong> for communications from the employer
                                    </li>
                                    <li>
                                        <strong>Check your application status</strong> anytime through your dashboard
                                    </li>
                                </ul>
                            </div>

                            <!-- Interview Preparation Tips -->
                            <div style="background-color: #eff6ff; border: 2px solid #93c5fd; padding: 25px; border-radius: 12px; margin-bottom: 30px;">
                                <h3 style="margin: 0 0 15px; color: #1e40af; font-size: 18px; font-weight: 700;">
                                    💡 Interview Preparation Tips
                                </h3>
                                <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="padding: 8px 0; vertical-align: top; width: 30px;">
                                            <span style="font-size: 20px;">✓</span>
                                        </td>
                                        <td style="padding: 8px 0; color: #1e3a8a; font-size: 14px; line-height: 1.6;">
                                            <strong>Research the company:</strong> Visit their website, understand their mission, values, and recent news
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0; vertical-align: top;">
                                            <span style="font-size: 20px;">✓</span>
                                        </td>
                                        <td style="padding: 8px 0; color: #1e3a8a; font-size: 14px; line-height: 1.6;">
                                            <strong>Review your application:</strong> Be ready to discuss your resume and cover letter in detail
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0; vertical-align: top;">
                                            <span style="font-size: 20px;">✓</span>
                                        </td>
                                        <td style="padding: 8px 0; color: #1e3a8a; font-size: 14px; line-height: 1.6;">
                                            <strong>Prepare examples:</strong> Use the STAR method (Situation, Task, Action, Result) for behavioral questions
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0; vertical-align: top;">
                                            <span style="font-size: 20px;">✓</span>
                                        </td>
                                        <td style="padding: 8px 0; color: #1e3a8a; font-size: 14px; line-height: 1.6;">
                                            <strong>Dress professionally:</strong> Choose appropriate attire that matches the company culture
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0; vertical-align: top;">
                                            <span style="font-size: 20px;">✓</span>
                                        </td>
                                        <td style="padding: 8px 0; color: #1e3a8a; font-size: 14px; line-height: 1.6;">
                                            <strong>Prepare questions:</strong> Have thoughtful questions ready about the role, team, and company
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0; vertical-align: top;">
                                            <span style="font-size: 20px;">✓</span>
                                        </td>
                                        <td style="padding: 8px 0; color: #1e3a8a; font-size: 14px; line-height: 1.6;">
                                            <strong>Test your setup:</strong> For video interviews, test your camera, microphone, and internet connection beforehand
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- View Application Button -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 25px;">
                                <tr>
                                    <td style="text-align: center; padding: 20px 0;">
                                        <a href="<?php echo e(route('jobseeker.applications.show', $application)); ?>"
                                           style="display: inline-block; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; text-decoration: none; padding: 18px 50px; border-radius: 12px; font-weight: 700; font-size: 18px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4); transition: all 0.3s ease;">
                                            👁️ View Application Details
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Encouragement Message -->
                            <div style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); padding: 20px; border-radius: 8px; border: 1px solid #86efac; margin-bottom: 20px; text-align: center;">
                                <p style="margin: 0; color: #166534; font-size: 16px; line-height: 1.6; font-weight: 600;">
                                    ⭐ You're one step closer to your dream job!<br>
                                    We wish you the best of luck with your interview.
                                </p>
                            </div>

                            <p style="margin: 0 0 10px; color: #6b7280; font-size: 15px; line-height: 1.6;">
                                If you have any questions about your application or the interview process, please don't hesitate to reach out to the employer.
                            </p>

                            <p style="margin: 0; color: #1f2937; font-size: 15px; font-weight: 600;">
                                Best of luck!<br>
                                <span style="background: linear-gradient(135deg, #3b82f6, #6366f1, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 700;">
                                    <?php echo e(config('app.name')); ?> Team
                                </span>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 15px; color: #6b7280; font-size: 14px;">
                                Track your application progress
                            </p>

                            <div style="margin: 20px 0;">
                                <a href="<?php echo e(route('jobseeker.applications.index')); ?>" style="display: inline-block; margin: 0 8px; color: #9ca3af; text-decoration: none; font-size: 13px;">My Applications</a>
                                <span style="color: #d1d5db;">•</span>
                                <a href="<?php echo e(route('jobs.index')); ?>" style="display: inline-block; margin: 0 8px; color: #9ca3af; text-decoration: none; font-size: 13px;">Browse Jobs</a>
                                <span style="color: #d1d5db;">•</span>
                                <a href="<?php echo e(route('jobseeker.profile.index')); ?>" style="display: inline-block; margin: 0 8px; color: #9ca3af; text-decoration: none; font-size: 13px;">My Profile</a>
                            </div>

                            <p style="margin: 15px 0 0; color: #9ca3af; font-size: 12px;">
                                © <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH /var/www/placemenet/resources/views/emails/application-status/shortlisted.blade.php ENDPATH**/ ?>