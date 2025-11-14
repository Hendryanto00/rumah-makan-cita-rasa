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
    ->withMiddleware(function (Middleware $middleware): void {
        // Exclude Midtrans notification endpoint from CSRF verification
        $middleware->validateCsrfTokens(except: [
            '/midtrans/notification',
            'midtrans/notification',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle signed URL validation errors for email verification
        $exceptions->render(function (\Illuminate\Routing\Exceptions\InvalidSignatureException $e, $request) {
            if ($request->is('verify-email/*')) {
                return redirect('/')->with('error', 'Link verifikasi tidak valid atau sudah kedaluwarsa. Silakan minta link verifikasi baru.');
            }
        });
    })->create();
