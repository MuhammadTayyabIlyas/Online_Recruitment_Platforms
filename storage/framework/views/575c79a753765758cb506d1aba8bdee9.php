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
                        <td style="background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                Application Status Update
                            </h1>
                            <p style="margin: 10px 0 0; color: rgba(255, 255, 255, 0.95); font-size: 16px;">
                                Your application status has been updated
                            </p>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px; color: #1f2937; font-size: 16px; line-height: 1.6;">
                                Hello <strong><?php echo e($application->user->name); ?></strong>,
                            </p>

                            <p style="margin: 0 0 25px; color: #4b5563; font-size: 16px; line-height: 1.7;">
                                This is to inform you that your application status for <strong><?php echo e($application->job->title); ?></strong> at <strong><?php echo e($application->job->company->company_name); ?></strong> has been updated.
                            </p>

                            <!-- Job Details Card -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 30px; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-radius: 12px; border: 2px solid #bae6fd;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <div style="margin-bottom: 15px;">
                                            <div style="color: #0369a1; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                                                Position
                                            </div>
                                            <div style="color: #0c4a6e; font-size: 20px; font-weight: 700; margin-bottom: 5px;">
                                                <?php echo e($application->job->title); ?>

                                            </div>
                                        </div>

                                        <div style="margin-bottom: 12px;">
                                            <span style="color: #0369a1; font-size: 14px; font-weight: 600;">🏢 Company:</span>
                                            <span style="color: #0c4a6e; font-size: 14px;"><?php echo e($application->job->company->company_name); ?></span>
                                        </div>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->job->location): ?>
                                        <div style="margin-bottom: 12px;">
                                            <span style="color: #0369a1; font-size: 14px; font-weight: 600;">📍 Location:</span>
                                            <span style="color: #0c4a6e; font-size: 14px;"><?php echo e($application->job->location); ?></span>
                                        </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                        <div>
                                            <span style="color: #0369a1; font-size: 14px; font-weight: 600;">✅ Status:</span>
                                            <span style="background-color: #3b82f6; color: #ffffff; padding: 4px 12px; border-radius: 12px; font-size: 13px; font-weight: 700; text-transform: uppercase;"><?php echo e($application->status); ?></span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- View Application Button -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 25px;">
                                <tr>
                                    <td style="text-align: center; padding: 20px 0;">
                                        <a href="<?php echo e(route('jobseeker.applications.show', $application)); ?>"
                                           style="display: inline-block; background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 12px; font-weight: 700; font-size: 16px; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);">
                                            👁️ View Application Details
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 10px; color: #6b7280; font-size: 15px; line-height: 1.6;">
                                You can check your application status and details anytime through your dashboard.
                            </p>

                            <p style="margin: 0; color: #1f2937; font-size: 15px; font-weight: 600;">
                                Best regards,<br>
                                <span style="background: linear-gradient(135deg, #3b82f6, #6366f1, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 700;">
                                    <?php echo e(config('app.name')); ?> Team
                                </span>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 30px; text-align: center; border-top: 1px solid #e5e7eb;">
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
<?php /**PATH /var/www/placemenet/resources/views/emails/application-status/general.blade.php ENDPATH**/ ?>