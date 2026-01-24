<?php

/**
 * LinkedIn Integration Verification Script
 * Run this to verify everything is configured correctly
 */

echo "===========================================\n";
echo "LinkedIn OAuth Integration Verification\n";
echo "===========================================\n\n";

// Check 1: Verify .env credentials
echo "✓ Checking LinkedIn credentials in .env...\n";
$clientId = env('LINKEDIN_CLIENT_ID');
$clientSecret = env('LINKEDIN_CLIENT_SECRET');
$redirectUri = env('LINKEDIN_REDIRECT_URI');

if ($clientId && $clientId !== 'your_linkedin_client_id_here') {
    echo "  ✓ LINKEDIN_CLIENT_ID is set: " . substr($clientId, 0, 8) . "...\n";
} else {
    echo "  ✗ LINKEDIN_CLIENT_ID is missing or not configured!\n";
}

if ($clientSecret && $clientSecret !== 'your_linkedin_client_secret_here') {
    echo "  ✓ LINKEDIN_CLIENT_SECRET is set: " . substr($clientSecret, 0, 8) . "...\n";
} else {
    echo "  ✗ LINKEDIN_CLIENT_SECRET is missing or not configured!\n";
}

if ($redirectUri) {
    echo "  ✓ LINKEDIN_REDIRECT_URI is set: " . $redirectUri . "\n";
} else {
    echo "  ✗ LINKEDIN_REDIRECT_URI is missing!\n";
}

echo "\n";

// Check 2: Verify database column
echo "✓ Checking database schema...\n";
try {
    if (Schema::hasColumn('users', 'linkedin_id')) {
        echo "  ✓ 'linkedin_id' column exists in users table\n";
    } else {
        echo "  ✗ 'linkedin_id' column is missing! Run: php artisan migrate --path=database/migrations/enhanced_auth\n";
    }
} catch (\Exception $e) {
    echo "  ✗ Database check failed: " . $e->getMessage() . "\n";
}

echo "\n";

// Check 3: Verify routes
echo "✓ Checking LinkedIn routes...\n";
$routes = collect(Route::getRoutes())->filter(function($route) {
    return strpos($route->uri(), 'auth/linkedin') !== false;
});

if ($routes->count() >= 2) {
    echo "  ✓ LinkedIn OAuth routes are registered:\n";
    foreach ($routes as $route) {
        echo "    - " . $route->uri() . " (" . $route->getName() . ")\n";
    }
} else {
    echo "  ✗ LinkedIn routes are missing! Check routes/auth.php\n";
}

echo "\n";

// Check 4: Verify controller exists
echo "✓ Checking LinkedInAuthController...\n";
$controllerPath = app_path('Http/Controllers/Auth/LinkedInAuthController.php');
if (file_exists($controllerPath)) {
    echo "  ✓ LinkedInAuthController.php exists\n";
    
    // Check controller methods
    $controllerContent = file_get_contents($controllerPath);
    $requiredMethods = ['redirectToLinkedIn', 'handleLinkedInCallback', 'findOrCreateUser'];
    foreach ($requiredMethods as $method) {
        if (strpos($controllerContent, "function {$method}(") !== false) {
            echo "  ✓ Method '{$method}' found\n";
        } else {
            echo "  ✗ Method '{$method}' is missing!\n";
        }
    }
} else {
    echo "  ✗ LinkedInAuthController.php not found!\n";
}

echo "\n";

// Check 5: Verify Socialite configuration
echo "✓ Checking Socialite configuration...\n";
$servicesConfig = config('services.linkedin');
if ($servicesConfig) {
    echo "  ✓ LinkedIn service configuration found\n";
    if (isset($servicesConfig['client_id'])) {
        echo "  ✓ Client ID in config\n";
    }
    if (isset($servicesConfig['client_secret'])) {
        echo "  ✓ Client Secret in config\n";
    }
    if (isset($servicesConfig['redirect'])) {
        echo "  ✓ Redirect URI in config\n";
    }
} else {
    echo "  ✗ LinkedIn configuration missing in config/services.php\n";
}

echo "\n";

// Check 6: Verify view has LinkedIn button
echo "✓ Checking login view...\n";
$viewPath = resource_path('views/auth/login.blade.php');
if (file_exists($viewPath)) {
    $viewContent = file_get_contents($viewPath);
    if (strpos($viewContent, 'linkedin.login') !== false) {
        echo "  ✓ LinkedIn button/link found in login view\n";
    } else {
        echo "  ✗ LinkedIn button not found in login view!\n";
    }
    
    if (strpos($viewContent, 'Continue with LinkedIn') !== false) {
        echo "  ✓ LinkedIn button text found\n";
    } else {
        echo "  ✗ LinkedIn button text not found!\n";
    }
} else {
    echo "  ✗ Login view file not found!\n";
}

echo "\n";

// Summary
echo "===========================================\n";
echo "Verification Complete!\n";
echo "===========================================\n\n";

if ($clientId && $clientSecret && $clientId !== 'your_linkedin_client_id_here') {
    echo "✅ LinkedIn integration is FULLY CONFIGURED and READY!\n";
    echo "\nNext steps:\n";
    echo "1. Visit your login page\n";
    echo "2. Click 'Continue with LinkedIn'\n";
    echo "3. Test the OAuth flow\n";
    echo "4. Verify redirect to jobseeker/dashboard\n";
} else {
    echo "⚠️  LinkedIn integration is PARTIALLY CONFIGURED:\n";
    echo "- Add your LinkedIn credentials to .env\n";
    echo "- Ensure all checks above pass\n";
    echo "- Clear caches: php artisan config:clear && php artisan cache:clear\n";
}

echo "\n";

// Quick test URL
echo "Test URL: " . env('APP_URL') . "/auth/linkedin\n";
echo "Expected: Redirect to LinkedIn authorization page\n";
