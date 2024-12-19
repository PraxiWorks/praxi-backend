<?php

namespace App\Infrastructure\Services\Jwt;

class JwtAuth
{
    /**
     * Gera um token JWT
     * 
     * @param int $userId ID do usuário
     * @param int $hours Horas de validade
     * @return string Token JWT
     */
    public function encode(int $userId, int $hours = 1): string
    {
        $issuedAt = time();
        $expiration = $issuedAt + ($hours * 3600);

        $header = self::urlsafeB64Encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
        $payload = self::urlsafeB64Encode(json_encode([
            'iss' => config('jwtAuth.domain'),
            'sub' => $userId,
            'iat' => $issuedAt,
            'exp' => $expiration,
        ]));

        $signature = self::urlsafeB64Encode(hash_hmac('sha256', "$header.$payload", config('jwtAuth.secret'), true));
        return "$header.$payload.$signature";
    }

    /**
     * Valida um token JWT
     * 
     * @param string $token Token JWT
     * @return bool True se válido, False caso contrário
     */
    public function validate(string $token): bool
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return false;
        }

        [$header, $payload, $signature] = $parts;

        // Verifica a assinatura
        $validSignature = self::urlsafeB64Encode(hash_hmac('sha256', "$header.$payload", config('jwtAuth.secret'), true));
        if ($signature !== $validSignature) {
            return false;
        }

        // Verifica a expiração
        $decodedPayload = json_decode(self::urlsafeB64Decode($payload), true);
        return isset($decodedPayload['exp']) && $decodedPayload['exp'] > time();
    }

    /**
     * URL-safe Base64 encode
     * 
     * @param string $input Texto para codificar
     * @return string Texto codificado
     */
    private static function urlsafeB64Encode(string $input): string
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    /**
     * URL-safe Base64 decode
     * 
     * @param string $input Texto para decodificar
     * @return string Texto decodificado
     */
    private static function urlsafeB64Decode(string $input): string
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $input .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }
}
