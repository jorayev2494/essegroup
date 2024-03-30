<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BooleanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->replace($this->transform($request->all()));

        return $next($request);
    }

    /**
     * Transform boolean strings to boolean
     * @param array $parameters
     * @return array
     */
    private function transform(array $parameters): array
    {
        return collect($parameters)->map(function ($param) {
            if (is_array($param)) {
                return $this->transform($param);
            }

            if ($param == 'true' || $param == 'false') {
                return filter_var($param, FILTER_VALIDATE_BOOLEAN);
            }

            return $param;
        })->all();
    }
}
