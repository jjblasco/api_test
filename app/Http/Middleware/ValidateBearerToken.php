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
        $auth = $request->header('Authorization');

        if ($auth !== '[]{}()') {
            return response()->json(['error' => 'Token inválido o ausente.'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
