<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

// Find user by email
$user = User::where('email', 'ceo@pakedx.com')->first();

if (!$user) {
    echo "User not found with email: ceo@pakedx.com\n";
    exit(1);
}

echo "User found: {$user->name} ({$user->email})\n";

// Check if already verified
if ($user->email_verified_at) {
    echo "Email is already verified at: {$user->email_verified_at}\n";
    echo "Proceeding to send verification email anyway...\n\n";
}

// Generate verification token
$verificationToken = Str::random(64);

// Save token to user
$user->verification_token = $verificationToken;
$user->save();

echo "Verification token generated and saved.\n";
echo "Token: {$verificationToken}\n\n";

// Send verification email
try {
    Mail::send('emails.verify', ['token' => $verificationToken, 'user' => $user], function ($message) use ($user) {
        $message->to($user->email);
        $message->subject('Verify Your Email Address');
    });

    echo "✓ Verification email sent successfully!\n\n";
    echo "Verification Link:\n";
    echo url('/email-verify/' . $verificationToken) . "\n\n";

    // Check mail driver
    $mailDriver = config('mail.default');
    echo "Mail Driver: {$mailDriver}\n";

    if ($mailDriver === 'log') {
        echo "Note: Emails are being logged to storage/logs/laravel.log\n";
    } elseif ($mailDriver === 'smtp' && config('mail.mailers.smtp.username') === null) {
        echo "⚠ Warning: SMTP credentials not configured. Email may not be delivered.\n";
    }

} catch (Exception $e) {
    echo "✗ Error sending email: {$e->getMessage()}\n";
    exit(1);
}
