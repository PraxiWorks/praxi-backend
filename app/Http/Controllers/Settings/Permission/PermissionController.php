<?php

namespace App\Http\Controllers\Settings\Permission;

use App\Application\Settings\Permission\DTO\ListPermissionsRequestDTO;
use App\Application\Settings\Permission\ListPermission;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function __construct(
        private ListPermission $listPermissionUseCase
    ) {}

    public function index(Request $request)
    {
        $companyId = $request->route('companyId');
        $permissions = $request->permission_id ?? [];

        try {
            $input = new ListPermissionsRequestDTO(
                $companyId,
                $permissions
            );
            $output = $this->listPermissionUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output->toArray(), 200);
        } catch (Exception $e) {
            $statusCode = ($e->getCode() >= 100 && $e->getCode() <= 599) ? $e->getCode() : 500;
            return $this->outputErrorArrayToJson($e->getMessage(), $statusCode);
        }
    }
}
