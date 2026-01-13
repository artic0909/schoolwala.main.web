<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__ . '/../routes/web.php',
            __DIR__ . '/../routes/admin-routes.php',
            __DIR__ . '/../routes/student-routes.php',
            __DIR__ . '/../routes/subscriber-routes.php',
            __DIR__ . '/../routes/waver-routes.php',
        ],
        api: __DIR__ . '/../routes/api-routes.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'guest' => RedirectIfAuthenticated::class,
            'auth' => Authenticate::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('subscriptions:check-expired')
            ->daily()
            ->withoutOverlapping();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
