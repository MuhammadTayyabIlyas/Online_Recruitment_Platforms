<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 40px 30px;
            text-align: center;
        }

        .email-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .email-header p {
            font-size: 16px;
            opacity: 0.95;
        }

        .email-body {
            padding: 40px 30px;
            color: #333333;
        }

        .email-body h2 {
            color: #667eea;
            font-size: 22px;
            margin-bottom: 20px;
        }

        .email-body p {
            font-size: 16px;
            margin-bottom: 20px;
            color: #555555;
        }

        .verification-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            margin: 20px 0;
            transition: transform 0.2s ease;
        }

        .verification-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .button-container {
            text-align: center;
            margin: 30px 0;
        }

        .divider {
            border-top: 1px solid #e0e0e0;
            margin: 30px 0;
        }

        .alternative-link {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .alternative-link p {
            font-size: 14px;
            margin-bottom: 10px;
            color: #666666;
        }

        .alternative-link a {
            color: #667eea;
            word-break: break-all;
            text-decoration: none;
        }

        .email-footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #666666;
            font-size: 14px;
        }

        .email-footer p {
            margin: 5px 0;
        }

        .email-footer a {
            color: #667eea;
            text-decoration: none;
        }

        .icon {
            font-size: 48px;
            margin-bottom: 20px;
        }

        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }

            .email-header,
            .email-body,
            .email-footer {
                padding: 20px;
            }

            .email-header h1 {
                font-size: 24px;
            }

            .verification-button {
                padding: 12px 30px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="icon">✉️</div>
            <h1>Email Verification</h1>
            <p>Please verify your email address to continue</p>
        </div>

        <div class="email-body">
            <h2>Hello {{ $user->name }}!</h2>

            <p>Thank you for registering with us. We're excited to have you on board!</p>

            <p>To complete your registration and ensure the security of your account, please verify your email address by clicking the button below:</p>

            <div class="button-container">
                <a href="{{ url('/email-verify/' . $token) }}" class="verification-button">
                    Verify Email Address
                </a>
            </div>

            <p>This verification link will help us confirm that you're the owner of this email address and will activate your account.</p>

            <div class="divider"></div>

            <div class="alternative-link">
                <p><strong>Having trouble with the button?</strong></p>
                <p>Copy and paste this link into your browser:</p>
                <a href="{{ url('/email-verify/' . $token) }}">{{ url('/email-verify/' . $token) }}</a>
            </div>

            <p style="margin-top: 30px; font-size: 14px; color: #888888;">
                <strong>Note:</strong> If you did not create an account with us, please ignore this email and no further action is required.
            </p>
        </div>

        <div class="email-footer">
            <p><strong>Need Help?</strong></p>
            <p>If you have any questions or need assistance, please contact our support team.</p>
            <p style="margin-top: 15px; color: #999999;">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
