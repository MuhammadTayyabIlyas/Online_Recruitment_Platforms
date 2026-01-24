<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Failed</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f43f5e 0%, #be123c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .error-container {
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

        .error-header {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #ffffff;
            padding: 50px 30px;
            text-align: center;
        }

        .error-icon {
            width: 100px;
            height: 100px;
            background-color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            animation: shake 0.6s ease-in-out 0.3s both;
        }

        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            10%, 30%, 50%, 70%, 90% {
                transform: translateX(-5px);
            }
            20%, 40%, 60%, 80% {
                transform: translateX(5px);
            }
        }

        .error-icon svg {
            width: 60px;
            height: 60px;
        }

        .error-x {
            stroke: #ef4444;
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

        .error-header h1 {
            font-size: 32px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .error-header p {
            font-size: 18px;
            opacity: 0.95;
        }

        .error-body {
            padding: 50px 40px;
            text-align: center;
            color: #333333;
        }

        .error-body h2 {
            color: #ef4444;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .error-body p {
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 20px;
            color: #555555;
        }

        .error-box {
            background-color: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 20px;
            border-radius: 5px;
            margin: 30px 0;
            text-align: left;
        }

        .error-box p {
            margin: 10px 0;
            color: #991b1b;
            font-size: 15px;
        }

        .error-box strong {
            color: #7f1d1d;
        }

        .reasons-list {
            text-align: left;
            margin: 20px 0;
            padding: 0 20px;
        }

        .reasons-list li {
            margin: 12px 0;
            color: #666;
            line-height: 1.6;
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

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #ffffff;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(239, 68, 68, 0.4);
        }

        .error-footer {
            background-color: #f9fafb;
            padding: 25px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }

        .error-footer p {
            margin: 5px 0;
        }

        .error-footer a {
            color: #667eea;
            text-decoration: none;
        }

        .error-footer a:hover {
            text-decoration: underline;
        }

        @media only screen and (max-width: 600px) {
            .error-container {
                margin: 0;
                border-radius: 0;
            }

            .error-header,
            .error-body {
                padding: 30px 20px;
            }

            .error-header h1 {
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
    <div class="error-container">
        <div class="error-header">
            <div class="error-icon">
                <svg viewBox="0 0 100 100">
                    <path class="error-x" d="M30,30 L70,70 M70,30 L30,70" />
                </svg>
            </div>
            <h1>Verification Failed</h1>
            <p>We couldn't verify your email address</p>
        </div>

        <div class="error-body">
            <h2>Oops! Something went wrong</h2>

            <div class="error-box">
                <p><strong>Error:</strong> <?php echo e($message ?? 'Invalid or expired verification token'); ?></p>
            </div>

            <p>We were unable to verify your email address. This could happen for several reasons:</p>

            <ul class="reasons-list">
                <li><strong>Expired Link:</strong> The verification link may have expired. Verification links are typically valid for a limited time.</li>
                <li><strong>Invalid Token:</strong> The verification token in the link may be invalid or has already been used.</li>
                <li><strong>Already Verified:</strong> Your email address might already be verified.</li>
                <li><strong>Corrupted Link:</strong> The link may have been corrupted when copied or clicked.</li>
            </ul>

            <p>Don't worry! You can request a new verification email and try again.</p>

            <div class="action-buttons">
                <a href="<?php echo e(url('/login')); ?>" class="btn btn-primary">Go to Login</a>
                <a href="<?php echo e(url('/')); ?>" class="btn btn-secondary">Back to Home</a>
            </div>
        </div>

        <div class="error-footer">
            <p><strong>Need Help?</strong></p>
            <p>If you continue to experience issues, please <a href="mailto:support@example.com">contact our support team</a> for assistance.</p>
            <p style="margin-top: 15px;">&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH /var/www/placemenet/resources/views/emails/verify_failed.blade.php ENDPATH**/ ?>