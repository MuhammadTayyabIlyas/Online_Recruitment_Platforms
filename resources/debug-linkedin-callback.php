<?php

// Manually test the LinkedIn callback endpoint
// Call this URL after authorization: https://www.placemenet.net/auth/linkedin/callback

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Simulate a GET request to the callback
$request = Illuminate\Http\Request::create('/auth/linkedin/callback');

// Log what we'd receive
error_log("=== LinkedIn Callback Debug ===");
error_log("Request URL: " . $request->fullUrl());
error_log("Query params: " . json_encode($request->query()));
error_log("All params: " . json_encode($request->all()));
error_log("================================");

echo "Debug mode - check logs\n";
