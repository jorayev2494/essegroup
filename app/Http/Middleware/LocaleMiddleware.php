<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

readonly class LocaleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->headers->get('Accept-Language') ?? $request->query->get('local');

        if ($locale !== null) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
