<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verified Successfully</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .success-container {
            max-width: 600px;
            width: 100%;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            padding: 50px 30px;
            text-align: center;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background-color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            animation: checkmark 0.6s ease-in-out 0.3s both;
        }

        @keyframes checkmark {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .success-icon svg {
            width: 60px;
            height: 60px;
        }

        .checkmark {
            stroke: #10b981;
            stroke-width: 3;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
            stroke-dasharray: 100;
            stroke-dashoffset: 100;
            animation: draw 0.5s ease-out 0.5s forwards;
        }

        @keyframes draw {
            to {
                stroke-dashoffset: 0;
            }
        }

        .success-header h1 {
            font-size: 32px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .success-header p {
            font-size: 18px;
            opacity: 0.95;
        }

        .success-body {
            padding: 50px 40px;
            text-align: center;
            color: #333333;
        }

        .success-body h2 {
            color: #10b981;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .success-body p {
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 20px;
            color: #555555;
        }

        .info-box {
            background-color: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 20px;
            border-radius: 5px;
            margin: 30px 0;
            text-align: left;
        }

        .info-box p {
            margin: 0;
            color: #166534;
            font-size: 15px;
        }

        .action-buttons {
            margin-top: 40px;
        }

        .btn {
            display: inline-block;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            margin: 10px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background-color: #f3f4f6;
            color: #374151;
            border: 2px solid #e5e7eb;
        }

        .btn-secondary:hover {
            background-color: #e5e7eb;
        }

        .success-footer {
            background-color: #f9fafb;
            padding: 25px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }

        .success-footer p {
            margin: 5px 0;
        }

        @media only screen and (max-width: 600px) {
            .success-container {
                margin: 0;
                border-radius: 0;
            }

            .success-header,
            .success-body {
                padding: 30px 20px;
            }

            .success-header h1 {
                font-size: 26px;
            }

            .btn {
                display: block;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-header">
            <div class="success-icon">
                <svg viewBox="0 0 100 100">
                    <path class="checkmark" d="M20,50 L40,70 L80,30" />
                </svg>
            </div>
            <h1>Email Verified!</h1>
            <p>Your email has been successfully verified</p>
        </div>

        <div class="success-body">
            <h2>Welcome Aboard!</h2>

            <p><?php echo e($message); ?></p>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($user)): ?>
                <p>Thank you, <strong><?php echo e($user->name); ?></strong>! Your email address has been confirmed and your account is now fully activated.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="info-box">
                <p><strong>✓</strong> Your email has been verified</p>
                <p><strong>✓</strong> Your account is now active</p>
                <p><strong>✓</strong> You can now access all features</p>
            </div>

            <p>You can now enjoy all the features and benefits of your account. Start exploring and make the most of your experience!</p>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <div style="background-color: #f0fdf4; border: 1px solid #10b981; padding: 15px; border-radius: 5px; margin: 20px 0;">
                    <p style="color: #166534; margin: 0;">
                        <strong>✓</strong> Redirecting to your dashboard in 3 seconds...
                    </p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="action-buttons">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-primary">Go to Dashboard</a>
                <?php else: ?>
                    <a href="<?php echo e(url('/login')); ?>" class="btn btn-primary">Go to Login</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <a href="<?php echo e(url('/')); ?>" class="btn btn-secondary">Back to Home</a>
            </div>
        </div>

        <div class="success-footer">
            <p>If you have any questions, feel free to contact our support team.</p>
            <p>&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH /var/www/placemenet/resources/views/emails/verify_success.blade.php ENDPATH**/ ?>