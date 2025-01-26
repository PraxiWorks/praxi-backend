<?php

namespace App\Http\Controllers\Settings\GroupPermission;

use App\Application\DTO\IdRequestDTO;
use App\Application\Settings\GroupPermission\AssignPermissionsToGroup;
use App\Application\Settings\GroupPermission\DeleteGroupPermission;
use App\Application\Settings\GroupPermission\DTO\AssignPermissionsToGroupRequestDTO;
use App\Application\Settings\GroupPermission\DTO\UpdateGroupPermissionRequestDTO;
use App\Application\Settings\GroupPermission\GetPermissionsGroup;
use App\Application\Settings\GroupPermission\UpdateGroupPermission;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class GroupPermissionController extends Controller
{

    public function __construct(
        private GetPermissionsGroup $getPermissionsGroupUseCase,
        private AssignPermissionsToGroup $assignPermissionsToGroupUseCase,
        private UpdateGroupPermission $updateGroupPermissionUseCase,
        private DeleteGroupPermission $deleteGroupPermissionUseCase
    ) {}

    public function index(Request $request)
    {
        $groupId = $request->route('groupId') ?? 0;

        try {
            $input = new IdRequestDTO($groupId);
            $output = $this->getPermissionsGroupUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function store(Request $request)
    {
        $groupId = $request->route('groupId') ?? 0;
        $permissions = $request->permission_id ?? [];

        try {
            $input = new AssignPermissionsToGroupRequestDTO(
                $groupId,
                $permissions
            );
            $output = $this->assignPermissionsToGroupUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function update(Request $request)
    {
        $groupId = $request->route('groupId') ?? 0;
        $permissions = $request->permission_id ?? [];

        try {
            $input = new UpdateGroupPermissionRequestDTO(
                $groupId,
                $permissions
            );
            $output = $this->updateGroupPermissionUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function delete(Request $request)
    {
        $groupId = $request->route('groupId') ?? 0;

        try {
            $input = new IdRequestDTO($groupId);
            $output = $this->deleteGroupPermissionUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
