<?php

namespace App\Http\Middleware;

use App\Domain\Interfaces\Company\CompanyRepositoryInterface;
use Closure;
use Illuminate\Http\Request;

class ValidateCompanyExistence
{
    private CompanyRepositoryInterface $companyRepositoryInterface;

    public function handle(Request $request, Closure $next)
    {
        $companyId = $request->route('id');
        
        if (empty($this->companyRepositoryInterface->getById($companyId))) {
            return response()->json(['message' => 'Empresa não encontrada'], 404);
        }
        
        return $next($request);
    }
}
