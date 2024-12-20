<?php

namespace App\Http\Middleware;

use App\Infrastructure\Services\Jwt\JwtAuth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function handle($request, \Closure $next, ...$guards)
    {
        $token = $request->bearerToken();
        $jwtAuth = new JwtAuth();

        if (empty($token) || !$jwtAuth->validate($token)) {
            throw new HttpResponseException(response()->json([
                'message' => 'Usuário não autenticado'
            ], 401));
        }

        return $next($request);
    }
}
