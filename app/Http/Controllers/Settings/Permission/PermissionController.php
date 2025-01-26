<?php

namespace App\Http\Controllers\Settings\Permission;

use App\Application\DTO\IdRequestDTO;
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

        try {
            $input = new IdRequestDTO($companyId);
            $output = $this->listPermissionUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output->toArray(), 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
