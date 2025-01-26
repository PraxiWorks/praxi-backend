<?php

namespace App\Http\Controllers\Register\UserPermission;

use App\Application\DTO\IdRequestDTO;
use App\Application\Register\UserPermission\AssignPermissionsToUserUseCase;
use App\Application\Register\UserPermission\DTO\AssignPermissionsToUserRequestDTO;
use App\Application\Register\UserPermission\DTO\UpdateUserPermissionRequestDTO;
use App\Application\Register\UserPermission\GetUserPermission;
use App\Application\Register\UserPermission\UpdateUserPermission;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class UserPermissionController extends Controller
{

    public function __construct(
        private GetUserPermission $getUserPermissionUseCase,
        private AssignPermissionsToUserUseCase $assignPermissionsToUserUseCase,
        private UpdateUserPermission $updateUserPermissionUseCase
    ) {}

    public function index(Request $request)
    {
        $userId = $request->route('userId') ?? 0;

        try {
            $input = new IdRequestDTO($userId);
            $output = $this->getUserPermissionUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function store(Request $request)
    {
        $userId = $request->route('userId') ?? 0;
        $permissions = $request->permission_id ?? [];
        try {
            $input = new AssignPermissionsToUserRequestDTO(
                $userId,
                $permissions
            );
            $output = $this->assignPermissionsToUserUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function update(Request $request)
    {
        $userId = $request->userId ?? 0;
        $permissions = $request->permission_id ?? [];

        try {
            $input = new UpdateUserPermissionRequestDTO(
                $userId,
                $permissions
            );
            $output = $this->updateUserPermissionUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
