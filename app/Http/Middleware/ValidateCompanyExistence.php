<?php

namespace App\Http\Middleware;

use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Infrastructure\Services\Jwt\JwtAuth;
use Closure;
use Illuminate\Http\Request;

class ValidateCompanyExistence
{
    public function __construct(
        private JwtAuth $jwtAuth,
        private CompanyRepositoryInterface $companyRepositoryInterface
    ) {}

    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        $jwtJsonDecoded = json_decode($this->jwtAuth->getUserIdFromToken($token), true);

        $companyId = $request->route('companyId');

        if ($companyId != $jwtJsonDecoded['company_id']) {
            return response()->json(['message' => 'Empresa não encontrada'], 404);
        }

        if (empty($this->companyRepositoryInterface->getById($companyId))) {
            return response()->json(['message' => 'Empresa não encontrada'], 404);
        }

        return $next($request);
    }
}
