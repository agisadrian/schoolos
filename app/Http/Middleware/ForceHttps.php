<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * Redirect otomatis ke HTTPS kalau aplikasi jalan di
     * mode production dan request yang masuk masih HTTP.
     *
     * Sengaja hanya aktif saat APP_ENV=production, supaya
     * development lokal (Laragon, http://127.0.0.1:8000)
     * tetap bisa diakses normal tanpa SSL.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            app()->environment('production') &&
            !$request->secure()
        ) {
            return redirect()->secure(
                $request->getRequestUri()
            );
        }

        return $next($request);
    }
}
