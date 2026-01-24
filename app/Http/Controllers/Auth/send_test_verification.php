<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing Direct Email Sending...\n";
echo "================================\n\n";

// Update mail config to send immediately
config(['queue.default' => 'sync']);

// Test the email directly
try {
    $testUser = new stdClass();
    $testUser->email = 'ceo@pakedx.com';
    $testUser->name = 'Test User';
    $testUser->verification_token = 'test_token_12345';
    
    echo "Sending verification email to: " . $testUser->email . "\n";
    
    \Illuminate\Support\Facades\Mail::send('emails.verify', ['token' => $testUser->verification_token, 'user' => $testUser], function ($message) use ($testUser) {
        $message->to($testUser->email);
        $message->subject('Verify Your Email Address');
    });
    
    echo "✓ Email sent synchronously!\n";
    echo "Check your inbox at: " . $testUser->email . "\n";
    
} catch (\Exception $e) {
    echo "✗ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\nDone.\n";

