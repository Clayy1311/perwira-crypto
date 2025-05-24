<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan route middleware di sini
        $middleware->alias([
            'payment.check' => \App\Http\Middleware\CheckPaymentStatus::class,
        ]);

        // Jika Anda memiliki middleware global (akan dijalankan di setiap request), daftarkan juga di sini:
        // $middleware->web(App\Http\Middleware\EncryptCookies::class, ...);
        // $middleware->api(App\Http\Middleware\EnsureFrontendRequestsAreStateful::class, ...);
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureIsAdmin::class,
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'approved.module' => \App\Http\Middleware\ApprovedModule::class,
    ]);
})

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();