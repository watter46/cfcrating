<?php

use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Application;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'Socialite' => Laravel\Socialite\Facades\Socialite::class,
            '2fa' => \PragmaRX\Google2FALaravel\Middleware::class,
            'user' => \App\Http\Middleware\UserMiddleware::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        $middleware->append(\App\Http\Middleware\TrustProxies::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
