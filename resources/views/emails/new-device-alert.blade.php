<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Device Login Alert</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f9fafb;
            padding: 20px;
            line-height: 1.6;
            color: #374151;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        .email-header {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }

        .email-header h1 {
            font-size: 24px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .email-header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .email-body {
            padding: 30px;
        }

        .alert-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
        }

        .alert-icon {
            color: #dc2626;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .alert-content h3 {
            color: #b91c1c;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .alert-content p {
            color: #7f1d1d;
            font-size: 13px;
        }

        .content-block {
            margin-bottom: 24px;
        }

        .content-block h2 {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 12px;
        }

        .content-block p {
            font-size: 14px;
            color: #4b5563;
            margin-bottom: 12px;
        }

        .details-table {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            width: 100%;
        }

        .details-row {
            display: flex;
            border-bottom: 1px solid #e5e7eb;
        }

        .details-row:last-child {
            border-bottom: none;
        }

        .details-label {
            background: #f3f4f6;
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            width: 35%;
            border-right: 1px solid #e5e7eb;
        }

        .details-value {
            padding: 12px 16px;
            font-size: 13px;
            color: #111827;
            flex: 1;
        }

        .action-buttons {
            margin-top: 24px;
            text-align: center;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            margin: 0 8px;
        }

        .btn-primary {
            background: #dc2626;
            color: #ffffff;
            border: 1px solid #dc2626;
        }

        .btn-primary:hover {
            background: #b91c1c;
            border-color: #b91c1c;
        }

        .btn-secondary {
            background: #ffffff;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .btn-secondary:hover {
            background: #f9fafb;
            border-color: #9ca3af;
        }

        .security-tips {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 16px;
            margin-top: 24px;
        }

        .security-tips h3 {
            font-size: 14px;
            font-weight: 600;
            color: #0369a1;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .security-tips ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .security-tips li {
            font-size: 13px;
            color: #0c4a6e;
            padding: 4px 0;
            padding-left: 20px;
            position: relative;
        }

        .security-tips li:before {
            content: "•";
            color: #0891b2;
            position: absolute;
            left: 8px;
        }

        .email-footer {
            background: #f9fafb;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
        }

        .email-footer p {
            margin-bottom: 8px;
        }

        .email-footer a {
            color: #dc2626;
            text-decoration: none;
            font-weight: 600;
        }

        .email-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .email-container {
                border-radius: 0;
            }
            
            .email-header,
            .email-body {
                padding: 20px;
            }
            
            .details-label {
                width: 40%;
                padding: 10px 12px;
                font-size: 12px;
            }
            
            .details-value {
                padding: 10px 12px;
                font-size: 12px;
            }
            
            .btn {
                display: block;
                margin: 8px 0;
                width: 100%;
                box-sizing: border-box;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Security Alert</h1>
            <p>New device login detected</p>
        </div>

        <div class="email-body">
            <div class="alert-box">
                <svg class="alert-icon h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div class="alert-content">
                    <h3>This wasn't you?</h3>
                    <p>If you did not sign in from this device, we recommend securing your account immediately.</p>
                </div>
            </div>

            <div class="content-block">
                <h2>Hello {{ $user->name }},</h2>
                <p>We detected a login to your account from a new device or location. For your security, we wanted to make sure it was you.</p>
            </div>

            <div class="content-block">
                <h2>Login Details:</h2>
                <div class="details-table">
                    <div class="details-row">
                        <div class="details-label">When</div>
                        <div class="details-value">{{ $time }}</div>
                    </div>
                    <div class="details-row">
                        <div class="details-label">Device</div>
                        <div class="details-value">{{ $device['browser'] ?? 'Unknown' }} on {{ $device['os'] ?? 'Unknown' }}</div>
                    </div>
                    <div class="details-row">
                        <div class="details-label">IP Address</div>
                        <div class="details-value">{{ $ip }}</div>
                    </div>
                    <div class="details-row">
                        <div class="details-label">Location</div>
                        <div class="details-value">
                            @if(function_exists('geoip'))
                                {{ geoip($ip)->country ?? 'Unknown' }}, {{ geoip($ip)->city ?? 'Unknown' }}
                            @else
                                Approximate location based on IP
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <a href="{{ url('/account/security') }}" class="btn btn-primary">
                    Review Account Activity
                </a>
                <a href="{{ url('/account/password') }}" class="btn btn-secondary">
                    Change Password
                </a>
            </div>

            <div class="security-tips">
                <h3>
                    <svg class="h-4 w-4 mr-2 inline-block" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    Security Tips
                </h3>
                <ul>
                    <li>Always use a strong, unique password for your account</li>
                    <li>Enable two-factor authentication for added security</li>
                    <li>Never share your password or verification codes with anyone</li>
                    <li>Regularly review your account activity</li>
                    <li>Sign out of devices you don't recognize</li>
                </ul>
            </div>
        </div>

        <div class="email-footer">
            <p>This is an automated security notification from <strong>Placemenet</strong>.</p>
            <p>If this was you, no further action is required.</p>
            <p>
                <a href="{{ url('/account/security') }}">Manage your security settings</a> |
                <a href="{{ url('/help') }}">Contact Support</a>
            </p>
            <p style="margin-top: 12px;">
                <small>Location and IP address information is approximate.</small>
            </p>
        </div>
    </div>
</body>
</html>
