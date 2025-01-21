<?php

namespace App\Http\Middleware;

use App\Infrastructure\Services\Jwt\JwtAuth;
use App\Models\Register\User\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
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

        // Obter o ID do usuário a partir do token JWT
        $jwtJsonDecoded = json_decode($jwtAuth->getUserIdFromToken($token), true);
        $userId = $jwtJsonDecoded['user_id'];

        if (empty($userId)) {
            throw new HttpResponseException(response()->json([
                'message' => 'Usuário inválido'
            ], 401));
        }

        // Buscar o usuário no banco
        $user = User::find($userId);

        if (empty($user)) {
            throw new HttpResponseException(response()->json([
                'message' => 'Usuário não encontrado'
            ], 404));
        }

        // Definir o usuário no Auth
        Auth::setUser($user);

        return $next($request);
    }
}
