<?php

use App\Http\Middleware\ClassAccessMiddleware;
use App\Http\Middleware\ForceHttps;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(
    basePath: dirname(__DIR__)
)
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'role' => RoleMiddleware::class,
            'class.member' => ClassAccessMiddleware::class,
        ]);

        $middleware->prepend(ForceHttps::class);

        // Percaya header dari proxy/load balancer/CDN
        // (misal Cloudflare) supaya Laravel tahu request
        // aslinya HTTPS meskipun diteruskan lewat proxy.
        $middleware->trustProxies(
            at: '*',
            headers: Request::HEADER_X_FORWARDED_FOR
                | Request::HEADER_X_FORWARDED_HOST
                | Request::HEADER_X_FORWARDED_PORT
                | Request::HEADER_X_FORWARDED_PROTO
        );

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();