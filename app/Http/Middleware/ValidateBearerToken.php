<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateBearerToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $excludedRoutes = [
            'api/documentation',
            'docs/asset/*',
            'api/docs',
            'api/docs/*',
            'docs/api-docs.json',
        ];

        foreach ($excludedRoutes as $route) {
            if ($request->is($route)) {
                return $next($request);
            }
        }

        $auth = $request->bearerToken();
        if ($auth !== '[]{}()') {
            return response()->json(['error' => 'Token inválido o ausente.'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }

}
