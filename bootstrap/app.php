<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',  // Add API routing
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'is_verify_email' => \App\Http\Middleware\IsVerifyEmail::class,
            'user-access' => \App\Http\Middleware\UserAccess::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'superadmin' => \App\Http\Middleware\SuperAdminMiddleware::class,
            'clear.all' => \App\Http\Middleware\ClearAllMiddleware::class,
            
        ]);

        $middleware->validateCsrfTokens(except: [
            'confirm',
        ]);

        // Define your API middleware here if needed
        // $middleware->group('api', [
        //     'user-access' => \App\Http\Middleware\UserAccess::class,
        //     'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle exceptions here if needed
    })
    ->create();
