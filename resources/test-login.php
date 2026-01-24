<?php
// Test login page functionality
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Check if login controller method exists
$controller = new \App\Http\Controllers\Auth\LoginController();
$reflection = new ReflectionClass($controller);

echo "Login Controller Methods:\n";
foreach ($reflection->getMethods() as $method) {
    if (!$method->isConstructor() && $method->class === 'App\Http\Controllers\Auth\LoginController') {
        echo "  - " . $method->name . "\n";
    }
}

echo "\nRoutes:\n";
$routes = collect(Route::getRoutes())->filter(function($route) {
    return strpos($route->uri(), 'login') !== false;
});

foreach ($routes as $route) {
    echo "  - " . $route->uri() . " => " . $route->getActionName() . "\n";
}
EOF