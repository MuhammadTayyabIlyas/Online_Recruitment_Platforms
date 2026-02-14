<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Console\Commands\SendJobAlerts;
use App\Console\Commands\SendAppointmentReminders;
use App\Console\Commands\SendDailyAppointmentSummary;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withCommands([
        SendJobAlerts::class,
        SendAppointmentReminders::class,
        SendDailyAppointmentSummary::class,
    ])
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('appointments:send-reminders')->everyMinute();
        $schedule->command('appointments:daily-summary')->dailyAt('21:00');
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'permission' => \App\Http\Middleware\PermissionMiddleware::class,
        ]);

        $middleware->appendToGroup('web', [
            \App\Http\Middleware\SetLocaleFromRequest::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
